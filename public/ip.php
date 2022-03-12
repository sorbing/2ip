<?php

header('Content-Type: text/plain; charset=utf-8');

$clientIp = $_SERVER['REMOTE_ADDR']; // $_SERVER['HTTP_CLIENT_IP']

echo "$clientIp\n";
