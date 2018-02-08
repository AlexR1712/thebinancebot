<?php
 
$api = "bot411509742:AAF0EfG_R-0mp3nL_KRTanuwDF79MiY2FRs";
 
$input = file_get_contents("php://input");
$update = json_decode($input, true);
$message = $update['message']['text'];
$chatid = $update['message']['chat']['id'];
$first_name = $update['message']['from']['first_name'];
$last_name = $update['message']['from']['last_name'];
$username = $update['message']['from']['username'];
function sendMessage($chatid, $text)
{
    global $api;
    $url = "https://api.telegram.org/$api/sendMessage?chat_id=".$chatid."&text=".urlencode($text);
    $get = file_get_contents($url);
}

if (true) {
	$link = mysqli_connect('85.10.205.173:3307', 'thebinancebot', 'xavier123');
	mysqli_select_db($link, 'thebinancebot');
	$result = mysqli_query($link, "SELECT chatid FROM users WHERE chatid = '$chatid'");
	if (mysqli_num_rows($result) == 0){
		mysqli_query($link, "INSERT INTO users (chatid, first_name, last_name, username) VALUES ('$chatid', '$first_name', '$last_name', '$username')");
	}
	mysqli_close($link);
}

 
if(strtolower($message) == "/start")
{
    sendMessage($chatid, "Hello ".$first_name.", to use the bot just type the token you want to know the price, for example: /BTCUSDT

If you want to know all token listed in Binance.com just type /coins");

}
elseif (strtolower($message) == "/help") {
	sendMessage($chatid, "You are retarded, please don't use this Bot");
}
elseif (strtolower($message) == "/coins") {
	$Binance = json_decode(file_get_contents("https://api.binance.com//api/v1/exchangeInfo"), true);
	$coins = "";
	for ($i= 0; $i < sizeof($Binance['symbols']) ; $i++) { 
		$coin = $Binance['symbols'][$i]['symbol'];
		$coins = $coins."
/".$coin;
	}
	sendMessage($chatid, $coins);
}
elseif (strtolower(substr($message, 0, 6)) == '/alarm') {
	$message = str_word_count($message, 1, "0123456789.");
	if (sizeof($message) == 3 ) {
		$coin = strtoupper($message[1]);
		$seted_price = floatval($message[2]);
		$price = json_decode(file_get_contents("https://api.binance.com/api/v1/ticker/price?symbol=$coin"), true)['price'];
		if ($seted_price > $price) {
			$type = "high";
		}
		else{
			$type = "low";
		}
		if (file_exists('alarms.json')) {
			$handle = fopen('alarms.json', 'r');
			$my_arr = json_decode(file_get_contents('alarms.json'), true);
			fclose($handle);
			$alarm = array (
		    'coin' => "/".$coin, 
		    'seted_price' => $seted_price, 
		    'chatid' => $chatid,
			'type' => $type);
			$handle = fopen('alarms.json', 'w');
			$my_arr[] = $alarm;
			file_put_contents('alarms.json',  json_encode($my_arr));
			fclose($handle);
			}
			else{
			$alarm[0] = array (
		    'coin' => "/".$coin, 
		    'seted_price' => $seted_price, 
		    'chatid' => $chatid,
			'type' => $type);
			$handle = fopen('alarms.json', 'w');
			file_put_contents('alarms.json',  json_encode($alarm));
			fclose($handle);
			}
		sendMessage($chatid, "You will receive a notification when $coin reaches $seted_price");	
	}
	else{
		sendMessage($chatid, "Error. Follow the example: /alarm BTCUSDT 9150");	
	}

}
else{
	$coin = strtoupper($message);
	$coin = ltrim($coin, '/');
	$price = json_decode(file_get_contents("https://api.binance.com/api/v1/ticker/price?symbol=$coin"), true)['price'];
	$message = "/".$coin." ".$price;
	sendMessage($chatid, $message);
}

?>
