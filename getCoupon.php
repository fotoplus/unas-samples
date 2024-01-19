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

$q    = (isset($_GET['sku']) and !empty($_GET['sku'])) ? $_GET['sku'] : false;
$show_request  = isset($_GET['showrequest']) ? true : false;

if($q) {
    $request='<?xml version="1.0" encoding="UTF-8" ?>
        <Params>
            <ContentType>minimal</ContentType>
            <Id>'.$q.'</Id>
        </Params>';
} else {
	$request = '<?xml version="1.0" encoding="UTF-8" ?>
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
    curl_setopt($curl, CURLOPT_URL, "https://api.unas.eu/shop/getCoupon");
    curl_setopt($curl, CURLOPT_POSTFIELDS,$request);
    $response = curl_exec($curl);
    echo $response;
}


?>


