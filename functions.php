<?php
$fname = $_POST['FName'];
$fullphone = $_POST['Phone']; // \D [^0-9]
$email = $_POST['Email'];
$ip = $_SERVER['REMOTE_ADDR'];
$domain = $_SERVER['SERVER_NAME'];
$ipCR = '';
$coun = '';

$ip_data = file_get_contents("http://api.sypexgeo.net/json/" . $ip);
$ip_data = json_decode($ip_data);

foreach ($ip_data as $i => $vl) {
	if ($i === 'country') {
		foreach ($vl as $d => $va) {
			if ($d === 'id') {
				$ipCR = $va;
			}
		}
	}
}
foreach ($ip_data as $ic => $vla) {
	if ($ic === 'country') {
		foreach ($vla as $di => $vda) {
			if ($di === 'name_en') {
				$coun = $vda;
			}
		}
	}
}
$ip_data = json_encode($ip_data);
// $fname = 'test128';
// $fullphone = '+12048170356'; // \D [^0-9]
// $email = 'test32145698lead@gmail.com';
extract(array_map("htmlspecialchars", $_POST), EXTR_OVERWRITE);







$addToken = array(
	'username' => "MetaLive",
	'password' => "HvoGeZ0574aL"
);
$addToken = json_encode($addToken);
$url = 'https://api.alphatech.proftit.com/api/user/v3/tokens';
$header = array();
$header[] = 'Accept: application/json';
$header[] = 'Content-Type: application/json';
$header[] = 'cache-control: no-cache';

$crl = curl_init();
curl_setopt($crl, CURLOPT_URL, $url);
curl_setopt($crl, CURLOPT_HTTPHEADER, $header);
curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($crl, CURLOPT_POST, true);
curl_setopt($crl, CURLOPT_POSTFIELDS, $addToken);
curl_setopt($crl, CURLOPT_INTERFACE, '185.233.116.51');




$rest = curl_exec($crl);
// //---------------------------------------------------------
// $info = curl_getinfo($crl);
// $info = json_encode($info);
// echo "    
// <script>
//     console.log($rest)
//     console.log($info)
// </script>
// ";
// $SR = json_encode($_SERVER);
// $ipSET = file_get_contents('https://api.ipify.org');
// $ipSET = json_encode($ipSET);
// echo "
//         <div style='text-align: center' id='bb'></div>
//         <script>
//             console.log($SR)
//             if ($rest.jwt) {
//                 console.log($rest.jwt)
//                 document.getElementById('bb').style.backgroundColor = 'green';
//                 document.getElementById('bb').innerHTML = 'token received'
//             } else {
//                 console.log($rest.message)
//                 document.getElementById('bb').style.backgroundColor = 'red';
//                 document.getElementById('bb').innerHTML = $rest.message
//             } 
//             // console.log($ipSET)
//         </script>
//     ";
// // ---------------------------------------------------------
$rest = json_decode($rest);
$token = false;
foreach ($rest as $val) {
	if (gettype($val) == 'string') {
		if (strlen($val) > 60) {
			$token = $val;
		}
	}
};
curl_close($crl);


$apiData = array(
	"isLead" => true,
	"firstName" => $fname,
	"lastName" => $coun,
	"email" => $email,
	"phone" => $fullphone,
	"password" => "a1234",
	"brandId" => "1",
	"countryId" => $ipCR,
	"campaignId" => 1005,
	"productName" => "source",
	"marketingInfo" => "additionalFunnelInfo",
);
// var_dump($apiData);
$apiData = json_encode($apiData);
$url = 'https://api.alphatech.proftit.com/api/user/v3/customers';
$header = array();
$header[] = 'Accept: application/json';
$header[] = 'Content-Type: application/json';
$header[] = 'cache-control: no-cache,no-cache';
$header[] = 'authorization:' . $token;

$crl = curl_init();
curl_setopt($crl, CURLOPT_URL, $url);
curl_setopt($crl, CURLOPT_HTTPHEADER, $header);
curl_setopt($crl, CURLOPT_VERBOSE, 0);
curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($crl, CURLOPT_POST, true);
curl_setopt($crl, CURLOPT_POSTFIELDS, $apiData);
curl_setopt($crl, CURLOPT_INTERFACE, '185.233.116.51');


