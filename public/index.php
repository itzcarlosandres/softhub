<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define base path
define('BASE_PATH', dirname(__DIR__));

// Load environment variables
require_once BASE_PATH . '/app/EnvLoader.php';
EnvLoader::load(BASE_PATH);

// Load helpers
require_once BASE_PATH . '/app/helpers.php';
require_once BASE_PATH . '/app/helpers_badges.php';
require_once BASE_PATH . '/app/helpers_breadcrumbs.php';

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = BASE_PATH . '/app/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

// Load router
$router = require BASE_PATH . '/routes/web.php';

// Dispatch request
$router->dispatch();
