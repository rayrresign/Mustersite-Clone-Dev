<?php
include_once("connect.php");
//	 print_r($_POST['id']);
$event_id = $_POST['id'];


echo $event_id;
// AJAX Send Tool for RES Guestlist Plugin for v8

//if(isset($_GET["event_id"])){
//	$event_id = strip_tags(mysql_real_escape_string($_GET["event_id"]));
//	$guestlist = mysql_query("SELECT * FROM guestlist WHERE event_id = '$event_id'");
//	$guestlist = mysql_fetch_array($guestlist);
//}else{
//	$guestlist = mysql_query("SELECT * FROM guestlist where status = '0' ORDER BY datum ASC LIMIT 1");
//	$guestlist = mysql_fetch_array($guestlist);
//	$event_id = $guestlist["event_id"];
//}
//
//$glist = mysql_query("SELECT * FROM guestlist WHERE status = '0' ORDER BY datum ASC");
//
//		if(isset($_GET["update_id"])){
//			$update_id = $_GET["update_id"];
//		}
//		else {$update_id = $guestlist["id"];}	
//		
//
//	// Callback
//	if(isset($_POST["inputs"]["inp3"]) && isset($_POST["inputs"]["inp7"]) && isset($_POST["inputs"]["inp4"])){
//
//	$settings_query = mysql_query("SELECT * from guestlist_settings");
//	$settings_query = mysql_fetch_array($settings_query);	
//
//					$event_id 		= $_POST["inputs"]["inp1"];
//					$bedingungen	= $_POST["inputs"]["inp2"];
//					$name 			= $_POST["inputs"]["inp3"];
//					$vorname 		= $_POST["inputs"]["inp4"];
//					$begleitungen 	= $_POST["inputs"]["inp5"];
//					$jahrgang 		= $_POST["inputs"]["inp6"];
//					$email 			= $_POST["inputs"]["inp7"];
//					$mobile 		= $_POST["inputs"]["inp8"];
//					$partyname		= $_POST["inputs"]["inp9"];
//					
//			
//					$entry_insert 	= mysql_query("INSERT into entries (Guestlist_id, name, vorname, begleitungen, jahrgang, email, mobile) values('$event_id', '$name', '$vorname', '$begleitungen', '$jahrgang', '$email', '$mobile')");
//					
//					$listinfo 		= mysql_query("SELECT * from guestlist where id = '$event_id'");
//					$listinfo 		= mysql_fetch_array($listinfo);
//
//					$wp_postinfo 	= mysql_query("SELECT * from wp_posts where ID = '".$listinfo["event_id"]."'");
//					$wp_postinfo 	= mysql_fetch_array($wp_postinfo);
//					
//					$to      		= ''.$email.'';
//					$subject 		= ' '.$settings_query["subject"];
//					
//
//$message = 'Hallo '.$vorname.'<br /><br />			
//'.'Du hast dich auf unserer Seite '.$_SERVER['SERVER_NAME'].' für die Liste auf folgenden Event eingeschrieben:<br /><br />
//'.'Eventname: <strong>'.$partyname.'</strong><br />
//'.'Bedingungen: <strong>'.$bedingungen.'</strong><br />
//'.'Name: <strong>'.$name.'</strong><br />
//'.'Vorname: <strong>'.$vorname.'</strong><br />
//'.'Begleitungen: <strong>'.$begleitungen.'</strong><br /><br />
//'.'Wir freuen uns, dass du unser Gast bist.<br />
//'.'Dein '.$_SERVER['SERVER_NAME'].' Team';
//
//	$body = "<html>\n";
//	$body .= "<body style=\"font-family:Verdana, Verdana, Geneva, sans-serif; font-size:12px; color:#666666;\">\n";
//	$body .= $message;
//	$body .= "</body>\n";
//	$body .= "</html>\n";
//						
//    $headers  = 'From: '.$settings_query["absendertitel"].'<'.$settings_query["absendermail"].'>' . "\r\n";
//    $headers .= 'Reply-To: <'.$settings_query["absendermail"].'>' . "\r\n";
//    $headers .= 'Return-Path: <'.$settings_query["absendermail"].'>' . "\r\n";
//    $headers .= "X-Mailer: PHP\n";
//    $headers .= 'MIME-Version: 1.0' . "\n";
//    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";			
//mail($to, $subject, utf8_decode($body), $headers); ?>
<div class="successmsg">
<?php // echo "<h2>".$settings_query["successtitel"]."</h2>".' '.$settings_query["successmsg"]; ?>
</div>
<?php
//}