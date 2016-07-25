<?php
    require_once 'connToServer.php';
    require_once 'channel.php';
    require_once 'getSession.php';

	if ($_REQUEST['text_cmt']=="") {
		} else {
	    $vidkey = $_SESSION['ChInfo']['ID'];
	    $user = $_SESSION["User_Name"];
	    $reply = stripslashes($_REQUEST['text_cmt']);
	    $date = date('Y-m-d H:i:s');

	    $rand = checkString();

	    $stmt = $conn->prepare("INSERT INTO comments (file_id, comment, com_code, author, date) VALUES (?, ?, ?, ?, ?)");
	    $stmt->execute(array($vidkey, $reply, $rand, $user, $date));
	}
?>