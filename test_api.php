<?php
// Test API endpoint
require_once __DIR__ . '/vendor/autoload.php';

$_GET['q'] = 'spotify';
$_GET['filter'] = 'all';

$controller = new \App\Controllers\ApiController();
$controller->search();
