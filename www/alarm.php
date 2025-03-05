<?php

	$em_led   = $_POST['em_led'];
	$em_light     = $_POST['em_light'];
	$em_time = $_POST['em_time'];
	$gpio_pin = $_POST['gpio_pin'];
    

    $commads = '';
    $commads .= "import RPi.GPIO as GPIO\n";
    $commads .= "import time\n\n";

    $commads .= "def outport_call():\n";
    $commads .= "    i = 1\n";
    $commads .= "    while (i <= ".$em_time."):\n";
    $commads .= "        GPIO.output(alarm_pin, True)\n";
    $commads .= "        GPIO.output(output_pin, True)\n";
    $commads .= "        time.sleep(0.5)\n";
    $commads .= "        GPIO.output(output_pin, False)\n";
    $commads .= "        time.sleep(0.5)\n";
    $commads .= "        GPIO.output(alarm_pin, False)\n";
    $commads .= "        i += 1\n\n";

    $commads .= "input_pin = ".$gpio_pin."\n\n";
    $commads .= "output_pin = ".$em_led."\n\n";
    $commads .= "alarm_pin = ".$em_light."\n\n";


    $commads .= "GPIO.setmode(GPIO.BCM)\n";
    $commads .= "GPIO.setup(input_pin, GPIO.IN)\n";
    $commads .= "GPIO.setup(output_pin, GPIO.OUT)\n";
    $commads .= "GPIO.setup(alarm_pin, GPIO.OUT)\n";
    $commads .= "GPIO.setwarnings(False)\n\n";

    $commads .= "while True:\n";
    $commads .= "    if not GPIO.input(input_pin):\n";
    $commads .= "        outport_call()\n";
    $commads .= "    continue\n";


    $mainfile = fopen("../../../home/outport.py", "w") or die("Unable to open file!");
	fwrite($mainfile, $commads);
	fclose($mainfile);

	$alarmtxt = $em_led.",".$em_light.",".$em_time;

    $alarmfile = fopen("alarm.txt", "w") or die("Unable to open file!");
    fwrite($alarmfile, $alarmtxt);
    fclose($alarmfile);
?>