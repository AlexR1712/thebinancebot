#!/usr/bin/env php
<?php

$api = "bot411509742:AAF0EfG_R-0mp3nL_KRTanuwDF79MiY2FRs";
function sendMessage($chatid, $text)
{
    global $api;
    $url = "https://api.telegram.org/$api/sendMessage?chat_id=".$chatid."&text=".urlencode($text);
    $get = file_get_contents($url);
}

while (true) {
	if (file_exists('alarmas.json')) {
		$handle = fopen('alarmas.json', 'r');
		$alarmas = json_decode(file_get_contents('alarmas.json'), true);

		for ($i=0; $i < sizeof($alarmas); $i++) { 
			$coin = substr($alarmas[$i]['coin'], 1, 10);
			$chatid = $alarmas[$i]['chatid'];
			$seted_price = $alarmas[$i]['seted_price'];
			$price = json_decode(file_get_contents("https://api.binance.com/api/v1/ticker/price?symbol=$coin"), true)['price'];
			if ($price >= $seted_price) {
				sendMessage($chatid, $coin." just reached the price of ".$seted_price);
				//unset($alarmas[$i]);
				array_splice($alarmas, $i, 1);
				$handle = fopen('alarmas.json', 'w');
				file_put_contents('alarmas.json',  json_encode($alarmas));
				fclose($handle);
			}
		}
	}
}








// if (file_exists('alarmas.json')) {
// 	$handle = fopen('alarmas.json', 'r');
// 	$alarmas = json_decode(file_get_contents('alarmas.json'), true);
// 	fclose($handle);
// 	$alarm = array (
//     'coin' => 'BTCUSDT', 
//     'price' => '9100', 
//     'chatid' => '12345'
// 	);
// 	$handle = fopen('alarmas.json', 'w');
// 	$alarmas[] = $alarm;
// 	file_put_contents('alarmas.json',  json_encode($alarmas));
// 	fclose($handle);
// }
// else{
// 	echo "No existe el archivo\n";
// 	$coin = 'BTCUSDT';
// 	$price = '9000';
// 	$chatid = '123456';
// 	$alarm[0] = array (
//     'coin' => $coin, 
//     'price' => $price, 
//     'chatid' => $chatid);
// 	$handle = fopen('alarmas.json', 'w');
// 	file_put_contents('alarmas.json',  json_encode($alarm));
// 	fclose($handle);
// }

?>