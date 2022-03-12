<?php

header('Content-Type: text/plain');

$headers = getallheaders();

// @note Sorting/priority headers
$sorting = array_flip(['User-Agent', 'Accept', 'Accept-Language', 'Accept-Encoding', 'Host']);
$sorting = array_fill_keys(array_keys($sorting), '');
$headers = array_merge($sorting, $headers);
$headers = array_filter($headers);

foreach ($headers as $h => $v) {
    echo str_pad("$h:", 30) . "$v\n";
}
