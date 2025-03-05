<?php
	$user_id   = $_POST['userName'];
	$user_pass     = $_POST['userPassword'];
	$findUser = false;

	session_start();

	$loginvalue = array();
	$handle = fopen("login.txt", "r");
	if ($handle) {
	    while (($line = fgets($handle)) !== false) {

	        $login = explode(',', $line);
	        if( trim($user_id)==trim($login[0]) && trim($user_pass)==trim($login[1]) ){

				$findUser = true;
				break;
			}

	    }

	    fclose($handle);
	} else {
	    // error opening the file.
	} 

	if(!$findUser){
		echo '<script>';
		//echo 'alert("아이디 혹은 비밀번호가 정확하지 않습니다.");';
        echo 'location.replace("index.php");';
        echo '</script>';
        
	} else {
		$_SESSION["m_id"] = $login[0];
		$_SESSION["m_pass"] = $login[1];
		echo '<script>';
        echo 'location.replace("main.php?p=m");';
        echo '</script>';
        
	}
?> 