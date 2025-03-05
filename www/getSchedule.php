<?php

    $day = date('D');
    $time = date("H:i");

    $findAudio = false;
    $findSchedule = false;
    $id = "";
    $result = '';
    $handle = fopen("schedule.txt", "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {

            $info = explode(',', $line);
            if( trim($day) == trim($info[0]) && trim($time) == trim($info[1])  ) {
                $findSchedule = true;
                $id = trim($info[2]);
                break;
            }
        }

        fclose($handle);
    } else {
        // error opening the file.
    }

    if ($findSchedule) {
        $handle = fopen("audioes.txt", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {

                $info = explode(',', $line);
                if( trim($id) == trim($info[0]) ){
                    $findAudio = true;
                    $result = trim($info[1]);
                    break;
                }

            }

            fclose($handle);
        } else {
            // error opening the file.
        } 
    }
    echo $result;
	
?>