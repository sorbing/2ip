<?php

header('Content-Type: text/plain; charset=utf-8');

$headers = getallheaders();

// @note Sorting/priority headers
$sorting = array_flip(['User-Agent', 'Accept', 'Accept-Language', 'Accept-Encoding', 'Host']);
$sorting = array_fill_keys(array_keys($sorting), '');
$headers = array_merge($sorting, $headers);
$headers = array_filter($headers);

$max = max(array_map('strlen', array_keys($headers)));

foreach ($headers as $h => $v) {
    echo str_pad("$h: ", $max+2) . "$v\n";
}
