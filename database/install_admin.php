<?php
/**
 * Script de Instalación del Panel de Administración
 * Este script crea la tabla de usuarios y un usuario administrador por defecto
 */

require_once __DIR__ . '/../app/Database.php';

use App\Database;

$db = Database::getInstance()->getConnection();

echo "=== Instalación del Panel de Administración ===\n\n";

// Crear tabla de usuarios si no existe
echo "1. Creando tabla de usuarios...\n";

$createUsersTable = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

try {
    $db->exec($createUsersTable);
    echo "✓ Tabla 'users' creada exitosamente\n\n";
} catch (PDOException $e) {
    echo "✗ Error al crear tabla 'users': " . $e->getMessage() . "\n\n";
}

// Verificar si ya existe un usuario admin
echo "2. Verificando usuario administrador...\n";

$checkAdmin = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'admin'")->fetch();

if ($checkAdmin['count'] == 0) {
    echo "   No se encontró usuario admin. Creando...\n";
    
    // Crear usuario administrador por defecto
    $adminPassword = password_hash('admin123', PASSWORD_BCRYPT);
    
    $insertAdmin = "
    INSERT INTO users (name, email, password, role) 
    VALUES ('Administrador', 'admin@softhub.com', :password, 'admin')
    ";
    
    try {
        $stmt = $db->prepare($insertAdmin);
        $stmt->execute(['password' => $adminPassword]);
        echo "✓ Usuario administrador creado exitosamente\n\n";
    } catch (PDOException $e) {
        echo "✗ Error al crear usuario admin: " . $e->getMessage() . "\n\n";
    }
} else {
    echo "✓ Ya existe un usuario administrador\n\n";
}

// Crear tabla de logs de actividad
echo "3. Creando tabla de logs de actividad...\n";

$createLogsTable = "
CREATE TABLE IF NOT EXISTS activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    description TEXT,
    ip_address VARCHAR(45),
    user_agent VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

try {
    $db->exec($createLogsTable);
    echo "✓ Tabla 'activity_logs' creada exitosamente\n\n";
} catch (PDOException $e) {
    echo "✗ Error al crear tabla 'activity_logs': " . $e->getMessage() . "\n\n";
}

// Crear tabla de reviews
echo "4. Creando tabla de reviews...\n";

$createReviewsTable = "
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    software_id INT NOT NULL,
    user_name VARCHAR(100) NOT NULL,
    user_email VARCHAR(100),
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (software_id) REFERENCES software(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

try {
    $db->exec($createReviewsTable);
    echo "✓ Tabla 'reviews' creada exitosamente\n\n";
} catch (PDOException $e) {
    echo "✗ Error al crear tabla 'reviews': " . $e->getMessage() . "\n\n";
}

// Mostrar resumen
echo "=== Instalación Completada ===\n\n";
echo "Credenciales de acceso:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "URL:        http://localhost/laravel/public/admin/login\n";
echo "Email:      admin@softhub.com\n";
echo "Contraseña: admin123\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
echo "⚠️  IMPORTANTE: Cambia la contraseña después del primer login\n\n";
?>
