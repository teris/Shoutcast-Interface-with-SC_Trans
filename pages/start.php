 <div class="row">
        <div class="col-sm-3 col-lg-3">
      		<div class="dash-unit">
	      		<dtitle>Befehle</dtitle>
	      		<hr>
				<h3><a class="befehl" seq="?op=getstatus">Status</a></h3>
				<h3><a class="befehl" seq="?op=getoptions">Optionen</a></h3>
				<h3><a class="befehl" seq="?op=listplaylists">Playlisten</a></h3>
				<h3><a class="befehl" seq="?op=listdjs">Deejays</a></h3>
				<h3><a class="befehl" seq="?op=listevents">Events</a></h3>
				<hr>
				<h3><a class="befehl" seq="?op=restart">Transcoder Neustarten</a></h3>
				<h3><a class="befehl" seq="?op=kickdj">Deejay Kicken</a></h3>
				<h3><a class="befehl" seq="?op=nexttrack">Next Track</a></h3>
			</div>
        </div>

        <div class="col-sm-9 col-lg-9">
      		<div class="dash-unit">
		  		<dtitle>Ausgabe - XML Format</dtitle>
		  		<hr>
	        	<pre><div style='overflow: auto;  height: 200px;' id='xmlcode' >Ausgabe vom Server</div></pre>
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