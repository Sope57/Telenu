<?php
	session_start();
 	$redirect_url = (isset($_SESSION['redirect_url'])) ? $_SESSION['redirect_url'] : '/';
 	unset($_COOKIE["id"]);
 	setcookie('id', '', time()-3600, '/');
	session_destroy();
	header('Location: '. $redirect_url);
 ?>














