<?php
/**
 * Script para importar múltiples programas populares
 * Ejecutar: php public/import_software.php
 */

require_once __DIR__ . '/../app/EnvLoader.php';
require_once __DIR__ . '/../app/Database.php';

EnvLoader::load(dirname(__DIR__));

echo "📦 IMPORTADOR DE SOFTWARE\n";
echo "========================\n\n";

// Lista de software popular para importar
$softwareList = [
    [
        'name' => 'Google Chrome',
        'slug' => 'google-chrome',
        'short_description' => 'Navegador web rápido, seguro y personalizable de Google',
        'description' => '<p>Google Chrome es un navegador web desarrollado por Google. Es conocido por su velocidad, seguridad y sincronización entre dispositivos.</p><p>Características principales:</p><ul><li>Navegación rápida y segura</li><li>Sincronización en todos tus dispositivos</li><li>Extensiones y temas personalizables</li><li>Modo incógnito para privacidad</li><li>Actualizaciones automáticas</li></ul>',
        'version' => '120.0.6099.130',
        'developer' => 'Google LLC',
        'category' => 'Navegadores',
        'license' => 'free',
        'operating_system' => 'Windows, Mac, Linux, Android, iOS',
        'file_size' => '95 MB',
        'download_url' => 'https://www.google.com/chrome/',
        'requirements' => 'Windows 10 o superior, 4 GB RAM, 350 MB espacio en disco',
        'rating' => 4.5,
        'downloads' => 15000
    ],
    [
        'name' => 'Mozilla Firefox',
        'slug' => 'mozilla-firefox',
        'short_description' => 'Navegador web rápido, privado y de código abierto',
        'description' => '<p>Mozilla Firefox es un navegador web libre y de código abierto desarrollado por Mozilla Foundation.</p><p>Características:</p><ul><li>Privacidad mejorada</li><li>Bloqueador de rastreadores</li><li>Personalización avanzada</li><li>Sincronización multiplataforma</li><li>Extensiones potentes</li></ul>',
        'version' => '121.0',
        'developer' => 'Mozilla Foundation',
        'category' => 'Navegadores',
        'license' => 'free',
        'operating_system' => 'Windows, Mac, Linux, Android, iOS',
        'file_size' => '58 MB',
        'download_url' => 'https://www.mozilla.org/firefox/',
        'requirements' => 'Windows 7 o superior, 2 GB RAM, 200 MB espacio',
        'rating' => 4.6,
        'downloads' => 12000
    ],
    [
        'name' => 'VLC Media Player',
        'slug' => 'vlc-media-player',
        'short_description' => 'Reproductor multimedia gratuito y de código abierto',
        'description' => '<p>VLC es un reproductor multimedia multiplataforma gratuito y de código abierto que reproduce la mayoría de archivos multimedia.</p><p>Características:</p><ul><li>Reproduce casi todos los formatos de video y audio</li><li>No requiere códecs adicionales</li><li>Streaming de video</li><li>Conversión de formatos</li><li>Interfaz personalizable</li></ul>',
        'version' => '3.0.20',
        'developer' => 'VideoLAN',
        'category' => 'Multimedia',
        'license' => 'free',
        'operating_system' => 'Windows, Mac, Linux, Android, iOS',
        'file_size' => '42 MB',
        'download_url' => 'https://www.videolan.org/vlc/',
        'requirements' => 'Windows 7 o superior, 1 GB RAM',
        'rating' => 4.8,
        'downloads' => 20000
    ],
    [
        'name' => 'WinRAR',
        'slug' => 'winrar',
        'short_description' => 'Potente herramienta de compresión y descompresión de archivos',
        'description' => '<p>WinRAR es una herramienta de compresión de datos que soporta múltiples formatos de archivo.</p><p>Características:</p><ul><li>Compresión RAR y ZIP</li><li>Descompresión de múltiples formatos</li><li>Cifrado de archivos</li><li>Reparación de archivos dañados</li><li>Integración con Windows</li></ul>',
        'version' => '6.24',
        'developer' => 'RARLAB',
        'category' => 'Utilidades',
        'license' => 'trial',
        'operating_system' => 'Windows, Mac, Linux, Android',
        'file_size' => '3.5 MB',
        'download_url' => 'https://www.win-rar.com/',
        'requirements' => 'Windows 7 o superior',
        'rating' => 4.4,
        'downloads' => 8500
    ],
    [
        'name' => 'Adobe Acrobat Reader',
        'slug' => 'adobe-acrobat-reader',
        'short_description' => 'Lector de PDF gratuito y confiable',
        'description' => '<p>Adobe Acrobat Reader es el software estándar gratuito para ver, imprimir y comentar documentos PDF.</p><p>Características:</p><ul><li>Visualización de PDF</li><li>Anotaciones y comentarios</li><li>Firma digital</li><li>Formularios interactivos</li><li>Sincronización en la nube</li></ul>',
        'version' => '2023.008.20470',
        'developer' => 'Adobe Inc.',
        'category' => 'Productividad',
        'license' => 'free',
        'operating_system' => 'Windows, Mac, Android, iOS',
        'file_size' => '180 MB',
        'download_url' => 'https://get.adobe.com/reader/',
        'requirements' => 'Windows 10 o superior, 2 GB RAM',
        'rating' => 4.3,
        'downloads' => 11000
    ],
    [
        'name' => 'CCleaner',
        'slug' => 'ccleaner',
        'short_description' => 'Optimizador y limpiador de sistema',
        'description' => '<p>CCleaner es una herramienta de optimización y limpieza para Windows y Mac.</p><p>Características:</p><ul><li>Limpieza de archivos temporales</li><li>Optimización del registro</li><li>Desinstalador de programas</li><li>Gestión de inicio</li><li>Borrado seguro</li></ul>',
        'version' => '6.19',
        'developer' => 'Piriform (Avast)',
        'category' => 'Utilidades',
        'license' => 'freemium',
        'operating_system' => 'Windows, Mac, Android',
        'file_size' => '45 MB',
        'download_url' => 'https://www.ccleaner.com/',
        'requirements' => 'Windows 7 o superior, 1 GB RAM',
        'rating' => 4.5,
        'downloads' => 9500
    ],
    [
        'name' => 'Spotify',
        'slug' => 'spotify',
        'short_description' => 'Servicio de streaming de música y podcasts',
        'description' => '<p>Spotify es un servicio de música en streaming que te da acceso a millones de canciones y podcasts.</p><p>Características:</p><ul><li>Millones de canciones</li><li>Podcasts exclusivos</li><li>Listas de reproducción personalizadas</li><li>Modo sin conexión (Premium)</li><li>Sincronización entre dispositivos</li></ul>',
        'version' => '1.2.28',
        'developer' => 'Spotify AB',
        'category' => 'Multimedia',
        'license' => 'freemium',
        'operating_system' => 'Windows, Mac, Linux, Android, iOS',
        'file_size' => '120 MB',
        'download_url' => 'https://www.spotify.com/download/',
        'requirements' => 'Windows 7 o superior, 2 GB RAM',
        'rating' => 4.7,
        'downloads' => 18000
    ],
    [
        'name' => 'Discord',
        'slug' => 'discord',
        'short_description' => 'Plataforma de comunicación para comunidades',
        'description' => '<p>Discord es una aplicación de comunicación por voz, video y texto diseñada para crear comunidades.</p><p>Características:</p><ul><li>Chat de voz y video</li><li>Servidores personalizables</li><li>Compartir pantalla</li><li>Bots y integraciones</li><li>Streaming en vivo</li></ul>',
        'version' => '0.0.308',
        'developer' => 'Discord Inc.',
        'category' => 'Comunicación',
        'license' => 'free',
        'operating_system' => 'Windows, Mac, Linux, Android, iOS',
        'file_size' => '95 MB',
        'download_url' => 'https://discord.com/download',
        'requirements' => 'Windows 7 o superior, 4 GB RAM',
        'rating' => 4.6,
        'downloads' => 14000
    ],
    [
        'name' => 'Visual Studio Code',
        'slug' => 'visual-studio-code',
        'short_description' => 'Editor de código fuente potente y gratuito',
        'description' => '<p>Visual Studio Code es un editor de código fuente desarrollado por Microsoft.</p><p>Características:</p><ul><li>IntelliSense (autocompletado)</li><li>Depuración integrada</li><li>Control de versiones Git</li><li>Extensiones ilimitadas</li><li>Terminal integrada</li></ul>',
        'version' => '1.85.1',
        'developer' => 'Microsoft',
        'category' => 'Desarrollo',
        'license' => 'free',
        'operating_system' => 'Windows, Mac, Linux',
        'file_size' => '85 MB',
        'download_url' => 'https://code.visualstudio.com/',
        'requirements' => 'Windows 10 o superior, 4 GB RAM',
        'rating' => 4.9,
        'downloads' => 16000
    ],
    [
        'name' => 'Zoom',
        'slug' => 'zoom',
        'short_description' => 'Plataforma de videoconferencias y reuniones virtuales',
        'description' => '<p>Zoom es una plataforma de comunicación por video que combina videoconferencias, reuniones en línea y colaboración móvil.</p><p>Características:</p><ul><li>Videollamadas HD</li><li>Compartir pantalla</li><li>Grabación de reuniones</li><li>Salas de espera</li><li>Chat integrado</li></ul>',
        'version' => '5.16.10',
        'developer' => 'Zoom Video Communications',
        'category' => 'Comunicación',
        'license' => 'freemium',
        'operating_system' => 'Windows, Mac, Linux, Android, iOS',
        'file_size' => '65 MB',
        'download_url' => 'https://zoom.us/download',
        'requirements' => 'Windows 10 o superior, 4 GB RAM',
        'rating' => 4.4,
        'downloads' => 13000
    ]
];

