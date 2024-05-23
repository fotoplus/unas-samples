<?php

/**
 * UNAS API - getMethod (shipping)
 * https://unas.hu/tudastar/api/fizetesi-szallitasi-modok
 * 
 * Itt a getMethod végpontot tudjuk kipróbálni, a shipping paraméterrel,
 * ami a szállítási módokat adja vissza.
 * 
 * A ?showrequest=1 paraméterrel pedig a kérését láthatjuk.
 * 
 */

require_once('config/config.php');
$unas = require_once('credentials/unas.php');

$show_request  = isset($_GET['showrequest']) ? true : false;

$request='<?xml version="1.0" encoding="UTF-8" ?>
<Params>
    <Type>shipping</Type>
</Params>
';


header('Content-Type:text/xml; charset=UTF-8');

if($show_request) {
	echo $request;
} else {

    include('unas-api/auth.php');

    $headers=array();
    $headers[]="Authorization: Bearer ".$token;
                
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_URL, "https://api.unas.eu/shop/getMethod");
    curl_setopt($curl, CURLOPT_POSTFIELDS,$request);
    $response = curl_exec($curl);
    echo $response;
}

?>


