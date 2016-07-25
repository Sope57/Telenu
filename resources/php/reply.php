<?php
    require_once 'connToServer.php';
    require_once 'channel.php';
    require_once 'getSession.php';

    if ($_REQUEST['text_cmt']=="") {
        } else {
        $vidkey = $_SESSION['vidkey'];
        $user = $_SESSION["User_Name"];
        $com_code = $_REQUEST['par_code'];
        $reply = $_REQUEST['text_cmt'];
        $date = date('Y-m-d H:i:s');

        $rand = checkString();

        $stmt = $conn->prepare("INSERT INTO comments (file_id, comment, com_code, is_child, par_code, author, date) VALUES (?, ?, ?, '1', ?, ?, ?)");
        $stmt->execute(array($vidkey, $reply, $rand, $com_code, $user, $date));
    }
?>