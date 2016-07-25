<?php
    require_once '../resources/php/connToServer.php';
    require_once '../resources/php/getSession.php';
    if($_SESSION["Email"]!="telenu.tv@gmail.com"){
        header('Location:../index.php');
    }    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Telenu</title>
        <link href='https://fonts.googleapis.com/css?family=Russo+One' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../resources/css/style.css" />
    </head>
    <body>
        <nav class="navbar navbar-fixed-top" id="navstyle1">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="http://telenu.tv/">
                        <img alt="Brand" class="img-responsive" src="../resources/images/logo.png">
                    </a>
                </div>

                <div id="navbar1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" class="social-button facebook fb" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://twitter.com/telenutv" class="social-button twitter tw" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="https://www.instagram.com/telenu.tv/" class="social-button instagram in" target="_blank"><i class="fa fa-instagram"></i></a></li>
                        <li class="dropdown">
                            <?php
                                $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; 
                                if(isset($_COOKIE["id"])){
                            ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <img class="profilePicture" src="../resources/images/Hon-Hon.png" alt="">
                                <?php echo $_SESSION["User_Name"] ?>
                                <i class="fa fa-ellipsis-v"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($_SESSION["Email"]=="elvigilantestudios@gmail.com") { ?>
                                <li><a class="btn btn-default" href="user/channelManager.php">Channel Manager</a></li>
                                <?php } ?>
                                <li><a class="btn btn-default" href="resources/php/logout.php">Salir</a></li>
                            </ul>
                            <?php } else { ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img class="usericon" src="../resources/images/usericon.png" alt=""> Ingreso / Registro <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php if(isset($_SESSION["LogInFail"])) { 
                                    echo '<li>',$_SESSION["LogInFail"],'</li>';
                                }
                                ?>
                                <form action="../resources/php/login.php" method="post" name="login" >
                                    <li><input type="email" name="Email" class="form-control text-center" required="required" placeholder="E-mail"></li>
                                    <li><input type="password" name="Password" class="form-control text-center" required="required" placeholder="Contraseña"></li>
                                    <li><input type="submit" name="Login" class="btn btn-default" value="Ingresar"></li>
                                </form>
                                <li role="separator" class="divider"></li>
                                <li><a href="#" data-toggle="modal" data-target="#regis">Registro</a></li>
                            </ul>
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid" id="newSeriesForm">
            <div class="row">
                <div class="col-xs-12 text-center" style="margin-top:50px">

<?php
    function url_get_contents ($Url) {
        if (!function_exists('curl_init')){ 
            die('CURL is not installed!');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    if(isset($_POST['RegisterSeries'])){

        echo '--- Starting Series Set-up ---<br><br>';

        $Name = $_POST['Name'];
        $Link = $_POST['URLName'];
        $Year = $_POST['Year'];

        $result = $conn->query("SELECT * FROM channel WHERE ChN='$Name'");
        $row_cnt = $result->rowCount();
        if ($row_cnt > 0){
           echo 'Telenu Channel already exists. <br><br>';
        } else {

            $stmt = $conn->prepare("INSERT INTO channel (ChT, ChN, ChL, ChY) VALUES ('series', ?, ?, ?)");
            if ($stmt->execute(array($Name, $Link, $Year))) {

                $idChannel = $conn->lastInsertId();

                echo 'Channel Created: ',$Name,' - ',$Year,' - ID: ',$idChannel,'<br><br>';
                
                $target_dir = "../resources/images/channel/";
                $uploadOk = 1;
                $target_file1 = $target_dir . basename($_FILES["Thumbnail"]["name"]);
                $target_file2 = $target_dir . basename($_FILES["Banner"]["name"]);
                $imageFileType1 = pathinfo($target_file1,PATHINFO_EXTENSION);
                $imageFileType2 = pathinfo($target_file2,PATHINFO_EXTENSION);
                move_uploaded_file($_FILES["Thumbnail"]["tmp_name"], $target_file1);
                move_uploaded_file($_FILES["Banner"]["tmp_name"], $target_file2);
                $Thumbnail = basename($_FILES["Thumbnail"]["name"]);
                $Banner = basename($_FILES["Banner"]["name"]);

                $stmt = $conn->prepare("INSERT INTO chanimg (ChThmb, ChBnr, ChID) VALUES (?, ?, ?)");
                if ($stmt->execute(array($Thumbnail, $Banner, $idChannel))) {
                    echo 'Channel Pictures Uploaded:<br>&nbsp - Thumbnail: '
                        ,$Thumbnail,'<br>&nbsp - Banner: '
                        ,$Banner,'<br><br>';
                } else { echo 'Error. Could not upload images.<br><br>'; }

                $optChanColumns = array();
                $optChanValues = array();
                $valCount = 0;

                $Genre = $_POST['Genre'];
                $Creator = $_POST['Creator'];
                array_push($optChanValues, $Genre);
                array_push($optChanValues, $Creator);
                if ($_POST['Winner']!=""){ 
                    $Winner = $_POST['Winner'];
                    array_push($optChanColumns, "Win");
                    array_push($optChanValues, $Winner);
                    $valCount++;
                }
                if ($_POST['Country']!=""){ 
                    $Country = $_POST['Country'];
                    array_push($optChanColumns, "Coun");
                    array_push($optChanValues, $Country);
                    $valCount++;
                }
                if ($_POST['Director']!=""){ 
                    $Director = $_POST['Director'];
                    array_push($optChanColumns, "Dir");
                    array_push($optChanValues, $Director);
                    $valCount++;
                }
                if ($_POST['Writer']!=""){ 
                    $Writer = $_POST['Writer'];
                    array_push($optChanColumns, "Wri");
                    array_push($optChanValues, $Writer);
                    $valCount++;
                }
                if ($_POST['Producer']!=""){ 
                    $Producer = $_POST['Producer'];
                    array_push($optChanColumns, "Pro");
                    array_push($optChanValues, $Producer);
                    $valCount++;
                }
                if ($_POST['Photography']!=""){ 
                    $Photography = $_POST['Photography'];
                    array_push($optChanColumns, "Pho");
                    array_push($optChanValues, $Photography);
                    $valCount++;
                }
                if ($_POST['Editor']!=""){ 
                    $Editor = $_POST['Editor'];
                    array_push($optChanColumns, "Edi");
                    array_push($optChanValues, $Editor);
                    $valCount++;
                }
                if ($_POST['Composer']!=""){ 
                    $Composer = $_POST['Composer'];
                    array_push($optChanColumns, "Com");
                    array_push($optChanValues, $Composer);
                    $valCount++;
                }
                if ($_POST['Cast']!=""){ 
                    $Cast = $_POST['Cast'];
                    array_push($optChanColumns, "Cast");
                    array_push($optChanValues, $Cast);
                    $valCount++;
                }
                $Synopsis = $_POST['Synopsis'];
                array_push($optChanValues, $Synopsis);
                array_push($optChanValues, $idChannel);

                if(empty($optChanColumns)) {
                    $stmt = $conn->prepare("INSERT INTO chaninfoseries (Genre, Cre, Syn, ChID) VALUES (?, ?, ?, ?)");
                    if ($stmt->execute(array($Genre, $Creator, $Synopsis, $idChannel))) {
                        echo 'Channel Info Uploaded Successfully:<br>';
                        foreach ($optChanValues as $value) {
                            echo '&nbsp - ',$value,'<br>';
                        }
                    } else { echo 'Error. Could not upload info.<br><br>'; }
                } else {
                    $valInput = "";
                    for ($i=0; $i < $valCount; $i++) { 
                        $valInput .= ",?";
                    }
                    $stmt = $conn->prepare("INSERT INTO chaninfoseries (Genre,Cre,".implode(",", $optChanColumns).",Syn,ChID) VALUES (?,?".$valInput.",?,?)");
                    foreach ($optChanValues as $key => $value) {
                        $key++;
                        $stmt->bindValue($key, $value);
                    }
                    if ($stmt->execute()) {
                        echo 'Channel Info Uploaded Successfully:<br>';
                        foreach ($optChanValues as $value) {
                            echo '&nbsp - ',$value,'<br>';
                        }
                    } else { echo 'Error. Could not upload info.<br><br>'; }
                }

                $seriesSource = $_POST['seriesSource'];

                switch ($seriesSource) {
                    case 'youtube':
                        $apikey = "AIzaSyA0mhtFXzJ_cFy6PMdGqSUJsV8ve8ANDRg";
                        $ytChID = "UC83dHaLZk7qyQRrelm7Bojw";

                        $seasons = array();
                        $count = 1;
                        while (isset($_POST['season'.$count.'YT'])){
                            $seasons[] = stripslashes($_POST['season'.$count.'YT']);
                            $count++;
                        }

                        echo '--- Initializing YouTube Search ---<br><br>';

                        $playlistQuery = array();
                        $playlistChannel = array();
                        $playlistSearch = json_decode(url_get_contents("https://www.googleapis.com/youtube/v3/playlists?part=id&channelId=$ytChID&maxResults=50&key=$apikey"), true);
                        foreach ($playlistSearch['items'] as $playlist) {
                            $playlistQuery [] = $playlist['id'];
                        }

                        $playlistQueryList = implode(",", $playlistQuery);

                        $playlistIdSearch = json_decode(url_get_contents("https://www.googleapis.com/youtube/v3/playlists?part=snippet&id=$playlistQueryList&key=$apikey"), true);
                        foreach ($playlistIdSearch['items'] as $playlist) {
                            $playlistChannel [] = array("title" => $playlist['snippet']['title'], "id" => $playlist['id']);
                            echo 'Obtained Playlist Title : ',$playlist['snippet']['title'],'<br>ID : ',$playlist['id'],'<br><br>';
                        }

                        if (!empty($playlistSearch['nextPageToken'])){
                            $nextPageToken = $playlistSearch['nextPageToken'];
                            while (!empty($nextPageToken)){
                                $playlistQuery = array();
                                $playlistSearch = json_decode(url_get_contents("https://www.googleapis.com/youtube/v3/playlists?part=id&channelId=$ytChID&maxResults=50&pageToken=$nextPageToken&key=$apikey"), true);
                                foreach ($playlistSearch['items'] as $playlist) {
                                    $playlistQuery [] = $playlist['id'];
                                }

                                $playlistQueryList = implode(",", $playlistQuery);

                                $playlistIdSearch = json_decode(url_get_contents("https://www.googleapis.com/youtube/v3/playlists?part=snippet&id=$playlistQueryList&key=$apikey"), true);
                                foreach ($playlistIdSearch['items'] as $playlist) {
                                    $playlistChannel [] = array("title" => $playlist['snippet']['title'], "id" => $playlist['id']);
                                    echo 'Obtained Playlist Title : ',$playlist['snippet']['title'],'<br>ID : ',$playlist['id'],'<br><br>';
                                }

                                if (!empty($playlistSearch['nextPageToken'])){
                                $nextPageToken = $playlistSearch['nextPageToken'];
                                } else {$nextPageToken = null;}
                            }
                        }

                        $playlistMatch = array();
                        foreach ($seasons as $seasonTitle) {
                            foreach ($playlistChannel as $playlist) {
                                if ($playlist['title'] == $seasonTitle) {
                                    $playlistMatch [] = $playlist['id'];
                                    echo "*** Obtained Youtube Channel Playlist: " . $playlist['title'] . " ID :" . $playlist['id'] . " ***<br><br>";
                                    break;
                                } else { echo "Playlist: " ,$playlist['title'], " did not match string: ", $seasonTitle ,"<br>"; }
                            }
                        }

                        $newMediaList = array();
                        foreach ($playlistMatch as $season => $playlistId) {
                            $season++;
                            $playlistSearchResult = json_decode(url_get_contents("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId=$playlistId&key=$apikey"), true);
                            foreach ($playlistSearchResult['items'] as $mediaData) {
                                $newMediaList[] = array($seriesSource,$season,$mediaData['snippet']['resourceId']['videoId'],$mediaData['snippet']['title'],$mediaData['snippet']['description'],$mediaData['snippet']['thumbnails']['medium']['url'],$mediaData['snippet']['publishedAt'],$idChannel);
                            }
                            if (!empty($playlistSearchResult['nextPageToken'])){
                                $nextPageToken = $playlistSearchResult['nextPageToken'];
                                while (!empty($nextPageToken)){
                                    $playlistSearchResult = json_decode(url_get_contents("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&pageToken=$nextPageToken&playlistId=" . $channelData['contentDetails']['relatedPlaylists']['uploads'] . "&key=$apikey"), true);
                                    foreach ($playlistSearchResult['items'] as $mediaData) {
                                        $newMediaList[] = array($seriesSource,$season,$mediaData['snippet']['resourceId']['videoId'],$mediaData['snippet']['title'],$mediaData['snippet']['description'],$mediaData['snippet']['thumbnails']['medium']['url'],$mediaData['snippet']['publishedAt'],$idChannel);
                                    }
                                    if (!empty($playlistSearchResult['nextPageToken'])){
                                    $nextPageToken = $playlistSearchResult['nextPageToken'];
                                    } else {$nextPageToken = null;}
                                }
                            }
                        }

                        $stmt = $conn->prepare("INSERT INTO media (mediaSource, mediaSeason, mediaId ,mediaTitle, mediaDescription, mediaThumbnail, mediaDate, ChID) VALUES (?,?,?,?,?,?,?,?)");
                        foreach ($newMediaList as $newVideo) {
                            foreach ($newVideo as $key => $value) {
                                $key++;
                                $stmt->bindValue($key, $value);
                            }
                            if ($stmt->execute()) {
                                echo 'New Video Uploaded Successfully: ',$newVideo['3'],'<br>';
                            } else { echo 'Error. Could not upload video: ',$newVideo['3'],'<br>'; }
                        } 
                        break;
                    
                    case 'vimeo':
                        require '../vendor/vimeo/autoload.php';
                        $client_id = "2d8ce5fec137d8da28158b5a1b979e2ce706e16d";
                        $client_secret = "bSJijpzXpB/mW7xZNkk8XA35JJAPkwTfGJK0wQKP5O+ZHJk+2Y2tPTLAd6W6WZtOn3fECB6nx92UFW0fz4Hm1zzV9I/YRwq0+BNG35XmlvbVxU9dgeiuzz0lKa6C/LIY";
                        $token = "6593bebaa361651e4bd9f3f11e88cb37";
                        $lib = new \Vimeo\Vimeo($client_id, $client_secret);
                        $lib->setToken($token);

                        $episodes = array();
                        $count = 1;
                        while (isset($_POST['episode'.$count])){
                            $episodes[] = array("mediaTitle" => stripslashes($_POST['episode'.$count]), "mediaSeason" => $_POST['episode'.$count.'season']);
                            $count++;
                        }

                        echo '--- Initializing Vimeo Search ---<br><br>';

                        $responseref = array();
                        $response = $lib->request('/me/likes?fields=uri,name,description,created_time,pictures.sizes', array(), 'GET');
                        foreach ($response['body']['data'] as $mediaData) {
                            for ($i=3; $i >= 0; $i--) { 
                                if (!empty($mediaData['pictures']['sizes'][$i])) {
                                    $mediaThumbnail = $mediaData['pictures']['sizes'][$i]['link'];
                                    break;
                                } 
                            }
                            if (empty($mediaData['description'])) { $mediaData['description'] = $Synopsis; }
                            $responseref[] = array("mediaId" => trim($mediaData['uri'], "/videos/"),"mediaTitle" => $mediaData['name'],"mediaDescription" => $mediaData['description'],"mediaThumbnail" => $mediaThumbnail,"mediaDate" => $mediaData['created_time']);
                        }
                        if (!empty($response['body']['paging']['next'])) {
                            $nextPageToken = $response['body']['paging']['next'];
                            while (!empty($nextPageToken)){
                                $response = $lib->request($nextPageToken, array(), 'GET');
                                foreach ($response['body']['data'] as $mediaData) {
                                    for ($i=3; $i >= 0; $i--) { 
                                        if (!empty($mediaData['pictures']['sizes'][$i])) {
                                            $mediaThumbnail = $mediaData['pictures']['sizes'][$i]['link'];
                                            break;
                                        } 
                                    }
                                    if (empty($mediaData['description'])) { $mediaData['description'] = $Synopsis; }
                                    $responseref[] = array("mediaId" => trim($mediaData['uri'], "/videos/"),"mediaTitle" => $mediaData['name'],"mediaDescription" => $mediaData['description'],"mediaThumbnail" => $mediaThumbnail,"mediaDate" => $mediaData['created_time']);
                                }
                                if (!empty($response['body']['paging']['next'])){
                                $nextPageToken = $response['body']['paging']['next'];
                                } else {$nextPageToken = null;}
                            }
                        }

                        $newMediaList = array();
                        foreach ($episodes as $episode) {
                            foreach ($responseref as $mediaData) {
                                if ($episode['mediaTitle'] == $mediaData['mediaTitle']) {
                                    $newMediaList[] = array($seriesSource,$episode['mediaSeason'],$mediaData['mediaId'],$mediaData['mediaTitle'],$mediaData['mediaDescription'],$mediaData['mediaThumbnail'],$mediaData['mediaDate'],$idChannel);
                                    echo "*** Obtained Vimeo Channel Episode: " . $mediaData['mediaTitle'] . " ***<br><br>";
                                    break;
                                } else { echo 'Episode: ',$episode['mediaTitle'],' did not match video string ',$mediaData['mediaTitle'],'<br>'; }
                            }
                        }

                        $stmt = $conn->prepare("INSERT INTO media (mediaSource, mediaSeason, mediaId ,mediaTitle, mediaDescription, mediaThumbnail, mediaDate, ChID) VALUES (?,?,?,?,?,?,?,?)");
                        foreach ($newMediaList as $newVideo) {
                            foreach ($newVideo as $key => $value) {
                                $key++;
                                $stmt->bindValue($key, $value);
                            }
                            if ($stmt->execute()) {
                                echo 'New Video Uploaded Successfully: ',$newVideo['3'],'<br>';
                            } else { echo 'Error. Could not upload video: ',$newVideo['3'],'<br>'; }
                            echo "<br>";
                        }
                        break;
                }

                echo '<br>New Telenu Channel Created Successfully<br><br>';

            } else { echo 'Error. Could not insert into "channel".<br><br>'; }
        }
    }

    if(isset($_POST['RegisterVlog'])){

        echo '--- Starting Series Set-up ---<br><br>';

        $Name = $_POST['Name'];
        $Link = $_POST['URLName'];
        $Year = $_POST['Year'];
        $youtubeUserName = $_POST['YTUsername'];
        $youtubePlaylist = $_POST['YTPlaylist'];

        $result = $conn->query("SELECT * FROM channel WHERE ChN='$Name'");
        $row_cnt = $result->rowCount();
        if ($row_cnt > 0){
           echo 'Telenu Channel already exists. <br><br>';
        } else {

            $stmt = $conn->prepare("INSERT INTO channel (ChT, ChN, ChL, ChY) VALUES ('vlog', ?, ?, ?)");
            if ($stmt->execute(array($Name, $Link, $Year, $youtubeUserName, $youtubePlaylist))) {

                $idChannel = $conn->lastInsertId();

                echo 'Channel Created: ',$Name,' - ',$Year,' - ID: ',$idChannel,'<br><br>';
                
                $target_dir = "../resources/images/channel/";
                $uploadOk = 1;
                $target_file1 = $target_dir . basename($_FILES["Thumbnail"]["name"]);
                $target_file2 = $target_dir . basename($_FILES["Banner"]["name"]);
                $imageFileType1 = pathinfo($target_file1,PATHINFO_EXTENSION);
                $imageFileType2 = pathinfo($target_file2,PATHINFO_EXTENSION);
                move_uploaded_file($_FILES["Thumbnail"]["tmp_name"], $target_file1);
                move_uploaded_file($_FILES["Banner"]["tmp_name"], $target_file2);
                $Thumbnail = basename($_FILES["Thumbnail"]["name"]);
                $Banner = basename($_FILES["Banner"]["name"]);

                $stmt = $conn->prepare("INSERT INTO chanimg (ChThmb, ChBnr, ChID) VALUES (?, ?, ?)");
                if ($stmt->execute(array($Thumbnail, $Banner, $idChannel))) {
                    echo 'Channel Pictures Uploaded:<br>&nbsp - Thumbnail: '
                        ,$Thumbnail,'<br>&nbsp - Banner: '
                        ,$Banner,'<br><br>';
                } else { echo 'Error. Could not upload images.<br><br>'; }

                $optChanColumns = array();
                $optChanValues = array();
                $valCount = 0;

                $Genre = $_POST['Genre'];
                $Creator = $_POST['Creator'];
                array_push($optChanValues, $Genre);
                array_push($optChanValues, $Creator);
                if ($_POST['Country']!=""){ 
                    $Country = $_POST['Country'];
                    array_push($optChanColumns, "Coun");
                    array_push($optChanValues, $Country);
                    $valCount++;
                }
                $Synopsis = $_POST['Synopsis'];
                array_push($optChanValues, $Synopsis);
                array_push($optChanValues, $idChannel);

                if(empty($optChanColumns)) {
                    $stmt = $conn->prepare("INSERT INTO chaninfoseries (Genre, Cre, Syn, ChID) VALUES (?, ?, ?, ?)");
                    if ($stmt->execute(array($Genre, $Creator, $Synopsis, $idChannel))) {
                        echo 'Channel Info Uploaded Successfully:<br>';
                        foreach ($optChanValues as $value) {
                            echo '&nbsp - ',$value,'<br>';
                        }
                    } else { echo 'Error. Could not upload info.<br><br>'; }
                } else {
                    $valInput = "";
                    for ($i=0; $i < $valCount; $i++) { 
                        $valInput .= ",?";
                    }
                    $stmt = $conn->prepare("INSERT INTO chaninfoseries (Genre,Cre,".implode(",", $optChanColumns).",Syn,ChID) VALUES (?,?".$valInput.",?,?)");
                    foreach ($optChanValues as $key => $value) {
                        $key++;
                        $stmt->bindValue($key, $value);
                    }
                    if ($stmt->execute()) {
                        echo 'Channel Info Uploaded Successfully:<br>';
                        foreach ($optChanValues as $value) {
                            echo '&nbsp - ',$value,'<br>';
                        }
                    } else { echo 'Error. Could not upload info.<br><br>'; }
                }

                $apikey = "AIzaSyA0mhtFXzJ_cFy6PMdGqSUJsV8ve8ANDRg";

                echo '--- Initializing YouTube Search ---<br><br>';

                $channelSearch = json_decode(url_get_contents("https://www.googleapis.com/youtube/v3/channels?part=contentDetails&forUsername=$youtubeUserName&key=$apikey"), true);
                foreach ($channelSearch['items'] as $channelData) 
                {
                    echo "Obtained Youtube Channel ID: " . $channelData['id'] . "<br><br>";
                }

                $ChannelId = "";
                if($channelSearch['pageInfo']['totalResults'] == 0) {
                    echo "Obtained Youtube Channel ID: " . $youtubeUserName . "<br><br>";
                    $ChannelId = $youtubeUserName;
                    $playlistSearch = json_decode(url_get_contents("https://www.googleapis.com/youtube/v3/playlists?part=id&channelId=".$youtubeUserName."&maxResults=50&key=$apikey"), true);
                } else {
                    $ChannelId = $channelSearch["items"]["0"]["id"];
                    $playlistSearch = json_decode(url_get_contents("https://www.googleapis.com/youtube/v3/playlists?part=id&channelId=".$channelSearch["items"]["0"]["id"]."&maxResults=50&key=$apikey"), true);
                }

                foreach ($playlistSearch['items'] as $playlist) {
                    $playlistQuery [] = $playlist['id'];
                }

                $playlistQueryList = implode(",", $playlistQuery);

                $playlistIdSearch = json_decode(url_get_contents("https://www.googleapis.com/youtube/v3/playlists?part=snippet&id=$playlistQueryList&key=$apikey"), true);
                foreach ($playlistIdSearch['items'] as $playlist) {
                    $playlistChannel [] = array("title" => $playlist['snippet']['title'], "id" => $playlist['id']);
                    echo 'Obtained Playlist Title : ',$playlist['snippet']['title'],'<br>ID : ',$playlist['id'],'<br><br>';
                }

                if (!empty($playlistSearch['nextPageToken'])){
                    $nextPageToken = $playlistSearch['nextPageToken'];
                    while (!empty($nextPageToken)){
                        $playlistQuery = array();
                        $playlistSearch = json_decode(url_get_contents("https://www.googleapis.com/youtube/v3/playlists?part=id&channelId=$ytChID&maxResults=50&pageToken=$nextPageToken&key=$apikey"), true);
                        foreach ($playlistSearch['items'] as $playlist) {
                            $playlistQuery [] = $playlist['id'];
                        }

                        $playlistQueryList = implode(",", $playlistQuery);

                        $playlistIdSearch = json_decode(url_get_contents("https://www.googleapis.com/youtube/v3/playlists?part=snippet&id=$playlistQueryList&key=$apikey"), true);
                        foreach ($playlistIdSearch['items'] as $playlist) {
                            $playlistChannel [] = array("title" => $playlist['snippet']['title'], "id" => $playlist['id']);
                            echo 'Obtained Playlist Title : ',$playlist['snippet']['title'],'<br>ID : ',$playlist['id'],'<br><br>';
                        }

                        if (!empty($playlistSearch['nextPageToken'])){
                        $nextPageToken = $playlistSearch['nextPageToken'];
                        } else {$nextPageToken = null;}
                    }
                }

                $PlaylistId = "";
                foreach ($playlistChannel as $playlist) {
                    if ($playlist['title'] == $youtubePlaylist) {
                        $PlaylistId = $playlist['id'];
                        echo "*** Obtained Youtube Channel Playlist: " . $playlist['title'] . " ID :" . $playlist['id'] . " ***<br><br>";
                        break;
                    } else { echo "Playlist: " ,$playlist['title'], " did not match string: ", $youtubePlaylist ,"<br>"; }
                }

                $newMediaList = array();
                $playlistSearchResult = json_decode(url_get_contents("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId=$PlaylistId&key=$apikey"), true);
                foreach ($playlistSearchResult['items'] as $mediaData) {
                    $newMediaList[] = array("youtube","0",$mediaData['snippet']['resourceId']['videoId'],$mediaData['snippet']['title'],$mediaData['snippet']['description'],$mediaData['snippet']['thumbnails']['medium']['url'],$mediaData['snippet']['publishedAt'],$idChannel);
                }
                if (!empty($playlistSearchResult['nextPageToken'])){
                    $nextPageToken = $playlistSearchResult['nextPageToken'];
                    while (!empty($nextPageToken)){
                        $playlistSearchResult = json_decode(url_get_contents("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&pageToken=$nextPageToken&playlistId=$PlaylistId&key=$apikey"), true);
                        foreach ($playlistSearchResult['items'] as $mediaData) {
                            $newMediaList[] = array("youtube","0",$mediaData['snippet']['resourceId']['videoId'],$mediaData['snippet']['title'],$mediaData['snippet']['description'],$mediaData['snippet']['thumbnails']['medium']['url'],$mediaData['snippet']['publishedAt'],$idChannel);
                        }
                        if (!empty($playlistSearchResult['nextPageToken'])){
                        $nextPageToken = $playlistSearchResult['nextPageToken'];
                        } else {$nextPageToken = null;}
                    }
                }

                $stmt = $conn->prepare("UPDATE channel SET ChSrcID = ?, ChSrcPL = ? WHERE ID = ?");
                $stmt->execute(array($ChannelId, $PlaylistId, $idChannel));

                $stmt = $conn->prepare("INSERT INTO media (mediaSource, mediaSeason, mediaId ,mediaTitle, mediaDescription, mediaThumbnail, mediaDate, ChID) VALUES (?,?,?,?,?,?,?,?)");
                foreach ($newMediaList as $newVideo) {
                    foreach ($newVideo as $key => $value) {
                        $key++;
                        $stmt->bindValue($key, $value);
                    }
                    if ($stmt->execute()) {
                        echo 'New Video Uploaded Successfully: ',$newVideo['3'],'<br>';
                    } else { echo 'Error. Could not upload video: ',$newVideo['3'],'<br>'; }
                } 

                echo '<br>New Telenu Channel Created Successfully<br><br>';

            } else { echo 'Error. Could not insert into "channel".<br><br>'; }
        }
    }

    if(isset($_POST['RegisterShort'])){

        echo '--- Starting Short Set-up ---<br><br>';

        $Name = $_POST['Name'];
        $Link = $_POST['URLName'];
        $Year = $_POST['Year'];

        $result = $conn->query("SELECT * FROM channel WHERE ChN='$Name'");
        $row_cnt = $result->rowCount();
        if ($row_cnt > 0){
           echo 'Telenu Channel already exists. <br><br>';
        } else {

            $stmt = $conn->prepare("INSERT INTO channel (ChT, ChN, ChL, ChY) VALUES ('short', ?, ?, ?)");
            if ($stmt->execute(array($Name, $Link, $Year))) {

                $idChannel = $conn->lastInsertId();

                echo 'Channel Created: ',$Name,' - ',$Year,' - ID: ',$idChannel,'<br><br>';
                
                $target_dir = "../resources/images/channel/";
                $uploadOk = 1;
                $target_file1 = $target_dir . basename($_FILES["Thumbnail"]["name"]);
                $target_file2 = $target_dir . basename($_FILES["Banner"]["name"]);
                $imageFileType1 = pathinfo($target_file1,PATHINFO_EXTENSION);
                $imageFileType2 = pathinfo($target_file2,PATHINFO_EXTENSION);
                move_uploaded_file($_FILES["Thumbnail"]["tmp_name"], $target_file1);
                move_uploaded_file($_FILES["Banner"]["tmp_name"], $target_file2);
                $Thumbnail = basename($_FILES["Thumbnail"]["name"]);
                $Banner = basename($_FILES["Banner"]["name"]);

                $stmt = $conn->prepare("INSERT INTO chanimg (ChThmb, ChBnr, ChID) VALUES (?, ?, ?)");
                if ($stmt->execute(array($Thumbnail, $Banner, $idChannel))) {
                    echo 'Channel Pictures Uploaded:<br>&nbsp - Thumbnail: '
                        ,$Thumbnail,'<br>&nbsp - Banner: '
                        ,$Banner,'<br><br>';
                } else { echo 'Error. Could not upload images.<br><br>'; }

                $optChanColumns = array();
                $optChanValues = array();
                $valCount = 0;

                $Genre = $_POST['Genre'];
                $Creator = $_POST['Creator'];
                array_push($optChanValues, $Genre);
                array_push($optChanValues, $Creator);
                if ($_POST['Country']!=""){ 
                    $Country = $_POST['Country'];
                    array_push($optChanColumns, "Coun");
                    array_push($optChanValues, $Country);
                    $valCount++;
                }
                if ($_POST['Director']!=""){ 
                    $Director = $_POST['Director'];
                    array_push($optChanColumns, "Dir");
                    array_push($optChanValues, $Director);
                    $valCount++;
                }
                if ($_POST['Writer']!=""){ 
                    $Writer = $_POST['Writer'];
                    array_push($optChanColumns, "Wri");
                    array_push($optChanValues, $Writer);
                    $valCount++;
                }
                if ($_POST['Producer']!=""){ 
                    $Producer = $_POST['Producer'];
                    array_push($optChanColumns, "Pro");
                    array_push($optChanValues, $Producer);
                    $valCount++;
                }
                if ($_POST['Photography']!=""){ 
                    $Photography = $_POST['Photography'];
                    array_push($optChanColumns, "Pho");
                    array_push($optChanValues, $Photography);
                    $valCount++;
                }
                if ($_POST['Editor']!=""){ 
                    $Editor = $_POST['Editor'];
                    array_push($optChanColumns, "Edi");
                    array_push($optChanValues, $Editor);
                    $valCount++;
                }
                if ($_POST['Composer']!=""){ 
                    $Composer = $_POST['Composer'];
                    array_push($optChanColumns, "Com");
                    array_push($optChanValues, $Composer);
                    $valCount++;
                }
                if ($_POST['Cast']!=""){ 
                    $Cast = $_POST['Cast'];
                    array_push($optChanColumns, "Cast");
                    array_push($optChanValues, $Cast);
                    $valCount++;
                }
                $Synopsis = $_POST['Synopsis'];
                array_push($optChanValues, $Synopsis);
                array_push($optChanValues, $idChannel);

                if(empty($optChanColumns)) {
                    $stmt = $conn->prepare("INSERT INTO chaninfoseries (Genre, Cre, Syn, ChID) VALUES (?, ?, ?, ?)");
                    if ($stmt->execute(array($Genre, $Creator, $Synopsis, $idChannel))) {
                        echo 'Channel Info Uploaded Successfully:<br>';
                        foreach ($optChanValues as $value) {
                            echo '&nbsp - ',$value,'<br>';
                        }
                    } else { echo 'Error. Could not upload info.<br><br>'; }
                } else {
                    $valInput = "";
                    for ($i=0; $i < $valCount; $i++) { 
                        $valInput .= ",?";
                    }
                    $stmt = $conn->prepare("INSERT INTO chaninfoseries (Genre,Cre,".implode(",", $optChanColumns).",Syn,ChID) VALUES (?,?".$valInput.",?,?)");
                    foreach ($optChanValues as $key => $value) {
                        $key++;
                        $stmt->bindValue($key, $value);
                    }
                    if ($stmt->execute()) {
                        echo 'Channel Info Uploaded Successfully:<br>';
                        foreach ($optChanValues as $value) {
                            echo '&nbsp - ',$value,'<br>';
                        }
                    } else { echo 'Error. Could not upload info.<br><br>'; }
                }

                $seriesSource = $_POST['seriesSource'];

                switch ($seriesSource) {
                    case 'youtube':
                        
                        $apikey = "AIzaSyA0mhtFXzJ_cFy6PMdGqSUJsV8ve8ANDRg";
                        $YTVideoID = $_POST['YTVideoID'];

                        echo '--- Initializing YouTube Search ---<br><br>';

                        $mediaData = json_decode(url_get_contents("https://www.googleapis.com/youtube/v3/videos?part=snippet&id=$YTVideoID&key=$apikey"), true);
                        $videoData = array("youtube","0",$mediaData['items']['0']['id'],$mediaData['items']['0']['snippet']['title'],$mediaData['items']['0']['snippet']['description'],$mediaData['items']['0']['snippet']['thumbnails']['medium']['url'],$mediaData['items']['0']['snippet']['publishedAt'],$idChannel);

                        $stmt = $conn->prepare("INSERT INTO media (mediaSource, mediaSeason, mediaId ,mediaTitle, mediaDescription, mediaThumbnail, mediaDate, ChID) VALUES (?,?,?,?,?,?,?,?)");
                        foreach ($videoData as $key => $value) {
                            $key++;
                            $stmt->bindValue($key, $value);
                        }
                        if ($stmt->execute()) {
                            echo 'New Video Uploaded Successfully: ',$videoData['3'],'<br>';
                        } else { echo 'Error. Could not upload video: ',$videoData['3'],'<br>'; }

                        break;
                    
                    case 'vimeo':
                        require '../vendor/vimeo/autoload.php';
                        $client_id = "2d8ce5fec137d8da28158b5a1b979e2ce706e16d";
                        $client_secret = "bSJijpzXpB/mW7xZNkk8XA35JJAPkwTfGJK0wQKP5O+ZHJk+2Y2tPTLAd6W6WZtOn3fECB6nx92UFW0fz4Hm1zzV9I/YRwq0+BNG35XmlvbVxU9dgeiuzz0lKa6C/LIY";
                        $token = "6593bebaa361651e4bd9f3f11e88cb37";
                        $lib = new \Vimeo\Vimeo($client_id, $client_secret);
                        $lib->setToken($token);

                        $VMVideoID = $_POST['VMVideoID'];
                        $mediaDescription = "";

                        echo '--- Initializing Vimeo Search ---<br><br>';

                        $response = $lib->request("/videos/$VMVideoID?fields=uri,name,description,created_time,pictures.sizes", array(), "GET");
                        $mediaData = $response['body'];

                        for ($i=3; $i >= 0; $i--) { 
                            if (!empty($mediaData['pictures']['sizes'][$i])) {
                                $mediaThumbnail = $mediaData['pictures']['sizes'][$i]['link'];
                                break;
                            } 
                        }
                        $mediaDescription = (empty($mediaData['description'])) ? $Synopsis : $mediaData['description'];

                        $videoData = array("vimeo", "0", trim($mediaData['uri'], "/videos/"), $mediaData['name'], $mediaDescription ,$mediaThumbnail ,$mediaData['created_time'], $idChannel);

                        $stmt = $conn->prepare("INSERT INTO media (mediaSource, mediaSeason, mediaId ,mediaTitle, mediaDescription, mediaThumbnail, mediaDate, ChID) VALUES (?,?,?,?,?,?,?,?)");
                        foreach ($videoData as $key => $value) {
                            $key++;
                            $stmt->bindValue($key, $value);
                        }
                        if ($stmt->execute()) {
                            echo 'New Video Uploaded Successfully: ',$videoData['3'],'<br>';
                        } else { echo 'Error. Could not upload video: ',$videoData['3'],'<br>'; }

                        break;
                }

                echo '<br>New Telenu Channel Created Successfully<br><br>';

            } else { echo 'Error. Could not insert into "channel".<br><br>'; }
        }
    }
?>

                <a class="btn btn-default" href="channelManager.php">Regresar</a>
                </div>
            </div>
        </div>
        
        <script type="text/javascript" src="../vendor/jquery.min.js"></script>
        <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../resources/js/script.js"></script>
       
    </body>
</html>













