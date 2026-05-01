<?php
if (ob_get_level()) {
    ob_end_clean();
}

header('Content-Type: application/xml; charset=utf-8');

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

require_once BASE_PATH . '/app/EnvLoader.php';
require_once BASE_PATH . '/app/Database.php';
require_once BASE_PATH . '/app/helpers.php';

EnvLoader::load(BASE_PATH);

try {
    $db = \App\Database::getInstance()->getConnection();
} catch(Exception $e) {
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    echo '  <url><loc>' . htmlspecialchars(url('/')) . '</loc><priority>1.0</priority></url>' . "\n";
    echo '</urlset>';
    exit;
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Página Principal -->
    <url>
        <loc><?= htmlspecialchars(url('/')) ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
        <lastmod><?= date('Y-m-d') ?></lastmod>
    </url>
    
    <!-- Páginas Estáticas -->
    <url>
        <loc><?= htmlspecialchars(url('/categories')) ?></loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
        <lastmod><?= date('Y-m-d') ?></lastmod>
    </url>
    
    <url>
        <loc><?= htmlspecialchars(url('/software')) ?></loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
        <lastmod><?= date('Y-m-d') ?></lastmod>
    </url>
    
    <!-- Categorías -->
    <?php
    try {
        $categories = $db->query("SELECT slug, updated_at FROM categories ORDER BY name")->fetchAll();
        foreach ($categories as $cat):
            $catUrl = url('/category/' . $cat['slug']);
            $lastmod = !empty($cat['updated_at']) ? date('Y-m-d', strtotime($cat['updated_at'])) : date('Y-m-d');
    ?>
    <url>
        <loc><?= htmlspecialchars($catUrl) ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
        <lastmod><?= $lastmod ?></lastmod>
    </url>
    <?php 
        endforeach;
    } catch (Exception $e) {
        // Continuar
    }
    ?>
    
    <!-- Blog Articles -->
    <?php
    try {
        $blogPosts = $db->query("SELECT slug, created_at FROM blog_posts ORDER BY created_at DESC LIMIT 500")->fetchAll();
        foreach ($blogPosts as $post):
            $postUrl = url('/blog/' . $post['slug']);
            $lastmod = date('Y-m-d', strtotime($post['created_at']));
    ?>
    <url>
        <loc><?= htmlspecialchars($postUrl) ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
        <lastmod><?= $lastmod ?></lastmod>
    </url>
    <?php 
        endforeach;
    } catch (Exception $e) {}
    ?>

    <!-- Blog Categories -->
    <?php
    try {
        $blogCats = $db->query("SELECT slug FROM blog_categories")->fetchAll();
        foreach ($blogCats as $bcat):
            $bcatUrl = url('/blog/category/' . $bcat['slug']);
    ?>
    <url>
        <loc><?= htmlspecialchars($bcatUrl) ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    <?php 
        endforeach;
    } catch (Exception $e) {}
    ?>

    <!-- Static Pages -->
    <?php
    $statics = ['/about' => '0.5', '/terms' => '0.3', '/privacy' => '0.3', '/dmca' => '0.3', '/contact' => '0.5'];
    foreach ($statics as $uri => $prio):
    ?>
    <url>
        <loc><?= htmlspecialchars(url($uri)) ?></loc>
        <changefreq>monthly</changefreq>
        <priority><?= $prio ?></priority>
    </url>
    <?php endforeach; ?>
</urlset>
<?php exit; ?>
