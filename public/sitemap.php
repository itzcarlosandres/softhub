<?php
header('Content-Type: application/xml; charset=utf-8');

require_once __DIR__ . '/../app/EnvLoader.php';
require_once __DIR__ . '/../app/Database.php';
require_once __DIR__ . '/../app/helpers.php';

EnvLoader::load(dirname(__DIR__));

$db = \App\Database::getInstance()->getConnection();

// Obtener el dominio base
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$baseUrl = $protocol . '://' . $host;

// Si estamos en localhost con subdirectorio, ajustar
if (strpos($host, 'localhost') !== false) {
    $baseUrl .= '/laravel/public';
}

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Página Principal -->
    <url>
        <loc><?= htmlspecialchars($baseUrl) ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
        <lastmod><?= date('Y-m-d') ?></lastmod>
    </url>
    
    <!-- Páginas Estáticas -->
    <url>
        <loc><?= htmlspecialchars($baseUrl . '/categories') ?></loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
        <lastmod><?= date('Y-m-d') ?></lastmod>
    </url>
    
    <url>
        <loc><?= htmlspecialchars($baseUrl . '/software') ?></loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
        <lastmod><?= date('Y-m-d') ?></lastmod>
    </url>
    
    <!-- Categorías -->
    <?php
    try {
        $categories = $db->query("SELECT slug, updated_at FROM categories ORDER BY name")->fetchAll();
        foreach ($categories as $cat):
            $catUrl = $baseUrl . '/category/' . urlencode($cat['slug']);
    ?>
    <url>
        <loc><?= htmlspecialchars($catUrl) ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
        <lastmod><?= date('Y-m-d', strtotime($cat['updated_at'])) ?></lastmod>
    </url>
    <?php 
        endforeach;
    } catch (Exception $e) {
        // Si hay error, continuar sin categorías
    }
    ?>
    
    <!-- Software -->
    <?php
    try {
        $software = $db->query("SELECT slug, updated_at FROM software WHERE status = 'approved' ORDER BY created_at DESC LIMIT 1000")->fetchAll();
        foreach ($software as $soft):
            $softUrl = $baseUrl . '/software/' . urlencode($soft['slug']);
    ?>
    <url>
        <loc><?= htmlspecialchars($softUrl) ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
        <lastmod><?= date('Y-m-d', strtotime($soft['updated_at'])) ?></lastmod>
    </url>
    <?php 
        endforeach;
    } catch (Exception $e) {
        // Si hay error, continuar sin software
    }
    ?>
</urlset>
