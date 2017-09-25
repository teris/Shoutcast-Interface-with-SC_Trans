<?php 
define('GETID3_DEMO_BROWSE_ALLOW_EDIT_LINK',   true);
define('GETID3_DEMO_BROWSE_ALLOW_DELETE_LINK', false);
define('GETID3_DEMO_BROWSE_ALLOW_MD5_LINK',    false);
/////////////////////////////////////////////////////////////////
// die if magic_quotes_runtime or magic_quotes_gpc are set
if (function_exists('get_magic_quotes_runtime') && get_magic_quotes_runtime()) {
	die('magic_quotes_runtime is enabled, getID3 will not run.');
}
if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
	die('magic_quotes_gpc is enabled, getID3 will not run.');
}
/////////////////////////////////////////////////////////////////
$PageEncoding = 'UTF-8';
$writescriptfilename = '?page=modi&mode=idtag_edit';
require_once('getid3/getid3.php');

// Initialize getID3 engine
$getID3 = new getID3;
$getID3->setOption(array('encoding' => $PageEncoding));

$getID3checkColor_Head           = 'CCCCDD';
$getID3checkColor_DirectoryLight = 'FFCCCC';
$getID3checkColor_DirectoryDark  = 'EEBBBB';
$getID3checkColor_FileLight      = 'EEEEEE';
$getID3checkColor_FileDark       = 'DDDDDD';
$getID3checkColor_UnknownLight   = 'CCCCFF';
$getID3checkColor_UnknownDark    = 'BBBBDD';
///////////////////////////////////////////////////////////////////////////////
header('Content-Type: text/html; charset='.$PageEncoding);

include_once("config.php"); 
include('function.inc.php');
session_start(); ?>
<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset='<?php echo $PageEncoding; ?>' />';
	<title>Shoutcast - Admincenter with Transcoder</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Teris Cooper">
    
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
	<link href="css/main.css" rel="stylesheet">
    <link href="css/font-style.css" rel="stylesheet">
    <link href="css/flexslider.css" rel="stylesheet">
	<link rel="stylesheet" href="css/jquery.fileupload.css">
	<link href="css/table.css" rel="stylesheet">
	
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>  
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/lineandbars.js"></script>
	<script type="text/javascript" src="js/dash-charts.js"></script>
	<script type="text/javascript" src="js/gauge.js"></script>
	<script type="text/javascript" src="js/noty/jquery.noty.js"></script>
	<script type="text/javascript" src="js/noty/layouts/top.js"></script>
	<script type="text/javascript" src="js/noty/layouts/topLeft.js"></script>
	<script type="text/javascript" src="js/noty/layouts/topRight.js"></script>
	<script type="text/javascript" src="js/noty/layouts/topCenter.js"></script>
	<script type="text/javascript" src="js/noty/themes/default.js"></script>
    <!-- <script type="text/javascript" src="assets/js/dash-noty.js"></script> -->
	<script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>
	<script src="js/jquery.flexslider.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/admin.js"></script>
	<script data-main="main.js" src="//cdnjs.cloudflare.com/ajax/libs/require.js/2.3.2/require.min.js"></script>
    <style type="text/css">
      body {
        padding-top: 60px;
      }
    </style>
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<link href="http://fonts.googleapis.com/css?family=Raleway:400,300" rel="stylesheet" type="text/css">
  	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
	<script>
	$("#resc").load("shoutcast.php");
       var refreshId = setInterval(function() {
          $("#resc").load('shoutcast.php?' + 1*new Date());
       }, 1000);
	$( "#resc" ).load( "shoutcast.php", function() {
	});	
	</script>
  </head>
  <body>
    <div class="navbar-nav navbar-inverse navbar-fixed-top">
        <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html"><img src="images/logo30.png" alt="">Shoutcast Admincenter</a>
        </div> 
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="index.php"><i class="icon-home icon-white"></i>Startseite</a></li>                            
              <li><a href="?page=modi"><i class="icon-th icon-white"></i> Modifizieren</a></li>
              <li><a href="?page=login"><i class="icon-lock icon-white"></i>Login/Logout</a></li>
            </ul>
          </div>
        </div>
    </div>

    <div class="container">
		
		<?php
			if($_GET['page'] == NULL or !file_exists('pages/'.$_GET['page'].'.php')):
				include('pages/start.php');
			else:
				include('pages/'.$_GET['page'].'.php');
			endif;
		?>
	
	</div>
	<div id="footerwrap">
      	<footer class="clearfix"></footer>
      	<div class="container">
			<div class="row">
				<div class="col-sm-3 col-lg-3">
				
				</div>
      			<div class="col-sm-9 col-lg-9">
      			<p><img src="images/logo.png" alt=""></p>
      			<p>Copyright 2017</p>
      			</div>
      		</div>
      	</div>		
	</div>
<script>
$('a.befehl').click(function() { 
	$('#xmlcode').load('transcoder.php' + $(this).attr('seq'));
//	alert($(this).attr('seq'));
});   
$('a.submit').click(function() {
	//var term = $('#hiddenInput').val();
	//alert(term);
	$('#xmlcode').load('transcoder.php?' + $('input.hiddenInput').val());
});
</script>
    <script type="text/javascript" src="js/bootstrap.js"></script>				
</body></html>
