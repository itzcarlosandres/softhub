<?php
/**
 * Script para optimizar todas las imágenes del proyecto
 * Ejecutar manualmente: php optimize_images.php
 */

require_once __DIR__ . '/../app/EnvLoader.php';
require_once __DIR__ . '/../app/Helpers/ImageOptimizer.php';

EnvLoader::load(dirname(__DIR__));

use App\Helpers\ImageOptimizer;

echo "🖼️  OPTIMIZADOR DE IMÁGENES\n";
echo "==========================\n\n";

$uploadsDir = __DIR__ . '/../public/uploads';
$totalProcessed = 0;
$totalSaved = 0;

if (!is_dir($uploadsDir)) {
    echo "❌ Directorio uploads no encontrado\n";
    exit(1);
}

// Buscar todas las imágenes
$extensions = ['jpg', 'jpeg', 'png', 'gif'];
$images = [];

foreach ($extensions as $ext) {
    $found = glob($uploadsDir . '/*.' . $ext);
    if ($found) {
        $images = array_merge($images, $found);
    }
    
    // También buscar en mayúsculas
    $found = glob($uploadsDir . '/*.' . strtoupper($ext));
    if ($found) {
        $images = array_merge($images, $found);
    }
}

echo "📊 Encontradas " . count($images) . " imágenes\n\n";

foreach ($images as $imagePath) {
    $filename = basename($imagePath);
    $originalSize = ImageOptimizer::getImageSize($imagePath);
    
    echo "📸 Procesando: $filename\n";
    echo "   Tamaño original: " . ImageOptimizer::formatFileSize($originalSize) . "\n";
    
    // Optimizar a WebP
    $webpPath = ImageOptimizer::optimizeImage($imagePath, 1200, 85);
    
    if ($webpPath && file_exists($webpPath)) {
        $newSize = ImageOptimizer::getImageSize($webpPath);
        $saved = $originalSize - $newSize;
        $percentage = round(($saved / $originalSize) * 100, 1);
        
        echo "   ✅ WebP creado: " . ImageOptimizer::formatFileSize($newSize) . "\n";
        echo "   💾 Ahorrado: " . ImageOptimizer::formatFileSize($saved) . " ($percentage%)\n";
        
        $totalSaved += $saved;
        $totalProcessed++;
        
        // Crear thumbnail si es un icono de software
        if (strpos($filename, 'icon') !== false || strpos($filename, 'logo') !== false) {
            $thumbPath = ImageOptimizer::createThumbnail($imagePath, 128, 128);
            if ($thumbPath) {
                echo "   🖼️  Thumbnail creado\n";
            }
        }
    } else {
        echo "   ❌ Error al optimizar\n";
    }
    
    echo "\n";
}

echo "==========================\n";
echo "✅ Proceso completado\n";
echo "📊 Imágenes procesadas: $totalProcessed\n";
echo "💾 Espacio ahorrado: " . ImageOptimizer::formatFileSize($totalSaved) . "\n";
echo "==========================\n";
?>
