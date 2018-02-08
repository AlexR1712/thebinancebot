#!/usr/bin/env php
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
	
	$result = mysqli_query($link, "SELECT * FROM alarms");
	while($row = mysqli_fetch_array($result)){
		$chatid = $row['chatid'];
		$coin = $row['coin'];
		$seted_price = $row['seted_price'];
		$type = $row['type'];
		$row_num = $row['row_num'];
		$price = json_decode(file_get_contents("https://api.binance.com/api/v1/ticker/price?symbol=$coin"), true)['price'];
		$seted_price = floatval($seted_price);
		$price = floatval($price);
		if ($price >= $seted_price and $type == "low") {
		sendMessage($chatid, $coin." just reached the price of ".$seted_price);
		mysqli_query($link, "DELETE FROM alarms WHERE row_num ='$row_num'");
		}
		elseif ($price <= $seted_price and $type == "high") {
			sendMessage($chatid, $coin." just reached the price of ".$seted_price);
			mysqli_query($link, "DELETE FROM alarms WHERE row_num ='$row_num'");
		}

 	}
?>
