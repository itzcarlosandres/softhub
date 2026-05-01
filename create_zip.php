<?php
$zipFile = __DIR__ . '/sitemap_fix.zip';

$zip = new ZipArchive();
if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    $zip->addFile(__DIR__ . '/app/helpers_badges.php', 'app/helpers_badges.php');
    $zip->addFile(__DIR__ . '/app/helpers_breadcrumbs.php', 'app/helpers_breadcrumbs.php');
    $zip->close();
    echo "Archivo ZIP creado con éxito: sitemap_fix.zip\n";
} else {
    echo "Error al crear el archivo ZIP.\n";
}
