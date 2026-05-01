<?php
/**
 * DETECTOR DE MODELOS GEMINI - LECTOR AUTOMÁTICO DE .ENV
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('BASE_PATH', dirname(__DIR__));

// Función para leer el .env manualmente sin clases externas
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
    $stmt = $pdo->prepare("SELECT setting_value FROM site_settings WHERE setting_key = 'gemini_api_key'");
    $stmt->execute();
    $apiKey = $stmt->fetchColumn();

    echo "<body style='font-family:sans-serif; background:#f4f7f6; padding:40px;'>";
    echo "<div style='max-width:800px; margin:auto; background:white; padding:30px; border-radius:15px; box-shadow:0 10px 40px rgba(0,0,0,0.1);'>";
    echo "<h2 style='color:#0088cc;'>🔍 Modelos Gemini Permitidos</h2>";

    if (!$apiKey) {
        die("<p style='color:red;'>❌ Error: API Key no encontrada en site_settings.</p>");
    }

    $url = "https://generativelanguage.googleapis.com/v1beta/models?key=" . $apiKey;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($response, true);

    if ($httpCode !== 200) {
        echo "<p style='color:red;'>❌ Error de API ($httpCode): " . ($data['error']['message'] ?? 'Desconocido') . "</p>";
    } else {
        echo "<p>✅ ¡Conectado! Google te permite usar estos modelos:</p><ul>";
        foreach ($data['models'] as $model) {
            $mName = $model['name'];
            $displayName = str_replace('models/', '', $mName);
            echo "<li style='margin-bottom:10px;'><strong>$mName</strong></li>";
        }
        echo "</ul>";
        echo "<p style='margin-top:20px; font-size:13px; color:#666;'>Copia el que prefieras (ejemplo: <b>models/gemini-1.5-flash</b>) y dímelo.</p>";
    }

} catch (Exception $e) {
    echo "<div style='color:red; padding:20px; border:1px solid red; border-radius:10px;'>";
    echo "<b>❌ Error de Conexión:</b><br>" . $e->getMessage();
    echo "<br><br>Asegúrate de que el archivo .env existe en la raíz y tiene los datos correctos.";
    echo "</div>";
}
echo "</div></body>";
