<?php
require_once __DIR__ . '/app/Database.php';
$db = \App\Database::getInstance()->getConnection();
$settings = $db->query("SELECT * FROM site_settings WHERE setting_key IN ('telegram_enabled', 'telegram_bot_token', 'telegram_channel')")->fetchAll(PDO::FETCH_ASSOC);
echo "Settings:\n";
foreach($settings as $s) {
    echo "{$s['setting_key']}: " . ($s['setting_key'] === 'telegram_bot_token' ? '[HIDDEN]' : $s['setting_value']) . "\n";
}
