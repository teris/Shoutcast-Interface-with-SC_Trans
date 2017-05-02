<?php

$download_path = 'files/';
$sort = 'asort';

$path = $_GET['path'];
$go = $_GET['go'];


?>
<div class="row">
<div class="col-sm-6 col-lg-6">
	<div id="hosting-table">
		<div class="table_style4"> 
			<div class="column">
				<ul>
					<li><strong>Playliste Erstellen</strong></li>
					<li>Name: <input type="text" id="name" name="name" placeholder="Playlist.lst"></li>
					<li class="footer_row"><a href="#" class="hosting-button">Erstellen</a></li>
				</ul>
			</div>
		</div>
	</div>	
</div>	
<div class="col-sm-6 col-lg-6">
	<div id="hosting-table">
		<div class="table_style4"> 
			<div class="column">
				<ul>
					<li><strong>Titelauswahl</strong></li>
					<?php
					if (!isset($go)):
						$go = 'dirlist';
					endif;

					if ($go == "dirlist"): 
						$between->generate_file_list_type2('');
					elseif ($go =='list' && isset($path)):
						if (isset($path)):
							$between->generate_file_list_type2($path);
						else:
							$between->generate_file_list_type2("");
						endif;
					endif; 

					?>
				</ul>
			</div>
		</div>
	</div>	
</div>	
</div>
<!--<div class="col-sm-12 col-lg-12"></div>-->
<?php
if (!isset($go)):
	$go = 'dirlist';
endif;

if ($go == "dirlist"): 
	$between->generate_file_list('');
elseif ($go =='list' && isset($path)):
	if (isset($path)):
		$between->generate_file_list($path);
	else:
		$between->generate_file_list("");
	endif;
endif; 

?>

<hr>
Playlisten Löschen:<br>
<?php
	
	$exit	= 	$between->load_xml($trans->getInfoTrans("op=listplaylists&seq=150"), 'playlisten.xml');
	//echo "<pre>";
	//print_r($exit['response']['data']['playlists']['playlist']);
	//echo "</pre>";
	for($i = 0; $exit['response']['data']['playlists']['playlist'][$i] >= $i; $i++):
		echo $exit['response']['data']['playlists']['playlist'][$i]['name']."<br>";
	endfor;
	
?>
<hr>
Playlisten Deaktivieren