<?php

    $id = $_POST['id'];
    $point = $_POST['point'];
    $findAudio = false;
    $result = '';
    $handle = fopen("audioes.txt", "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {

            $info = explode(',', $line);
            if( trim($id) == trim($info[0]) ){
                $findAudio = true;
                if ($point == 'file') {
                    $result = trim($info[1]);
                } elseif ($point == 'content') {
                    $result = trim($info[2]);
                } elseif ($point == 'all') {
                    $result = array('file' => trim($info[1]), 'content' => trim($info[2]));
                    echo json_encode($result);
                    exit();
                }
                break;
            }

        }

        fclose($handle);
    } else {
        // error opening the file.
    } 
    echo $result;
	
?>