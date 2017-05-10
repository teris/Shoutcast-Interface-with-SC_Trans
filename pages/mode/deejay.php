<?php
	if(isset($_POST['save'])):
		$request	= "op=adddj";
		if($_POST['password'] == $_POST['pass_wdh']):
			($_POST['login'] != NULL) 		? $request .="&name=".$_POST['login']				: $request.="";
			($_POST['prio'] != NULL) 		? $request .="&priority=".$_POST['prio']			: $request.="&priority=2";
			$request .= "&password=".$_POST['password'];
			
			if($_POST['aktiv'] == "1"):
				
				$request2 = "op=addevent";
				$request2 .= "&type=dj"; 
				$request2 .= "&name=".$_POST['login']; 
				$request2 .= "&startdate=00:00:00"; 
				$request2 .= "&archive=inherit"; 
				
				$returns2 = $between->load_xml($trans->getInfoTrans($request2."&seq=15"),'deejay_add_event.xml');
				echo "<pre>";
					print_r($returns2['response']);
				echo "</pre>";
			endif;
			
			$returns = $between->load_xml($trans->getInfoTrans($request."&seq=15"),'deejay_add.xml');
			echo "<hr><pre>";
				print_r($returns['response']);
			echo "</pre>";
		
		else:
			echo "<font color=''>Das Passwort stimmt nicht überein!</font>";
		endif;		
	endif;
?>
						
<div class="row">
	<div class="col-sm-8 col-lg-8">
		<div class="dash-unit">
		<form action="" method="post">
			<dtitle>Deejay hinzufügen</dtitle>
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
						<td>Name:</td>
						<td><input type="text" name="login" placeholder="Name ist der Login für den Deeay"></td>
					</tr>
					<tr class="odd">
						<td>Passwort:</td>
						<td><input type="password" name="password" placeholder="Passwort für den Deejay"></td>
					</tr>
					<tr class="even">
						<td>Passwort wiederholen:</td>
						<td><input type="password" name="pass_wdh" placeholder="Passwort wiederholen"></td>
					</tr>
					<tr class="odd">
						<td>Priorität:</td>
						<td><input type="text" name="prio" placeholder="Standart 1 / Empholen 5"></td>
					</tr>
					<tr class="even">
						<td>Aktivieren:</td>
						<td><input type="checkbox" name="aktiv" value="1" checked></td>
					</tr>
				</tbody>
			</table>
			<p><input type="submit" value="Speichern" name="save"> <input type="reset" value="Zurücksetzen"></p>
		</form>
		</div>
	</div>
	<div class="col-sm-4 col-lg-4">
		<div class="dash-unit">
			<dtitle>Vorhandene DJs</dtitle>
			<hr>
			<ul>
			<?php
				$exit	=	$between->load_xml($trans->getInfoTrans("op=listdjs&seq=15"), 'deejay_liste.xml');
				$liste	=	$exit['response']['data']['djlist']['dj'];
				//$i=0;
				for($i=0; $liste[$i] >= $i; $i++):
					if($liste[$i]['enabled'] == "1"):
						echo "<li>Deejay: <font color='green'>".$liste[$i]['name']."</font></li>";
					else:
						echo "<li>Deejay: <font color='red'>".$liste[$i]['name']."</font></li>";
					endif;
				//	$i++;
				endfor;
			?>
			</ul>
		</div>
	</div>
</div>
<?php
	if(isset($_POST['modi'])):
		$request	= "op=modifydj";
		if($_POST['password'] == $_POST['pass_wdh']):
			($_POST['name'] != NULL) 		? $request .="&name=".$_POST['name']				: $request.="";
			($_POST['prio'] != NULL) 		? $request .="&priority=".$_POST['prio']			: "";
			$request .= "&password=".$_POST['password'];
			
			if($_POST['aktiv'] == "1"):
				$request2 = "op=addevent";
				$request2 .= "&type=dj"; 
				$request2 .= "&name=".$_POST['name']; 
				$request2 .= "&startdate=00:00:00"; 
				$request2 .= "&archive=inherit"; 
				$returns2 = $between->load_xml($trans->getInfoTrans($request2."&seq=15"),'deejay_add_event.xml');
				echo "<pre>";
					print_r($returns2['response']);
				echo "</pre>";
			endif;
			
			$returns = $between->load_xml($trans->getInfoTrans($request."&seq=15"),'deejay_edit.xml');
			echo "<hr><pre>";
				print_r($returns['response']);
			echo "</pre>";
		
		else:
			echo "<font color=''>Das Passwort stimmt nicht überein!</font>";
		endif;		
	endif;
?>
<div class="row">
	<div class="col-sm-6 col-lg-6">
		<div class="double-unit">
		<form action="" method="post">
			<dtitle>Deejay Bearbeiten</dtitle>
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
						<td>Name:</td>
						<td><select name="name">
						<?php
							$exit	=	$between->load_xml($trans->getInfoTrans("op=listdjs&seq=15"), 'deejay_liste2.xml');
							
							for($i = 0; $exit['response']['data']['djlist']['dj'][$i] >= $i; $i++):
								echo "<option value='".$exit['response']['data']['djlist']['dj'][$i]['name']."'>".$exit['response']['data']['djlist']['dj'][$i]['name']."</option>";
								$i++;
							endfor;
						?>
						</select></td>
					</tr>
					<tr class="odd">
						<td>Neues Passwort:</td>
						<td><input type="password" name="password" placeholder="Passwort für den Deejay"></td>
					</tr>
					<tr class="even">
						<td>Passwort wiederholen:</td>
						<td><input type="password" name="pass_wdh" placeholder="Passwort wiederholen"></td>
					</tr>
					<tr class="odd">
						<td>Priorität:</td>
						<td><input type="text" name="prio" placeholder="Standart 1 / Empholen 5"></td>
					</tr>
					<tr class="even">
						<td>Aktivieren:</td>
						<td><input type="checkbox" name="aktiv" value="1" checked></td>
					</tr>
				</tbody>
			</table>
			<p><input type="submit" value="Speichern" name="modi"> <input type="reset" value="Zurücksetzen"></p>
		</form>
		</div>
	</div>
	<div class="col-sm-6 col-lg-6">
		<div class="half-unit">
			<dtitle>Deejay Löschen</dtitle>
			<hr>
			<form action="" method="POST">
				<p><input type="text" name="dj_name" placeholder="Name des Deejays eingeben zum Löschen"> <input type="submit" name="deletedj" value="Löschen"></p>
			</form>
		</div>
	</div>
	<div class="col-sm-6 col-lg-6">
		<div class="half-unit">
			<dtitle>Informationscenter | Priorität</dtitle>
			<hr>
			<p>Priorität: Enthält die Prioritätsstufe für den DJ, der verwendet wird, um einen DJ zu priorisieren, wenn mehr als ein DJ gleichzeitig angeschlossen ist.</p>
		</div>
	</div>
	<div class="col-sm-6 col-lg-6">
		<div class="half-unit">
			<dtitle>Informationscenter | Farbskala</dtitle>
			<hr>
			<p><font color="red">Rot</font>: Deejay darf sich nicht einloggen!<br>
			<font color="green">Grün</font>: Deejay darf sich einloggen!<br></p>
		</div>
	</div>
</div>