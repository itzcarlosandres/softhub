<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Carga Directa (A prueba de fallos)
$basePath = dirname(__DIR__);
require_once $basePath . '/app/EnvLoader.php';

// Cargar Entorno y Base de Datos
// Nota: La clase puede estar en el namespace App o no, intentamos ambas
if (class_exists('App\EnvLoader')) {
    \App\EnvLoader::load($basePath);
} else {
    EnvLoader::load($basePath);
}

// Cargar Database
require_once $basePath . '/app/Database.php';

echo "<h1>💣 Limpiador de Contenido (Extremo)</h1>";

if (!isset($_GET['confirm'])) {
    echo "<h3>⚠️ ADVERTENCIA: Se borrarán TODOS los programas, blogs y categorías.</h3>";
    echo "<a href='?confirm=1' style='background:red; color:white; padding:10px 20px; border-radius:5px; text-decoration:none;'>SÍ, BORRAR TODO EL CONTENIDO</a>";
    exit;
}

try {
    $db = \App\Database::getInstance()->getConnection();
    $db->exec("SET FOREIGN_KEY_CHECKS = 0;");

    // 🏆 Vaciar Software y Relacionados
    $db->exec("TRUNCATE TABLE software;");
    $db->exec("TRUNCATE TABLE download_links;");
    $db->exec("TRUNCATE TABLE categories;");
    
    // 📝 Vaciar Blog
    $db->exec("TRUNCATE TABLE blog_posts;");
    $db->exec("TRUNCATE TABLE blog_categories;");
    
    // 🛡️ REPARAR TABLAS DE SISTEMA (Solo borrar si es necesario, pero mejor mantener)
    // No tocamos 'users' ni 'site_settings' para no perder el acceso al panel.

    $db->exec("SET FOREIGN_KEY_CHECKS = 1;");

    echo "<h2 style='color:green'>✅ ¡CONTENIDO LIMPIO!</h2>";
    echo "<p>Se han eliminado todos los programas, blogs y categorías del sistema.</p>";
    echo "<a href='/admin/dashboard'>Volver al Panel Administrativo</a>";

} catch (PDOException $e) {
    echo "<h2 style='color:red'>❌ ERROR: No se pudo completar la limpieza.</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>
