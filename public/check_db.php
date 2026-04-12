<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Database.php';

try {
    $db = \App\Database::getInstance()->getConnection();
    
    // Check if column exists
    $stmt = $db->query("SHOW COLUMNS FROM software LIKE 'custom_badge'");
    $column = $stmt->fetch();
    
    if (!$column) {
        echo "Updating database... ";
        $db->exec("ALTER TABLE software ADD COLUMN custom_badge VARCHAR(255) DEFAULT NULL AFTER badge_editors_choice");
        echo "Column 'custom_badge' added successfully!\n";
    } else {
        echo "Column 'custom_badge' already exists.\n";
    }
    
    // Check data
    $stmt = $db->query("SELECT id, name, custom_badge FROM software WHERE custom_badge IS NOT NULL AND custom_badge != ''");
    $rowCount = $stmt->rowCount();
    echo "Found $rowCount software with custom badges.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
