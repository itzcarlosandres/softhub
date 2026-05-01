<?php

use App\Router;

$router = new Router();

// Public Routes
$router->get('/', 'HomeController@index');
$router->get('/home-demo', 'HomeController@homeDemo');
$router->get('/about', 'PageController@about');
$router->get('/terms', 'PageController@terms');
$router->get('/privacy', 'PageController@privacy');
$router->get('/cookies', 'PageController@cookies');
$router->get('/dmca', 'PageController@dmca');
$router->get('/contact', 'PageController@contact');

// Software Routes
$router->get('/software', 'SoftwareController@index');
$router->get('/software/:slug', 'SoftwareController@show');
$router->get('/latest', 'SoftwareController@latest');
$router->get('/popular', 'SoftwareController@popular');
$router->get('/api/latest-software', 'SoftwareController@apiLatest');
$router->get('/download/:id', 'SoftwareController@download');
$router->get('/go/:hash', 'GoController@index');
$router->get('/search', 'SoftwareController@search');
$router->get('/lang/:lang', 'LanguageController@switch');

// Blog Routes
$router->get('/blog', 'BlogController@index');
$router->get('/blog/search', 'BlogController@search');
$router->get('/blog/category/:slug', 'BlogController@category');
$router->get('/blog/:slug', 'BlogController@show');

// API Routes
$router->get('/sitemap.xml', function() {
    require_once BASE_PATH . '/public/sitemap.xml.php';
});
$router->get('/api/search', 'ApiController@search');

// Category Routes
$router->get('/categories', 'CategoryController@index');
$router->get('/category/:slug', 'CategoryController@show');

// Admin Routes - Authentication
$router->get('/admin/login', 'AdminController@showLogin');
$router->post('/admin/login', 'AdminController@login');
$router->get('/admin/logout', 'AdminController@logout');

// Admin Routes - Dashboard
$router->get('/admin', 'AdminController@dashboard');

// Admin Routes - Software Management
$router->get('/admin/software', 'AdminController@softwareList');
$router->get('/admin/software/create', 'AdminController@softwareCreate');
$router->post('/admin/software/store', 'AdminController@softwareStore');
$router->get('/admin/software/edit/:id', 'AdminController@softwareEdit');
$router->post('/admin/software/update/:id', 'AdminController@softwareUpdate');
$router->get('/admin/software/delete/:id', 'AdminController@softwareDelete');
$router->get('/admin/software/toggle-featured/:id', 'AdminController@toggleFeatured');
$router->get('/admin/software/toggle-trending/:id', 'AdminController@toggleTrending');

// Admin Routes - Category Management
$router->get('/admin/categories', 'AdminController@categoryList');
$router->post('/admin/categories/store', 'AdminController@categoryStore');
$router->post('/admin/categories/update/:id', 'AdminController@categoryUpdate');
$router->get('/admin/categories/delete/:id', 'AdminController@categoryDelete');

// Admin Routes - License Management
$router->get('/admin/licenses', 'AdminController@licenseList');
$router->post('/admin/licenses/store', 'AdminController@licenseStore');
$router->get('/admin/licenses/delete/:id', 'AdminController@licenseDelete');

// Admin Routes - Badges Management
$router->get('/admin/badges', 'AdminController@badgeList');
$router->post('/admin/badges/store', 'AdminController@badgeStore');
$router->get('/admin/badges/delete/:id', 'AdminController@badgeDelete');

// Admin Routes - Reports (Broken Links)
$router->get('/admin/reports', 'AdminController@reportList');
$router->get('/admin/reports/resolve/:id', 'AdminController@reportResolve');
$router->get('/admin/reports/delete/:id', 'AdminController@reportDelete');
$router->post('/api/report-link', 'AdminController@reportLinkPublic');

// Admin Routes - Analytics
$router->get('/admin/analytics', 'AdminController@analyticsIndex');
$router->post('/api/track-view', 'AdminController@trackView');

// Admin Routes - Blog Category Management
$router->get('/admin/blog-categories', 'AdminController@blogCategoryList');
$router->post('/admin/blog-categories/store', 'AdminController@blogCategoryStore');
$router->post('/admin/blog-categories/update/:id', 'AdminController@blogCategoryUpdate');
$router->get('/admin/blog-categories/delete/:id', 'AdminController@blogCategoryDelete');

// Admin Routes - Blog Post Management
$router->get('/admin/blog-posts', 'AdminController@blogPostList');
$router->get('/admin/blog-posts/create', 'AdminController@blogPostCreate');
$router->post('/admin/blog-posts/store', 'AdminController@blogPostStore');
$router->get('/admin/blog-posts/edit/:id', 'AdminController@blogPostEdit');
$router->post('/admin/blog-posts/update/:id', 'AdminController@blogPostUpdate');
$router->get('/admin/blog-posts/delete/:id', 'AdminController@blogPostDelete');
$router->get('/admin/blog-posts/toggle-featured/:id', 'AdminController@blogPostToggleFeatured');

// Admin Routes - Settings
$router->get('/admin/settings', 'AdminController@settings');
$router->post('/admin/settings', 'AdminController@settingsSave');

// Admin Routes - Updates
$router->get('/admin/updates', 'AdminController@showUpdates');
$router->post('/admin/updates/install', 'AdminController@handleUpdate');

// Admin Routes - Profile
$router->get('/admin/profile', 'AdminController@profile');
$router->post('/admin/profile/update-info', 'AdminController@updateInfo');
$router->post('/admin/profile/update-password', 'AdminController@updatePassword');

// API Routes
$router->get('/api/search', 'ApiController@search');
$router->get('/api/filter-category', 'ApiController@filterCategory');
$router->post('/api/rate-software', 'ApiController@rateSoftware');
$router->post('/api/generate-requirements', 'ApiController@generateRequirements');
$router->post('/api/generate-description', 'ApiController@generateDescription');
$router->post('/api/ai/generate-descriptions', 'AiController@generateDescriptions');
$router->post('/api/ai/test-connection', 'AiController@testConnection');
$router->post('/api/ai/generate-blog-post', 'AiController@generateBlogPost');
$router->post('/api/track-tg-sub', 'ApiController@trackTgSub');
$router->post('/api/telegram-webhook', 'ApiController@telegramWebhook');

// Admin Routes - Advanced Importer
$router->get('/admin/import', 'ImportController@index');
$router->get('/admin/import/search', 'ImportController@search');
$router->get('/admin/import/discover', 'ImportController@discover');
$router->get('/admin/import/details', 'ImportController@getDetails');
$router->post('/admin/import/generate-ai', 'ImportController@generateAi');
$router->post('/admin/import/store', 'ImportController@store');

$router->get('/demo/updates', 'HomeController@demoUpdates');

return $router;
