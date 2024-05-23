<?php

/**
 * UNAS API - getOrderType
 * https://unas.hu/tudastar/api/megrendeles-tipusok
 * 
 * Itt a getOrderType végpontot tudjuk kipróbálni
 * ami a megrendelés típusokat adja vissza
 * 
 * A ?showrequest=1 paraméterrel pedig a kérését láthatjuk.
 * 
 * (VIP CSOMAG szükséges, a teszt webáruházban nem elérhető)
 * 
 */

require_once('config/config.php');
$unas = require_once('credentials/unas.php');

$show_request  = isset($_GET['showrequest']) ? true : false;

$request='<?xml version="1.0" encoding="UTF-8" ?>
<Params>
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
    curl_setopt($curl, CURLOPT_URL, "https://api.unas.eu/shop/getOrderType");
    curl_setopt($curl, CURLOPT_POSTFIELDS,$request);
    $response = curl_exec($curl);
    echo $response;
}

?>


