<?php

header('Content-Type: text/plain; charset=utf-8');

$config = require_once __DIR__ . '/../config.php';

$key = $_REQUEST['deploy-key'] ?? '';

if (!$key || $key !== $config->APP_DEPLOY_KEY) {
    header('HTTP/1.0 403 Forbidden');
    echo "Forbidden\n";
    exit(1);
}

//$body = file_get_contents('php://input');
//logDeployRequest($body);
//$json = json_decode($body);
////$pushBranch = $json->push->changes[0]->new->name;

// @todo Проверить, что процесс деплоя в данный момент не запущен!
// @todo Проверить, что разрешено запускать deploy.sh от юзера www-data:
//       sudo visudo -f /etc/sudoers.d/www-data

echo date('Y-m-d H:i:s') . "\n";
echo "Run deploy..\n";
$command = sprintf('cd ../ && sudo -Hu tuner git pull -X theirs 2>&1');
exec($command, $output, $retCode);
$text = implode("\n", $output);
echo $text . "\n";
echo "Exit code: $retCode";

if ($config->TG_NOTICE_BOT_KEY && $config->TG_NOTICE_CHAT_ID) {
    $msg = ($retCode === 0) ? 'Deploy success 2ip.fun 👍' : 'Deploy fail 2ip.fun ⚠';
    $url = "https://api.telegram.org/bot{$config->TG_NOTICE_BOT_KEY}/sendMessage?chat_id={$config->TG_NOTICE_CHAT_ID}&text=" . urlencode($msg);
    file_get_contents($url);

    if ($retCode !== 0) {
        $url = "https://api.telegram.org/bot{$config->TG_NOTICE_BOT_KEY}/sendMessage?chat_id={$config->TG_NOTICE_CHAT_ID}&text=" . urlencode($text);
        file_get_contents($url);
    }
}
