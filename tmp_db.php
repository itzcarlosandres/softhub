<?php
$db = new PDO('mysql:host=localhost;dbname=foro_forohost', 'root', 'root');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try {
    $db->exec("ALTER TABLE software ADD COLUMN buy_url VARCHAR(255) NULL AFTER file_size");
    echo "Added buy_url\n";
} catch (Exception $e) { echo $e->getMessage() . "\n"; }
try {
    $db->exec("ALTER TABLE software ADD COLUMN price DECIMAL(10,2) DEFAULT '0.00' AFTER file_size");
    echo "Added price\n";
} catch (Exception $e) { echo $e->getMessage() . "\n"; }
echo "Done.\n";
