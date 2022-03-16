<?php

header('Content-Type: text/plain; charset=utf-8');

$clientIp = $_SERVER['X-Forwarded-For'] ?? $_SERVER['REMOTE_ADDR']; // $_SERVER['HTTP_CLIENT_IP']

echo "$clientIp\n";

/* Если сервер за Cloudflare:
Host:                         2ip.fun
Cdn-Loop:                     cloudflare
Cf-Ipcountry:                 UA
Cf-Connecting-Ip:             95.215.223.233
Cf-Visitor:                   {"scheme":"http"}
X-Forwarded-Proto:            http
Cf-Ray:                       6ecf66488b52fa8c-AMS
X-Forwarded-For:              95.215.223.233
Connection:                   Keep-Alive
*/
