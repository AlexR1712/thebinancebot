<?php /* Template Name: Telegram */

<html>
<body>

<h1>My First Heading</h1>

<p>My first paragraph.</p>

</body>
</html>
 
$api = "bot542182830:AAEFUyXJeGUEiHGeu_SCs2Ej_IGC8olbgH4";
 
$input = file_get_contents("php://input");
$update = json_decode($input, true);
 
$message = $update['message']['text'];
$chatid = $update['message']['chat']['id'];
 
function sendMessage($chatid, $text)
{
    global $api;
    $url = "https://api.telegram.org/$api/sendMessage?chat_id=".$chatid."&text=".urlencode($text);
    $get = file_get_contents($url);
}
 
if($message == "/start")
{
    sendMessage($chatid, "Iniciado");
}
 
?>