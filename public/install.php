<?php

/**
 * Script de Instalación de Base de Datos
 * Ejecuta este archivo una vez para crear las tablas necesarias
 */

define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . '/app/EnvLoader.php';
EnvLoader::load(BASE_PATH);

require_once BASE_PATH . '/app/Database.php';

// Bloquear en produccion
if (env('APP_ENV') === 'production') {
    die("Error: El script de instalacion esta deshabilitado en produccion por seguridad.");
}

use App\Database;

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Instalación - SoftHub</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 800px;
            width: 100%;
        }
        h1 {
            color: #667eea;
            margin-bottom: 30px;
            font-size: 32px;
        }
        .step {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px 20px;
            margin: 15px 0;
            border-radius: 8px;
        }
        .success {
            border-left-color: #10b981;
            background: #d1fae5;
        }
        .error {
            border-left-color: #ef4444;
            background: #fee2e2;
        }
        .btn {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        .btn:hover {
            background: #5568d3;
        }
        code {
            background: #1f2937;
            color: #10b981;
            padding: 2px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🚀 Instalación de SoftHub</h1>";

try {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    
    echo "<div class='step success'>✓ Conexión a la base de datos establecida</div>";
    
    // Create categories table
    echo "<div class='step'>Creando tabla de categorías...</div>";
    $conn->exec("CREATE TABLE IF NOT EXISTS categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL UNIQUE,
        description TEXT,
        icon VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<div class='step success'>✓ Tabla categories creada</div>";
    
    // Create software table
    echo "<div class='step'>Creando tabla de software...</div>";
    $conn->exec("CREATE TABLE IF NOT EXISTS software (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL UNIQUE,
        description TEXT,
        short_description VARCHAR(500),
        version VARCHAR(50),
        developer VARCHAR(255),
        category_id INT,
        license VARCHAR(50) DEFAULT 'free',
        operating_system VARCHAR(100),
        file_size VARCHAR(50),
        download_url TEXT,
        image VARCHAR(255),
        icon VARCHAR(255),
        screenshots TEXT,
        requirements TEXT,
        downloads INT DEFAULT 0,
        rating DECIMAL(3,2) DEFAULT 0,
        status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
        featured BOOLEAN DEFAULT FALSE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<div class='step success'>✓ Tabla software creada</div>";
    
    // Create users table
    echo "<div class='step'>Creando tabla de usuarios...</div>";
    $conn->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'user') DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<div class='step success'>✓ Tabla users creada</div>";
    
    // Insert default admin user
    echo "<div class='step'>Creando usuario administrador...</div>";
    $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?) 
                           ON DUPLICATE KEY UPDATE name=name");
    $stmt->execute(['Administrador', 'admin@softhub.com', $adminPassword, 'admin']);
    echo "<div class='step success'>✓ Usuario administrador creado</div>";
    echo "<div class='step'>
        <strong>Credenciales de acceso:</strong><br>
        Email: <code>admin@softhub.com</code><br>
        Contraseña: <code>admin123</code>
    </div>";
    
    // Insert default categories
    echo "<div class='step'>Creando categorías predeterminadas...</div>";
    $categories = [
        ['Windows', 'windows', 'Software para Windows', '💻'],
        ['Mac', 'mac', 'Software para macOS', '🍎'],
        ['Android', 'android', 'Aplicaciones para Android', '📱'],
        ['iOS', 'ios', 'Aplicaciones para iOS', '📲'],
        ['Navegadores', 'navegadores', 'Navegadores web', '🌐'],
        ['Multimedia', 'multimedia', 'Audio, video y diseño', '🎨'],
        ['Productividad', 'productividad', 'Herramientas de productividad', '📊'],
        ['Seguridad', 'seguridad', 'Antivirus y seguridad', '🔒'],
        ['Utilidades', 'utilidades', 'Herramientas del sistema', '🛠️'],
        ['Juegos', 'juegos', 'Videojuegos', '🎮']
    ];
    
    $stmt = $conn->prepare("INSERT INTO categories (name, slug, description, icon) VALUES (?, ?, ?, ?) 
                           ON DUPLICATE KEY UPDATE name=name");
    foreach ($categories as $cat) {
        $stmt->execute($cat);
    }
    echo "<div class='step success'>✓ Categorías predeterminadas creadas</div>";
    
    // Insert sample software
    echo "<div class='step'>Creando software de ejemplo...</div>";
    $sampleSoftware = [
        [
            'Google Chrome',
            'google-chrome',
            'Google Chrome es un navegador web rápido, seguro y gratuito diseñado para la web moderna. Ofrece sincronización entre dispositivos, extensiones personalizables y actualizaciones automáticas.',
            'Navegador web rápido y seguro de Google',
            '120.0.6099.129',
            'Google LLC',
            5, // Navegadores
            'free',
            'Windows, Mac, Linux',
            '95 MB',
            'https://www.google.com/chrome/',
            '/uploads/images/chrome.jpg',
            '/uploads/icons/chrome-icon.png',
            'published',
            1
        ],
        [
            'Mozilla Firefox',
            'mozilla-firefox',
            'Firefox es un navegador web de código abierto que prioriza tu privacidad. Incluye protección contra rastreo mejorada, gestión de contraseñas y sincronización entre dispositivos.',
            'Navegador web de código abierto enfocado en privacidad',
            '121.0',
            'Mozilla Foundation',
            5, // Navegadores
            'free',
            'Windows, Mac, Linux',
            '58 MB',
            'https://www.mozilla.org/firefox/',
            '/uploads/images/firefox.jpg',
            '/uploads/icons/firefox-icon.png',
            'published',
            1
        ],
        [
            'VLC Media Player',
            'vlc-media-player',
            'VLC es un reproductor multimedia gratuito y de código abierto que reproduce la mayoría de archivos multimedia, así como DVDs, CDs de audio, VCDs y diversos protocolos de transmisión.',
            'Reproductor multimedia gratuito y versátil',
            '3.0.20',
            'VideoLAN',
            6, // Multimedia
            'free',
            'Windows, Mac, Linux, Android, iOS',
            '40 MB',
            'https://www.videolan.org/vlc/',
            '/uploads/images/vlc.jpg',
            '/uploads/icons/vlc-icon.png',
            'published',
            1
        ]
    ];
    
    $stmt = $conn->prepare("INSERT INTO software (name, slug, description, short_description, version, developer, category_id, license, operating_system, file_size, download_url, image, icon, status, featured, downloads) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0) 
                           ON DUPLICATE KEY UPDATE name=name");
    foreach ($sampleSoftware as $soft) {
        $stmt->execute($soft);
    }
    echo "<div class='step success'>✓ Software de ejemplo creado</div>";
    
    echo "<div class='step success' style='margin-top: 30px;'>
        <h2 style='color: #10b981; margin-bottom: 15px;'>✅ ¡Instalación Completada!</h2>
        <p style='margin-bottom: 10px;'><strong>La base de datos ha sido configurada exitosamente.</strong></p>
        <p style='margin-bottom: 20px;'>Ahora puedes:</p>
        <ul style='margin-left: 20px; margin-bottom: 20px;'>
            <li>Acceder al panel de administración en <code>/admin/login</code></li>
            <li>Ver la página principal en <code>/</code></li>
            <li>Explorar las categorías y software</li>
        </ul>
        <p style='color: #ef4444; font-weight: bold;'>⚠️ IMPORTANTE: Elimina este archivo (install.php) por seguridad</p>
    </div>";
    
    echo "<a href='/admin/login' class='btn'>Ir al Panel de Administración</a>";
    echo "<a href='/' class='btn' style='margin-left: 10px; background: #10b981;'>Ver Sitio Web</a>";
    
} catch (Exception $e) {
    echo "<div class='step error'>
        <strong>❌ Error durante la instalación:</strong><br>
        " . htmlspecialchars($e->getMessage()) . "
    </div>";
    echo "<div class='step'>
        <strong>Posibles soluciones:</strong>
        <ul style='margin-left: 20px; margin-top: 10px;'>
            <li>Verifica que MAMP esté ejecutándose</li>
            <li>Asegúrate de que MySQL esté activo</li>
            <li>Verifica las credenciales en <code>config/database.php</code></li>
            <li>Crea manualmente la base de datos <code>softhub</code> en phpMyAdmin</li>
        </ul>
    </div>";
}

echo "
    </div>
</body>
</html>";
