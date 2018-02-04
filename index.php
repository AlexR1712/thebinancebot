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
    sendMessage($chatid, "Hola ".$name);
}
elseif ($message == "/btc" or $message == "/BTC") {
	$BINANCE_BTCUSDT = file_get_contents("https://api.binance.com/api/v1/ticker/price?symbol=BTCUSDT");
	$BINANCE_BTCUSDT = json_decode($BINANCE_BTCUSDT, true);
	$BTC = round($BINANCE_BTCUSDT['price']);
	sendMessage($chatid, $BINANCE_BTCUSDT);
}
else{
	sendMessage($chatid, "Por ahora solo saludo, estoy ocupado tumbando al gobierno");
}

?>
