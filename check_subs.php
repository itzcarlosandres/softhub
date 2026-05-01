<?php
require_once __DIR__ . '/app/Database.php';
$db = \App\Database::getInstance()->getConnection();
$subs = $db->query("SELECT * FROM software_subscriptions")->fetchAll(PDO::FETCH_ASSOC);
echo "Subscribers:\n";
print_r($subs);
