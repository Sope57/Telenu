<?php
date_default_timezone_set('Etc/UTC');
require_once '../resources/php/connToServer.php';

    //toda la info
   
     //serie o corto
      $serie_corto_vlog = $_POST['type'];

      //participante
      $nombre_participante = $_POST['nombre_participante']; 
      $edad_participante = $_POST['edad_participante']; 
      $correo_participante = $_POST['correo_participante']; 
      $telefono_participante = $_POST['telefono_participante']; 
      $direccion_participante = $_POST['direccion_participante']; 
      $postal_participante = $_POST['postal_participante']; 
      $ciudad_participante = $_POST['ciudad_participante']; 
      $estado_participante = $_POST['estado_participante'];
      $pais_participante = $_POST['pais_participante']; 

      //redes sociales
      $facebook_serie = $_POST['facebook_serie']; 
      $twitter_serie = $_POST['twitter_serie']; 
      $youtube_serie = $_POST['youtube_serie']; 
      $vimeo_serie = $_POST['vimeo_serie']; 
      $instagram_serie = $_POST['instagram_serie']; 
      $otra_serie = $_POST['otra_serie']; 

      //serie
      $nombre_serie = $_POST['nombre_serie']; 
      $pagina_serie = $_POST['pagina_serie']; 
      $idioma_serie = $_POST['idioma_serie']; 
      $genero_serie = $_POST['genero_serie']; 
      $creador_serie = $_POST['creador_serie']; 
      $director_serie = $_POST['director_serie']; 
      $escritor_serie = $_POST['escritor_serie']; 
      $productor_serie = $_POST['productor_serie'];
      $cinefotografo_serie = $_POST['cinefotografo_serie'];  
      $editor_serie = $_POST['editor_serie']; 
      $compositor_serie = $_POST['compositor_serie'];
      $reparto_serie = $_POST['reparto_serie']; 
      $sinopsis_serie = $_POST['sinopsis_serie'];

      //links 
      $enlace_1 = $_POST['enlace_1']; 
      $enlace_2 = $_POST['enlace_2']; 
      $enlace_3 = $_POST['enlace_3']; 
      $pw = $_POST['pw']; 



    
     
    function clean_string($string) {
        $bad = array("content-type","bcc:","to:","cc:","href");
        return str_replace($bad,"",$string);
    }


      $email_message = "Registro Telenu\n\n<br />";

      $email_message .= "
              <table style=\"width: 100%; text-align: center;\">
            <tr>
                <td style=\"width: auto;\"></td>
                <td style=\"width: 700px;\">
                    <table style=\"width: 100%; background-color: black;\" bgcolor=\"black\">
                        <tr>
                            <th style=\"width: 100%;\">
                                <a href=\"http://telenu.tv/\" target=\"_blank\">
                                    <img src=\"http://telenu.tv/resources/images/emailup.jpg\" style=\"width: 700px;\" />
                                </a>
                            </th>
                        </tr>
                    </table>
                    <table style=\"width: 100%; background-color: black;\" bgcolor=\"black\">
                        <tr>
                            <th style=\"width: 90px;\"></th>
                            <th style=\"width: 500px;\"></th>
                            <th style=\"width: 90px;\"></th>
                        </tr>
                        <tr>
                            <td></td>
                            <td style=\"color: white; text-align: left; padding: 10px 0;\" align=\"left\">
                ";

      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">El contenido es: </span>".clean_string($serie_corto_vlog)."\n<br /><br />";
     
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Nombre del participante: </span>".clean_string($nombre_participante)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Edad: </span>".clean_string($edad_participante)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Correo: </span>".clean_string($correo_participante)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Teléfono: </span>".clean_string($telefono_participante)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Dirección: </span>".clean_string($direccion_participante)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Código postal: </span>".clean_string($postal_participante)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Ciudad: </span>".clean_string($ciudad_participante)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Estado: </span>".clean_string($estado_participante)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">País: </span>".clean_string($pais_participante)."\n\n<br /><br />";

      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Nombre de la serie: </span>".clean_string($nombre_serie)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Página web: </span>".clean_string($pagina_serie)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Idioma: </span>".clean_string($idioma_serie)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Género: </span>".clean_string($genero_serie)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Creador: </span>".clean_string($creador_serie)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Director: </span>".clean_string($director_serie)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Escritor: </span>".clean_string($escritor_serie)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Productor: </span>".clean_string($productor_serie)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Cinefotógrafo: </span>".clean_string($cinefotografo_serie)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Editor: </span>".clean_string($editor_serie)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Compositor: </span>".clean_string($compositor_serie)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Reparto: </span>".clean_string($reparto_serie)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Sinopsis: </span>".clean_string($sinopsis_serie)."\n\n<br /><br />";

      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Facebook: </span>".clean_string($facebook_serie)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Twitter: </span>".clean_string($twitter_serie)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Youtube: </span>".clean_string($youtube_serie)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Vimeo: </span>".clean_string($vimeo_serie)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Instagram: </span>".clean_string($instagram_serie)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Otras redes: </span>".clean_string($otra_serie)."\n\n<br /><br />";

      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Link 1: </span>".clean_string($enlace_1)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Link 2: </span>".clean_string($enlace_2)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Link 3: </span>".clean_string($enlace_3)."\n<br />";
      $email_message .= "<span style=\"color: #6ce4d6; font-family: Arial, Helvetica, sans-serif; font-size: 10pt\">Password: </span>".clean_string($pw)."\n\n<br />";

      $email_message .= "
        <td></td>
                        </tr>
                    </table>
                    <table style=\"width: 100%; background-color: black;\" bgcolor=\"black\">
                        <tr>
                            <th style=\"width: 100%;\">
                                <img src=\"http://telenu.tv/resources/images/emaildown.jpg\" style=\"width: 700px;\" />
                            </th>
                        </tr>
                    </table>
                </td>
                <td style=\"width: auto;\"></td>
            </tr>
        </table>
      ";

      $ToName  = 'Luis Diaz';
      $Subject = $nombre_participante.' quiere ser parte de Telenu';

