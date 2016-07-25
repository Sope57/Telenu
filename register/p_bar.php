<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_FILES["userfile"])) {
    require_once ( '../vendor/PHPMailer/PHPMailerAutoload.php' );
    $Mail = new PHPMailer();
    $Mail->IsSMTP(); // Use SMTP
    $Mail->Host        = gethostbyname('smtp.gmail.com'); // Sets SMTP server
    $Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
    $Mail->Debugoutput = 'html';
    $Mail->SMTPOptions = array(
      'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
      )
  );
    $Mail->SMTPAuth    = TRUE; // enable SMTP authentication
    $Mail->SMTPSecure  = "tls"; //Secure conection
    $Mail->Port        = 587; // set the SMTP port
    $Mail->Username    = "telenu.tv@gmail.com";
    $Mail->Password    = "vigilante_18";
    $Mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
    $Mail->CharSet     = 'UTF-8';
    $Mail->Encoding    = '8bit';
    $Mail->Subject     = 'Tu cola';
    $Mail->ContentType = 'text/html; charset=utf-8\r\n';
    $Mail->From        = 'telenu.tv@gmail.com';
    $Mail->FromName    = 'Telenu! Registro';
    $Mail->Body        = 'Tugfa we';
    $Mail->WordWrap    = 50; // RFC 2822 Compliant for Max 998 characters per line

      if (isset($_FILES['userfile']) &&
        $_FILES['userfile']['error'] == UPLOAD_ERR_OK) {
        $Mail->AddAttachment($_FILES['userfile']['tmp_name'],
                             $_FILES['userfile']['name']);
      }
  $Mail->AddAddress('luisgdiazreynoso@gmail.com'); // To:
  $Mail->isHTML( TRUE );
  // $Mail->msgHTML(file_get_contents('emailcontenido.html'), dirname(__FILE__));


        if (!$Mail->Send()) {
            echo "Mailer Error: " . $Mail->ErrorInfo . "<br>";
        } else {
            switch($_POST['language']) {
              case spanish:
                header('Location: http://www.telenu.tv/register/thanks_es.html');
              break;
              case english:
                header('Location: http://www.telenu.tv/register/thanks_en.html');
              break;
            }
        }


  $Mail->SmtpClose();
}
?>
<html>
   <head>
    <title>File Upload Progress Bar</title>
    <style>
      #bar_blank {
        border: solid 1px #000;
        height: 20px;
        width: 300px;
      }

      #bar_color {
        background-color: #006666;
        height: 20px;
        width: 0px;
      }

      #bar_blank, #hidden_iframe {
        display: none;
      }
    </style>
   </head>
   <body>
      <div id="bar_blank">
         <div id="bar_color">
         </div>
      </div>
      <div id="status"></div>
      <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" id="myForm" enctype="multipart/form-data" target="hidden_iframe">
         <input type="hidden" value="myForm" name="<?php echo ini_get("session.upload_progress.name"); ?>">
         <input type="file" name="userfile"><br>
         <input type="submit" value="Start Upload">
      </form>
      <iframe id="hidden_iframe" name="hidden_iframe" src="about:blank"></iframe>
      <script type="text/javascript" src="p_bar_js.js"></script>
   </body>
</html>