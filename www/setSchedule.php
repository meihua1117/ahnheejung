<?php

    $id = $_POST['id'];
    $day = $_POST['day'];
    $time = $_POST['time'];

    $response = 0;
    $findAudio = false;
    $audio = "";
    $filename = "";
    $commands = "";

    $commands .= "import schedule\n";
    $commands .= "import time\n";
    $commands .= "import os\n\n";

    $commands .= "#def job():\n";
    $commands .= "#    print(\"I'm working...\")\n\n";

    $handle = fopen("audioes.txt", "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $info = explode(',', $line);
            if (trim($info[1])) {
                $commands .= "def mpg".trim($info[0])."():\n";
                $commands .= "    os.system('mpg321 /var/www/html/sound/".trim($info[1])."')\n";
            }
            if( trim($id) == trim($info[0]) ) {
                $findAudio = true;
                $filename = trim($info[1]);
            }
        }
        fclose($handle);
    } else {
        // error opening the file.
    }

    $commands .= "\n";
    
    if (!$findAudio || !$filename) {
        echo $response;
        exit;
    } else {
        $response = 1;
        $findSchedule = false;
        $schedules = "";
        $handle = fopen("schedule.txt", "r");
        if ($handle) {
            $num = 1;
            while (($line = fgets($handle)) !== false) {
                $info = explode(',', $line);
                if( trim($day) == trim($info[1]) && trim($time) == trim($info[2])  ) {
                    $findSchedule = true;
                    $response = 2;
                    $schedules .= trim($info[0]).",".trim($info[1]).",".trim($info[2]).",".trim($id)."\r\n";
                    $commands .= "schedule.every().".trim($info[1]).".at(\"".trim($info[2])."\").do(mpg".trim($id).")\n";
                } else {
                    $commands .= "schedule.every().".trim($info[1]).".at(\"".trim($info[2])."\").do(mpg".trim($info[3]).")\n";
                    $schedules .= $line;
                }
                $num++;
            }
            fclose($handle);
        } else {
            // error opening the file.
        }

        if (!$findSchedule) {
            if ($num > 49) {
                echo $response;
                exit;
            } else {
                $response = 2;
                $schedules .= trim($num).",".trim($day).",".trim($time).",".trim($id)."\r\n";
                $commands .= "schedule.every().".trim($day).".at(\"".trim($time)."\").do(mpg".trim($id).")\n";
            }
        }
        $commands .= "\n";

        $commands .= "while True:\n";
        $commands .= "    schedule.run_pending()\n";
        $commands .= "    time.sleep(1)\n";

        $mainfile = fopen("sc.py", "w") or die("Unable to open file!");
        fwrite($mainfile, $commands);
        fclose($mainfile);
        
        $schedulefile = fopen("schedule.txt", "w") or die("Unable to open file!");
        fwrite($schedulefile, $schedules);
        fclose($schedulefile);

        echo $response;
        
/*
        include('Net/SSH2.php');
        $ssh = new Net_SSH2('localhost');
        $ssh->login('root', 'root') or die("Login failed");

        echo $ssh->exec('sudo python /home/lin-restart.py');
        echo $ssh->exec('sudo reboot -f');
*/
    }

?>