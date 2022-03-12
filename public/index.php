<?php

//$path = $_SERVER['PATH_INFO']; // @note Не работает в Nginx конфиге для Laravel. Пустое значение PATH_INFO
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === '/help') {
    require_once './help.php';
} elseif ($path === '/ip') {
    require_once './ip.php';
} elseif ($path === '/headers' || $path === '/heads' || $path === '/h') {
    require_once './headers.php';
} elseif ($path === '/info' || $path === '/i' || $path === '/geo' || $path === '/g') {
    require_once './info.php';
} elseif ($path === '/quality' || $path === '/q') {
    require_once './quality.php';
} else {
    require_once './ip.php';
}
