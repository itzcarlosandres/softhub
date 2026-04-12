<?php
require_once __DIR__ . '/../config/database.php';
$config = require __DIR__ . '/../config/database.php';

try {
    $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset=utf8mb4";
    $pdo = new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERR_MODE_EXCEPTION
    ]);

    // 1. Create badges table
    $pdo->exec("CREATE TABLE IF NOT EXISTS badges (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        slug VARCHAR(100) NOT NULL,
        color VARCHAR(50) DEFAULT 'cyan',
        created_at TIMESTAMP DEFAULT CURRENT__TIMESTAMP
    )");
    
    // 2. Add badge_id to software table
    $stmt = $pdo->query("SHOW COLUMNS FROM software LIKE 'badge_id'");
    if (!$stmt->fetch()) {
        $pdo->exec("ALTER TABLE software ADD COLUMN badge_id INT DEFAULT NULL AFTER custom_badge");
        $pdo->exec("ALTER TABLE software ADD FOREIGN KEY (badge_id) REFERENCES badges(id) ON DELETE SET NULL");
    }

    echo "Table 'badges' created and software table updated successfully!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
