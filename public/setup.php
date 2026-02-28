<?php
/**
 * Script simplificado para crear las tablas de la base de datos
 */

// Cargar variables de entorno
require_once __DIR__ . '/../app/EnvLoader.php';
EnvLoader::load(dirname(__DIR__));

// Obtener credenciales del .env
$host = env('DB_HOST', 'localhost');
$database = env('DB_NAME', 'softhub');
$username = env('DB_USER', 'root');
$password = env('DB_PASS', 'root');

try {
    $conn = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h1>Instalación de SoftHub</h1>";
    echo "<p>Creando tablas...</p>";
    
    // Tabla de usuarios
    $conn->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'user') DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✅ Tabla 'users' creada<br>";
    
    // Tabla de categorías
    $conn->exec("
        CREATE TABLE IF NOT EXISTS categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            slug VARCHAR(100) UNIQUE NOT NULL,
            description TEXT,
            icon VARCHAR(50),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✅ Tabla 'categories' creada<br>";
    
    // Tabla de software
    $conn->exec("
        CREATE TABLE IF NOT EXISTS software (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(200) NOT NULL,
            slug VARCHAR(200) UNIQUE NOT NULL,
            description TEXT,
            short_description VARCHAR(500),
            version VARCHAR(50),
            developer VARCHAR(100),
            category_id INT,
            image VARCHAR(255),
            icon VARCHAR(255),
            screenshots TEXT,
            download_url VARCHAR(500),
            file_size VARCHAR(50),
            license VARCHAR(100),
            operating_system VARCHAR(100),
            requirements TEXT,
            downloads INT DEFAULT 0,
            rating DECIMAL(3,2) DEFAULT 0,
            rating_count INT DEFAULT 0,
            featured BOOLEAN DEFAULT FALSE,
            status ENUM('pending', 'approved', 'rejected') DEFAULT 'approved',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✅ Tabla 'software' creada<br>";
    
    // Tabla de reviews
    $conn->exec("
        CREATE TABLE IF NOT EXISTS reviews (
            id INT AUTO_INCREMENT PRIMARY KEY,
            software_id INT NOT NULL,
            user_id INT,
            rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
            comment TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (software_id) REFERENCES software(id) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✅ Tabla 'reviews' creada<br>";
    
    // Tabla de site_settings
    $conn->exec("
        CREATE TABLE IF NOT EXISTS site_settings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            setting_key VARCHAR(100) UNIQUE NOT NULL,
            setting_value TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✅ Tabla 'site_settings' creada<br>";
    
    // Tabla de download_links
    $conn->exec("
        CREATE TABLE IF NOT EXISTS download_links (
            id INT AUTO_INCREMENT PRIMARY KEY,
            software_id INT NOT NULL,
            platform VARCHAR(50) NOT NULL,
            download_url VARCHAR(500) NOT NULL,
            version VARCHAR(50),
            file_size VARCHAR(50),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (software_id) REFERENCES software(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✅ Tabla 'download_links' creada<br>";
    
    // Crear usuario administrador por defecto
    $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $conn->prepare("
        INSERT IGNORE INTO users (username, email, password, role) 
        VALUES ('admin', 'admin@softhub.local', ?, 'admin')
    ");
    $stmt->execute([$adminPassword]);
    echo "✅ Usuario administrador creado (username: admin, password: admin123)<br>";
    
    // Insertar configuraciones por defecto
    $defaultSettings = [
        ['site_name', 'SoftHub'],
        ['site_description', 'Descarga software gratis y seguro'],
        ['site_keywords', 'software, descargas, gratis, programas'],
        ['home_featured_count', '8'],
        ['home_latest_count', '12'],
        ['home_top_downloads', '10'],
        ['ai_enabled', '1'],
        ['gemini_api_key', 'AIzaSyDRNUFFwaVBL-BRyJKbFm1SVOaW1J9iUgw']
    ];
    
    $stmt = $conn->prepare("
        INSERT IGNORE INTO site_settings (setting_key, setting_value) 
        VALUES (?, ?)
    ");
    
    foreach ($defaultSettings as $setting) {
        $stmt->execute($setting);
    }
    echo "✅ Configuraciones por defecto creadas<br>";
    
    // Insertar categorías de ejemplo
    $categories = [
        ['Navegadores', 'navegadores', 'Navegadores web modernos y rápidos', '🌐'],
        ['Multimedia', 'multimedia', 'Reproductores y editores de audio y video', '🎬'],
        ['Productividad', 'productividad', 'Herramientas para aumentar tu productividad', '📊'],
        ['Seguridad', 'seguridad', 'Antivirus y herramientas de seguridad', '🔒'],
        ['Comunicación', 'comunicacion', 'Mensajería y comunicación', '💬'],
        ['Desarrollo', 'desarrollo', 'Herramientas para desarrolladores', '💻']
    ];
    
    $stmt = $conn->prepare("
        INSERT IGNORE INTO categories (name, slug, description, icon) 
        VALUES (?, ?, ?, ?)
    ");
    
    foreach ($categories as $cat) {
        $stmt->execute($cat);
    }
    echo "✅ Categorías de ejemplo creadas<br>";
    
    // Crear índices para optimizar consultas
    echo "<br><h3>Optimizando base de datos...</h3>";
    
    // Índices para software
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_software_slug ON software(slug)");
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_software_category ON software(category_id)");
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_software_status ON software(status)");
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_software_featured ON software(featured)");
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_software_downloads ON software(downloads DESC)");
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_software_rating ON software(rating DESC)");
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_software_created ON software(created_at DESC)");
    echo "✅ Índices de 'software' creados<br>";
    
    // Índices para categories
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_categories_slug ON categories(slug)");
    echo "✅ Índices de 'categories' creados<br>";
    
    // Índices para users
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_users_email ON users(email)");
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_users_role ON users(role)");
    echo "✅ Índices de 'users' creados<br>";
    
    // Índices para reviews
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_reviews_software ON reviews(software_id)");
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_reviews_user ON reviews(user_id)");
    echo "✅ Índices de 'reviews' creados<br>";
    
    // Índices para site_settings
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_settings_key ON site_settings(setting_key)");
    echo "✅ Índices de 'site_settings' creados<br>";
    
    // Índices para download_links
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_downloads_software ON download_links(software_id)");
    echo "✅ Índices de 'download_links' creados<br>";
    
    echo "<br><h2>✅ Instalación completada exitosamente!</h2>";
    echo "<p><a href='/laravel/public/'>Ir a la página principal</a></p>";
    echo "<p><a href='/laravel/public/admin/login'>Ir al panel de administración</a></p>";
    
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
