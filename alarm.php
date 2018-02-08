<?php

$api = "bot411509742:AAF0EfG_R-0mp3nL_KRTanuwDF79MiY2FRs";
function sendMessage($chatid, $text)
{
    global $api;
    $url = "https://api.telegram.org/$api/sendMessage?chat_id=".$chatid."&text=".urlencode($text);
    $get = file_get_contents($url);
}
$link = mysqli_connect('85.10.205.173:3307', 'thebinancebot', 'xavier123');
mysqli_select_db($link, 'thebinancebot');

while (true) {
	$coin = 'BTCUSDT'
	$chatid = '149273661';
	$type = 'low';
	$seted_price = '7783';
	$price = json_decode(file_get_contents("https://api.binance.com/api/v1/ticker/price?symbol=$coin"), true)['price'];
	$seted_price = floatval($seted_price);
	$price = floatval($price);
	
	$result = mysqli_query($link, "SELECT chatid FROM users");
	while ($row = $result->fetch_assoc()){
	    foreach($row as $value) echo "$value"."\n";
	}


		
	if ($price >= $seted_price and $type == "high") {
		sendMessage($chatid, $coin." just reached the price of ".$seted_price);
		
	}
	elseif ($price <= $seted_price and $type == "low") {
		sendMessage($chatid, $coin." just reached the price of ".$seted_price);
		
	}
	sleep(20);
}

?>