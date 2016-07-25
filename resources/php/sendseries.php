<?php
	session_start();
    
    $email_to = $_POST['Receiver'];
    $email_from = $_POST['Sender'];
    $SenderName = $_POST['SenderName']; 
    $email_subject = 'Telenu.TV - '.$SenderName.' compartió una serie contigo.';

    function died($error) {
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
 
    if(!isset($_POST['Receiver']) ||
        !isset($_POST['Sender']) ||
        !isset($_POST['SenderName'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
 
    if(isset($_POST['Message'])) {
    	$Message = $_POST['Message']; 
    }
 
    $error_message = "";
 
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
	 
	if(!preg_match($email_exp,$email_to)) {
	    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
	}

	if(!preg_match($email_exp,$email_from)) {
	    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
	}

	    $string_exp = "/^[A-Za-z .'-]+$/";
	 
	if(!preg_match($string_exp,$SenderName)) {
	    $error_message .= 'The Name you entered does not appear to be valid.<br />';
	}
	 
	if(strlen($Message) < 2) {
	    $error_message .= 'The Comments you entered do not appear to be valid.<br />';
	}
	 
	if(strlen($error_message) > 0) {
	    died($error_message);
	}
	 
	function clean_string($string) {
	    $bad = array("content-type","bcc:","to:","cc:","href");
	    return str_replace($bad,"",$string);
	}

	$email_message = '';
	$email_message .= '<html><body><div style="width: 100%; text-align: center;" align="center">';
	$email_message .= '<div style="width: 680px; background-color: black; color: white; margin: auto;">';
	$email_message .= '<a href="http://telenu.tv/" target="_blank">';
	$email_message .= '<img src="http://telenu.tv/resources/images/logo.png" alt="" style="margin: 30px 0px;">';
	$email_message .= '</a>';
	$email_message .= '<h3 style="margin: 10px 0px;">'.clean_string($SenderName).' te ha enviado una serie:</h3>';
	$email_message .= '<h1 style="margin: 10px 0px;">'.$_SESSION['ChInfo']['ChN'].'</h1>';
	$email_message .= '<p style="width: 500px; margin: 10px auto;">'.clean_string($Message).'</p>';
	$email_message .= '<a href="http://telenu.tv/channel/'.$_SESSION['ChInfo']['ChL'].'" target="_blank">';
	$email_message .= '<img src="http://telenu.tv/resources/images/channel/'.$_SESSION['ChInfo']['ChThmb'].'" alt="" style="width: 500px; margin: 10px 0px;">';
	$email_message .= '</a>';
	$email_message .= '<p style="width: 500px; margin: 10px auto;">Conoce &eacute;sta y m&aacute;s series web en <a href="http://telenu.tv/" target="_blank">www.telenu.tv</a></p>';
	$email_message .= '<p style="width: 500px; padding-bottom: 30px; margin: 10px auto 0px;">Telenu TV. Todos los derechos reservados</p>';
	$email_message .= '</div>';
	$email_message .= '</div></body></html>';

	$headers = 'From: '.clean_string($email_from)."\r\n".
	'Reply-To: '.clean_string($email_from)."\r\n" .
	'MIME-Version: 1.0'."\r\n" .
	'Content-Type: text/html; charset=utf-8'."\r\n" .
	'X-Mailer: PHP/' . phpversion();
	@mail($email_to, $email_subject, $email_message, $headers); 

	$redirect_url = (isset($_SESSION['redirect_url'])) ? $_SESSION['redirect_url'] : '/';
    unset($_SESSION['redirect_url']);

    header('Location: '. $redirect_url);
?>
