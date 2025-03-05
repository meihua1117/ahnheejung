<?php
    include('Net/SSH2.php');
    $ssh = new Net_SSH2('localhost');
    $ssh->login('root', 'root') or die("Login failed");

    $fp = fopen("bgm_setup.txt", "w");
    fwrite($fp, "0");
    fclose($fp);
    
//    flush();
//    sleep(2);
    echo $ssh->exec("python /home/mute.py");
//    echo $ssh->exec("sudo pkill -f mpg321");
    echo $ssh->exec("sudo pkill -f cvlc.py");
//    echo $ssh->exec("sudo pkill -f vlc");
    //echo $ssh->exec("sudo pkill -9 -f /home/answer.py");
    
?>