<?php

/**
 * UNAS API
 * 
 * getProductDB
 * https://unas.hu/tudastar/api/termekek-getProductDB-keres
 * 
 * A termékadatbázist adja vissza, esetünkben egy konkért ID-jú kategóriát,
 * ami a képrendeléseké. Az ID-ja az éles és teszt környezetben nem ugyanaz.
 * 
 */

require_once('config/config.php');
$unas = require_once('credentials/unas.php');

$show_request  = isset($_GET['showrequest']) ? true : false;

$request='<?xml version="1.0" encoding="UTF-8" ?>
<Params>
    <Format>txt</Format>
    <Compress>no</Compress>
    <Category>284879</Category>
    <Lang>hu</Lang>
    <Order>Category</Order>
</Params>';


header('Content-Type:text/xml; charset=UTF-8');

if($show_request) {
    echo $request;
} else {

    include('unas-api/auth.php');

    $headers=array();
    $headers[]="Authorization: Bearer ".$token;
                
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_URL, "https://api.unas.eu/shop/getProductDB");
    curl_setopt($curl, CURLOPT_POSTFIELDS,$request);
    $response = curl_exec($curl);
    echo $response;
}

?>