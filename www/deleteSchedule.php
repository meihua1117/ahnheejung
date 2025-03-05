<?php
	$id = $_GET['id'];

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
                $commands .= "    os.system('mpg321 /home/sound/".trim($info[1])."')\n";
            }
        }
        fclose($handle);
    } else {
        goto_url("main.php?p=s");
    }

    $commands .= "\n";
    
    $schedules = "";
    $handle = fopen("schedule.txt", "r");
    if ($handle) {
        $num = 1;
        while (($line = fgets($handle)) !== false) {
            $info = explode(',', $line);
            if( trim($id) != trim($info[0]) ) {
                $schedules .= trim($num).",".trim($info[1]).",".trim($info[2]).",".trim($info[3])."\r\n";
                $commands .= "schedule.every().".trim($info[1]).".at(\"".trim($info[2])."\").do(mpg".trim($info[3]).")\n";
                $num++;
            }
        }
        fclose($handle);
    } else {
        goto_url("main.php?p=s");
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
	


    goto_url("main.php?p=s");

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