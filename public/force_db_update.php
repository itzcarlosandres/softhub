<?php
// Simple DB update script without dependencies
$config = [
    'host' => 'localhost',
    'dbname' => 'softhub',
    'user' => 'root',
    'pass' => 'root'
];

try {
    // Attempt to connect
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";
    $pdo = new PDO($dsn, $config['user'], $config['pass'], [
        PDO::ATTR_ERR_MODE => PDO::ERR_MODE_EXCEPTION
    ]);

    echo "Connected. Checking custom_badge...\n";
    
    $pdo->exec("ALTER TABLE software ADD COLUMN IF NOT EXISTS custom_badge VARCHAR(255) DEFAULT NULL");
    echo "Check completed.";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
