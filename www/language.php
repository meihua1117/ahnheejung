<?php
	include_once('./common.php');

	$lang   = $_GET['lang'];
	$alarmfile = fopen("language.txt", "w") or die("Unable to open file!");
    fwrite($alarmfile, $lang);
    fclose($alarmfile);

    goto_url("./index.php");
?>