<?php

namespace App\Controllers;

use App\Models\Software;
use App\Models\Category;

class HomeController extends Controller
{
    private $softwareModel;
    private $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->softwareModel = new Software();
        $this->categoryModel = new Category();
    }

    public function index()
    {
        // Obtener configuraciones
        $settingsModel = new \App\Models\SiteSetting();
        $db = \App\Database::getInstance()->getConnection();

        $featuredCount = (int)$settingsModel->get('home_featured_count', 8);
        $latestCount = (int)$settingsModel->get('home_latest_count', 12);
        $topDownloadsCount = (int)$settingsModel->get('home_top_downloads', 10);
        $latestLayout = $settingsModel->get('home_latest_layout', 'grid');
        $popularThreshold = (int)$settingsModel->get('popular_threshold', 500);

        // Fetch Card Visibility & Grid Settings
        $cardSettings = [];
        try {
            $stmtSet = $db->query("SELECT setting_key, setting_value FROM site_settings WHERE setting_key LIKE 'card_show_%' OR setting_key LIKE 'home_latest_grid_cols%'");
            while($row = $stmtSet->fetch(\PDO::FETCH_ASSOC)) {
                $cardSettings[$row['setting_key']] = $row['setting_value'];
            }
        } catch (\PDOException $e) {
            // Manejo silencioso en caso de tabla extraviada
        }
        
        $showIcon = ($cardSettings['card_show_icon'] ?? '1') == '1';
        $showDesc = ($cardSettings['card_show_description'] ?? '1') == '1';
        $showRating = ($cardSettings['card_show_rating'] ?? '1') == '1';
        $showDownloads = ($cardSettings['card_show_downloads'] ?? '1') == '1';
        $showPrice = ($cardSettings['card_show_price'] ?? '1') == '1';
        $showBadges = ($cardSettings['card_show_badges'] ?? '1') == '1';
        $showButton = ($cardSettings['card_show_button'] ?? '1') == '1';

        // Grid Columns (Default: 3 desktop, 2 tablet, 1 mobile)
        $colsDesktop = $cardSettings['home_latest_grid_cols'] ?? 3;
        $colsTablet = $cardSettings['home_latest_grid_cols_md'] ?? 2;
        $colsMobile = $cardSettings['home_latest_grid_cols_sm'] ?? 1;

        // Get Total Software Count
        $stmtCount = $db->query("SELECT COUNT(*) as total FROM software WHERE status = 'approved'");
        $totalSoftware = $stmtCount->fetch(\PDO::FETCH_ASSOC)['total'];

        // Get Updates in Last 24 Hours
        $stmtUpdates = $db->query("SELECT COUNT(*) as total FROM software WHERE updated_at >= DATE_SUB(NOW(), INTERVAL 1 DAY) AND status = 'approved'");
        $updatesToday = $stmtUpdates->fetch(\PDO::FETCH_ASSOC)['total'];

        // Get Hero Settings
        $heroTitleSetting = $settingsModel->get('home_hero_title');
        $heroSubtitleSetting = $settingsModel->get('home_hero_subtitle');

        // Trending software IDs
        $stmtTrending = $db->query("
            SELECT id FROM software 
            WHERE status = 'approved' AND trending = 1
            ORDER BY downloads DESC 
            LIMIT 10
        ");
        $trendingIds = array_column($stmtTrending->fetchAll(\PDO::FETCH_ASSOC), 'id');
        
        $featured = $this->softwareModel->getFeatured($featuredCount);
        $latest = $this->softwareModel->getLatest($latestCount);
        $recentlyUpdated = $this->softwareModel->getRecentlyUpdated(15);
        $mostDownloaded = $this->softwareModel->getMostDownloaded($topDownloadsCount);
        
        // Limitar categorías a 8 para el sidebar
        $allCategories = $this->categoryModel->withSoftwareCount();
        $categories = array_slice($allCategories, 0, 8);

        return $this->view('pages/home', [
            'title' => seo_site_title(),
            'featured' => $featured,
            'latest' => $latest,
            'recentlyUpdated' => $recentlyUpdated,
            'mostDownloaded' => $mostDownloaded,
            'categories' => $categories,
            'latestLayout' => $latestLayout,
            'colsDesktop' => $colsDesktop,
            'colsTablet' => $colsTablet,
            'colsMobile' => $colsMobile,
            'showIcon' => $showIcon,
            'showDesc' => $showDesc,
            'showRating' => $showRating,
            'showDownloads' => $showDownloads,
            'showPrice' => $showPrice,
            'showBadges' => $showBadges,
            'showButton' => $showButton,
            'totalSoftware' => $totalSoftware,
            'updatesToday' => $updatesToday,
            'popularThreshold' => $popularThreshold,
            'heroTitleSetting' => $heroTitleSetting,
            'heroSubtitleSetting' => $heroSubtitleSetting,
            'heroDynamicActive' => ($settingsModel->get('home_hero_dynamic_active') == '1'),
            'heroDynamicPrefix' => $settingsModel->get('home_hero_dynamic_prefix', 'Descubre'),
            'heroDynamicText' => $settingsModel->get('home_hero_dynamic_text', 'Programas Full, Apps Premium, Juegos PC'),
            'heroDynamicSuffix' => $settingsModel->get('home_hero_dynamic_suffix', ''),
            'heroDotsActive' => ($settingsModel->get('home_hero_dots_active') == '1'),
            'heroSpotlightActive' => ($settingsModel->get('home_hero_spotlight_active') == '1'),
            'trendingIds' => $trendingIds
        ]);
    }

    public function homeDemo()
    {
        // Obtener configuraciones
        $settingsModel = new \App\Models\SiteSetting();
        $db = \App\Database::getInstance()->getConnection();

        $featuredCount = (int)$settingsModel->get('home_featured_count', 8);
        $latestCount = (int)$settingsModel->get('home_latest_count', 12);
        $topDownloadsCount = (int)$settingsModel->get('home_top_downloads', 10);
        $latestLayout = $settingsModel->get('home_latest_layout', 'grid');
        $popularThreshold = (int)$settingsModel->get('popular_threshold', 500);

        // Fetch Card Visibility & Grid Settings
        $cardSettings = [];
        try {
            $stmtSet = $db->query("SELECT setting_key, setting_value FROM site_settings WHERE setting_key LIKE 'card_show_%' OR setting_key LIKE 'home_latest_grid_cols%'");
            while($row = $stmtSet->fetch(\PDO::FETCH_ASSOC)) {
                $cardSettings[$row['setting_key']] = $row['setting_value'];
            }
        } catch (\PDOException $e) { }
        
        $showIcon = ($cardSettings['card_show_icon'] ?? '1') == '1';
        $showDesc = ($cardSettings['card_show_description'] ?? '1') == '1';
        $showRating = ($cardSettings['card_show_rating'] ?? '1') == '1';
        $showDownloads = ($cardSettings['card_show_downloads'] ?? '1') == '1';
        $showPrice = ($cardSettings['card_show_price'] ?? '1') == '1';
        $showBadges = ($cardSettings['card_show_badges'] ?? '1') == '1';
        $showButton = ($cardSettings['card_show_button'] ?? '1') == '1';

        $colsDesktop = $cardSettings['home_latest_grid_cols'] ?? 4;
        $colsTablet = $cardSettings['home_latest_grid_cols_md'] ?? 2;
        $colsMobile = $cardSettings['home_latest_grid_cols_sm'] ?? 1;

        $stmtCount = $db->query("SELECT COUNT(*) as total FROM software WHERE status = 'approved'");
        $totalSoftware = $stmtCount->fetch(\PDO::FETCH_ASSOC)['total'];

        $stmtUpdates = $db->query("SELECT COUNT(*) as total FROM software WHERE updated_at >= DATE_SUB(NOW(), INTERVAL 1 DAY) AND status = 'approved'");
        $updatesToday = $stmtUpdates->fetch(\PDO::FETCH_ASSOC)['total'];

        $heroTitleSetting = $settingsModel->get('home_hero_title');
        $heroSubtitleSetting = $settingsModel->get('home_hero_subtitle');

        $stmtTrending = $db->query("SELECT id FROM software WHERE status = 'approved' AND trending = 1 ORDER BY downloads DESC LIMIT 10");
        $trendingIds = array_column($stmtTrending->fetchAll(\PDO::FETCH_ASSOC), 'id');
        
        $featured = $this->softwareModel->getFeatured($featuredCount);
        $latest = $this->softwareModel->getLatest($latestCount);
        $recentlyUpdated = $this->softwareModel->getRecentlyUpdated(15);
        $mostDownloaded = $this->softwareModel->getMostDownloaded($topDownloadsCount);
        
        $categories = array_slice($this->categoryModel->withSoftwareCount(), 0, 12);

        return $this->view('pages/home_demo', [
            'title' => 'Rediseño Home Demo | SoftHub',
            'featured' => $featured,
            'latest' => $latest,
            'recentlyUpdated' => $recentlyUpdated,
            'mostDownloaded' => $mostDownloaded,
            'categories' => $categories,
            'latestLayout' => $latestLayout,
            'colsDesktop' => $colsDesktop,
            'colsTablet' => $colsTablet,
            'colsMobile' => $colsMobile,
            'showIcon' => $showIcon,
            'showDesc' => $showDesc,
            'showRating' => $showRating,
            'showDownloads' => $showDownloads,
            'showPrice' => $showPrice,
            'showBadges' => $showBadges,
            'showButton' => $showButton,
            'totalSoftware' => $totalSoftware,
            'updatesToday' => $updatesToday,
            'popularThreshold' => $popularThreshold,
            'heroTitleSetting' => $heroTitleSetting,
            'heroSubtitleSetting' => $heroSubtitleSetting,
            'heroDynamicActive' => ($settingsModel->get('home_hero_dynamic_active') == '1'),
            'heroDynamicPrefix' => $settingsModel->get('home_hero_dynamic_prefix', 'Descubre'),
            'heroDynamicText' => $settingsModel->get('home_hero_dynamic_text', 'Programas Full, Apps Premium, Juegos PC'),
            'heroDynamicSuffix' => $settingsModel->get('home_hero_dynamic_suffix', ''),
            'trendingIds' => $trendingIds
        ]);
    }

    public function filterLatestHTML()
    {
        $categoryId = $_GET['category'] ?? 'all';
        $db = \App\Database::getInstance()->getConnection();
        $settingsModel = new \App\Models\SiteSetting();
        $latestCount = (int)$settingsModel->get('home_latest_count', 12);
        $latestLayout = $settingsModel->get('home_latest_layout', 'grid');
        
        // Fetch Card Visibility Settings
        $stmtSet = $db->query("SELECT setting_key, setting_value FROM site_settings WHERE setting_key LIKE 'card_show_%'");
        $cardSettings = [];
        while($row = $stmtSet->fetch(\PDO::FETCH_ASSOC)) {
            $cardSettings[$row['setting_key']] = $row['setting_value'];
        }
        
        $showIcon = ($cardSettings['card_show_icon'] ?? '1') == '1';
        $showDesc = ($cardSettings['card_show_description'] ?? '1') == '1';
        $showRating = ($cardSettings['card_show_rating'] ?? '1') == '1';
        $showDownloads = ($cardSettings['card_show_downloads'] ?? '1') == '1';
        $showPrice = ($cardSettings['card_show_price'] ?? '1') == '1';
        $showBadges = ($cardSettings['card_show_badges'] ?? '1') == '1';
        $showButton = ($cardSettings['card_show_button'] ?? '1') == '1';
        
        // Trending software IDs
        $stmtTrending = $db->query("SELECT id FROM software WHERE status = 'approved' AND trending = 1 ORDER BY downloads DESC LIMIT 10");
        $trendingIds = array_column($stmtTrending->fetchAll(\PDO::FETCH_ASSOC), 'id');
        
        $query = "SELECT * FROM software WHERE status = 'approved'";
        $params = [];
        
        if ($categoryId !== 'all' && is_numeric($categoryId)) {
            $query .= " AND category_id = ?";
            $params[] = $categoryId;
        }
        $query .= " ORDER BY created_at DESC LIMIT ?";
        $params[] = $latestCount;
        
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        $latest = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        if (empty($latest)) {
            echo '<div class="col-span-full text-center py-20">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-inbox text-gray-300 text-5xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No hay software disponible para esta categoría</h3>
                </div>';
            exit;
        }
        
        $colors = ['blue', 'purple', 'green', 'orange', 'red', 'indigo', 'pink', 'teal'];
        $colorIndex = 0;
        
        foreach ($latest as $soft) {
            $color = $colors[$colorIndex % count($colors)];
            $colorIndex++;
            $isTrending = in_array($soft['id'], $trendingIds);
            
            if ($latestLayout == 'list') {
                include __DIR__ . '/../Views/partials/software_list_item.php';
            } else {
                include __DIR__ . '/../Views/partials/software_card.php';
            }
        }
        exit;
    }

    public function about()
    {
        return $this->view('pages/about', [
            'title' => 'Acerca de Nosotros'
        ]);
    }

    public function demoUpdates()
    {
        return $this->view('pages/demo_updates', [
            'title' => 'Demo: Diseños Recién Actualizados'
        ]);
    }
}
