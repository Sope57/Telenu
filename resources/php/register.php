<?php
    session_start();

    require 'connToServer.php';
    require 'password.php';

    $conn = db_connect();

    $Name = $_POST['First_Name'] . ' ' . $_POST['Last_Name'];
    $UN = $_POST['User_Name'];
    $EM = $_POST['Email'];
    $PW = $_POST['Password'];
    $PW2 = $_POST['Password2'];

    if (strlen($_FILES["UserImageUpload"]["name"]) > 0) {
        $target_dir = "../images/user/";
        $uploadOk = 1;
        $target_file1 = $target_dir . basename($_FILES["UserImageUpload"]["name"]);
        $imageFileType1 = pathinfo($target_file1,PATHINFO_EXTENSION);
        move_uploaded_file($_FILES["UserImageUpload"]["tmp_name"], $target_file1);
        $UserImage = "http://telenu.tv/resources/images/user/".basename($_FILES["UserImageUpload"]["name"]);
    } else {
        $UserImage = "http://telenu.tv/resources/images/user/".$_POST["UserImage"].".png";
    }
    $redirect_url = (isset($_SESSION['redirect_url'])) ? $_SESSION['redirect_url'] : '/';
    unset($_SESSION['redirect_url']);
    if ($PW === $PW2) {
        $StorePassword = password_hash($PW, PASSWORD_BCRYPT, array('cost' => 10));
        $stmt = $conn->prepare("INSERT INTO user (Name, UN, EM, PW, Picture) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute(array($Name, $UN, $EM, $StorePassword, $UserImage));
        $id = $conn->lastInsertId();
        setcookie('id', $id, time()+60*60*24*365, '/');
        $_SESSION["showLogin"] = "yes";
        $_SESSION["firstLogin"] = "yes";
        // header('Location: welcomeEmail.php?email='.$EM.'&redirect='.$redirect_url);
        header('Location: '. $redirect_url);
    } else {
        $_SESSION["LogInFail"] = "Passwords did not match. Please try again.";
        header('Location: '. $redirect_url);
    }
?>