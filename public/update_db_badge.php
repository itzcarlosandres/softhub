<?php
require_once __DIR__ . '/../app/Database.php';

try {
    $db = \App\Database::getInstance()->getConnection();
    
    // Check if column exists
    $stmt = $db->query("SHOW COLUMNS FROM software LIKE 'custom_badge'");
    $exists = $stmt->fetch();
    
    if (!$exists) {
        $db->exec("ALTER TABLE software ADD COLUMN custom_badge VARCHAR(255) DEFAULT NULL AFTER badge_editors_choice");
        echo "Column 'custom_badge' added successfully.";
    } else {
        echo "Column 'custom_badge' already exists.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
