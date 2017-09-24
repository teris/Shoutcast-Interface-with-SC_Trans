 <?php
    header("Content-Type: text/html; charset=utf-8");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
	include_once("config.php");
	date_default_timezone_set('Europe/Berlin');
	
        $fp = @fsockopen($shoutserver, $shoutport, $errno, $errstr, 30);

        if ($fp) {
            fputs($fp, "GET /7.html HTTP/1.0\r\nUser-Agent: XML Getter (Mozilla Compatible)\r\n\r\n");
				$page 							= "";
            while(!feof($fp))
				$page 							.= fgets($fp, 1000);
				fclose($fp);
				$page 							= ereg_replace(".*<body>", "", $page);
				$page 							= ereg_replace("</body>.*", ",", $page);
				$numbers 						= explode(",", $page);
				$shoutcast_currentlisteners 	= $numbers[0];
				$connected 						= $numbers[1];
				$shoutcast_peaklisteners 		= $numbers[2];
				$shoutcast_maxlisteners 		= $numbers[3];
				$shoutcast_reportedlisteners 	= $numbers[4];
				$shoutcast_bitrate 				= $numbers[5];
				$shoutcast_cursong 				= $numbers[6];
				$shoutcast_curbwidth 			= $shoutcast_bitrate * $shoutcast_currentlisteners;
				$shoutcast_peakbwidth 			= $shoutcast_bitrate * $shoutcast_peaklisteners;
        }
	
	$extras = rand(1,25);
	$listeners = $shoutcast_currentlisteners+$extras;

	$uhrzeit = date("H:i:s");
	
    if ($connected == 1):
		echo 'Bitrate: '.$shoutcast_bitrate.'kb/s<br> Uhrzeit: '.$uhrzeit.'<br>';
		//echo 'Zuhörer: '.$listeners.'<br>';
        echo 'Titel: '.htmlentities($shoutcast_cursong);
    else:
		echo 'Unser Radio ist zur Zeit offline!';
    endif;
    ?>
