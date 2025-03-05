<?php
	$user = $_GET['id'];
	$pass = $_GET['pass'];
	$duser = $_GET['duser'];

	$usertxt = "";
	$handle = fopen("login.txt", "r");
	if ($handle) {
	    while (($line = fgets($handle)) !== false) {

	    	$login = explode(',', $line);
	    	if(trim($login[0]) != trim($duser))
	        	$usertxt .= $line;

	    }

	    fclose($handle);
	} else {
	    
	}

    echo $usertxt;
	
	$userfile = fopen("login.txt", "w") or die("Unable to open file!");
    fwrite($userfile, $usertxt);
    fclose($userfile);


    goto_url("main.php?userName=".$user."&p=m&userPassword=".$pass);

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