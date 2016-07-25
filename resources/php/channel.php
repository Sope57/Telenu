<?php

    function updateRecents() {
        $conn = db_connect();

        $stmt = $conn->prepare("SELECT rlist FROM recents WHERE recents.UID = ?");
        $stmt->execute(array($_COOKIE["id"]));
        $recentsList = $stmt->fetchColumn();

        if (empty($recentsList)) {
            $stmt = $conn->prepare("INSERT INTO recents (rlist, UID) VALUES (?, ?)");
            $stmt->execute(array($_SESSION['ChInfo']['ChID'], $_COOKIE["id"]));
        } else {
            $recentsArray = explode(',', $recentsList);

            if (in_array($_SESSION['ChInfo']['ChID'], $recentsArray)) {
                $pushIndex = array_search($_SESSION['ChInfo']['ChID'], $recentsArray);
            } else {
                $pushIndex = count($recentsArray);
            }

            for ($i = $pushIndex; $i > 0; $i--) { 
                $recentsArray[$i] = $recentsArray[$i-1];
            }
            $recentsArray[0] = $_SESSION['ChInfo']['ChID'];
            if (count($recentsArray) > 10) {
                array_pop($recentsArray);
            }
            $recentsList = implode(',', $recentsArray);
            $stmt = $conn->prepare("UPDATE recents SET rlist = ? WHERE UID = ?");
            $stmt->execute(array($recentsList, $_COOKIE["id"]));
        }
    }

    function get_video_data() {
        $conn = db_connect();

        switch ($_SESSION['ChInfo']['ChT']) {
            case 'webshow':
                $videoQuery = "SELECT * FROM media WHERE media.ChID = ? ORDER BY mediaDate DESC";
                break;

            case 'vlog':
                $videoQuery = "SELECT * FROM media WHERE media.ChID = ? ORDER BY mediaDate DESC";
                break;
            
            default:
                $videoQuery = "SELECT * FROM media WHERE media.ChID = ? ORDER BY ID";
                break;
        }

        $stmt = $conn->prepare($videoQuery);
        $stmt->execute(array($_SESSION['ChInfo']['ChID']));

        $_SESSION['media'] = $stmt->fetchAll();

        if (isset($_GET["v"])) {
            $_SESSION['vidkey'] = $_GET["v"];
            foreach ($_SESSION['media'] as $key => $video) {
                if ($video['mediaId'] == $_GET["v"]) {
                    $_SESSION['index'] = $key;
                    break;
                }
            }
        } else {
            $_SESSION['index'] = 0;
            $_SESSION['vidkey'] = $_SESSION['media'][$_SESSION['index']]['mediaId'];
        }
    }

    function update_index() {
        $_SESSION['index'] = $_SESSION['index'] + 1;
        $_SESSION['vidkey'] = $_SESSION['media'][$_SESSION['index']]['mediaId'];

        header('Content-Type: application/json');
        echo json_encode(array('index' => $_SESSION['index'], 'vidkey' => $_SESSION['vidkey']));
    }

    function update_video_data($index) {
        include 'connToServer.php';
        include 'getSession.php';

        $_SESSION['index'] = $index;
        $_SESSION['vidkey'] = $_SESSION['media'][$index]['mediaId'];

        print_player();
    }

    function print_player(){
        echo $_SESSION['media'][$_SESSION['index']]['mediaTitle'];
    }

    function fetch_social_share() { 
        ?>
            <li>
                <a class="share-buttons text-center" href="https://www.facebook.com/dialog/share?app_id=966242223397117&redirect_uri=http%3A%2F%2Fwww.facebook.com%2Fdialog%2Freturn%2Fclose&display=popup&href=http://telenu.tv/channel/<?= $_SESSION['ChInfo']['ChL'] ?>%26v=<?= $_SESSION['vidkey'] ?>" onclick="window.open(this.href,'mywin','left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" >
                    <div class="share-fb"><i class="fa fa-facebook vertical-center"></i></div>
                </a>
            </li>
            <li>
                <a class="share-buttons text-center" href="https://twitter.com/intent/tweet?source=http://telenu.tv/channel/<?= $_SESSION['ChInfo']['ChL'] ?>&v=<?= $_SESSION['vidkey'] ?>&text=http://telenu.tv/channel/<?= $_SESSION['ChInfo']['ChL'] ?>%26v=<?= $_SESSION['vidkey'] ?>%20via%20@TelenuTv" onclick="window.open(this.href,'mywin','left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" >
                    <div class="share-tw"><i class="fa fa-twitter vertical-center"></i></div>
                </a>
            </li>
            <li>
                <a class="share-buttons  text-center" href="#" data-toggle="modal" data-target="#emailshare">
                    <div class="share-em"><i class="fa fa-envelope vertical-center"></i></div>
                </a>
            </li>
        <?php
    }

    function get_rating_data() {
        $conn = db_connect();

        $stmt = $conn->prepare("SELECT rating FROM ratings WHERE ChID = ?");
        $stmt->execute(array($_SESSION['ChInfo']['ID']));
        $result = $stmt->fetchAll();

        if (!empty($result)) {
            $sum = 0;
            foreach ($result as $value) {
                $sum = $sum + $value['rating'];
            }
            $_SESSION['ChInfo']['rating'] = ($sum/count($result))*100;
            $_SESSION['ChInfo']['isRated'] = true;
        } else {
            $_SESSION['ChInfo']['rating'] = 50;
            $_SESSION['ChInfo']['isRated'] = false;
        }
        $_SESSION['ChInfo']['ratingn'] = 100 - $_SESSION['ChInfo']['rating'];
    }

    function update_rating_data() {
        get_rating_data();

        header('Content-Type: application/json');
        echo json_encode(array('rating' => $_SESSION['ChInfo']['rating'], 'ratingn' => $_SESSION['ChInfo']['ratingn']));
    }

    function get_comments() {
        $conn = db_connect();

        $result = $conn->query("SELECT * FROM comments WHERE file_id = '".$_SESSION['ChInfo']['ID']."' AND is_child = FALSE ORDER BY date DESC");
        $row_cnt = $result->rowCount();

        echo '<h3>Comentarios (',$row_cnt,')</h3>';
            new_comment();

        foreach ($result as $item) {
            $date = new dateTime($item['date']);
            $date = date_format($date, 'M j, Y | H:i:s');
            $auth = $item['author'];
            $par_code = $item['com_code'];

            $chi_result = $conn->query("SELECT * FROM comments WHERE par_code = '$par_code' AND is_child = TRUE");
            $chi_cnt = $chi_result->rowCount();

            echo '<div class="comment" name="',$item['com_code'],'" id="',$item['com_code'],'">'
                , '<span class="author">',$auth,'</span><br />'
                , $item['comment'], '<br />'
                , '<span class="date">Enviado: ',$date,'</span><br />';

            if ($chi_cnt == 0) {
                echo '<span class="replies">Sin respuestas</span>'
                , '<span class="replies">&emsp;<a id="reply',$par_code,'" onClick="openReply(this.id);">Responder</a></span>';
                add_comment($auth, $par_code);
            } else {
                echo '<span class="replies">',$chi_cnt,' respuestas</span>'
                , '<span class="replies">&emsp;<a id="reply',$par_code,'" onClick="openReply(this.id);">Responder</a></span>'
                , '<div name="children" id="children">';
                foreach ($chi_result as $com) {
                    $chi_date = new dateTime($com['date']);
                    $chi_date = date_format($chi_date, 'M j, Y | H:i:s');

                    echo '<div class="child" name="',$com['com_code'],'">'
                    , '<span class="author">',$com['author'],'</span><br />'
                    , $com['comment'],'<br />'
                    , '<span class="date">Enviado: ',$chi_date,'</span><br />'
                    , '</div>';
                }
                echo '</div>';
                add_comment($auth, $par_code);
            }
            echo '</div>';
        }
    }

    function add_comment($reply, $code) {
        echo '<form id="formreply',$code,'" action="../resources/php/reply.php" method="post" name="new_reply" class="hidden">'
        ,'<input type="hidden" name="vidkey" value="',$_SESSION['ChInfo']['ID'],'"/>'
        ,'<input type="hidden" name="par_code" value="',$code,'"/>';
        if (isset($_COOKIE["id"])) {
            echo '<textarea class="text_cmt" name="text_cmt" placeholder="Responder a ',$reply,'"></textarea><br />'
            .'<input id="formreply',$code,'" type="submit" value="Enviar" class="commentButton" onClick="postComment(this.id);"/>';
        } else {
            echo '<textarea class="text_cmt" name="text_cmt" placeholder="Inicia sesión para responder."></textarea><br />'
            ,'<a href="#" class="commentButton" data-toggle="modal" data-target="#showregister">Enviar</a>';
        }
        echo '</form>';
    }

    function new_comment() {
        echo '<form id="formreply',$_SESSION['ChInfo']['ID'],'" action="../resources/php/new.php" method="post" name="new_comment">'
        ,'<input type="hidden" name="vidkey" value="',$_SESSION['ChInfo']['ID'],'"/>';
        if (isset($_COOKIE["id"])) {
            echo '<textarea class="text_cmt" name="text_cmt" placeholder="Haz un comentario!"></textarea><br />'
            ,'<input id="formreply',$_SESSION['ChInfo']['ID'],'" type="submit" value="Enviar" class="commentButton" onClick="postComment(this.id);"/>';
        } else {
            echo '<textarea class="text_cmt" name="text_cmt" placeholder="Inicia sesión para comentar."></textarea><br />'
            ,'<a href="#" class="commentButton" data-toggle="modal" data-target="#showregister">Enviar</a>';
        }
        echo '</form>';
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characterLength = strlen($characters);
        $randomString = '';

        for ($i=0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $characterLength - 1)];
        }
        return $randomString;
    }

    function checkString() {
        $conn = db_connect();
        $rand = generateRandomString();
        $result = $conn->query("SELECT * FROM comments WHERE com_code = '$rand'");
        $row_cnt = $result->rowCount();

        if ($row_cnt == 0) {
            return $rand;
        } else {
            checkString();
        }
    }

    if(isset($_POST['action']) && !empty($_POST['action'])) {
        $action = $_POST['action'];
        switch($action) {
            case 'update_video_data' :
                $index = $_POST['index'];
                update_video_data($index);
                break;
            case 'get_comments' : 
                include 'connToServer.php';
                include 'getSession.php';
                get_comments();
                break;
            case 'update_index' : 
                include 'connToServer.php';
                include 'getSession.php';
                update_index();
                break;
            case 'fetch_social_share' :
                include 'connToServer.php';
                include 'getSession.php';
                fetch_social_share();
                break;
            case 'update_rating_data' :
                include 'connToServer.php';
                include 'getSession.php';
                update_rating_data();
                break;
        }
    }
?>