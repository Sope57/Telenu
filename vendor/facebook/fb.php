<?php 
	require 'facebook.php';

	$facebook = new Facebook(array(
	  'appId'  => '245714182449029',
	  'secret' => 'ad6f30e67aa79dda0fc39aa5861f6f0f',
	));

	$_SESSION['loginUrl'] = $facebook->getLoginUrl(array(
	    'scope' => 'email'
	));

	function printFBlogin($loginUrl, $version) {
		if ($version == "desktop") {
			echo '<a href="' . $loginUrl . '"><p class="fblogin"><i class="fa fa-facebook"></i>   Ingresa con Facebook!</p></a>';
		} else {
			echo '<li><a href="' . $loginUrl . '"><p class="fblogin"><i class="fa fa-facebook"></i>   Ingresa con Facebook!</p></a></li>';
		}
	}
?>
