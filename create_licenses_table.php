<?php
$db = new PDO("mysql:host=localhost;dbname=foro_forohost;charset=utf8", "root", "root");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "CREATE TABLE IF NOT EXISTS licenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

try {
    $db->exec($sql);
    echo "Tabla 'licenses' creada con éxito.\n";
    
    // Insert default licenses if empty
    $count = $db->query("SELECT COUNT(*) FROM licenses")->fetchColumn();
    if ($count == 0) {
        $db->exec("INSERT INTO licenses (name, slug) VALUES ('Gratis', 'free'), ('Pago', 'paid'), ('Freemium', 'freemium'), ('Open Source', 'open-source')");
        echo "Licencias por defecto insertadas.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
