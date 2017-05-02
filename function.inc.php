<?php
class trans 
{
	var $host;
	var $port;
	var $adminpass;
	var $adminuser;
	
	function getInfoTrans($option)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://'.$this->adminuser.':'.$this->adminpass.'@'.$this->host.':'.$this->port.'/api');
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $option);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		$xml = curl_exec($ch);
		return($xml);
		curl_close ($ch);
	}
}

class strings {
	function between($von,$bis,$string) 
	{
		##$von (<teil>)
		##$bis (</teil>)
		##$string = datei
	$a = explode($von,$string);
	$b = explode($bis,$a[1]);
	return($b[0]);
	}

	function file_list($dir) {
		global $sort;
		global $file_file_count;

		if (is_dir($dir)):
			$fd = @opendir($dir);
			while (($part = @readdir($fd)) == true):
				clearstatcache();
				if ($part != '.' && $part != '..'):
					$file_array[] = $part;
				endif;
			endwhile;
			
			if($fd == true): 
				closedir($fd);
			endif;
			
			if (is_array($file_array)):
				$sort($file_array);
				$file_file_count = count($file_array);
				return $file_array;
			else:
				return false;
			endif;
		else:
			return false;
		endif;
	}
	function generate_file_list($path) {
		global $download_path;
		
		$final_path = str_replace("//","/",str_replace("..","",urldecode($path)));
		$file_array = $this->file_list("$download_path/$final_path/");
		
		echo '<strong>'.$final_path.'/</strong>';
		echo '<br />';
		
		if ($file_array == false): 
			echo 'Verzeichnis ist leer.';
		else:
			echo '<div  style="overflow: auto;  height: 200px;">';
			echo '<table border="1" cellpadding="2" cellspacing="3" class="display"><thead>
					<tr>
					<th>Dateiname</th>
					<th>Pfad</th>
					<th>Select</th>
					</tr></thead><tbody>';
		
			foreach ($file_array as $file_name):
				$is_file = "$download_path/$final_path/$file_name";
				$final_dir_name = urlencode($final_path);
				$final_file_name = urlencode($file_name);
				if (is_file($is_file)):
				
					echo '<tr class="odd">';
					echo '<td>'.$file_name.'</td>';
					echo '<td>'.$_SERVER['DOCUMENT_ROOT'].'/files'.$final_path.'</td>';
					echo '<td> <input type="checkbox" name="mp3[]"></td>';
					echo "</tr>\n";
				
				elseif (is_dir($is_file)):
					
					echo '<tr class="even">';
					echo '<td><a href="?page=modi&mode=play&go=list&path='.$final_dir_name.'/'.$final_file_name.'">'.$file_name.'/</a></td>';
					echo '<td>Verzeichnis</td>';
					echo '<td> </td>';
					echo "</tr>\n";
				
				endif;
			endforeach;
		
			echo '</tbody></table></div>';
		endif;
	}
	function generate_file_list_type2($path) {
		global $download_path;
		
		$final_path = str_replace("//","/",str_replace("..","",urldecode($path)));
		$file_array = $this->file_list("$download_path/$final_path/");
		
		if ($file_array == false): 
			echo '<li>Verzeichnis ist leer.</li>';
		else:
			foreach ($file_array as $file_name):
				$is_file = "$download_path/$final_path/$file_name";
				$final_dir_name = urlencode($final_path);
				$final_file_name = urlencode($file_name);
				if (is_file($is_file)):
				
					echo '<li>'.$file_name.' | ';
					echo '<input type="checkbox" name="mp3[]"></li>';
					
				elseif (is_dir($is_file)):
					
					echo '<li><a href="?page=modi&mode=play&go=list&path='.$final_dir_name.'/'.$final_file_name.'">'.$file_name.'/</a> | ';
					echo 'Verzeichnis</li>';
					
				endif;
			endforeach;
		endif;
	}
	
	function load_xml($action, $file = 'serverinfo.xml', $dir = 'xml/')
	{
		$handle = fopen ($dir.$file, w);
		
		fwrite ($handle, $action);
		fclose ($handle);
		
		$xml   = simplexml_load_file($dir.$file);
		
		$array = json_decode(json_encode((array) $xml), 1);
		$array = array($xml->getName() => $array);
		
		return $array;
		
		//unlink($dir.$file);
	}
}
?>