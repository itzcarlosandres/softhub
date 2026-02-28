<?php
/**
 * Script para agregar todas las categorías de software
 */

require_once __DIR__ . '/../app/EnvLoader.php';
require_once __DIR__ . '/../app/Database.php';

EnvLoader::load(dirname(__DIR__));

$db = \App\Database::getInstance()->getConnection();

// Lista completa de categorías con iconos
$categories = [
    // Seguridad
    ['name' => 'Antivirus', 'slug' => 'antivirus', 'description' => 'Protección contra virus, malware y amenazas en línea', 'icon' => 'fas fa-shield-virus'],
    ['name' => 'Firewall', 'slug' => 'firewall', 'description' => 'Protección de red y control de tráfico', 'icon' => 'fas fa-fire'],
    ['name' => 'VPN', 'slug' => 'vpn', 'description' => 'Redes privadas virtuales para privacidad y seguridad', 'icon' => 'fas fa-user-shield'],
    ['name' => 'Anti-Malware', 'slug' => 'anti-malware', 'description' => 'Eliminación de malware y spyware', 'icon' => 'fas fa-bug-slash'],
    
    // Internet
    ['name' => 'Navegadores', 'slug' => 'navegadores', 'description' => 'Navegadores web para explorar Internet', 'icon' => 'fas fa-globe'],
    ['name' => 'Descargas', 'slug' => 'descargas', 'description' => 'Gestores de descargas y torrents', 'icon' => 'fas fa-download'],
    ['name' => 'FTP', 'slug' => 'ftp', 'description' => 'Clientes FTP para transferencia de archivos', 'icon' => 'fas fa-server'],
    ['name' => 'Mensajería', 'slug' => 'mensajeria', 'description' => 'Aplicaciones de chat y mensajería instantánea', 'icon' => 'fas fa-comments'],
    ['name' => 'Email', 'slug' => 'email', 'description' => 'Clientes de correo electrónico', 'icon' => 'fas fa-envelope'],
    
    // Multimedia
    ['name' => 'Reproductores de Video', 'slug' => 'reproductores-video', 'description' => 'Reproductores multimedia y de video', 'icon' => 'fas fa-video'],
    ['name' => 'Reproductores de Audio', 'slug' => 'reproductores-audio', 'description' => 'Reproductores de música y audio', 'icon' => 'fas fa-music'],
    ['name' => 'Editores de Video', 'slug' => 'editores-video', 'description' => 'Software de edición de video', 'icon' => 'fas fa-film'],
    ['name' => 'Editores de Audio', 'slug' => 'editores-audio', 'description' => 'Software de edición de audio y música', 'icon' => 'fas fa-microphone'],
    ['name' => 'Editores de Imagen', 'slug' => 'editores-imagen', 'description' => 'Software de edición y retoque fotográfico', 'icon' => 'fas fa-image'],
    ['name' => 'Conversores', 'slug' => 'conversores', 'description' => 'Conversores de formatos multimedia', 'icon' => 'fas fa-exchange-alt'],
    ['name' => 'Streaming', 'slug' => 'streaming', 'description' => 'Software para streaming y transmisión', 'icon' => 'fas fa-broadcast-tower'],
    
    // Productividad
    ['name' => 'Ofimática', 'slug' => 'ofimatica', 'description' => 'Suites de oficina y procesadores de texto', 'icon' => 'fas fa-file-word'],
    ['name' => 'PDF', 'slug' => 'pdf', 'description' => 'Lectores y editores de PDF', 'icon' => 'fas fa-file-pdf'],
    ['name' => 'Notas', 'slug' => 'notas', 'description' => 'Aplicaciones para tomar notas', 'icon' => 'fas fa-sticky-note'],
    ['name' => 'Gestión de Proyectos', 'slug' => 'gestion-proyectos', 'description' => 'Software de gestión y planificación', 'icon' => 'fas fa-tasks'],
    ['name' => 'Calendario', 'slug' => 'calendario', 'description' => 'Calendarios y organizadores', 'icon' => 'fas fa-calendar-alt'],
    
    // Desarrollo
    ['name' => 'Editores de Código', 'slug' => 'editores-codigo', 'description' => 'IDEs y editores para programación', 'icon' => 'fas fa-code'],
    ['name' => 'Bases de Datos', 'slug' => 'bases-datos', 'description' => 'Gestores de bases de datos', 'icon' => 'fas fa-database'],
    ['name' => 'Servidores Web', 'slug' => 'servidores-web', 'description' => 'Servidores web y aplicaciones', 'icon' => 'fas fa-server'],
    ['name' => 'Control de Versiones', 'slug' => 'control-versiones', 'description' => 'Git y sistemas de control de versiones', 'icon' => 'fab fa-git-alt'],
    
    // Utilidades
    ['name' => 'Compresión', 'slug' => 'compresion', 'description' => 'Compresores y descompresores de archivos', 'icon' => 'fas fa-file-archive'],
    ['name' => 'Limpieza', 'slug' => 'limpieza', 'description' => 'Limpiadores y optimizadores del sistema', 'icon' => 'fas fa-broom'],
    ['name' => 'Recuperación de Datos', 'slug' => 'recuperacion-datos', 'description' => 'Recuperación de archivos eliminados', 'icon' => 'fas fa-trash-restore'],
    ['name' => 'Backup', 'slug' => 'backup', 'description' => 'Software de copias de seguridad', 'icon' => 'fas fa-save'],
    ['name' => 'Particiones', 'slug' => 'particiones', 'description' => 'Gestores de particiones de disco', 'icon' => 'fas fa-hdd'],
    ['name' => 'Drivers', 'slug' => 'drivers', 'description' => 'Actualizadores de controladores', 'icon' => 'fas fa-cog'],
    
    // Sistema
    ['name' => 'Sistemas Operativos', 'slug' => 'sistemas-operativos', 'description' => 'Sistemas operativos y distribuciones', 'icon' => 'fab fa-windows'],
    ['name' => 'Virtualización', 'slug' => 'virtualizacion', 'description' => 'Máquinas virtuales y emuladores', 'icon' => 'fas fa-cube'],
    ['name' => 'Monitoreo', 'slug' => 'monitoreo', 'description' => 'Monitores de sistema y rendimiento', 'icon' => 'fas fa-chart-line'],
    
    // Diseño
    ['name' => 'Diseño Gráfico', 'slug' => 'diseno-grafico', 'description' => 'Software de diseño y creatividad', 'icon' => 'fas fa-palette'],
    ['name' => 'CAD', 'slug' => 'cad', 'description' => 'Diseño asistido por computadora', 'icon' => 'fas fa-drafting-compass'],
    ['name' => '3D', 'slug' => '3d', 'description' => 'Modelado y animación 3D', 'icon' => 'fas fa-cube'],
    
    // Juegos
    ['name' => 'Juegos', 'slug' => 'juegos', 'description' => 'Videojuegos y entretenimiento', 'icon' => 'fas fa-gamepad'],
    ['name' => 'Emuladores', 'slug' => 'emuladores', 'description' => 'Emuladores de consolas y sistemas', 'icon' => 'fas fa-laptop'],
    ['name' => 'Plataformas de Juegos', 'slug' => 'plataformas-juegos', 'description' => 'Steam, Epic Games, etc.', 'icon' => 'fab fa-steam'],
    
    // Educación
    ['name' => 'Educación', 'slug' => 'educacion', 'description' => 'Software educativo y de aprendizaje', 'icon' => 'fas fa-graduation-cap'],
    ['name' => 'Idiomas', 'slug' => 'idiomas', 'description' => 'Aprendizaje de idiomas', 'icon' => 'fas fa-language'],
    ['name' => 'Matemáticas', 'slug' => 'matematicas', 'description' => 'Software matemático y científico', 'icon' => 'fas fa-calculator'],
    
    // Redes
    ['name' => 'Redes', 'slug' => 'redes', 'description' => 'Herramientas de red y diagnóstico', 'icon' => 'fas fa-network-wired'],
    ['name' => 'Acceso Remoto', 'slug' => 'acceso-remoto', 'description' => 'Control remoto de equipos', 'icon' => 'fas fa-desktop'],
    
    // Otros
    ['name' => 'Personalización', 'slug' => 'personalizacion', 'description' => 'Temas y personalización del sistema', 'icon' => 'fas fa-paint-brush'],
    ['name' => 'Fondos de Pantalla', 'slug' => 'fondos-pantalla', 'description' => 'Wallpapers y fondos de escritorio', 'icon' => 'fas fa-image'],
    ['name' => 'Capturas de Pantalla', 'slug' => 'capturas-pantalla', 'description' => 'Software para capturas y grabación de pantalla', 'icon' => 'fas fa-camera'],
];

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>Agregar Categorías</title>
    <script src='https://cdn.tailwindcss.com'></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>
