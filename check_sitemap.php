<?php
$url = 'https://ddlwarez.cc/sitemap.xml';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

if ($response === false) {
    echo "cURL Error\n";
    exit;
}

$header_size = $info['header_size'];
$header = substr($response, 0, $header_size);
$body = substr($response, $header_size);

echo "--- HEADERS ---\n$header\n";
echo "--- FIRST 50 BYTES OF BODY (HEX) ---\n";
echo bin2hex(substr($body, 0, 50)) . "\n";
echo "--- FIRST 50 BYTES OF BODY (STRING) ---\n";
echo substr($body, 0, 50) . "\n";
