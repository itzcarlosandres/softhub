<?php
require_once __DIR__ . '/app/Database.php';
$db = \App\Database::getInstance()->getConnection();
try {
    $stmt = $db->query("DESCRIBE blog_posts");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Columns in 'blog_posts' table:\n";
    print_r($columns);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