</head>
<body class='bg-gray-50 p-8'>
    <div class='max-w-4xl mx-auto'>
        <h1 class='text-3xl font-bold text-gray-900 mb-6'>📁 Agregando Categorías</h1>
        <div class='bg-white rounded-lg shadow-md p-6'>";

$added = 0;
$skipped = 0;

foreach ($categories as $category) {
    // Verificar si ya existe
    $stmt = $db->prepare("SELECT id FROM categories WHERE slug = ?");
    $stmt->execute([$category['slug']]);
    
    if ($stmt->fetch()) {
        echo "<div class='flex items-center gap-2 p-3 bg-yellow-50 border-l-4 border-yellow-500 mb-2 rounded'>";
        echo "<span class='text-yellow-700'>⚠️ Ya existe: <strong>{$category['name']}</strong></span>";
        echo "</div>";
        $skipped++;
    } else {
        // Insertar categoría con icono
        $stmt = $db->prepare("INSERT INTO categories (name, slug, description, icon) VALUES (?, ?, ?, ?)");
        $stmt->execute([$category['name'], $category['slug'], $category['description'], $category['icon']]);
        
        echo "<div class='flex items-center gap-2 p-3 bg-green-50 border-l-4 border-green-500 mb-2 rounded'>";
        echo "<i class='{$category['icon']} text-green-600'></i>";
        echo "<span class='text-green-700'>✅ Agregada: <strong>{$category['name']}</strong></span>";
        echo "</div>";
        $added++;
    }
}

echo "        </div>
        
        <div class='mt-6 bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg'>
            <h2 class='font-bold text-blue-900 text-xl mb-2'>📊 Resumen</h2>
            <div class='space-y-2 text-blue-800'>
                <p>✅ <strong>Agregadas:</strong> $added categorías</p>
                <p>⚠️ <strong>Omitidas:</strong> $skipped categorías (ya existían)</p>
                <p>📁 <strong>Total:</strong> " . count($categories) . " categorías procesadas</p>
            </div>
        </div>
        
        <div class='mt-6 text-center'>
            <a href='/laravel/admin/categories' class='inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold'>
                Ver Categorías en Admin
            </a>
        </div>
    </div>
</body>
</html>";
?>
