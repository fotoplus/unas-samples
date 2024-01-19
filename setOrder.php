<?php

/**
 * UNAS API - setOrder
 * https://unas.hu/tudastar/api/megrendelesek-setOrder-keres
 * 
 * Itt a setOrder végpontot tudjuk kipróbálni, ami egy rendelést hoz létre
 * A ?showrequest paraméterrel pedig a kérését láthatjuk.
 * 
 */



require_once('config/config.php');
$unas = require_once('credentials/unas.php');

$show_request  = isset($_GET['showrequest']) ? true : false;

// Legyen egy talán egydi felhasználónk, aki Béla :)
$user = date('Hi');

$request='<?xml version="1.0" encoding="UTF-8" ?>
<Orders> 
	<Order> 
	    <Action>add</Action>  
		<Date>'.date('Y.m.d H:i:s').'</Date> 
		
		<!-- 
			A rendelés típusa nagyon fontos, mert ez alapján megy az UNAS-bana státusz kezelés,
			és így választjuk külön a normál webáruházas rendeléseket a képrendelésektől,
			amit a státuszuk alapján tud csak külön kezelni a CloudERP, 
			mert ott nincs külön képrendelés típus.
		-->
		<Type><![CDATA[Képrendelés]]></Type>


		<Lang>hu</Lang> 

		<!-- 
			Vásárló

			Itt nincs jelentősége, hogy ez egy már regisztrált, vagy egy új vásárló.
			Ha van ilyen e-mail címmel vásárló, akkor a rendszer hozzárendeli a rendelést.

		-->
		<Customer> 

			<Email>noreg-'.$user.'@localhost.local</Email> 
			<Contact> 
				<Name><![CDATA['.$user.'. Béla]]></Name> 
				<Phone><![CDATA[+3699111111]]></Phone> 
			</Contact>

			<Addresses> 

				<!--
					Legalább számlázási adatnak kell lenni 
				-->
				<Invoice> 
					<Name><![CDATA['.$user.'. Béla]]></Name> 
					<ZIP>1111</ZIP> 
					<City><![CDATA[Város]]></City> 
					<Street><![CDATA[Véletlen utca '.$user.'.]]></Street> 
					<StreetName><![CDATA[Véletlen]]></StreetName> 
					<StreetType><![CDATA[utca]]></StreetType> 
					<StreetNumber><![CDATA['.$user.']]></StreetNumber> 
					<County><![CDATA[]]></County> 
					<Country>Magyarország</Country> 
					<CountryCode>hu</CountryCode> 
					<CustomerType><![CDATA[private]]></CustomerType> 
				</Invoice>

			</Addresses>
			<Comment><![CDATA[Megjegyzés]]></Comment> 		
		</Customer>

		<Currency>HUF</Currency> 

		<Payment> 

			<!-- 
				Fizetési mód
				Az ID és a Name az UNAS-ból jön,
				a teszt és éles könryezetben nem ugyanaz 
			-->
			<Id>4926455</Id> 
			<Name><![CDATA[Bankkártya (képrendelés)]]></Name> 
			<Type>card</Type> 
			<Status>paid</Status> 
			<Paid>127</Paid> 
			<Pending>0</Pending> 

			<!-- 
				Ha történt tranazkació,
				akkor itt lehet megadni 
			-->
			<Transactions> 

				<Transaction>
					<Id>manual</Id> 
					<Status>finish</Status>
					<Date>'.date('Y.m.d H:i:s').'</Date> 
					<Amount>127</Amount> 
				</Transaction>

			</Transactions>

		</Payment>

		<!-- 
			Szállítási mód
			Az ID és a Name az UNAS-ból jön,
			a teszt és éles könryezetben nem ugyanaz 
		-->
		<Shipping> 
			<Id>4058478</Id> 
			<Name><![CDATA[Futárral]]></Name> 
		</Shipping>

		<!-- Ennek nincs jelentősége, de megadhatjuk -->
		<Referer><![CDATA[keprendeles.fotoplus.hu]]></Referer> 

		<Comments> 
			<Comment> 
				<Type>customer</Type> 
				<Text><![CDATA[A vásárló megjegyzése]]></Text> 
			</Comment>
			<Comment> 
				<Type>customer_shipping</Type> 
				<Text><![CDATA[A vásárló megjegyzése a szállító számára]]></Text> 
			</Comment>
			<Comment> 
				<Type>admin</Type> 
				<Text><![CDATA[Az adminisztrátor megjegyzése, a vásárló nem látja]]></Text> 
			</Comment>
		</Comments>

		<SumPriceGross>127</SumPriceGross> 

		<!--
			Termékek
			A termék ID, SKU, Name az UNAS-ból jön,
			a teszt és éles könryezetben nem ugyanaz
		-->
		<Items> 
			<Item> 
				<Id>1000</Id> 
				<Sku>UNAS-0001</Sku> 
				<Name><![CDATA[Teszt termék U-0001]]></Name> 
				<Unit>db</Unit> 
				<Quantity>1</Quantity> 
				<PriceNet>100</PriceNet> 
				<PriceGross>127</PriceGross> 
				<Vat>27%</Vat> 
			</Item>
		</Items>
	</Order>	
</Orders>';


if($show_request) {
	echo $request;
} else {
	include('unas-api/auth.php');

	$headers=array();
	$headers[]="Authorization: Bearer ".$token;

	$request = $xml_request;
				
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_URL, "https://api.unas.eu/shop/setOrder");
	curl_setopt($curl, CURLOPT_POSTFIELDS,$request);
	$response = curl_exec($curl);

	header('Content-Type:text/xml; charset=UTF-8');
	echo $response;

}

?>