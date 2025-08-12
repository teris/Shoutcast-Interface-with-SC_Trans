<?php
include_once("config.php");
include('function.inc.php');

$trans = new trans();
	$trans->host = $transhost;
	$trans->port = $transport;
	$trans->adminpass = $transadminpass;
	$trans->adminuser = $transadminuser;

$between = new strings();
	
$request = '';
if (isset($_GET['op'])):
	$parts = array();
	foreach($_GET as $key => $select):
		$parts[] = rawurlencode($key) . "=" . rawurlencode($select);
	endforeach;
	$request = implode('&', $parts) . '&';
endif;

$op = isset($_GET['op']) ? preg_replace('/[^a-zA-Z0-9_\-]/', '', $_GET['op']) : '';

echo "<hr>";
// avoid duplicating op when echoing built command
$displayRequest = $request;
$displayRequest = preg_replace('/(^|&)op=[^&]*&/','\\1', $displayRequest);
echo "Befehl: op=".$op."&".$displayRequest."seq=150";
echo "<hr>";
	
if (!empty($op)):
	$params = "op=".$op."&".$displayRequest."seq=150";
	$response = $trans->getInfoTrans($params);
	echo( highlight_string($response,true) );
	$returns = $between->load_xml($response,'transcoder.xml');
	echo "<hr><pre>";
	print_r($returns['response']);
	echo "</pre>";
else:
	echo( "<font color='red'>Der Befehl war FALSCH</font><br>Bitte setlle bei jedem Befehl 'op=' vorran." );
endif;
?>