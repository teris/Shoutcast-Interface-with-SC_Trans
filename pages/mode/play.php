<?php

$download_path = 'files/';
$sort = 'asort';

$path = $_GET['path'];
$go = $_GET['go'];

if(isset($_POST['delete'])):
	$request =	"op=deleteplaylist";
		for($i = 0; $_POST['l']-1 >= $i; $i++):
			
			if($_POST['liste'][$i] != NULL):
				$request .= "&name=".$_POST['liste'][$i];
			endif;
			
			$del = $_POST['filedel'][$i]-1;
			
			if($_POST['liste'][$i] == $del):
				$request .= "&deletefile=1";
			endif;
			
			$returns = $between->load_xml($trans->getInfoTrans($request."&seq=15"),'transcoder_playliste_'.$i.'_delete.xml');
			
			echo "<hr><pre>";
			print_r($returns['response']);
			echo "</pre>";
			
		endfor;
endif;


?>

<form action="" method="post">
<div class="row">
	<div class="col-sm-6 col-lg-6">
		<div class="dash-unit">
		<dtitle>Playlisten</dtitle>
		<hr>
			<div  style="overflow: auto;  height: 200px;">
				<table border="1" cellpadding="2" cellspacing="3" class="display">
					<thead>
						<tr>
							<th>Name</th>
							<th>Deaktivieren</th>
							<th>Löschen</th>
						</tr>
					</thead>
					<tbody>						
					<?php
						$exit	= 	$between->load_xml($trans->getInfoTrans("op=listplaylists&seq=15"), 'playlisten.xml');
						$a = "0";
						for($i = 0; $exit['response']['data']['playlists']['playlist'][$i] >= $i; $i++):
							echo "<tr class='even'>
									<td>".$exit['response']['data']['playlists']['playlist'][$i]['name']."</td>
									<td><input type='checkbox' value='".$exit['response']['data']['playlists']['playlist'][$i]['name']."' name='liste[".$a++."]'></td>
									<td><input type='checkbox' value='1' name='filedel[".$a."]'><input type='hidden' value='".$a."' name='l'></td>
								</tr>";
						endfor;
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-lg-6">
		<div class="half-unit">
		<dtitle>Aktion</dtitle>
		<hr>
		<center>
			<input type="submit" name="delete" value="Löschen"> <input type="reset" value="Zurücksetzen">
		</center>
		</div>
	</div>
</div>
</form>

<?php
if(isset($_POST['create'])):
	$request =	"op=addplaylist";
	if($_POST['name'] != NULL):
		$request .= "&name=".$_POST['name'];
		$i = 0;
		while($i < count($_POST['mp3']) ):
			$request .= "&entry".$i."=".$_POST['mp3'][$i];
			$i++;
		endwhile;
		$request .= "&format=list";
	endif;
  
	$returns = $between->load_xml($trans->getInfoTrans($request."&seq=15"),'transcoder_playlist_add.xml');
	
	echo "<hr><pre>";
	print_r($returns['response']);
	echo "</pre>";
endif;

?>

<form action="" method="post">
<div class="row">
	<div class="col-sm-12 col-lg-12">
		<div class="dash-unit">
		<dtitle>Dateien</dtitle>
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
		</div>
	</div>
	<div class="col-sm-6 col-lg-6">
		<div class="half-unit">
		<dtitle>Name</dtitle>
		<input type="text" placeholder="Deine Playliste" name='name'>
		</div>
	</div>
	<div class="col-sm-6 col-lg-6">
		<div class="half-unit">
		<dtitle>Aktion</dtitle>
			<center>
				<input type="submit" name="create" value="Erstellen"> <input type="reset" value="Zurücksetzen">
			</center>
		</div>
	</div>
	
	
</div>
</form>
