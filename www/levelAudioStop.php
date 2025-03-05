<?php

    include('Net/SSH2.php');
    $ssh = new Net_SSH2('localhost');
    $ssh->login('root', 'root') or die("Login failed");

    echo $ssh->exec('sudo pkill -9 -f /var/www/html/level-2.py');
?>