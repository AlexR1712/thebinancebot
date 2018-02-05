<?php
 
$api = "bot411509742:AAF0EfG_R-0mp3nL_KRTanuwDF79MiY2FRs";
 
$input = file_get_contents("php://input");
$update = json_decode($input, true);
$message = $update['message']['text'];
$chatid = $update['message']['chat']['id'];
$name = $update['message']['from']['first_name'];
function sendMessage($chatid, $text)
{
    global $api;
    $url = "https://api.telegram.org/$api/sendMessage?chat_id=".$chatid."&text=".urlencode($text);
    $get = file_get_contents($url);
}

if (true) {
	//sendMessage(149273661, $name." ".$message);
	$user = array (
	    'name' => $name,
	    'chatid' => $chatid);
	if (file_exists('users.json')) {
		$handle = fopen('users.json', 'r');
		$my_arr = json_decode(file_get_contents('users.json'), true);
		fclose($handle);
		$handle = fopen('users.json', 'w');
		$my_arr[] = $user;
		file_put_contents('users.json',  json_encode($my_arr));
		fclose($handle);
		}
	else{
		$users[0] = array (
	    'name' => $name,
	    'chatid' => $chatid);
		$handle = fopen('users.json', 'w');
		file_put_contents('users.json',  json_encode($users));
		fclose($handle);
	}
	
}

 
if(strtolower($message) == "/start")
{
	//sendMessage($chatid, $chatid);
    sendMessage($chatid, "Hello ".$name.", to use the bot just type the token you want to know the price, for example: /BTCUSDT

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
		$coin = strtoupper("/".$message[1]);
		$seted_price = floatval($message[2]);

		if (file_exists('alarmas.json')) {
		$handle = fopen('alarmas.json', 'r');
		$my_arr = json_decode(file_get_contents('alarmas.json'), true);
		fclose($handle);
		$alarm = array (
	    'coin' => $coin, 
	    'seted_price' => $seted_price, 
	    'chatid' => $chatid);
		$handle = fopen('alarmas.json', 'w');
		$my_arr[] = $alarm;
		file_put_contents('alarmas.json',  json_encode($my_arr));
		fclose($handle);
		}
		else{
		$alarm[0] = array (
	    'coin' => $coin, 
	    'seted_price' => $seted_price, 
	    'chatid' => $chatid);
		$handle = fopen('alarmas.json', 'w');
		file_put_contents('alarmas.json',  json_encode($alarm));
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
	sendMessage($chatid, $price);
}

?>
