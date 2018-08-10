<?php

if (!function_exists('http_response_code')) {
	function http_response_code($code = NULL) {

		if ($code !== NULL) {

			switch ($code) {
				case 100: $text = 'Continue'; break;
				case 101: $text = 'Switching Protocols'; break;
				case 200: $text = 'OK'; break;
				case 201: $text = 'Created'; break;
				case 202: $text = 'Accepted'; break;
				case 203: $text = 'Non-Authoritative Information'; break;
				case 204: $text = 'No Content'; break;
				case 205: $text = 'Reset Content'; break;
				case 206: $text = 'Partial Content'; break;
				case 300: $text = 'Multiple Choices'; break;
				case 301: $text = 'Moved Permanently'; break;
				case 302: $text = 'Moved Temporarily'; break;
				case 303: $text = 'See Other'; break;
				case 304: $text = 'Not Modified'; break;
				case 305: $text = 'Use Proxy'; break;
				case 400: $text = 'Bad Request'; break;
				case 401: $text = 'Unauthorized'; break;
				case 402: $text = 'Payment Required'; break;
				case 403: $text = 'Forbidden'; break;
				case 404: $text = 'Not Found'; break;
				case 405: $text = 'Method Not Allowed'; break;
				case 406: $text = 'Not Acceptable'; break;
				case 407: $text = 'Proxy Authentication Required'; break;
				case 408: $text = 'Request Time-out'; break;
				case 409: $text = 'Conflict'; break;
				case 410: $text = 'Gone'; break;
				case 411: $text = 'Length Required'; break;
				case 412: $text = 'Precondition Failed'; break;
				case 413: $text = 'Request Entity Too Large'; break;
				case 414: $text = 'Request-URI Too Large'; break;
				case 415: $text = 'Unsupported Media Type'; break;
				case 500: $text = 'Internal Server Error'; break;
				case 501: $text = 'Not Implemented'; break;
				case 502: $text = 'Bad Gateway'; break;
				case 503: $text = 'Service Unavailable'; break;
				case 504: $text = 'Gateway Time-out'; break;
				case 505: $text = 'HTTP Version not supported'; break;
				default:
					exit('Unknown http status code "' . htmlentities($code) . '"');
				break;
			}

			$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

			header($protocol . ' ' . $code . ' ' . $text);

			$GLOBALS['http_response_code'] = $code;

		} else {

			$code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);

		}

		return $code;

	}
}

function check_input_footer($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function bigfootermail() {
    global $nachname, $vorname, $plz, $ipost, $phone, $ort, $strasse, $mobile, $betreff, $nachricht, $kontakt;
	$empfaenger = get_option('res_kontaktdaten')['form_adress_reciever'];	
	//$empfaenger = 'info@resignstudios.ch';	
    $nachname = $vorname = $plz = $ipost = $phone = $ort = $strasse = $mobile = $betreff = $nachricht  = $kontakt = $rueckruf = '';
    if (isset($_POST["senden"])) {

        $nachname = check_input_footer($_POST["nachname"]);
        $vorname = check_input_footer($_POST["vorname"]);
        $plz = check_input_footer($_POST["plz"]);
        $ort = check_input_footer($_POST["ort"]);
        $phone = check_input_footer($_POST["phone"]);
        $strasse = check_input_footer($_POST["strasse"]);
        $ipost = check_input_footer($_POST["ipost"]);
        $nachricht = check_input_footer($_POST["nachricht"]);
		$kontakt = check_input_footer($_POST["kontakt"]);
		$rueckruf = check_input_footer($_POST["rueckruf"]);		
		
		
        $emailRegex = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';

        $emailValid = preg_match($emailRegex, $ipost);
		http_response_code(200);
        if (!empty($nachname) && !empty($ipost) && empty($_POST["res_hon"]) && $emailValid) {
			
            $url = $_SERVER['SERVER_NAME'];
            if ($betreff == '') {
                $betreff = "Kontakt-Formular gesendet: " . $url;
            }
            $mailtext = "<html><head><title>$betreff</title></head>
                        <body style='font-family:Verdana, Geneva, sans-serif; font-size:12px; color:#666666;'>
                        <p>Ihnen wurde eine Nachricht via Footer-Formular von $url gesendet:</p>
                        <p><b>Name:</b> $vorname&nbsp;$nachname</p>
						<p><b>Phone:</b> $phone<br /></p>
						<p><b>Strasse:</b> $strasse<br /></p>
						<p><b>PLZ/Ort:</b> $plz &nbsp; $ort</p>
                        <p><b>E-Mail:</b> $ipost<br /></p>
                        <p><b>kontakt:</b> $kontakt<br /></p>
                        <p><b>Rückruf:</b> $rueckruf<br /></p>
                        <p><b>Betreff:</b> $betreff</p> 
                        <p><b>Nachricht:</b> $nachricht</p> 
                        </body></html>";

            $headers = 'From: Kontaktformular <'.get_option('res_kontaktdaten')['form_adress_sender'].'>' . "\r\n";
            $headers .= 'Reply-To: <' . $ipost . '>' . "\r\n";
            $headers .= 'Return-Path: <' . $ipost . '>' . "\r\n";
            $headers .= "X-Mailer: PHP\n";
            $headers .= 'MIME-Version: 1.0' . "\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            echo mail($empfaenger, $betreff, $mailtext, $headers);
				echo 'mail-success';
        } else {
            echo 'fail';
        }
        exit(); 
    }
}

// check ab ob das BigFooterFormular ausgefüllt wurde
if(isset($_POST['senden'])){
	if($_POST['form_name'] == 'footerBigFormular'){
		add_action('wp_footer', "bigfootermail");
	}
}
