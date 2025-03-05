<?php

    $volume = $_POST['volume'];

    
    $commands = '';
    $commands .= "# Master Volume Control\n";
    $commands .= "# Adjust Volume Control - 20%(0%~100%)\n\n";

    $commands .= "import os\n\n";

    $commands .= "os.system(\"amixer -c0 set 'Lineout volume control' ".$volume."%\")\n";
    #$commands .= "os.system(\"amixer -c0 set 'MIC1 boost AMP gain control' ".$volume."%\")\n";
    

    $mainfile = fopen("dv.py", "w") or die("Unable to open file!");
    fwrite($mainfile, $commands);
    fclose($mainfile);

    include('Net/SSH2.php');
    $ssh = new Net_SSH2('localhost');
    $ssh->login('root', 'root') or die("Login failed");

    echo $ssh->exec("python /home/mute-t1.py");
    echo $ssh->exec("sudo amixer -c0 set 'Lineout volume control' ".$volume."%");

    $dvfile = fopen("dv.txt", "w") or die("Unable to open file!");
    fwrite($dvfile, $volume);
    fclose($dvfile);

    #echo "Successfully updated!";
	
?>