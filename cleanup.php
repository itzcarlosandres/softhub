<?php
/**
 * Script de Limpieza Pro - SoftHub
 * Elimina archivos temporales, demos y scripts de depuración que no son necesarios en producción.
 */

$filesToDelete = [
    // Raíz
    'check.php',
    'check_settings.php',
    'fix_db.php',
    'hero_reallive.php',
    'programas.zip',
    'zip_it.php',
    
    // Carpeta Public
    'public/add_all_categories.php',
    'public/blog_demo.php',
    'public/check_db.php',
    'public/clean_content.php',
    'public/debug.php',
    'public/factory_reset.php',
    'public/force_branding.php',
    'public/force_db_update.php',
    'public/hero_reallive.php',
    'public/import_software.php',
    'public/importer_demo.php',
    'public/install.php',
    'public/setup.php',
    'public/setup_admin.php',
    'public/setup_badges.php',
    'public/update_db_badge.php',
    'public/verificar-optimizaciones.php',
    'public/zip_it.php',
    
    // Vistas
    'app/Views/pages/categories/index_backup.php'
];

echo "<h2>Iniciando limpieza de archivos innecesarios...</h2>";
echo "<ul>";

$total = 0;
foreach ($filesToDelete as $file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "<li style='color: green;'>✅ Eliminado: $file</li>";
            $total++;
        } else {
            echo "<li style='color: red;'>❌ Error al eliminar: $file</li>";
        }
    } else {
        echo "<li style='color: gray;'>ℹ️ No existe / Ya eliminado: $file</li>";
    }
}

echo "</ul>";
echo "<h3>Limpieza completada. Se eliminaron $total archivos.</h3>";
echo "<h4>Nota: Se ha conservado 'public/update_db.php' para que puedas aplicar las actualizaciones de base de datos actuales.</h4>";
?>
