<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body style="text-align:center">
        

        <?php
            include 'resources/php/connToServer.php';
            
            $conn = db_connect();

            function url_get_contents ($Url) {
                if (!function_exists('curl_init')){ 
                    die('CURL is not installed!');
                }
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $Url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output = curl_exec($ch);
                curl_close($ch);
                return $output;
            }

            // function sendNewVideo ($emails, $channel, $videoData) {
            //     date_default_timezone_set('Etc/UTC');

            //     require '../../vendor/PHPMailer/PHPMailerAutoload.php';

            //     $channelName = htmlentities($channel['ChN']);
            //     $videoTitle = htmlentities($videoData['5']);

            //     $mssg = '<html><body>'.
            //         '<table style="width: 100%; text-align: center;"><tr>'.
            //         '<td style="width: auto;"></td><td style="width: 700px;">'.
            //         '<table style="width: 100%; background-color: black;" bgcolor="black"><tr><th style="width: 100%;"><a href="http://telenu.tv/" target"_blank"><img src="http://telenu.tv/resources/images/emailup.jpg" alt="" style="width: 700px;" /></a></th></tr></table>'.
            //         '<table style="width: 100%; background-color: black;" bgcolor="black"><tr><th style="width: 90px;"></th><th style="width: 500px;"></th><th style="width: 90px;"></th></tr><tr><td></td><td style="color: white; text-align: left; padding: 10px 0;" align="left"><h1 style="text-align: center; font-size: 30px;">&iexcl;Nuevo video de <strong>'.$channelName.'</strong>!</h1><td></td></tr></table>'.
            //         '<table style="width: 100%; background-color: black;" bgcolor="black"><tr><th style="width: 190px;"></th><th style="width: 320px"><a href="http://telenu.tv/channel/'.$channel['ChL'].'&v='.$videoData['2'].'" target="_blank"><img src="'.$videoTitle.'" alt="" style="width: 320px;" /></a></th><th style="width: 190px;"></th></tr></table>'.
            //         '<table style="width: 100%; background-color: black;" bgcolor="black"><tr><th style="width: 90px;"></th><th style="width: 500px;"></th><th style="width: 90px;"></th></tr><tr><td></td><td style="color: white; text-align: left; padding: 10px 0;" align="left"><h1 style="text-align: center; font-size: 20px;">'.$videoData['3'].'</h1>&Eacute;ste video est&aacute; bien ching&oacute;n, dale click y dale like y suscr&iacute;bete y la madre.<br><br>&iexcl;Comparte este video que est&aacute; bien ching&oacute;n con tus amigos y tus amiguis!</td><td></td></tr></table>'.
            //         '<table style="width: 100%; background-color: black;" bgcolor="black"><tr><th style="width: 100%;"><img src="http://telenu.tv/resources/images/emaildown.jpg" alt="" style="width: 700px;" /></th></tr></table>'.
            //         '<table style="width: 100%; background-color: black;" bgcolor="black"><tr><th style="width: 90px;"></th><th style="width: 500px;"></th><th style="width: 90px;"></th></tr><tr><td></td><td style="color: white; text-align: left; padding: 10px 0;" align="left">Quieres dejar de recibir &eacute;ste correo que est&aacute; bien ching&oacute;n? Da click <a href="http://telenu.tv">aqu&iacute;</a>.</td><td></td></tr></table>'.
            //         '</td><td style="width: auto;"></td></tr></table>'.
            //     '</body></html>';

            //     foreach ($emails as $email) {
            //         $mail = new PHPMailer;
            //         $mail->isSMTP();
            //         $mail->SMTPDebug = 0;
            //         $mail->Debugoutput = 'html';
            //         $mail->Host = 'smtp.gmail.com';
            //         $mail->Port = 587;
            //         $mail->SMTPSecure = 'tls';
            //         $mail->SMTPAuth = true;
            //         $mail->Username = "telenu.tv@gmail.com";
            //         $mail->Password = "vigilante_18";
            //         $mail->setFrom('telenu.tv@gmail.com', 'Telenu.TV');
            //         $mail->addAddress($email);
            //         // $mail->addAddress($email['EM']);
            //         $mail->Subject = 'Nuevo video de '.$channelName.'!';
            //         $mail->WordWrap = 50;
            //         $mail->IsHTML(true);           
            //         $mail->msgHTML($mssg);
            //         $mail->send();
            //     }
            // }

            // $stmt = $conn->prepare("SELECT EM FROM user");
            // $stmt->execute(array());
            // $emails = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // $emails = ["jorgecq57@hotmail.com", "elvigilantestudios@gmail.com"];

            $stmt = $conn->prepare("SELECT * FROM channel WHERE channel.ChT = ? OR channel.ChT = ?");
            $stmt->execute(array("vlog", "webshow"));
            $channels = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($channels as $channel) {
                // switch ($channel["mediaSource"]) {
                //     case 'youtube':
                        $apikey = "AIzaSyA0mhtFXzJ_cFy6PMdGqSUJsV8ve8ANDRg";

                        echo '***** Initializing New Video Search for ',ucfirst($channel["ChT"]),': ',$channel["ChN"],' *****<br><br>';

                        $stmt = $conn->prepare("SELECT mediaId FROM media WHERE ChID = ?");
                        $stmt->execute(array($channel["ID"]));
                        $media = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

                        echo 'Video count on Database: ',count($media),'<br>';

                        $mediaList = array();
                        $searchResult = json_decode(url_get_contents("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId=".$channel["ChSrcPL"]."&fields=items%2Fsnippet%2FresourceId%2FvideoId%2CnextPageToken&key=$apikey"), true);
                        foreach ($searchResult['items'] as $mediaData) {
                            $mediaList[] = $mediaData['snippet']['resourceId']['videoId'];
                        }
                        if (!empty($searchResult['nextPageToken'])){
                            $nextPageToken = $searchResult['nextPageToken'];
                            while (!empty($nextPageToken)){
                                $searchResult = json_decode(url_get_contents("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&pageToken=$nextPageToken&playlistId=".$channel["ChSrcPL"]."&fields=items%2Fsnippet%2FresourceId%2FvideoId%2CnextPageToken&key=$apikey"), true);
                                foreach ($searchResult['items'] as $mediaData) {
                                    $mediaList[] = $mediaData['snippet']['resourceId']['videoId'];
                                }
                                if (!empty($searchResult['nextPageToken'])){
                                $nextPageToken = $searchResult['nextPageToken'];
                                } else {$nextPageToken = null;}
                            }
                        }

                        echo 'Video count on Source: ',count($mediaList),'<br>';

                        foreach ($media as $id) {
                            if(($key = array_search($id, $mediaList)) !== false) {
                                unset($mediaList[$key]);
                            }
                        }

                        foreach ($mediaList as $videoId) {
                            $mediaData = json_decode(url_get_contents("https://www.googleapis.com/youtube/v3/videos?part=snippet&id=$videoId&key=$apikey"), true);
                            $videoData = array("youtube","0",$mediaData['items']['0']['id'],$mediaData['items']['0']['snippet']['title'],$mediaData['items']['0']['snippet']['description'],$mediaData['items']['0']['snippet']['thumbnails']['medium']['url'],$mediaData['items']['0']['snippet']['publishedAt'],$channel["ID"]);

                            $stmt = $conn->prepare("INSERT INTO media (mediaSource, mediaSeason, mediaId ,mediaTitle, mediaDescription, mediaThumbnail, mediaDate, ChID) VALUES (?,?,?,?,?,?,?,?)");
                            foreach ($videoData as $key => $value) {
                                $key++;
                                $stmt->bindValue($key, $value);
                            }
                            if ($stmt->execute()) {
                                echo 'New Video Uploaded Successfully: ',$videoData['3'],'<br>';
                                // sendNewVideo($emails, $channel, $videoData);
                            } else { echo 'Error. Could not upload video: ',$videoData['3'],'<br>'; }

                        }

                        if (count($mediaList) == 0) {
                            echo '<br>***** No Videos to Upload for ',ucfirst($channel["ChT"]),': ',$channel["ChN"],' *****<br><br>';
                        } else {
                            echo '<br>***** All Videos on ',ucfirst($channel["ChT"]),': ',$channel["ChN"],' Updated *****<br><br>';
                        }

                //         break;
                    
                //     case 'vimeo':
                        
                //         break;
                // }
            }
        ?>
    </body>
</html>