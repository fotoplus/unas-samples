<?php

/**
 * UNAS API - checkCustomer
 * https://unas.hu/tudastar/api/vasarlok-checkCustomer-keres
 * 
 * Itt a checkCustomer végpontot tudjuk kipróbálni.
 * A ?wrong paraméterrel hibás jelszót adunk meg, míg nélküle helyeset.
 * A ?showrequest paraméterrel pedig a kérését láthatjuk.
 * 
 */

require_once('config/config.php');
$unas = require_once('credentials/unas.php');

$wrong = isset($_GET['wrong']) ? true : false;
$show_request  = isset($_GET['showrequest']) ? true : false;

if(!$wrong) {
    $request='<?xml version="1.0" encoding="UTF-8" ?>
		<Params>
			<User>customer@localhost.local</User>
			<Password><![CDATA[password]]></Password>
		</Params>';
} else {
    $request='<?xml version="1.0" encoding="UTF-8" ?>
        <Params>
            <User>customer@localhost.local</User>
            <Password><![CDATA[WRONGpassword]]></Password>
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
    curl_setopt($curl, CURLOPT_URL, "https://api.unas.eu/shop/checkCustomer");
    curl_setopt($curl, CURLOPT_POSTFIELDS,$request);
    $response = curl_exec($curl);
    echo $response;
}



