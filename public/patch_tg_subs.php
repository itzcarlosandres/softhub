<?php
/**
 * PARCHE DE BASE DE DATOS: SUSCRIPCIONES INDIVIDUALES
 */
define('BASE_PATH', dirname(__DIR__));

// Función para leer el .env manualmente
function get_env_value($key) {
    if (file_exists(BASE_PATH . '/.env')) {
        $lines = file(BASE_PATH . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            list($name, $value) = explode('=', $line, 2);
            if (trim($name) === $key) {
                return trim($value, " \t\n\r\0\x0B\"'");
            }
        }
    }
    return null;
}

$db_host = get_env_value('DB_HOST') ?: 'localhost';
$db_name = get_env_value('DB_NAME');
$db_user = get_env_value('DB_USER');
$db_pass = get_env_value('DB_PASS');

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<h1>🚀 Creando Sistema de Suscripciones Individuales</h1>";

    // 1. Crear tabla de suscripciones
    $sql = "CREATE TABLE IF NOT EXISTS software_subscriptions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        software_id INT NOT NULL,
        chat_id VARCHAR(50) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_sub (software_id, chat_id)
    )";
    $pdo->exec($sql);
    echo "<p style='color:green;'>✅ Tabla 'software_subscriptions' creada (o ya existía).</p>";

    echo "<p><b>Siguiente paso:</b> Configurar el Webhook para que el bot pueda recibir datos de los usuarios.</p>";

} catch (Exception $e) {
    echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
}
