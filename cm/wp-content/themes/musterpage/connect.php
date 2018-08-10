<?php

function fs_get_wp_config_path()
{
    $base = dirname(__FILE__);
    $path = false;

    if (@file_exists(dirname(dirname($base))."/wp-config.php"))
    {
        $path = dirname(dirname($base))."/wp-config.php";
    }
    else
    if (@file_exists(dirname(dirname(dirname($base)))."/wp-config.php"))
    {
        $path = dirname(dirname(dirname($base)))."/wp-config.php";
    }
    else
    $path = false;

    if ($path != false)
    {
        $path = str_replace("\\", "/", $path);
    }
    return $path;
}


require_once (fs_get_wp_config_path());

if (!($con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME)))
	{
		print "<h3>Keine Verbindung zur Datenbank!</h3>\n";
		exit;
	}
	
 mysqli_set_charset($con, "utf8");
?>