<?php
	$id = $_GET['id'];
    
    $bgm = "";
    $handle = fopen("bgm.txt", "r");
    if ($handle) {
        $num = 1;
        while (($line = fgets($handle)) !== false) {
            if( trim($id) != trim($line) ) {
                $bgm .= trim($line)."\r\n";
            } else {
                $path = '/var/www/html/sound/bgm/';
                
                if (file_exists($path.trim($line))) {
                    unlink($path.trim($line));
                }
            }
        }
        fclose($handle);
    } else {
        goto_url("main.php?p=b");
    }

   
    $bgmfile = fopen("bgm.txt", "w") or die("Unable to open file!");
    fwrite($bgmfile, $bgm);
    fclose($bgmfile);
	


    goto_url("main.php?p=b");

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