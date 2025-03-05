<?php

	echo "<script>alert('장치가 재시작 됩니다. \r\n재설정을 하려면 수정 한 주소로 재 접속 하십시오.');</script>";
    
	include('Net/SSH2.php');
    $ssh = new Net_SSH2('localhost');
    $ssh->login('root', 'root') or die("Login failed");
    echo $ssh->exec('sudo python /home/lin-restart.py');
    echo $ssh->exec('sudo reboot -f');
    
?>