$rest = curl_exec($crl);
// //---------------------------------------------------------
// echo "
//         <div style='text-align: center' id='dd'></div>
//         <script>
//         if ($rest.message) {
//                 console.log($rest.message)
//                 document.getElementById('dd').style.backgroundColor = 'red';
//                 document.getElementById('dd').innerHTML = $rest.message
//             } else {
//                 console.log('NEW Lid')
//                 document.getElementById('dd').style.backgroundColor = 'green';
//                 document.getElementById('dd').innerHTML = 'NEW Lid'
//             }
//             console.log($ip_data)
//         </script>
//     ";
// //---------------------------------------------------------
curl_close($crl);


// Телеграм бот
// Токен
$tg_bot_token = '5987793418:AAH7O8AjmcmD29ig0H-K31jjzXAfwrjo6c4';
// ID чата
$chat_id = '-1001541410143';

$text = '';

// foreach ($_POST as $key => $val) {
// 	$text .= $key . ": " . $val . "\n";
// }

$text .= "\n" . 'Новый лид:';
$text .= "\n" . 'Источник: OIL';
$text .= "\n" . 'Name: ' . $fname;
$text .= "\n" . 'Email: ' . $email;
$text .= "\n" . 'Phone: ' . $fullphone;
$text .= "\n" . 'country: ' . $coun;
$text .= "\n" . 'ip: ' . $_SERVER['REMOTE_ADDR'];
$text .= "\n" . 'Data: ' . date('d.m.y H:i:s');




$param = [
	"chat_id" => $chat_id,
	"text" => $text
];

$url = "https://api.telegram.org/bot" . $tg_bot_token . "/sendMessage?" . http_build_query($param);

// var_dump($text);

file_get_contents($url);


$url = "https://api.telegram.org/bot" . $tg_bot_token . "/sendDocument";


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, ["chat_id" => $chat_id, "document" => $document]);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$out = curl_exec($ch);

curl_close($ch);

// 
// 
// 
$mysql = new mysqli('fdmarket.mysql.tools', 'fdmarket_db', 'tTEeJKC9', 'fdmarket_db');
$mysql->query("INSERT INTO `lids` (`FName`, `LName`, `Email`, `Phone`, `ip`, `Country`, `source`) VALUES('$fname', 'null', '$email', '$fullphone', '$ip', '$coun', 'OIL Premium')");
$mysql->close();










// $apiData = array(
// 	'link_id' => 3234,
// 	'fname' => $fname,
// 	'email' => $email,
// 	'fullphone' => $fullphone,
// 	'source' => "OIL Premium",
// 	'ip' => $ip,
// 	'domain' => $domain,
// 	'utm_source' => isset($utm_source) ? $utm_source : "",
// 	'utm_medium' => isset($utm_medium) ? $utm_medium : "",
// 	'utm_campaign' => isset($utm_campaign) ? $utm_campaign : "",
// 	'utm_term' => isset($utm_term) ? $utm_term : "",
// 	'utm_content' => isset($utm_content) ? $utm_content : "",
// 	'click_id' => isset($click_id) ? $click_id : "",
// 	'promo' => isset($promo) ? $promo : "",
// 	'trading_platform' => isset($tradeserv) ? $tradeserv : "WebTrade",
// );
// // var_dump($apiData);
// $ch = curl_init();
// $url = 'https://marketing.affboat.com/api/v3/integration?api_token=mVec2YGDK6LU9PiU4r8uBjGCP46nLHIjtVXy5h3rP583yeGvfowvx9A3TEVO';
// $header = array();
// $header[] = 'Accept: application/json';
// $header[] = 'Content-Type: application/json';
// $header[] = 'cache-control: no-cache';

// $crl = curl_init();
// curl_setopt($crl, CURLOPT_URL, $url);
// curl_setopt($crl, CURLOPT_HTTPHEADER, $header);
// curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($crl, CURLOPT_POST, true);
// curl_setopt($crl, CURLOPT_POSTFIELDS, $apiData);
// $rest = curl_exec($crl);
// // //---------------------------------------------------------
// // // $rest = json_decode($rest);
// // echo "
// //         <script>
// //                 console.log('вторая crm:',$rest)
// //         </script>
// //     ";
// // //---------------------------------------------------------
// curl_close($crl);