<?php
/**
 * Generador de Iconos para PWA
 * Este script genera todos los tamaños de iconos necesarios para la PWA
 */

// Configuración
$sourceImage = __DIR__ . '/../public/assets/icons/icon-source.png'; // Imagen fuente (debe ser 512x512 o mayor)
$outputDir = __DIR__ . '/../public/assets/icons/';

// Tamaños de iconos necesarios
$sizes = [72, 96, 128, 144, 152, 192, 384, 512];

// Crear directorio si no existe
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0755, true);
}

echo "<html><head><meta charset='UTF-8'><title>Generador de Iconos PWA</title>";
echo "<style>body{font-family:Arial,sans-serif;max-width:800px;margin:50px auto;padding:20px;background:#f5f5f5;}";
echo ".success{background:#d4edda;border:1px solid #c3e6cb;color:#155724;padding:15px;border-radius:5px;margin:10px 0;}";
echo ".error{background:#f8d7da;border:1px solid #f5c6cb;color:#721c24;padding:15px;border-radius:5px;margin:10px 0;}";
echo ".info{background:#d1ecf1;border:1px solid #bee5eb;color:#0c5460;padding:10px;border-radius:5px;margin:5px 0;}";
echo "h1{color:#333;}table{width:100%;border-collapse:collapse;background:white;margin-top:20px;}";
echo "th,td{padding:12px;text-align:left;border-bottom:1px solid #ddd;}th{background:#0369a1;color:white;}</style></head><body>";

echo "<h1>🎨 Generador de Iconos para PWA</h1>";

// Verificar si existe GD
if (!extension_loaded('gd')) {
    echo "<div class='error'>";
    echo "<h2>❌ Error: Extensión GD no disponible</h2>";
    echo "<p>La extensión GD de PHP es necesaria para generar iconos.</p>";
    echo "<p>Por favor, habilita la extensión GD en tu php.ini</p>";
    echo "</div>";
    echo "</body></html>";
    exit;
}

// Verificar si existe la imagen fuente
if (!file_exists($sourceImage)) {
    echo "<div class='info'>";
    echo "<h2>📝 Instrucciones para generar iconos</h2>";
    echo "<ol>";
    echo "<li>Crea una imagen PNG de <strong>512x512 píxeles</strong></li>";
    echo "<li>Guárdala como: <code>public/assets/icons/icon-source.png</code></li>";
    echo "<li>Recarga esta página</li>";
    echo "</ol>";
    echo "<p><strong>Recomendaciones:</strong></p>";
    echo "<ul>";
    echo "<li>Usa un diseño simple y reconocible</li>";
    echo "<li>Evita texto pequeño (no se leerá en tamaños pequeños)</li>";
    echo "<li>Usa colores contrastantes</li>";
    echo "<li>Deja un margen de seguridad de 10% alrededor</li>";
    echo "</ul>";
    echo "</div>";
    
    // Crear icono de ejemplo
    createPlaceholderIcon($outputDir);
    
    echo "</body></html>";
    exit;
}

// Generar iconos
echo "<div class='success'>";
echo "<h2>✅ Generando iconos...</h2>";
echo "</div>";

echo "<table>";
echo "<tr><th>Tamaño</th><th>Archivo</th><th>Estado</th></tr>";

$generated = 0;
foreach ($sizes as $size) {
    $outputFile = $outputDir . "icon-{$size}x{$size}.png";
    
    echo "<tr>";
    echo "<td><strong>{$size}x{$size}px</strong></td>";
    echo "<td>icon-{$size}x{$size}.png</td>";
    
    if (resizeImage($sourceImage, $outputFile, $size, $size)) {
        echo "<td style='color:#155724;'>✅ Generado</td>";
        $generated++;
    } else {
        echo "<td style='color:#721c24;'>❌ Error</td>";
    }
    
    echo "</tr>";
}

echo "</table>";

echo "<div class='success' style='margin-top:20px;'>";
echo "<h2>🎉 ¡Proceso completado!</h2>";
echo "<p>Se generaron <strong>$generated de " . count($sizes) . "</strong> iconos correctamente.</p>";
echo "</div>";

echo "<div class='info' style='margin-top:20px;'>";
echo "<h3>📝 Próximos pasos:</h3>";
echo "<ol>";
echo "<li>Verifica que los iconos se vean correctamente</li>";
echo "<li>La PWA ya está lista para usar estos iconos</li>";
echo "<li>Prueba instalar la app en tu dispositivo móvil</li>";
echo "</ol>";
echo "</div>";

echo "</body></html>";

/**
 * Redimensionar imagen
 */
function resizeImage($source, $destination, $width, $height) {
    try {
        // Obtener información de la imagen
        $imageInfo = getimagesize($source);
        if (!$imageInfo) {
            return false;
        }
        
        // Crear imagen desde el archivo fuente
        $sourceImage = imagecreatefrompng($source);
        if (!$sourceImage) {
            return false;
        }
        
        // Crear imagen de destino
        $destImage = imagecreatetruecolor($width, $height);
        
        // Preservar transparencia
        imagealphablending($destImage, false);
        imagesavealpha($destImage, true);
        $transparent = imagecolorallocatealpha($destImage, 255, 255, 255, 127);
        imagefilledrectangle($destImage, 0, 0, $width, $height, $transparent);
        
        // Redimensionar
        imagecopyresampled(
            $destImage, $sourceImage,
            0, 0, 0, 0,
            $width, $height,
            imagesx($sourceImage), imagesy($sourceImage)
        );
        
        // Guardar
        $result = imagepng($destImage, $destination, 9);
        
        // Liberar memoria
        imagedestroy($sourceImage);
        imagedestroy($destImage);
        
        return $result;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Crear icono de ejemplo
 */
function createPlaceholderIcon($outputDir) {
    $size = 512;
    $image = imagecreatetruecolor($size, $size);
    
    // Colores
    $bg = imagecolorallocate($image, 3, 105, 161); // #0369a1
    $white = imagecolorallocate($image, 255, 255, 255);
    
    // Fondo
    imagefilledrectangle($image, 0, 0, $size, $size, $bg);
    
    // Círculo
    $centerX = $size / 2;
    $centerY = $size / 2;
    $radius = $size / 3;
    imagefilledellipse($image, $centerX, $centerY, $radius * 2, $radius * 2, $white);
    
    // Guardar
    imagepng($image, $outputDir . 'icon-source.png', 9);
    imagedestroy($image);
    
    echo "<div class='info'>";
    echo "<p>✅ Se creó un icono de ejemplo en: <code>public/assets/icons/icon-source.png</code></p>";
    echo "<p>Reemplázalo con tu propio diseño y recarga esta página.</p>";
    echo "</div>";
}
