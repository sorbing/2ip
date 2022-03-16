<?php

$config = require_once __DIR__ . '/../config.php';

$ip = $_REQUEST['ip'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];

if (@$_REQUEST['key'] !== $config->APP_API_KEY) {
    header('HTTP/1.0 403 Forbidden');
    die("Forbidden");
}

if (!filter_var($ip, FILTER_VALIDATE_IP)) {
    header('HTTP/1.0 400 Bad Request');
    die("Error. Invalid IP: $ip");
}

// Free 1500 req/day
$isDebug = false;
$source = !$isDebug ? "https://api.ipdata.co/$ip?api-key={$config->IPDATA_API_KEY}" : './demo/info.json';
$json = file_get_contents($source);
$data = json_decode($json);
//$debug = json_encode($data, JSON_PRETTY_PRINT);

$threats = '';
foreach ($data->threat as $key => $val) {
    if ($val) {
        $threats .= str_replace('is_', '', $key) . ',';
    }
}

////////////////////////////
//// ipqualityscore.com ////
////////////////////////////
// @see https://www.ipqualityscore.com/documentation/proxy-detection/overview
/*
strictness=0   - Uses the lowest strictness (0-3) for Fraud Scoring. Increasing this value will expand the tests we perform. Levels 2+ have a higher risk of false-positives.
fast=0|1       - Speeds up the API response time. Not recommended.
lighter_penalties=true  - Lowers scoring and proxy detection for mixed quality IP addresses to prevent false-positives.
                        - Снижает скоринг и обнаружение прокси для IP-адресов смешанного качества для предотвращения ложных срабатываний.
mobile=0|1     - Forces the IP to be scored as a mobile device. Passing the "user_agent" will automatically detect the device type.
allow_public_access_points=true - Allows corporate and public connections like Institutions, Hotels, Businesses, Universities, etc.
*/
$apiKey = $config->IPQUALITYSCORE_API_KEY;
$url = "https://www.ipqualityscore.com/api/json/ip/$apiKey/$ip?strictness=1&allow_public_access_points=true"; // &fast=0&lighter_penalties=true&mobile=true
$json = file_get_contents($url);
$qData = json_decode($json);
//$debug = json_encode($qData, JSON_PRETTY_PRINT);

/*
"success": true,
"message": "Success",
"fraud_score": 100,

"proxy": true,
"vpn": false,
"tor": false,
"active_vpn": false,
"active_tor": false,
"recent_abuse": true,
"bot_status": false,
"is_crawler": false,

"mobile": false,
"ISP": "Rostelecom",
"host": "host-85-237-43-223.dsl.sura.ru",

"country_code": "RU",
"region": "Penzenskaya Oblast'",
"city": "Penza",
"ASN": 12389,
"organization": "Rostelecom",
"latitude": 53.1958,
"longitude": 45,
"timezone": "Europe\/Moscow",

"connection_type": "Premium required.",
"abuse_velocity": "Premium required.",
"request_id": "4ZDu3uZ9dGK3Xh"
 */

// 126 = Permission denied. Нужно: chmod +x ./blcheck.sh; chmod 777 blcheck.sh
// 1   = spam
//$lastLine = exec("./blcheck.sh -q $ip --bl=cbl.abuseat.org", $output, $retCode);
//$spamOut = ($retCode === 1) ? 'spam' : '';
$spamOut = '?';

header('Content-Type: text/plain; charset=utf-8');

$proxyOut = ($qData->proxy ? 'proxy' : '');
$mobileOut = ($qData->mobile ? '/mobile' : ''); // hosting/mobile

//$line = sprintf('%-15s | %s | %-14s | fraud: %-4s | %-5s | %-5s | %s', $ip, $data->country_code, "{$data->asn->type}$mobileOut", "$qData->fraud_score%", $proxyOut, $spamOut, $threats);
$line = sprintf('%-15s | %s | %-8s | fraud: %-4s | %-5s | %-5s | %s', $ip, $data->country_code, $data->asn->type, "$qData->fraud_score%", $proxyOut, $spamOut, $threats);

echo "$line\n";
