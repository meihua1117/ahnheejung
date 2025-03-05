<?php

    $bgmip = $_POST['bgmip'];

    $bgmfile = fopen("bgmip.txt", "w") or die("Unable to open file!");
    fwrite($bgmfile, $bgmip);
    fclose($bgmfile);

    $commands = '';
    $commands .= "import os\n";
    $commands .= "import time\n";
    $commands .= "import vlc\n\n";
    $commands .= "if __name__ == '__main__':\n\n";
    $commands .= "    if os.path.isfile('/var/www/html/dv.txt'):\n";
    $commands .= "        f = open('/var/www/html/dv.txt', mode='rt')\n";
    $commands .= "        read_data = f.readline()\n";
    $commands .= "        f.close()\n";
    $commands .= "        os.system(\"amixer -c0 set 'Lineout volume control' \" + read_data + \"%\")\n\n";

    $commands .= "    instance = vlc.Instance()\n";
    $commands .= "    player = instance.media_player_new()\n";
    $commands .= "    player.set_mrl(\"http://".$bgmip."\")\n";
    $commands .= "    player.play()\n\n";
    $commands .= "    value = player.is_playing()\n";
    $commands .= "    print('=== Play Value : ' + str(value))\n";
    $commands .= "    time.sleep(1)\n\n";

    $commands .= "    while True:\n\n";
    $commands .= "        value = player.is_playing()\n";
    $commands .= "        if value == 0:\n";
    $commands .= "            print('=== Play Value : ' + str(value))\n\n";
    $commands .= "            os.system(\"amixer -c0 set 'Lineout volume control' 0%\")\n\n";
    $commands .= "            instance = vlc.Instance()\n";
    $commands .= "            player = instance.media_player_new()\n";
    $commands .= "            player.set_mrl(\"http://".$bgmip."\")\n";
    $commands .= "            player.play()\n\n";
    $commands .= "            time.sleep(1)\n\n";
    $commands .= "            if os.path.isfile('/var/www/html/dv.txt'):\n";
    $commands .= "                f = open('/var/www/html/dv.txt', mode='rt')\n";
    $commands .= "                read_data = f.readline()\n";
    $commands .= "                f.close()\n\n";
    $commands .= "                os.system(\"amixer -c0 set 'Lineout volume control' \" + read_data + \"%\")\n\n";
    $commands .= "            value = player.is_playing()\n";
    $commands .= "            print('=== Play Value : ' + str(value))\n\n";
    $commands .= "        time.sleep(0.1)\n";

    $mainfile = fopen("cvlc.py", "w") or die("Unable to open file!");
    fwrite($mainfile, $commands);
    fclose($mainfile);
	
?>