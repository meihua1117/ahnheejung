<?php

	
	$server   = $_POST['sip_ip_address'];
	$user     = $_POST['user_name'];
	$password = $_POST['user_pass'];
	$callNum  = $_POST['call_num'];
    $mgs      = $_POST['mgs'];
    
    $uploaddir = '/usr/share/sounds/linphone/';
    $uploadfile = $uploaddir . basename($_FILES['ring_wav']['name']);

    if (move_uploaded_file($_FILES['ring_wav']['tmp_name'], $uploadfile)) {
        echo "The file ". basename( $_FILES["ring_wav"]["name"]). " has been uploaded.";
    } else {
        echo "Possible file upload attack!\n";
    }

    

	$commads = '';
    $commads .= "import OPi.GPIO as GPIO\n";
    $commads .= "import time\n";
    $commads .= "import subprocess\n";
    $commads .= "import atexit\n";
	$commads .= "import os\n";
	$commads .= "import commands\n\n";
    
    $commads .= "def setup_linphone():\n";
    $commads .= "    subprocess.call([\"linphonecsh\", \"init\"])\n";
    $commads .= "    time.sleep(5)\n";
    $commads .= "    subprocess.call([\"linphonecsh\", \"register\", \"--host\", \"".$server."\", \"--username\", \"".$user."\", \"--password\", \"".$password."\"])\n";
    $commads .= "    subprocess.call([\"linphonecsh\", \"generic\", \"autoanswer disable\"])\n\n";
    
    $commads .= "def unregister():\n";
    $commads .= "    subprocess.call([\"linphonecsh\", \"unregister\"])\n\n";
    
    $commads .= "def make_call():\n";
    $commads .= "    subprocess.call([\"linphonecsh\", \"generic\", \"call sip:".$callNum."@".$server."\"])\n\n";
	
	$commads .= "def make_hangup():\n";
    $commads .= "    os.system(\"linphonecsh hangup\")\n";
	$commads .= "    print (\"Hangup\")\n\n";
	
	$commads .= "def status_hook():\n";
    $commads .= "    while True:\n";
    $commads .= "        batcmd = 'linphonecsh status hook'\n";
    $commads .= "        result = commands.getoutput(batcmd)\n";
    $commads .= "        if result == (\"hook=offhook\"):\n";
    $commads .= "            print (\"Hook-Off\")\n";
    $commads .= "            GPIO.output(led, False)\n";
    $commads .= "            GPIO.output(light, False)\n";
    $commads .= "            time.sleep(1)\n";

    $commads .= "        if result != (\"hook=offhook\"):\n";
    $commads .= "            print (\"Hook-On\")\n";
    $commads .= "            GPIO.output(led, True)\n";
    $commads .= "            GPIO.output(light, True)\n";
    $commads .= "            time.sleep(1)\n";
    
    $commads .= "        if result == (\"hook=offhook\"):\n";
    $commads .= "            print (\"Hook-reset\")\n";
    $commads .= "            make_hangup()\n";
    $commads .= "            GPIO.output(led, False)\n";
    $commads .= "            GPIO.output(light, False)\n";
    $commads .= "            time.sleep(1)\n";
    $commads .= "            break\n";

    $commads .= "input = 18\n\n";
	$commads .= "led = 8\n\n";
	$commads .= "light = 9\n\n";
    
    $commads .= "GPIO.setmode(GPIO.BCM)\n";
    $commads .= "GPIO.setup(input, GPIO.IN)\n";
	$commads .= "GPIO.setup(led, GPIO.OUT)\n";
	$commads .= "GPIO.setup(light, GPIO.OUT)\n";
    $commads .= "GPIO.setwarnings(False)\n";
    $commads .= "atexit.register(unregister)\n";
    $commads .= "setup_linphone()\n\n";

    $commads .= "while (True):\n";
    $commads .= "    time.sleep(1)\n";
    $commads .= "    if not GPIO.input(input):\n";
    $commads .= "        make_call()\n";
	$commads .= "        status_hook()\n";
    $commads .= "        time.sleep(0.3)\n";
	$commads .= "    continue\n";
    

    $mainfile = fopen("../../../home/main-o.py", "w") or die("Unable to open file13!");
	fwrite($mainfile, $commads);
	fclose($mainfile);

	$siptxt = $user.",".$server.",".$password.",".$callNum;
    $sipfile = fopen("sip.txt", "w") or die("Unable to open file!");
    fwrite($sipfile, $siptxt);
    fclose($sipfile);


    $commads = '';
    $commads .= "import OPi.GPIO as GPIO\n";
    $commads .= "import urllib2\n";
    $commads .= "import time\n";
    $commads .= "import subprocess\n";

    $commads .= "netled = 17\n";

    $commads .= "GPIO.setmode(GPIO.BCM)\n";
    $commads .= "GPIO.setup(netled, GPIO.OUT)\n";
    $commads .= "GPIO.setwarnings(False)\n";

    $commads .= "def internet_on():\n";
    $commads .= "    try:\n";
    $commads .= "        response=urllib2.urlopen('http://".$server."')\n";
    $commads .= "        return True\n";
    $commads .= "    except urllib2.URLError as err: pass\n";
    $commads .= "    return False\n";

    $commads .= "while 1:\n";
    $commads .= "    if internet_on() == 1:\n";
    $commads .= "            GPIO.output(netled, True)\n";
    $commads .= "            time.sleep(0.2)\n";
    $commads .= "            GPIO.output(netled, False)\n";
    $commads .= "    else:\n";
    $commads .= "        while True:\n";
    $commads .= "            GPIO.output(netled, False)\n";
    $commads .= "    time.sleep(1)\n";
    $commads .= "    pass\n";

    $commads .= "try:\n";
    $commads .= "    main()\n";
    $commads .= "except KeyboardInterrupt:\n";
    $commads .= "    GPIO.Cleanup()\n";

    $mainfile = fopen("../../../home/netled.py", "w") or die("Unable to open file14!");
    fwrite($mainfile, $commads);
    fclose($mainfile);

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