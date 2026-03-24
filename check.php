<?php
require __DIR__ . '/app/EnvLoader.php';
require __DIR__ . '/app/Database.php';
EnvLoader::load(__DIR__);
$db = \App\Database::getInstance()->getConnection();
$db->exec("
CREATE TABLE IF NOT EXISTS blog_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE
);
CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    blog_category_id INT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    extract TEXT,
    content LONGTEXT,
    image VARCHAR(255),
    is_featured BOOLEAN DEFAULT FALSE,
    views INT DEFAULT 0,
    author_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (blog_category_id) REFERENCES blog_categories(id) ON DELETE SET NULL
);
");
echo "Blog tables created!\n";
$stmt = $db->query('SHOW TABLES');
print_r($stmt->fetchAll(\PDO::FETCH_ASSOC));
