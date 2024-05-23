<?php





/**
 * UNAS API - getCoupon
 * https://unas.hu/tudastar/api/kuponok
 * 
 * Itt a getCoupon végpontot tudjuk kipróbálni.
 * 
 * Egy ?q=ABC paraméterrel konkrét kuponkódot is lekérhetünk a kódja alapján.
 * A ?showrequest=1 paraméterrel pedig a kérését láthatjuk.
 * 
 */

require_once('config/config.php');
$unas = require_once('credentials/unas.php');


$request='<?xml version="1.0" encoding="UTF-8" ?>
<Params>
    <Type>shipping</Type>
</Params>
';


header('Content-Type:text/xml; charset=UTF-8');

include('unas-api/auth.php');

$headers=array();
$headers[]="Authorization: Bearer ".$token;
            
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_URL, "https://api.unas.eu/shop/getMethod");
curl_setopt($curl, CURLOPT_POSTFIELDS,$request);
$response = curl_exec($curl);
echo $response;


?>


