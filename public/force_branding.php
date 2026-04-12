<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../app/EnvLoader.php';
\App\EnvLoader::load(dirname(__DIR__));
require_once __DIR__ . '/../app/Database.php';

echo "<h1>🚀 Forzador de Branding (Modo Manual)</h1>";

$db = \App\Database::getInstance()->getConnection();
$brandingDir = __DIR__ . '/uploads/branding/';
$brandingFiles = is_dir($brandingDir) ? array_diff(scandir($brandingDir), array('.', '..')) : [];

echo "<h3>Escaneando carpeta: <code>$brandingDir</code></h3>";
echo "<ul>";

if (empty($brandingFiles)) {
    echo "<li>❌ <b>ERROR:</b> No se encontraron archivos en la carpeta. ¡Sube tu logo/favicon por File Manager primero!</li>";
} else {
    foreach ($brandingFiles as $file) {
        $path = 'uploads/branding/' . $file;
        echo "<li>✅ Detectado: <b>$file</b></li>";
        
        // Si el archivo es ICO o termina en favicon, lo marcamos como favicon
        if (strpos(strtolower($file), 'favicon') !== false || pathinfo($file, PATHINFO_EXTENSION) == 'ico') {
            $stmt = $db->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES ('site_favicon', ?) ON DUPLICATE KEY UPDATE setting_value = ?");
            $stmt->execute([$path, $path]);
            echo "   - 🏁 <b style='color:blue'>REGISTRADO COMO FAVICON</b>";
        } 
        // Si es logo o lo demás, lo marcamos como logo (puedes cambiarlo aquí si quieres)
        else {
            $stmt = $db->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES ('site_logo', ?) ON DUPLICATE KEY UPDATE setting_value = ?");
            $stmt->execute([$path, $path]);
            echo "   - 🏁 <b style='color:green'>REGISTRADO COMO LOGO</b>";
        }
        echo "</li><br>";
    }
}

echo "</ul>";
echo "<h2>🎯 ¡Listo! Ahora entra a tu web y refresca (Ctrl + F5).</h2>";
echo "<a href='/admin/settings'>Volver al Admin</a>";
?>
