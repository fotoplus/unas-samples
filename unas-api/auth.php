<?php

/**
 * UNAS API
 * 
 * Azonosítás
 * https://unas.hu/tudastar/api/azonositas
 * 
 */

$curl = curl_init();
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_POST, TRUE);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$auth_request='<?xml version="1.0" encoding="UTF-8" ?>
			<Params>
				<ApiKey>'.$unas['api-key'].'</ApiKey>
			</Params>';
			
curl_setopt($curl, CURLOPT_URL, "https://api.unas.eu/shop/login");
curl_setopt($curl, CURLOPT_POSTFIELDS,$auth_request);
$response = curl_exec($curl);
$xml=simplexml_load_string($response);
$token=(string)$xml->Token;

?>