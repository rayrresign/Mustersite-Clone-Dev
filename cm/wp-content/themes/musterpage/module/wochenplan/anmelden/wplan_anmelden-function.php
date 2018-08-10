<?php
function check_input_kurs_anmeldung($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function wplananmeldenform() {
    global $nachname, $vorname, $plz, $ipost, $phone, $ort, $strasse, $mobile, $betreff, $nachricht, $kontakt;
//	$empfaenger = get_option('res_kontaktdaten')['form_adress_reciever'];	
	$empfaenger = 'nico@resign.ch';	
    $nachname = $vorname = $plz = $ipost = $phone = $ort = $strasse = $mobile = $betreff = $nachricht  = $kontakt = $rueckruf = '';
    if (isset($_POST["senden"])) {
	

	$nachname 		= check_input_kurs_anmeldung($_POST["nachname"]);
	$vorname 		= check_input_kurs_anmeldung($_POST["vorname"]);
	$ipost 			= check_input_kurs_anmeldung($_POST["ipost"]);
	$mobile 		= check_input_kurs_anmeldung($_POST["telefon"]);
	$kurs 			= check_input_kurs_anmeldung($_POST["courseinfo"]);
	
	$mailText 		= check_input_kurs_anmeldung($_POST["mailText"]);
	$absenderName 	= check_input_kurs_anmeldung($_POST["absenderName"]);
	$absenderMail 	= check_input_kurs_anmeldung($_POST["absenderMail"]);


	$emailRegex = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';

	$emailValid = preg_match($emailRegex, $ipost);

	if (!empty($nachname) && !empty($ipost) && empty($_POST["res_honing"]) && $emailValid) {

		$url = $_SERVER['SERVER_NAME'];
		if ($betreff == '') {
			$betreffWebmaser = "Anmeldung erhalten für: " . $kurs;
			$betreffUser = "Anmeldung für: " . $kurs;
		}

		// Mail an Webmaster
		$mailtext = "<html><head><title>$betreffWebmaser</title></head>
					<body style='font-family:Verdana, Geneva, sans-serif; font-size:12px; color:#666666;'>
					<p>Ihnen wurde eine Anmeldung via Anmeldeformular von $url gesendet:</p>
					<p><b>Anmeldung für den Kurs:</b> $kurs</p>
					<p><b>Name:</b> $vorname&nbsp;$nachname</p>
					<p><b>E-Mail:</b> $ipost</p>
					<p><b>Telefon:</b> $mobile</p>
					</body></html>";

		$headers = 'From: ' . $vorname . ' ' . $nachname .'<' . $ipost . '>' . "\r\n";
		$headers .= 'Reply-To: <' . $ipost . '>' . "\r\n";
		$headers .= 'Return-Path: <' . $ipost . '>' . "\r\n";
		$headers .= "X-Mailer: PHP\n";
		$headers .= 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

		mail($empfaenger, $betreffWebmaser, $mailtext, $headers);


		// Mail an Absender
		$bestaetigung = "<html><head><title>$betreffUser</title></head>
					<body style='font-family:Verdana, Geneva, sans-serif; font-size:12px; color:#666666;'>
					<p><b>$mailText</b></p>
					<p><b>Sie wurden für folgenden Kurs angemeldet:<br></b> $kurs </p>
					<p>Folgende Daten wurden uns übermittelt:</p>
					<p><b>Name:</b> $vorname&nbsp;$nachname<br>
					<b>E-Mail:</b> $ipost<br>
					<b>Telefon:</b> $mobile</p>
					</body></html>";

		$headersBest = 'From: ' . $absenderName . '<' . $absenderMail . '>' . "\r\n";
		$headersBest .= 'Reply-To: <' . $ipost . '>' . "\r\n";
		$headersBest .= 'Return-Path: <' . $ipost . '>' . "\r\n";
		$headersBest .= "X-Mailer: PHP\n";
		$headersBest .= 'MIME-Version: 1.0' . "\n";
		$headersBest .= 'Content-type: text/html; charset=utf-8' . "\r\n";

		mail($ipost, $betreffUser, $bestaetigung, $headersBest);


		echo 'mail-success';

	} else {
		echo 'fail';
	}
	exit();
}
}

// check ab ob das BigFooterFormular ausgefüllt wurde
if(isset($_POST['senden'])){
	if($_POST['form_name'] == 'wplan_anmelden_form'){
		add_action('wp_footer', "wplananmeldenform");
	}
}

//// Formular Script
//function check_input_kurs_anmeldung($data) {
//    $data = trim($data);
//    $data = stripslashes($data);
//    $data = htmlspecialchars($data);
//    return $data;
//}
//
//
//$empfaenger = 'nico@resign.ch';
//
//$nachname = $vorname = $mobile = $ipost = $titel = $betreff = '';
//	
//function wplan_anmeldung(){
//	
//
//if (isset($_POST["senden"])) {
//	
//
//	$nachname 		= check_input_kurs_anmeldung($_POST["nachname"]);
//	$vorname 		= check_input_kurs_anmeldung($_POST["vorname"]);
//	$ipost 			= check_input_kurs_anmeldung($_POST["ipost"]);
//	$mobile 		= check_input_kurs_anmeldung($_POST["telefon"]);
//	$kurs 			= check_input_kurs_anmeldung($_POST["kurs"]);
//	
//	$mailText 		= check_input_kurs_anmeldung($_POST["mailText"]);
//	$absenderName 	= check_input_kurs_anmeldung($_POST["absenderName"]);
//	$absenderMail 	= check_input_kurs_anmeldung($_POST["absenderMail"]);
//
//
//	$emailRegex = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';
//
//	$emailValid = preg_match($emailRegex, $ipost);
//
//	if (!empty($nachname) && !empty($ipost) && empty($_POST["res_hon"]) && $emailValid) {
//
//		$url = $_SERVER['SERVER_NAME'];
//		if ($betreff == '') {
//			$betreffWebmaser = "Anmeldung erhalten für: " . $kurs;
//			$betreffUser = "Anmeldung für: " . $kurs;
//		}
//
//		// Mail an Webmaster
//		$mailtext = "<html><head><title>$betreffWebmaser</title></head>
//					<body style='font-family:Verdana, Geneva, sans-serif; font-size:12px; color:#666666;'>
//					<p>Ihnen wurde eine Anmeldung via Anmeldeformular von $url gesendet:</p>
//					<p><b>Anmeldung für den Kurs:</b> $kurs</p>
//					<p><b>Name:</b> $vorname&nbsp;$nachname</p>
//					<p><b>E-Mail:</b> $ipost</p>
//					<p><b>Telefon:</b> $mobile</p>
//					</body></html>";
//
//		$headers = 'From: ' . $vorname . ' ' . $nachname .'<' . $ipost . '>' . "\r\n";
//		$headers .= 'Reply-To: <' . $ipost . '>' . "\r\n";
//		$headers .= 'Return-Path: <' . $ipost . '>' . "\r\n";
//		$headers .= "X-Mailer: PHP\n";
//		$headers .= 'MIME-Version: 1.0' . "\n"; 
//		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
//
//		mail($empfaenger, $betreffWebmaser, $mailtext, $headers);
//
//
//		// Mail an Absender
//		$bestaetigung = "<html><head><title>$betreffUser</title></head>
//					<body style='font-family:Verdana, Geneva, sans-serif; font-size:12px; color:#666666;'>
//					<p><b>$mailText</b></p>
//					<p><b>Sie wurden für folgenden Kurs angemeldet:<br></b> $kurs </p>
//					<p>Folgende Daten wurden uns übermittelt:</p>
//					<p><b>Name:</b> $vorname&nbsp;$nachname<br>
//					<b>E-Mail:</b> $ipost<br>
//					<b>Telefon:</b> $mobile</p>
//					</body></html>";
//
//		$headersBest = 'From: ' . $absenderName . '<' . $absenderMail . '>' . "\r\n";
//		$headersBest .= 'Reply-To: <' . $ipost . '>' . "\r\n";
//		$headersBest .= 'Return-Path: <' . $ipost . '>' . "\r\n";
//		$headersBest .= "X-Mailer: PHP\n";
//		$headersBest .= 'MIME-Version: 1.0' . "\n";
//		$headersBest .= 'Content-type: text/html; charset=utf-8' . "\r\n";
//
//		mail($ipost, $betreffUser, $bestaetigung, $headersBest);
//
//
//		echo 'mail-success';
//
//	} else {
//		echo 'fail';
//	}
//	exit();
//}
//
//
//}
//// check ab ob das BigFooterFormular ausgefüllt wurde
//if(isset($_POST['senden'])){
//	if($_POST['form_name'] == 'kurs_anmelden'){
//		add_action('wp_footer', "wplan_anmeldung");
//	}
//}
//
//
