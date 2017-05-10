<?php
include_once("config.php");
include('function.inc.php');

$trans = new trans();
	$trans->host = $transhost;
	$trans->port = $transport;
	$trans->adminpass = $transadminpass;
	$trans->adminuser = $transadminuser;

$between = new strings();
	
$reguest = NULL;
if(isset($_GET['op'])):
	foreach($_GET as $key => $select):
		$request .= $key."=".$select."&";
	endforeach;
endif;

echo "<hr>";	
echo "Befehl: ".$request."seq=150";
echo "<hr>";
	
if($_GET['op']):
	echo( highlight_string($trans->getInfoTrans("op=".$_GET['op']."&".$request."seq=150"),true) );
	$returns = $between->load_xml($trans->getInfoTrans("op=".$_GET['op']."&".$request."seq=150"),'transcoder.xml');
	echo "<hr><pre>";
	print_r($returns['response']);
	echo "</pre>";
else:
	echo( "<font color='red'>Der Befehl war FALSCH</font><br>Bitte setlle bei jedem Befehl 'op=' vorran." );
endif;
?>