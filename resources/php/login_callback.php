<?php
	session_start();
	require_once 'http://telenu.tv/vendor/Facebook/autoload.php';

	$fb = new Facebook\Facebook([
	'app_id' => '245714182449029',
	'app_secret' => 'ad6f30e67aa79dda0fc39aa5861f6f0f',
	'default_graph_version' => 'v2.5',
	]);

	$helper = $fb->getRedirectLoginHelper();
	try {
		$accessToken = $helper->getAccessToken();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		// echo 'Graph returned an error: ' . $e->getMessage();
		header('Location: ../../index.php');
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		// echo 'Facebook SDK returned an error: ' . $e->getMessage();
		header('Location: ../../index.php');
		exit;
	}

	if (isset($accessToken)) {
		// Logged in!
		$fb_access_token_short = (string) $accessToken;

		// OAuth 2.0 client handler
		$oAuth2Client = $fb->getOAuth2Client();
		// Exchanges a short-lived access token for a long-lived one
		$longAT = $oAuth2Client->getLongLivedAccessToken($fb_access_token_short);

		// Logged in!
		$_SESSION['fb_access_token'] = (string) $longAT;

		header('Location: http://telenu.tv/resources/php/fblogin.php');
	}
?>

<html>
	<head>
	</head>
	<body>
	</body>
</html>