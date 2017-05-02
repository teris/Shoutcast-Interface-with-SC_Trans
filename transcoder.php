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
	
	$returns = $trans->getInfoTrans("op=".$_GET['op']."&".$request."seq=150");
	echo "<hr><pre>";
	$xml = simplexml_load_string($returns);
	//foreach($xml as $key_log => $key_select):
	//	echo $key_log." - ".$key_select."<br>";
	//endforeach;
	print_r($xml->data);
	echo "</pre>";
else:
	echo( "<font color='red'>Der Befehl war FALSCH</font><br>Bitte setlle bei jedem Befehl 'op=' vorran." );
endif;
?>