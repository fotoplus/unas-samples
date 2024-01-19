<?php

/**
 * UNAS API - getOrder
 * https://unas.hu/tudastar/api/megrendelesek-getOrder-keres
 * 
 * Itt a getOrder végpontot tudjuk kipróbálni, ami egy rendelést ad vissza
 * 
 * A rendelések, vagy egy/bizonyos konkrét rendelés(ek) részleteit kérhetjük le.
 * Itt egy ?key= paraméterrel le tudunk kérni egy konkrét rendelést.
 * A ?showrequest paraméterrel pedig a kérését láthatjuk.
 * 
 */

require_once('config/config.php');
$unas = require_once('credentials/unas.php');




$key= isset($_GET['key']) ? $_GET['key'] : false;
$show_request  = isset($_GET['showrequest']) ? true : false;

if($key){
	$request='<?xml version="1.0" encoding="UTF-8" ?>
	<Params>
			<Key>'.$key.'</Key>
	</Params>';
} else {
	$request='<?xml version="1.0" encoding="UTF-8" ?>
	<Params>
	</Params>';
}


header('Content-Type:text/xml; charset=UTF-8');

if($show_request) {
	echo $request;
} else {
	include('unas-api/auth.php');
	$headers=array();
	$headers[]="Authorization: Bearer ".$token;
			
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_URL, "https://api.unas.eu/shop/getOrder");
	curl_setopt($curl, CURLOPT_POSTFIELDS,$request);
	$response = curl_exec($curl);
	echo $response;
}

?>