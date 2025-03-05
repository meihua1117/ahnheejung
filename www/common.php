<?php
	function goto_url($url)
	{
	    $url = str_replace("&amp;", "&", $url);
	    //echo "<script> location.replace('$url'); </script>";

	    if (!headers_sent())
	        header('Location: '.$url);
	    else {
	        echo '<script>';
	        echo 'location.replace("'.$url.'");';
	        echo '</script>';
	        echo '<noscript>';
	        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
	        echo '</noscript>';
	    }
	    exit;
	}
?>