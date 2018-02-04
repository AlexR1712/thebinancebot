<?php
 
$api = "bot542182830:AAEFUyXJeGUEiHGeu_SCs2Ej_IGC8olbgH4";
 
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
 
if($message == "/start")
{
    sendMessage($chatid, "Hola ".$name);
}
else{
	sendMessage($chatid, "Por ahora solo saludo, estoy ocupado tumbando al gobierno")
}
 
?>