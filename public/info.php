<?php

$config = require_once __DIR__ . '/../config.php'; // @todo getenv('IPDATA_API_KEY')
$isAcceptJson = (stripos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false || isset($_REQUEST['json']));
$ip = $_REQUEST['ip'] ?? $_SERVER['REMOTE_ADDR'];

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

$props = isset($_REQUEST['o']) ? explode(',', $_REQUEST['o']) : [];
if (!count($props)) {
    header('Content-Type: application/json; charset=utf-8');
    echo $json . "\n";
} else {
    $data = json_decode($json, true);

    function getPropDotNotation(&$arr, $path, $separator = '.') {
        $keys = explode($separator, $path);

        foreach ($keys as $key) {
            $arr = &$arr[$key];
        }

        return $arr;
    }

    $result = [];
    foreach ($props as $prop) {
        $result[$prop] = getPropDotNotation($data, $prop);
    }

    if ($isAcceptJson) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($result) . "\n";
    } else {
        header('Content-Type: text/plain; charset=utf-8');
        echo implode(' | ', $result) . "\n";
    }
}

//$data = json_decode($json);
//$debug = json_encode($data, JSON_PRETTY_PRINT);

// $data->threat->is_anonymous;       // if `is_tor` or `is_proxy` is true
// $data->threat->is_known_attacker;  // of malicious activity (злонамеренной деятельности)
// $data->threat->is_known_abuser;    // of abuse (источник насилия)
// $data->threat->is_threat;          // if `is_known_abuser` or `is_known_attacker` is true
// $data->threat->is_bogon;           // if the IP is a Bogon, an unassigned or unaddressable