//function SendMail( $ToEmail, $Subject, $email_message ) {
  require_once ( '../vendor/PHPMailer/PHPMailerAutoload.php' ); // Add the path as appropriate
  $Mail = new PHPMailer();
  //$Mail->IsSMTP(); // Use SMTP
  /*$Mail->Host        = gethostbyname('smtp.gmail.com'); // Sets SMTP server*/
  $Mail->Host        = 'smtp.gmail.com'; // Sets SMTP server
  $Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
  $Mail->Debugoutput = 'html';
/*  $Mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);*/
  $Mail->SMTPAuth    = true; // enable SMTP authentication
  $Mail->SMTPSecure  = "tls"; //Secure conection
  $Mail->Port        = 587; // set the SMTP port
  $Mail->Username    = "telenu.tv@gmail.com";
  $Mail->Password    = "vigilante_18";
 // $Mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
  $Mail->CharSet     = 'UTF-8';
  $Mail->Encoding    = '8bit';
  $Mail->Subject     =  $Subject;
  $Mail->ContentType = 'text/html; charset=utf-8\r\n';
  $Mail->From        = 'telenu.tv@gmail.com';
  $Mail->FromName    = 'Telenu! Registro';
  $Mail->Body        = $email_message;
  $Mail->WordWrap    = 50; // RFC 2822 Compliant for Max 998 characters per line

    if (isset($_FILES['img_1']) &&
      $_FILES['img_1']['error'] == UPLOAD_ERR_OK) {
      $Mail->AddAttachment($_FILES['img_1']['tmp_name'],
                           $_FILES['img_1']['name']);
    }
    if (isset($_FILES['img_2']) &&
      $_FILES['img_2']['error'] == UPLOAD_ERR_OK) {
      $Mail->AddAttachment($_FILES['img_2']['tmp_name'],
                           $_FILES['img_2']['name']);
    }
  $Mail->AddAddress('luisgdiazreynoso@gmail.com'); // To:
  $Mail->isHTML(true);
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
  // $Mail->ClearAddresses();

?>