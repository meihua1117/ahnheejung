<?php

    $id = $_POST['audioID'];
    $filename = ""; 
    $content = "";
    $port = "";
    $audioes = "";
    $seed_string = "XNgIKcVBCkiOX4DArtFJpI1CigAOKgyG15UDrITFHgCNdQBIh0iaHojA6cBH5slFbAwDSRwGgowVFgCKvMRB6smJMoyUXQBGiQDKbQxbJoiP0YRLpkxGbkjeuxSOvQRJ_MwEiU1SO0FOEUSIxgiFvAzAB9yFb5RETRlXjEiUCEDce0wE4kgUuIlXqghObAULhoVUNojLxAiNAsyYhMgIMgyOsgiULsiB"; // random seed string
    if (isset($_POST['key']))
        $key = $_POST['key'];
    else
        $key = $sead_string;
    if (isset($_POST['content']))
        $content = $_POST['content'];
    if (isset($_POST['port']))
        $port = $_POST['port'];
    if (isset($_FILES['audioFile']['name'])){

        for($i = 0; $i < count($_FILES['audioFile']['name']); $i++){
 
            $filename = time()."-".$_FILES['audioFile']['name'][$i];

            if($id == 'BGM') {
                $audioes .= trim($filename)."\r\n";
            }

     
            if($id == 'BGM') $location = "/var/www/html/sound/bgm/".$filename;
            else $location = "/var/www/html/sound/".$filename;

            if (!file_exists('sound'))
            {
                mkdir('sound', 0777 , true);
            }
            $audioFileType = pathinfo($location, PATHINFO_EXTENSION);
            $audioFileType = strtolower($audioFileType);

            /* Valid extensions */
            $valid_extensions = array("mp3","wav");

            $response = 0;
            /* Check file extension */
            if(in_array(strtolower($audioFileType), $valid_extensions)) {
                /* Upload file */
                if(move_uploaded_file($_FILES['audioFile']['tmp_name'][$i], $location)){
                    $response = $location;
                }
            }
        }
    }

    if($id == 'BGM') {
        $handle = fopen("bgm.txt", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {

                $audioes .= $line;
            }
 
            fclose($handle);
        } else {
            // error opening the file.
        }
        
        $audiofile = fopen("bgm.txt", "w") or die("Unable to open file!");
        fwrite($audiofile, $audioes);
        fclose($audiofile);
    } else {

        $findAudio = false;
        $handle = fopen("audioes.txt", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {

                $info = explode(',', $line);
                if( trim($id) == trim($info[0]) ) {
                    $findAudio = true;
                    $audioes .= trim($info[0]).",";
                    if ($filename) {
                        $audioes .= trim($filename).",";
                    } else {
                        $audioes .= trim($info[1]).",";
                        $filename = trim($info[1]);
                    }
                    if ($content) {
                        $audioes .= trim($content)."\r\n";
                    } else {
                        $audioes .= trim($info[2])."\r\n";
                    }
                } else {
                    $audioes .= $line;
                }
            }

            fclose($handle);
        } else {
            // error opening the file.
        }

        if (!$findAudio) {
            $audioes .= trim($id).",".trim($filename).",".trim($content)."\r\n";
        }
        
        $audiofile = fopen("audioes.txt", "w") or die("Unable to open file!");
        fwrite($audiofile, $audioes);
        fclose($audiofile);
    }

    if ($port) {
        $response = false;
        if (!$findAudio || !$filename) {
            echo $response;
            exit;
        } else {
            $response = true;
            $commands = '';
			$commands = "# -*- coding: utf-8 -*\n";
      $commands .= "# encoding=utf8\n\n";
      $commands .= "import OPi.GPIO as GPIO\n";
			$commands .= "import time\n";
			$commands .= "import os\n";
			$commands .= "import subprocess\n";
			$commands .= "import atexit\n";
			$commands .= "import commands\n";
			$commands .= "import threading\n";
			$commands .= "import os.path\n\n";

			$commands .= "input = 27\n";
			$commands .= "read_data = '0'\n\n";
			$commands .= "GPIO.setmode(GPIO.BCM)\n";
			$commands .= "GPIO.setup(input, GPIO.IN)\n";
			$commands .= "GPIO.setwarnings(False)\n\n";

			$commands .= "def cvlc_off():\n";
			$commands .= "    os.system('pkill -9 -f answer.py')\n";
			$commands .= "    time.sleep(1)\n";
			$commands .= "    os.system('mpg321 /home/chime.mp3')\n\n";
			
			$commands .= "def event_play():\n";
			$commands .= "    os.system('pkill -9 -f vlc')\n";
 			$commands .= "    time.sleep(0.1)\n";
      $commands .= "    os.system(\"mpg321 /var/www/html/sound/".$filename."\")\n\n";

			$commands .= "def cvlc_on(aa):\n";
			$commands .= "    os.system('python /home/answer.py')\n\n";

			$commands .= "while True:\n";
			$commands .= "    time.sleep(1)\n";
			$commands .= "    if not GPIO.input(input):\n";
			$commands .= "        cvlc_off()\n";
			$commands .= "        time.sleep(2)\n";
			$commands .= "        event_play()\n";
			$commands .= "    else:\n";
			$commands .= "        ss1 = os.popen('ps -ef | grep mpg*').read()\n";
			$commands .= "        if 'mpg321' in ss1:\n";
			$commands .= "            print ('incoming')\n";
			$commands .= "        else:\n";
			$commands .= "            ss2 = os.popen('ps -ef | grep python').read()\n";
			$commands .= "            if 'answer.py' in ss2:\n";
			$commands .= "                print ('===> answer run ')\n";
			$commands .= "            else:\n";
			$commands .= "                sun_run = threading.Thread(target=cvlc_on, args=(1,))\n";
			$commands .= "                sun_run.start()\n";

            $mainfile = fopen("event.py", "w") or die("Unable to open file!");
            fwrite($mainfile, $commands);
            fclose($mainfile);


            $event = trim($port).",".trim($id).",".trim($filename)."\r\n";
            $eventfile = fopen("event.txt", "w") or die("Unable to open file!");
            fwrite($eventfile, $event);
            fclose($eventfile);

            echo $response;
            exit;
        }
    }

    goto_url("./main.php?p=m");

    function goto_url($url)
    {
        $url = str_replace("&amp;", "&", $url);
        
        if (!headers_sent())
            header('Location: '.$url);
        else {
            echo '<script>';
            echo 'location.replace("'.$url.'");';
            echo 'alert("'.$mgs.'");';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
            echo '</noscript>';
        }
        exit;
    }
	
?>