				<?php
				$trans = new trans();
					$trans->host = $transhost;
					$trans->port = $transport;
					$trans->adminpass = $transadminpass;
					$trans->adminuser = $transadminuser;
				$between = new strings();
				?>
 <div class="row">
        <div class="col-sm-3 col-lg-3">
      		<div class="dash-unit">
	      		<dtitle>Navigation</dtitle>
	      		<hr>
				<h3><a href="?page=modi&mode=server">Server Einstellungen</a></h3>
				<h3><a href="?page=modi&mode=deejay">Deejay Einstellungen</a></h3>
				<h3><a href="?page=modi&mode=play">Playlisten Einstellungen</a></h3>
				<h3><a href="?page=modi&mode=event">Event Einstellungen</a></h3>
				<h3><a href="?page=modi&mode=data">Dateien verwalten</a></h3>
				<h3><a href="?page=modi&mode=points">Endpoint Einstellungen</a></h3>
			</div>
        </div>

        <div class="col-sm-9 col-lg-9">
      		<div class="double-unit">
		  		<dtitle>Einstellungen</dtitle>
		  		<hr>
				<?php
				if($_GET['mode'] == NULL or !file_exists('pages/mode/'.$_GET['mode'].'.php')):
					echo "<p><h1>Alle Einstellungen</h1>Alle Einstellungen vom Transcoder und der Dateiverwaltung.</p>";
				else:
					include('pages/mode/'.$_GET['mode'].'.php');
				endif;
				?>
			</div>
        </div>
	  </div>
	  <div class="row">
		<div class="col-sm-5 col-lg-5">
			<div class="half-unit">
				<dtitle>Serverübersicht</dtitle>
				<hr>
				<div id="resc" style="padding-left:15px;">Response</div>
			</div>
		</div>
	  
        <div class="col-sm-7 col-lg-7">
      		<div class="half-unit">
		  		<dtitle>Manueller Begehl</dtitle>
		  		<hr>
	        	<div style="padding: 5px;">
					<input type="text" id="hiddenInput" class="hiddenInput" placeholder="op=getstatus">
					<a id="submit" class="submit">Ausführen</a>
				</div>
			</div>
        </div>
      </div>    