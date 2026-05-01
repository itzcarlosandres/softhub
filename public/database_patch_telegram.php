<?php
/**
 * PARCHE DE EMERGENCIA - CONEXIÓN DIRECTA
 * Este script funciona de forma independiente para evitar errores 500
 */

// Credenciales directas de tu .env
$db_host = 'localhost';
$db_name = 'foro_forohost';
$db_user = 'root';
$db_pass = 'root';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<body style='font-family: sans-serif; padding: 40px; background: #eef2f3;'>";
    echo "<div style='background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); max-width: 600px; margin: auto; border: 1px solid #d1d9e6;'>";
    echo "<h1 style='color: #2c3e50; margin-top: 0;'>⚙️ Actualización de Base de Datos</h1>";
    echo "<div style='height: 4px; background: linear-gradient(to right, #3498db, #2ecc71); border-radius: 2px; margin-bottom: 20px;'></div>";

    // 1. Columna telegram_subs
    try {
        $pdo->exec("ALTER TABLE software ADD COLUMN telegram_subs INT DEFAULT 0 AFTER downloads");
        echo "<div style='padding: 10px; color: #27ae60;'>✔️ Columna <b>telegram_subs</b> creada.</div>";
    } catch (Exception $e) {
        if (strpos($e->getMessage(), 'Duplicate column') !== false) {
            echo "<div style='padding: 10px; color: #7f8c8d;'>ℹ️ La columna telegram_subs ya existía.</div>";
        } else {
            echo "<div style='padding: 10px; color: #c0392b;'>❌ Error en columna: " . $e->getMessage() . "</div>";
        }
    }

    // 2. Ajustes en site_settings
    $settings = [
        ['telegram_enabled', '0', 'bool', 'Habilitar suscripción a Telegram'],
        ['telegram_bot_token', '', 'text', 'Token del Bot de Telegram'],
        ['telegram_bot_username', '', 'text', 'Username del Bot de Telegram (sin @)'],
    ];

    foreach ($settings as $s) {
        $stmt = $pdo->prepare("SELECT 1 FROM site_settings WHERE setting_key = ?");
        $stmt->execute([$s[0]]);
        if (!$stmt->fetch()) {
            $ins = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value, setting_type, description) VALUES (?, ?, ?, ?)");
            $ins->execute($s);
            echo "<div style='padding: 10px; color: #27ae60;'>✔️ Ajuste <b>{$s[0]}</b> configurado.</div>";
        } else {
            echo "<div style='padding: 10px; color: #7f8c8d;'>ℹ️ El ajuste {$s[0]} ya estaba presente.</div>";
        }
    }

    echo "<div style='margin-top: 25px; padding: 15px; background: #ebf5fb; border-left: 5px solid #3498db; color: #2980b9;'>";
    echo "<b>¡TODO LISTO!</b> Los cambios se han aplicado correctamente. Ya puedes usar las funciones de Telegram.";
    echo "</div>";
    echo "</div></body>";

} catch (PDOException $e) {
    echo "<div style='background: #fdf2f2; color: #9b1c1c; padding: 20px; border-radius: 10px; border: 1px solid #f8b4b4;'>";
    echo "<b>ERROR DE CONEXIÓN:</b> " . $e->getMessage() . "<br>Por favor, verifica que MariaDB/MAMP esté encendido.";
    echo "</div>";
}
