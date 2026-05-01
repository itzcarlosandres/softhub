<?php
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/sitemap.xml';
$_SERVER['SCRIPT_NAME'] = '/index.php';

register_shutdown_function(function() {
    $output = ob_get_clean();
    $debug = "OUTPUT_LENGTH: " . strlen($output) . "\n";
    $debug .= "FIRST_20_BYTES_HEX: " . bin2hex(substr($output, 0, 20)) . "\n";
    $debug .= "OUTPUT_START: " . substr($output, 0, 100) . "\n";
    file_put_contents(__DIR__ . '/debug_sitemap.txt', $debug);
});

ob_start();
require 'public/index.php';
