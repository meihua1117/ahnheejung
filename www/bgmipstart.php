b<?php
    include('Net/SSH2.php');
    $ssh = new Net_SSH2('localhost');
    $ssh->login('root', 'root') or die("Login failed");
    
    $fp = fopen("bgm_setup.txt", "w");
    fwrite($fp, "1");
    fclose($fp);
    
//    echo $ssh->exec("sudo python /var/www/html/cvlc.py");
//    echo $ssh->exec("sudo python /home/answer.py");
    echo $ssh->exec("sudo python /home/unmute.py");
?>
