<?php
    require 'connToServer.php';
    require 'password.php';

    $conn =  db_connect();

    $Email = $_POST['Email'];
    $PW = $_POST['Password'];
    $stmt = $conn->prepare("SELECT ID, PW FROM user WHERE EM = ?");
    $stmt->execute(array($Email));
    $row = $stmt->fetch();
    session_start();
    $redirect_url = (isset($_SESSION['redirect_url'])) ? $_SESSION['redirect_url'] : '/';
    unset($_SESSION['redirect_url']);
    if (password_verify($PW, $row['PW'])) {
        setcookie('id', $row['ID'], time()+60*60*24*365, '/');
        $_SESSION["showLogin"] = "yes";
        header('Location: '. $redirect_url);
    } else {
        $_SESSION["LogInFail"] = "Email and Password do not match. Please try again.";
        header('Location: '. $redirect_url);
    }
?>