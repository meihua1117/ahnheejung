<?php

	$cameraIp   = $_POST['camera_ip_address'];
	$cameraNo     = $_POST['camera_no'];
	$resetNo = $_POST['preset_no'];
	$camera_mask = $_POST['camera_mask'];
    $camera_protocol = $_POST['camera_protocol'];
    $em_led   = $_POST['em_led'];
    $em_light     = $_POST['em_light'];
    
    $commads  = '';
    $commads  .= "import OPi.GPIO as GPIO\n";
    $commads  .= "import time\n";
    $commads  .= "import subprocess\n";
    $commads  .= "import atexit\n";
    $commads  .= "import urllib2\n";
    $commads  .= "import urllib\n";
    $commads  .= "import cgi\n";
    $commads  .= "import cgitb; cgitb.enable()\n";
    $commads  .= "import os\n";

    $commads  .= "from multiprocessing import Process\n\n";

    $commads  .= "def camera_call():\n";
    $commads  .= "    query_args = { 'RPI':'Active' }\n";

    $commads  .= "    url = '";

    if($camera_mask == '1')
        $commads .= "http://".$cameraIp."/cgi-bin/fwptzctr.cgi?FwModId=0&PortId=".$cameraNo."&PtzCode=0x00000112&PtzParm=".$resetNo."&RcvData=NO&FwCgiVer=0x0001,;";
    else
        $commads .= $camera_protocol;

    $commads  .= "'\n";

    $commads  .= "    data = urllib.urlencode(query_args)\n";
    $commads  .= "    request = urllib2.Request(url, data)\n";
    $commads  .= "    response = urllib2.urlopen(request).read()\n\n";

	/*
    $commads  .= "def led_call():\n";
    $commads  .= "    i = 1\n";
    $commads  .= "    while (i <= ".$em_led."):\n";
    $commads  .= "        GPIO.output(led, True)\n";
    $commads  .= "        time.sleep(0.5)\n";
    $commads  .= "        GPIO.output(led, False)\n";
    $commads  .= "        time.sleep(0.5)\n";
    $commads  .= "        i += 1\n";
    $commads  .= "def light_call():\n";
    $commads  .= "    i = 1\n";
    $commads  .= "    while (i <= 1):\n";
    $commads  .= "        GPIO.output(light, True)\n";
    $commads  .= "        time.sleep(".$em_light.")\n";
    $commads  .= "        GPIO.output(light, False)\n";
    $commads  .= "        time.sleep(0.5)\n";
    $commads  .= "        i += 1\n\n";
	*/
    $commads  .= "def cctv_call():\n";
    $commads  .= "    GPIO.output(cctv, True)\n";
    $commads  .= "    time.sleep(1)\n";
    $commads  .= "    GPIO.output(cctv, False)\n\n";

    $commads  .= "input_pin = 18\n";
    $commads  .= "led = 8\n";
    $commads  .= "light = 9\n";
    $commads  .= "cctv = 11\n";
    
    $commads  .= "GPIO.setmode(GPIO.BCM)\n";
    $commads  .= "GPIO.setup(input_pin, GPIO.IN)\n";
    $commads  .= "GPIO.setup(led, GPIO.OUT)\n";
    $commads  .= "GPIO.setup(light, GPIO.OUT)\n";
    $commads  .= "GPIO.setup(cctv, GPIO.OUT)\n";
    $commads  .= "GPIO.setwarnings(False)\n";
    $commads  .= "while True:\n";
    $commads  .= "    time.sleep(1)\n";
    $commads  .= "    if not GPIO.input(input_pin):\n";
    $commads  .= "        p1 = Process(target=camera_call)\n";
    $commads  .= "        p1.start()\n";
    //$commads  .= "        p2 = Process(target=led_call)\n";
    //$commads  .= "        p2.start()\n";
    //$commads  .= "        p3 = Process(target=light_call)\n";
    //$commads  .= "        p3.start()\n";
    $commads  .= "        p4 = Process(target=cctv_call)\n";
    $commads  .= "        p4.start()\n";
    $commads  .= "        p1.join()\n";
    //$commads  .= "        p2.join()\n";
    //$commads  .= "        p3.join()\n";
    $commads  .= "        p4.join()\n";
    $commads  .= "    continue\n";


    $mainfile = fopen("../../../home/camera_call.py", "w") or die("Unable to open file!");
	fwrite($mainfile, $commads);
	fclose($mainfile);

	$cameratxt = $camera_mask.",".$cameraIp.",".$cameraNo.",".$resetNo.",".$camera_protocol;

    $camerafile = fopen("camera.txt", "w") or die("Unable to open file!");
    fwrite($camerafile, $cameratxt);
    fclose($camerafile);

    $alarmtxt = $em_led.",".$em_light;

    $alarmfile = fopen("alarm.txt", "w") or die("Unable to open file!");
    fwrite($alarmfile, $alarmtxt);
    fclose($alarmfile);
?>