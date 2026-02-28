<?php
header('Content-Type: application/xml; charset=utf-8');

require_once __DIR__ . '/../app/EnvLoader.php';
require_once __DIR__ . '/../app/Database.php';

EnvLoader::load(dirname(__DIR__));

// Obtener el dominio base dinámicamente
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$baseUrl = $protocol . '://' . $host;

// Si estamos en localhost con subdirectorio, ajustar
if (strpos($host, 'localhost') !== false && strpos($_SERVER['REQUEST_URI'] ?? '', '/laravel/') !== false) {
    $baseUrl .= '/laravel/public';
}

// Conectar a BD
try {
    $db = \App\Database::getInstance()->getConnection();
} catch(Exception $e) {
    // Si falla la BD, mostrar sitemap básico
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    echo '<url><loc>' . htmlspecialchars($baseUrl) . '</loc><priority>1.0</priority></url>';
    echo '</urlset>';
    exit;
}

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

// Home
echo '<url><loc>' . htmlspecialchars($baseUrl) . '</loc><changefreq>daily</changefreq><priority>1.0</priority><lastmod>' . date('Y-m-d') . '</lastmod></url>';

// Páginas estáticas
echo '<url><loc>' . htmlspecialchars($baseUrl . '/categories') . '</loc><changefreq>daily</changefreq><priority>0.9</priority></url>';
echo '<url><loc>' . htmlspecialchars($baseUrl . '/software') . '</loc><changefreq>daily</changefreq><priority>0.9</priority></url>';

// Categorías
try {
    $cats = $db->query("SELECT slug, updated_at FROM categories ORDER BY name")->fetchAll();
    foreach ($cats as $cat) {
        $catUrl = $baseUrl . '/category/' . urlencode($cat['slug']);
        $lastmod = date('Y-m-d', strtotime($cat['updated_at']));
        echo '<url><loc>' . htmlspecialchars($catUrl) . '</loc><changefreq>weekly</changefreq><priority>0.8</priority><lastmod>' . $lastmod . '</lastmod></url>';
    }
} catch (Exception $e) {
    // Continuar sin categorías
}

// Software
try {
    $soft = $db->query("SELECT slug, updated_at FROM software WHERE status = 'approved' ORDER BY created_at DESC LIMIT 1000")->fetchAll();
    foreach ($soft as $s) {
        $softUrl = $baseUrl . '/software/' . urlencode($s['slug']);
        $lastmod = date('Y-m-d', strtotime($s['updated_at']));
        echo '<url><loc>' . htmlspecialchars($softUrl) . '</loc><changefreq>weekly</changefreq><priority>0.9</priority><lastmod>' . $lastmod . '</lastmod></url>';
    }
} catch (Exception $e) {
    // Continuar sin software
}

echo '</urlset>';
?>