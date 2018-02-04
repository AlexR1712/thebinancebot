<?php
 
$api = "bot411509742:AAF0EfG_R-0mp3nL_KRTanuwDF79MiY2FRs";
 
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

if (true) {
	$price = json_decode(file_get_contents("https://api.binance.com/api/v1/ticker/price?symbol=BTCUSDT"), true)['price'];
	$sendMessage("149273661", $price);
}

 
if(strtolower($message) == "/start")
{
	//sendMessage($chatid, $chatid);
    sendMessage($chatid, "Hola ".$name.", para usar el bot simplemente coloca el token  correspondiente al precio de la moneda que quieres conocer, por ejemplo /BTCUSDT

Si quieres conocer todas los tokens disponibles usa el comando /coins");

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
		sendMessage($chatid, "Tu token es: $coin y la alarma esta fijada cuando alcance el valor de $seted_price");
	}
	else{
		sendMessage($chatid, "Error. Siga el ejemplo: /alarm BTCUSDT 12345");	
	}

}
else{
	$coin = strtoupper($message);
	$coin = ltrim($coin, '/');
	$price = json_decode(file_get_contents("https://api.binance.com/api/v1/ticker/price?symbol=$coin"), true)['price'];
	sendMessage($chatid, $price);
}

?>
