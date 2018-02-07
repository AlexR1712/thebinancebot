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
			$type = $alarmas[$i]['type'];
			$seted_price = $alarmas[$i]['seted_price'];
			$price = json_decode(file_get_contents("https://api.binance.com/api/v1/ticker/price?symbol=$coin"), true)['price'];
			$seted_price = floatval($seted_price);
			$price = floatval($price);
			if ($price >= $seted_price and $type = "high") {
				sendMessage($chatid, $coin." just reached the price of ".$seted_price);
				array_splice($alarmas, $i, 1);
				$handle = fopen('alarmas.json', 'w');
				file_put_contents('alarmas.json',  json_encode($alarmas));
				fclose($handle);
			}
			elseif ($price <= $seted_price and $type = "low") {
				sendMessage($chatid, $coin." just reached the price of ".$seted_price);
				array_splice($alarmas, $i, 1);
				$handle = fopen('alarmas.json', 'w');
				file_put_contents('alarmas.json',  json_encode($alarmas));
				fclose($handle);
			}
		}
	}
	sleep(20);
}

?>