<?php
$db_host = 'localhost';
$db_name = 'foro_forohost';
$db_user = 'root';
$db_pass = 'root';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<h1>🛠️ Optimizando Tabla de Ajustes</h1>";

    // Intentar añadir el índice UNIQUE si no existe
    try {
        $pdo->exec("ALTER TABLE site_settings ADD UNIQUE (setting_key)");
        echo "<p style='color:green'>✅ Campo 'setting_key' marcado como único. Ahora el guardado funcionará siempre.</p>";
    } catch (Exception $e) {
        echo "<p style='color:blue'>ℹ️ El campo ya era único o hubo un aviso menor.</p>";
    }

    echo "<p><b>Por favor, vuelve al Panel de Administración, escribe el nombre del bot y pulsa Guardar de nuevo.</b></p>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
