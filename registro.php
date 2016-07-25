<?php
	require_once 'resources/php/connToServer.php';
    require_once 'resources/php/getSession.php';

    $conn = db_connect();
    
	if($_SESSION["Email"]=="elvigilantestudios@gmail.com" || $_SESSION["Email"]=="alejandro.manuel.anell@gmail.com"){
	    $stmt = $conn->prepare("SELECT Name, EM FROM user");
	    $stmt->execute();

	    $result = $stmt->fetchAll();

	    echo 'Registrados (',count($result),') :<br><br>';

	    foreach ($result as $value) {
	    	echo $value["Name"] , " - " , $value["EM"] , "<br>";
	    }
	} else {
		header('Location: http://telenu.tv');
	}
?>