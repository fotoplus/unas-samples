<?php

/**
 * UNAS API - getProduct
 * https://unas.hu/tudastar/api/termekek
 * 
 * Itt a getProduct végpontot tudjuk kipróbálni.
 * 
 * Egy ?sku=ABC paraméterrel konkrét terméket is lekérhetünk a cikkszáma alapján.
 * Egy ?category_id=345973 paraméterrel pedig egy kategória összes termékét.
 * A ?showrequest=1 paraméterrel pedig a kérését láthatjuk.
 * 
 */

require_once('config/config.php');
$unas = require_once('credentials/unas.php');

$sku    = (isset($_GET['sku']) and !empty($_GET['sku'])) ? $_GET['sku'] : false;
$show_request  = isset($_GET['showrequest']) ? true : false;
$category_id   = isset($_GET['category_id']) ? $_GET['category_id'] : false;

if($sku) {
    $request='<?xml version="1.0" encoding="UTF-8" ?>
        <Params>
            <ContentType>minimal</ContentType>
            <Sku>'.$sku.'</Sku>
        </Params>';
} else {
    if($category_id) {
        
        $request='<?xml version="1.0" encoding="UTF-8" ?>
            <Params>
                <CategoryId>'.$category_id.'</CategoryId>        
                <ContentType>full</ContentType>
            </Params>';   
    } else {
        $request='<?xml version="1.0" encoding="UTF-8" ?>
            <Params>
                <ContentType>full</ContentType>
            </Params>';   
    }
}

header('Content-Type:text/xml; charset=UTF-8');
if($show_request) {
    echo $request;
} else {
    include('unas-api/auth.php');

    $headers=array();
    $headers[]="Authorization: Bearer ".$token;
                
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_URL, "https://api.unas.eu/shop/getProduct");
    curl_setopt($curl, CURLOPT_POSTFIELDS,$request);
    $response = curl_exec($curl);
    echo $response;
}


?>


