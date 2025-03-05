<?php

    $id = $_POST['id'];

    $filename = "";
    $handle = fopen("audioes.txt", "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {

            $info = explode(',', $line);
            if( trim($id) == trim($info[0]) ) {
                $filename = trim($info[1]);
            } 
        }

        fclose($handle);
    } else {
        // error opening the file.
    }

    //echo $id;

    include('Net/SSH2.php');
    $ssh = new Net_SSH2('localhost');
    $ssh->login('root', 'root') or die("Login failed");
    echo $ssh->exec('python /home/unmute.py');
    if($id == 'BGM') echo $ssh->exec("python /var/www/html/bgm.py");
    else echo $ssh->exec("sudo mpg321 /var/www/html/sound/".$filename."");
?>