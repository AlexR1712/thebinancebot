<?php
 
$api = "bot542182830:AAEFUyXJeGUEiHGeu_SCs2Ej_IGC8olbgH4";
 
$input = file_get_contents("php://input");
$update = json_decode($input, true);
 
$message = $update['message']['text'];
$chatid = $update['message']['chat']['id'];
$name = $update['message']['from']['first_name'];
// $BINANCE_BTCUSDT = file_get_contents("https://api.binance.com/api/v1/ticker/price?symbol=BTCUSDT");
// $BINANCE_BTCUSDT = json_decode($BINANCE_BTCUSDT, true);
// $BTC = round($BINANCE_BTCUSDT['price']);
 
function sendMessage($chatid, $text)
{
    global $api;
    $url = "https://api.telegram.org/$api/sendMessage?chat_id=".$chatid."&text=".urlencode($text);
    $get = file_get_contents($url);
}
 
if($message == "/start")
{
    sendMessage($chatid, "Hola ".$name." Para usar el bot simplemente coloca el token que quieras conocer el precio, por ejemplo /BTCUSDT
Si quieres conocer todas los tokens disponibles usa el comando /coins");
}
elseif ($message == "/coins") {
	$Binance = json_decode(file_get_contents("https://api.binance.com//api/v1/exchangeInfo"), true);
	$coins = "";
	for ($i= 0; $i < sizeof($Binance['symbols']) ; $i++) { 
		$coin = $Binance['symbols'][$i]['symbol'];
		$coins = $coins."
/".$coin;
	}
	sendMessage($chatid, $coins);
}
else{
	$coin = $message;
	$coin = ltrim($coin, '/');
	$price = json_decode(file_get_contents("https://api.binance.com/api/v1/ticker/price?symbol=$coin"), true)['price'];
	sendMessage($chatid, $price);
}

?>
