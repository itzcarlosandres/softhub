<?php
$zip = new ZipArchive();
$filename = "sitemap_fix.zip";

if ($zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
    exit("No se pudo crear <$filename>\n");
}

$files = [
    'app/helpers_badges.php',
    'app/helpers_breadcrumbs.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $zip->addFile($file, $file);
        echo "Añadido: $file\n";
    } else {
        echo "No encontrado: $file\n";
    }
}

$zip->close();
echo "\nÉxito. Archivo creado: $filename\n";
echo "Sube este archivo ZIP en el panel de tu servidor para aplicar la corrección del sitemap.\n";
