<?php

    include('Net/SSH2.php');
    $ssh = new Net_SSH2('localhost');
    $ssh->login('root', 'root') or die("Login failed");

    echo $ssh->exec('sudo pkill -9 -f mpg321');
    echo $ssh->exec('sudo pkill -9 -f vlc');
    echo $ssh->exec("sudo pkill -9 -f cvlc");
    echo $ssh->exec("sudo pkill -9 -f /home/answer.py");
?>