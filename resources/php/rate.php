<?php
    require_once 'connToServer.php';
    require_once 'channel.php';
    require_once 'getSession.php';

    $channelID = $_REQUEST['channelID'];
    $user = $_COOKIE["id"];
    $rating = $_REQUEST['rating-input-1'];

    $stmt = $conn->prepare("SELECT rating FROM ratings WHERE ChID = ? AND ratedBy = ?");
    $stmt->execute(array($channelID, $user));
    $result = $stmt->fetch();

    if(empty($result)) {
        $stmt = $conn->prepare("INSERT INTO ratings (rating, ratedBy, ChID) VALUES (?, ?, ?)");
    } else {
        $stmt = $conn->prepare("UPDATE ratings SET rating = ? WHERE ratedBy = ? AND ChID = ?");
    }
    $stmt->execute(array($rating, $user, $channelID));
?>