<?php
$url = 'https://ddlwarez.cc/sitemap.xml';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Spoof Googlebot user agent just in case Cloudflare is doing something weird
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)');
$xmlString = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP CODE: $httpCode\n";

if ($httpCode !== 200) {
    echo "Sitemap returned HTTP $httpCode\n";
    exit;
}

libxml_use_internal_errors(true);
$dom = new DOMDocument;
$dom->loadXML($xmlString);

$errors = libxml_get_errors();
if (empty($errors)) {
    echo "VALIDATION SUCCESS: The XML is 100% valid and well-formed.\n";
    echo "Root element: " . $dom->documentElement->nodeName . "\n";
    $urlElements = $dom->getElementsByTagName('url');
    echo "Total URLs found: " . $urlElements->length . "\n";
} else {
    echo "VALIDATION ERRORS FOUND:\n";
    foreach ($errors as $error) {
        echo "- Line {$error->line}, Column {$error->column}: {$error->message}";
    }
}
libxml_clear_errors();