try {
    $db = \App\Database::getInstance()->getConnection();
    
    $imported = 0;
    $skipped = 0;
    $errors = 0;
    
    foreach ($softwareList as $software) {
        echo "📦 Procesando: {$software['name']}...\n";
        
        // Verificar si ya existe
        $stmt = $db->prepare("SELECT id FROM software WHERE slug = ?");
        $stmt->execute([$software['slug']]);
        if ($stmt->fetch()) {
            echo "   ⚠️  Ya existe, omitiendo\n\n";
            $skipped++;
            continue;
        }
        
        // Obtener ID de categoría
        $stmt = $db->prepare("SELECT id FROM categories WHERE name = ?");
        $stmt->execute([$software['category']]);
        $category = $stmt->fetch();
        
        if (!$category) {
            echo "   ❌ Categoría '{$software['category']}' no encontrada\n\n";
            $errors++;
            continue;
        }
        
        // Insertar software
        $stmt = $db->prepare("
            INSERT INTO software (
                name, slug, short_description, description, version, 
                developer, category_id, license, operating_system, 
                file_size, download_url, requirements, status, 
                rating, downloads, created_at, updated_at
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'approved', ?, ?, NOW(), NOW()
            )
        ");
        
        $stmt->execute([
            $software['name'],
            $software['slug'],
            $software['short_description'],
            $software['description'],
            $software['version'],
            $software['developer'],
            $category['id'],
            $software['license'],
            $software['operating_system'],
            $software['file_size'],
            $software['download_url'],
            $software['requirements'],
            $software['rating'],
            $software['downloads']
        ]);
        
        echo "   ✅ Importado exitosamente\n\n";
        $imported++;
    }
    
    echo "========================\n";
    echo "✅ IMPORTACIÓN COMPLETADA\n";
    echo "========================\n";
    echo "✅ Importados: $imported\n";
    echo "⚠️  Omitidos: $skipped\n";
    echo "❌ Errores: $errors\n";
    echo "📊 Total procesados: " . count($softwareList) . "\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
