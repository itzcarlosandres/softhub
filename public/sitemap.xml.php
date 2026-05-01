<?php
// Limpiar cualquier búfer de salida previo para evitar espacios en blanco al inicio
if (ob_get_level()) {
    ob_end_clean();
}

header('Content-Type: application/xml; charset=utf-8');

// Cargar dependencias solo si no están cargadas (útil si se llama directamente o vía router)
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

require_once BASE_PATH . '/app/EnvLoader.php';
require_once BASE_PATH . '/app/Database.php';
require_once BASE_PATH . '/app/helpers.php';

EnvLoader::load(BASE_PATH);

// Conectar a BD
try {
    $db = \App\Database::getInstance()->getConnection();
} catch(Exception $e) {
    // Si falla la BD, mostrar sitemap básico
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    echo '  <url><loc>' . htmlspecialchars(url('/')) . '</loc><priority>1.0</priority></url>' . "\n";
    echo '</urlset>';
    exit;
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// Home
echo '  <url>' . "\n";
echo '    <loc>' . htmlspecialchars(url('/')) . '</loc>' . "\n";
echo '    <changefreq>daily</changefreq>' . "\n";
echo '    <priority>1.0</priority>' . "\n";
echo '    <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
echo '  </url>' . "\n";

// Páginas estáticas principales
$statics = [
    '/about' => '0.5',
    '/terms' => '0.3',
    '/privacy' => '0.3',
    '/dmca' => '0.3',
    '/contact' => '0.5',
    '/categories' => '0.9',
    '/software' => '0.9',
    '/blog' => '0.9'
];

foreach ($statics as $uri => $prio) {
    echo '  <url>' . "\n";
    echo '    <loc>' . htmlspecialchars(url($uri)) . '</loc>' . "\n";
    echo '    <changefreq>weekly</changefreq>' . "\n";
    echo '    <priority>' . $prio . '</priority>' . "\n";
    echo '  </url>' . "\n";
}

// Categorías de Software
try {
    $cats = $db->query("SELECT slug, updated_at FROM categories ORDER BY name")->fetchAll();
    foreach ($cats as $cat) {
        $catUrl = url('/category/' . $cat['slug']);
        $lastmod = !empty($cat['updated_at']) ? date('Y-m-d', strtotime($cat['updated_at'])) : date('Y-m-d');
        echo '  <url>' . "\n";
        echo '    <loc>' . htmlspecialchars($catUrl) . '</loc>' . "\n";
        echo '    <changefreq>weekly</changefreq>' . "\n";
        echo '    <priority>0.8</priority>' . "\n";
        echo '    <lastmod>' . $lastmod . '</lastmod>' . "\n";
        echo '  </url>' . "\n";
    }
} catch (Exception $e) {}

// Software (Programas)
try {
    $soft = $db->query("SELECT slug, updated_at, created_at FROM software WHERE status = 'approved' ORDER BY updated_at DESC LIMIT 5000")->fetchAll();
    foreach ($soft as $s) {
        $softUrl = url('/software/' . $s['slug']);
        $dateSource = !empty($s['updated_at']) ? $s['updated_at'] : (!empty($s['created_at']) ? $s['created_at'] : 'now');
        $lastmod = date('Y-m-d', strtotime($dateSource));
        echo '  <url>' . "\n";
        echo '    <loc>' . htmlspecialchars($softUrl) . '</loc>' . "\n";
        echo '    <changefreq>weekly</changefreq>' . "\n";
        echo '    <priority>0.9</priority>' . "\n";
        echo '    <lastmod>' . $lastmod . '</lastmod>' . "\n";
        echo '  </url>' . "\n";
    }
} catch (Exception $e) {}

// Blog Categories
try {
    $blogCats = $db->query("SELECT slug FROM blog_categories ORDER BY name")->fetchAll();
    foreach ($blogCats as $bc) {
        echo '  <url>' . "\n";
        echo '    <loc>' . htmlspecialchars(url('/blog/category/' . $bc['slug'])) . '</loc>' . "\n";
        echo '    <changefreq>weekly</changefreq>' . "\n";
        echo '    <priority>0.7</priority>' . "\n";
        echo '  </url>' . "\n";
    }
} catch (Exception $e) {}

// Blog Posts (Artículos)
try {
    $posts = $db->query("SELECT slug, created_at FROM blog_posts ORDER BY created_at DESC LIMIT 1000")->fetchAll();
    foreach ($posts as $p) {
        $postUrl = url('/blog/' . $p['slug']);
        $lastmod = date('Y-m-d', strtotime($p['created_at']));
        echo '  <url>' . "\n";
        echo '    <loc>' . htmlspecialchars($postUrl) . '</loc>' . "\n";
        echo '    <changefreq>monthly</changefreq>' . "\n";
        echo '    <priority>0.8</priority>' . "\n";
        echo '    <lastmod>' . $lastmod . '</lastmod>' . "\n";
        echo '  </url>' . "\n";
    }
} catch (Exception $e) {}

echo '</urlset>';
exit;