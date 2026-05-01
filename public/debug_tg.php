<?php
// Diagnóstico directo sin dependencias
$db_host = 'localhost';
$db_name = 'foro_forohost';
$db_user = 'root';
$db_pass = 'root';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    echo "<h1>Estado de Configuración Telegram</h1>";
    
    $keys = ['telegram_enabled', 'telegram_bot_username', 'telegram_bot_token'];
    
    foreach ($keys as $key) {
        $stmt = $pdo->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $val = $stmt->fetchColumn();
        $status = ($val === false) ? '<span style="color:red">NO EXISTE</span>' : '<span style="color:green">['.$val.']</span>';
        echo "<b>$key:</b> $status<br>";
    }
    
    echo "<h2>Estructura de la tabla Software</h2>";
    $stmt = $pdo->query("SHOW COLUMNS FROM software LIKE 'telegram_subs'");
    $col = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($col) {
        echo "<span style='color:green'>✅ Columna telegram_subs existe.</span>";
    } else {
        echo "<span style='color:red'>❌ Columna telegram_subs NO EXISTE.</span>";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
