<?php
if(isset($_POST['submit'])):
	$request = "op=addevent";
	
	($_POST['type'] != NULL) 			? $request.="&type=".$_POST['type']				: $type=false;
	
	if($_POST['type'] == 'playlist'):
		($_POST['loop'] == "on") 			? $request.="&loopatend=1" 						: $request.="&loopatend=0";
		($_POST['prio'] != NULL) 			? $request.="&priority=".$_POST['prio'] 		: $request.="&priority=1";
		($_POST['start_time'] != NULL) 		? $request.="&starttime=".$_POST['start_time'] 	: $start_time=false;
		($_POST['start_date'] != NULL) 		? $request.="&startdate=".$_POST['start_date'] 	: $start_date=false;
		($_POST['end_date'] != NULL) 		? $request.="&enddate=".$_POST['end_date'] 		: $end_date=false;
		($_POST['duration'] != NULL) 		? $request.="&duration=".$_POST['duration'] 	: $duration=false;
		($_POST['delay'] != NULL) 			? $request.="&timeoffset=".$_POST['delay'] 		: $delay=false;
		($_POST['mo'] == '2') 				? $day1="2" 									: $day1="0";
		($_POST['di'] == '4') 				? $day2="4" 									: $day2="0";
		($_POST['mi'] == '8') 				? $day3="8" 									: $day3="0";
		($_POST['do'] == '16') 				? $day4="16" 									: $day4="0";
		($_POST['fr'] == '32') 				? $day5="32" 									: $day5="0";
		($_POST['sa'] == '64') 				? $day6="64" 									: $day6="0";
		($_POST['so'] == '1') 				? $day7="1" 									: $day7="0";
		($_POST['pero'] == '128') 			? $day8="128" 									: $day8="0";
	endif;
	
	($_POST['name'] != NULL) 			? $request.="&name=".$_POST['name'] 			: $name=false;
	($_POST['shuffled'] != 'inherit') 	? $request.="&shuffle=".$_POST['shuffled'] 		: $request.="&archive=1";
	
	$days = $day1+$day2+$day3+$day4+$day5+$day6+$day7+$day8;
	if($days != NULL):
		$request .= "&repeat=".$days;
	endif;	
	
	$returns = $between->load_xml($trans->getInfoTrans($request."&seq=150"),'transcoder_event_add.xml');
	
	echo "<hr><pre>";
	print_r($returns['response']);
	echo "</pre>";
	
endif;
?>

<form action="" method="post">
<div class="row">
	<div class="col-sm-8 col-lg-8">
		<div class="double-unit">
			<dtitle>Kalender Optionen</dtitle>
			<hr>
			<table border="1" cellpadding="2" cellspacing="3" class="display">
				<thead>
					<tr>
						<th>Action</th>
						<th>Option</th>
					</tr>
				</thead>
				<tbody>
					<tr class="even">
						<td>Deejay <input type="radio" name="type" value="dj"></td>
						<td>Playlist <input type="radio" name="type" value="playlist" checked></td>
					</tr>
					<tr class="odd">
						<td class="" >Playliste / Deejay Name</td>
						<td>
							<select name="name" class="inputtable">
							<?php
								$exit	= 	$between->load_xml($trans->getInfoTrans("op=listplaylists&seq=150"), 'playlisten_activate.xml');
								for($i = 0; $exit['response']['data']['playlists']['playlist'][$i] >= $i; $i++):
									echo "<option value='".$exit['response']['data']['playlists']['playlist'][$i]['name']."'>Playliste: ".$exit['response']['data']['playlists']['playlist'][$i]['name']."</option>";
								endfor;
								$exit2	=	$between->load_xml($trans->getInfoTrans("op=listdjs&seq=150"), 'deejay_activate.xml');
								for($i = 0; $exit2['response']['data']['djlist']['dj'][$i] >= $i; $i++):
									echo "<option value='".$exit2['response']['data']['djlist']['dj'][$i]['name']."'>Deejay: ".$exit2['response']['data']['djlist']['dj'][$i]['name']."</option>";
								endfor;
							?>
							</select>
						</td>
					</tr>
					<tr class="even">
						<td class="">Wiederholung der Playliste</td>
						<td><input name="loop" checked="checked" type="checkbox"></td>
					</tr>
					<tr class="odd">
						<td class="">Zufällig / Dj Aktivieren</td>
						<td>
							<select name="shuffled" class="inputtable">
								<option value="inherit">Aktivieren (Wichtig für Deejay)</option>
								<option value="1">Ja (Nur für Playlisten)</option>
								<option value="0">Nein  (Nur für Playlisten)</option>
							</select>
						</td>
					</tr>
					<tr class="even">
						<td class="">Priorität</td>
						<td><input name="prio" placeholder="1 (Wichtig für Playlisten)" value="" type="text"></td>
					</tr>
					<tr class="odd">
						<td class="" >Start Datum</td>
						<td><input name="start_date" placeholder="yyyy/mm/dd z.Bsp. 2010/12/31" value="" type="text"></td>
					</tr>
					<tr class="even">
						<td class="">End Datum</td>
						<td><input name="end_date" placeholder="yyyy/mm/dd z.Bsp. 2010/12/31" value="" type="text"></td>
					</tr>
					<tr class="odd">
						<td class="">Start Zeit</td>
						<td><input name="start_time" placeholder="hh:mm:ss - 24 Stunden Format z.Bsp. 23:59:59" value="" type="text"></td>
					</tr>
					<tr class="even">
						<td class="">Dauer</td>
						<td><input name="duration" placeholder="hh:mm:ss - 24 Stunden Format z.Bsp. 23:59:59" value="" type="text"></td>
					</tr>
					<tr class="odd">
						<td class="">Zeitverzögerung</td>
						<td><input name="delay" placeholder="hh:mm:ss - 24 Stunden Format z.Bsp. 23:59:59" value="" type="text"></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-sm-4 col-lg-4">
		<div class="double-unit">
			<dtitle>Tages Optionen</dtitle>
			<hr>
			<table border="1" cellpadding="2" cellspacing="3" class="display">
				<thead>
					<tr>
						<th>Tag</th>
						<th>Option</th>
					</tr>
				</thead>
				<tbody>
					<tr class="odd">
						<th>Montag</th>
						<td><input name="mo" value="2" type="checkbox"></td>
					</tr>
					<tr class="even">
						<th>Dienstag</th>
						<td><input name="di" value="4" type="checkbox"></td>
					</tr>
					<tr class="odd">
						<th>Mittwoch</th>
						<td><input name="mi" value="8" type="checkbox"></td>
					</tr>
					<tr class="even">
						<th>Donnerstag</th>
						<td><input name="do" value="16" type="checkbox"></td>
					</tr>
					<tr class="odd">
						<th>Freitag</th>
						<td><input name="fr" value="32" type="checkbox"></td>
					</tr>
					<tr class="even">
						<th>Samstag</th>
						<td><input name="sa" value="64" type="checkbox"></td>
					</tr>
					<tr class="odd">
						<th>Sonntag</th>
						<td><input name="so" value="1" type="checkbox"></td>
					</tr>
					<tr class="even">
						<th>Periodisch</th>
						<td><input name="pero" value="128" type="checkbox"></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12 col-lg-12">
		<div class="half-unit">
		<dtitle>Aktion</dtitle>
		<hr>
		<center>
			<input type="submit" name="submit" value="Speichern"> <input type="reset" value="Zurücksetzen">
		</center>
		</div>
	</div>
</div>
</form>