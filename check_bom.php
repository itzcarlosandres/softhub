<?php
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(__DIR__),
    RecursiveIteratorIterator::LEAVES_ONLY
);

$bom = pack('H*','EFBBBF');

foreach ($files as $name => $file) {
    if (!$file->isFile()) continue;
    if ($file->getExtension() !== 'php') continue;
    
    $path = $file->getRealPath();
    $f = fopen($path, 'r');
    if (!$f) continue;
    $bytes = fread($f, 3);
    fclose($f);
    
    if ($bytes === $bom) {
        echo "BOM Found in: " . $path . "\n";
    }
}
echo "BOM Check complete.\n";
