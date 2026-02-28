<?php

use App\Router;

$router = new Router();

// Public Routes
$router->get('/', 'HomeController@index');
$router->get('/about', 'PageController@about');
$router->get('/terms', 'PageController@terms');
$router->get('/privacy', 'PageController@privacy');
$router->get('/demo-heroes', 'PageController@demoHeroes'); // Ruta de Demo para Heroes
$router->get('/demo-software', 'PageController@demoSoftware'); // Ruta de Demo para Software Catalog
$router->get('/contact', 'HomeController@contact');
$router->get('/demo-footers', 'PageController@demoFooters');
$router->get('/demo-admin', 'PageController@demoAdmin');
$router->get('/demo-titles', 'PageController@demoTitles');

// Software Routes
$router->get('/software', 'SoftwareController@index');
$router->get('/software/:slug', 'SoftwareController@show');
$router->get('/latest', 'SoftwareController@latest');
$router->get('/popular', 'SoftwareController@popular');
$router->get('/api/latest-software', 'SoftwareController@apiLatest');
$router->get('/download/:id', 'SoftwareController@download');
$router->get('/go/:hash', 'GoController@index');
$router->get('/search', 'SoftwareController@search');

// API Routes
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

// Admin Routes - Settings
$router->get('/admin/settings', 'AdminController@settings');
$router->post('/admin/settings', 'AdminController@settingsSave');

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

return $router;
