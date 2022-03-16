<?php

$config = require_once __DIR__ . '/../config.php';

$key = $_REQUEST['deploy-key'] ?? '';

if (!$key || $key !== $config->APP_DEPLOY_KEY) {
    header('HTTP/1.0 403 Forbidden');
    die("Forbidden");
}

echo "@todo Run deploy..\n";

// @todo
//git checkout -- .
//git pull -X theirs
//$cmd = sprintf('cd ../ && git pull -X theirs');
//exec($cmd);
