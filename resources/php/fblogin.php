<?php
    session_start();
    require 'connToServer.php';
    require '../../vendor/facebook/facebook.php';

    $conn = db_connect();

    $facebook = new Facebook(array(
      'appId'  => '245714182449029',
      'secret' => 'ad6f30e67aa79dda0fc39aa5861f6f0f',
    ));

    $user = $facebook->getUser();

    if ($user) {
      try {
        $user_profile = $facebook->api('/me?fields=id,name,email');
      } catch (FacebookApiException $e) {
        error_log($e);
        $user = null;
      }
    }

    $Name = $user_profile['name'];
    $EM = $user_profile['email'];
    $Picture = "https://graph.facebook.com/".$user."/picture?type=large";

    $stmt = $conn->prepare("SELECT ID FROM user WHERE EM = ?");
    $stmt->execute(array($EM));
    $id = $stmt->fetchColumn();

    if(empty($id)) {
        $stmt = $conn->prepare("INSERT INTO user (Name, EM, Picture) VALUES (?, ?, ?)");
        $stmt->execute(array($Name, $EM, $Picture));
        $stmt = $conn->prepare("SELECT ID FROM user WHERE EM = ?");
        $stmt->execute(array($EM));
        $id = $stmt->fetchColumn();
    }
    
    $redirect_url = (isset($_SESSION['redirect_url'])) ? $_SESSION['redirect_url'] : '/';
    unset($_SESSION['redirect_url']);
    
    setcookie('id', $id, time()+60*60*24*365, '/');
    $_SESSION["showLogin"] = "yes";
    header('Location: '. $redirect_url);


?>