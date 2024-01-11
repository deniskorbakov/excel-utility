<?php
//$status = '20';
//$limit = '2000';
//
//$apiKey = 'bbpodolsk674927484ji9UHKVVfjb5dgsrVJVdm8Hkfbg7mG';
//
//$url = "https://api.sonline.su/v1/orders?status=$status&limit=$limit&sort=desc&order_by=id&order_id=91450";
//
//// proxy - https://spys.one/
//$proxy = '38.152.69.149:8000';
//$loginPassword = 'Sk5qgc:UVe4b4';
//
//$initRequest = curl_init();
//
//curl_setopt($initRequest, CURLOPT_URL, $url);
//curl_setopt($initRequest, CURLOPT_HTTPHEADER, [
//    'Content-Type: application/json',
//    "X-API-Key: $apiKey",
//]);
//curl_setopt($initRequest, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($initRequest, CURLOPT_PROXY, $proxy);
//curl_setopt($initRequest, CURLOPT_PROXYUSERPWD, $loginPassword);
//
//$response = json_decode(curl_exec($initRequest), true);
//
//echo '<pre>';
//var_dump($response);
//echo '</pre>';
//
//curl_close($initRequest);
//
//$arrayResult = [];
//
//$patternDate = '/(\d{4}-\d{2}-\d{2})/';
//
//foreach ($response as $record) {
//    preg_match($patternDate, $record['date'], $matches);
//    $currentDate = $matches[0];
//    $masterName = $record['master']['name'];
//    $price = $record["money"]["to_pay"];
//
//    if (!isset($arrayResult[$currentDate])) {
//        $arrayResult[$currentDate] = [];
//    }
//    if (!isset($arrayResult[$currentDate][$masterName])) {
//        $arrayResult[$currentDate][$masterName] = 0;
//    }
//    $arrayResult[$currentDate][$masterName] += $price;
//}
//
////echo '<pre>';
////var_dump($response);
////echo '</pre>';
////die();
//
//$filename = 'masters.csv';
//
//$fp = fopen($filename, 'w');
//$header = ['Дата'];
//$masterNames = array_keys(reset($arrayResult));
//
//foreach ($masterNames as $name) {
//    $header[] = $name;
//}
//
//$header[] = 'Общая сумма';
//fputcsv($fp, $header);
//
//foreach ($arrayResult as $date => $values) {
//    $row = [$date];
//    $total = 0;
//
//    foreach ($masterNames as $name) {
//        if (array_key_exists($name, $values)) {
//            $row[] = $values[$name];
//            $total += $values[$name];
//        } else {
//            $row[] = 0;
//        }
//    }
//
//    $row[] = $total;
//    fputcsv($fp, $row);
//}
//
//fclose($fp);
//
//

// include your composer dependencies
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$jsonKey = [
    'type' => 'service_account',
    'client_id' => '285459846864-oroge45m8ddhe6hvs9g89n7j6vc1pi3n.apps.googleusercontent.com',
    'client_email' => 'korbakovd@gmail.com',
    'private_key' => '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',
];

$client = new Google\Client();
$client->setAuthConfig($jsonKey);
$client->addScope(Google\Service\Drive::DRIVE);

// Your redirect URI can be any registered URI, but in this example
// we redirect back to this same page
$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$client->setRedirectUri($redirect_uri);

$token = null;

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
}

var_dump($token);
//$client->useApplicationDefaultCredentials();
//$client->addScope(Google\Service\Drive::DRIVE);
//$service = new Google_Service_Sheets($client);
//$result = $service->spreadsheets_values->get('10fbzqhGqwwXWd8Z485DPVNqFy_SPwXnYus-O81YAoQQ', 10);
//try{
//    $numRows = $result->getValues() != null ? count($result->getValues()) : 0;
//    printf("%d rows retrieved.", $numRows);
//    return $result;
//}
//catch(Exception $e) {
//    // TODO(developer) - handle error appropriately
//    echo 'Message: ' .$e->getMessage();
//}
