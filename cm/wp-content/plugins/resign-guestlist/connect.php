<?php

require_once(ABSPATH . 'wp-config.php');
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);



//$dbname = DB_NAME;
//$dbuser = DB_USER;
//$dbpass = DB_PASSWORD;
//$dbhost = DB_HOST;

if (!(mysqli_select_db($connection, DB_NAME)))
	{
		print "<h3>Keine Verbindung zur Datenbank!</h3>\n";
		exit;
	}
?>