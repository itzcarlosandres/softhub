<?php
// Habilitar errores para debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluir autoloader y database
define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . '/app/EnvLoader.php';
EnvLoader::load(BASE_PATH);

require_once BASE_PATH . '/app/Database.php';

// Bloquear en produccion
if (env('APP_ENV') === 'production') {
    die("Error: El script de configuracion inicial esta deshabilitado en produccion por seguridad.");
}

use App\Database;

$installed = false;
$errors = [];
$success = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['install'])) {
    try {
        $db = Database::getInstance()->getConnection();

        // 1. Crear tabla de usuarios
        try {
            $db->exec("
                CREATE TABLE IF NOT EXISTS users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(100) NOT NULL,
                    email VARCHAR(100) UNIQUE NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    role ENUM('admin', 'editor', 'user') DEFAULT 'user',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $success[] = "✓ Tabla 'users' creada";
        } catch (PDOException $e) {
            $errors[] = "✗ Error tabla 'users': " . $e->getMessage();
        }

        // 2. Crear usuario admin
        try {
            $checkAdmin = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'admin'")->fetch();
            
            if ($checkAdmin['count'] == 0) {
                $adminPassword = password_hash('admin123', PASSWORD_BCRYPT);
                $stmt = $db->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
                $stmt->execute(['Administrador', 'admin@softhub.com', $adminPassword, 'admin']);
                $success[] = "✓ Usuario admin creado";
            } else {
                $success[] = "✓ Usuario admin ya existe";
            }
        } catch (PDOException $e) {
            $errors[] = "✗ Error usuario admin: " . $e->getMessage();
        }

        // 3. Crear tabla de logs
        try {
            $db->exec("
                CREATE TABLE IF NOT EXISTS activity_logs (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id INT,
                    action VARCHAR(100) NOT NULL,
                    description TEXT,
                    ip_address VARCHAR(45),
                    user_agent VARCHAR(255),
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $success[] = "✓ Tabla 'activity_logs' creada";
        } catch (PDOException $e) {
            $errors[] = "✗ Error tabla 'activity_logs': " . $e->getMessage();
        }

        // 4. Crear tabla de reviews
        try {
            $db->exec("
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
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $success[] = "✓ Tabla 'reviews' creada";
        } catch (PDOException $e) {
            $errors[] = "✗ Error tabla 'reviews': " . $e->getMessage();
        }

        $installed = empty($errors);

    } catch (Exception $e) {
        $errors[] = "Error fatal: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalación - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-2xl">
        <div class="text-center mb-8">
            <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-cog <?= $installed ? '' : 'fa-spin' ?> text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Instalación del Panel Admin</h1>
            <p class="text-gray-600">Configuración inicial del sistema</p>
        </div>

        <?php if (!empty($success)): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6">
                <h3 class="font-bold mb-2"><i class="fas fa-check-circle mr-2"></i>Instalación Exitosa</h3>
                <ul class="space-y-1">
                    <?php foreach ($success as $msg): ?>
                        <li><?= htmlspecialchars($msg) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6">
                <h3 class="font-bold mb-2"><i class="fas fa-exclamation-circle mr-2"></i>Errores</h3>
                <ul class="space-y-1">
                    <?php foreach ($errors as $msg): ?>
                        <li><?= htmlspecialchars($msg) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($installed): ?>
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-6 rounded-lg">
                <h3 class="font-bold text-lg mb-4"><i class="fas fa-key mr-2"></i>Credenciales de Acceso</h3>
                <div class="space-y-2 mb-4">
                    <p><strong>Email:</strong> <code class="bg-white px-2 py-1 rounded">admin@softhub.com</code></p>
                    <p><strong>Contraseña:</strong> <code class="bg-white px-2 py-1 rounded">admin123</code></p>
                </div>
                <a href="<?= $_SERVER['REQUEST_SCHEME'] ?>://<?= $_SERVER['HTTP_HOST'] ?>/laravel/public/admin_login.php" class="inline-block gradient-bg text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90 transition">
                    <i class="fas fa-sign-in-alt mr-2"></i>Ir al Panel Admin
                </a>
            </div>
        <?php else: ?>
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg mb-6">
                <h3 class="font-bold text-blue-800 mb-2">
                    <i class="fas fa-info-circle mr-2"></i>¿Qué se instalará?
                </h3>
                <ul class="list-disc list-inside text-blue-700 space-y-1">
                    <li>Tabla de usuarios (users)</li>
                    <li>Tabla de logs (activity_logs)</li>
                    <li>Tabla de reviews (reviews)</li>
                    <li>Usuario administrador</li>
                </ul>
            </div>

            <form method="POST">
                <button type="submit" name="install" value="1" 
                        class="w-full gradient-bg text-white py-4 rounded-lg font-semibold hover:opacity-90 transition">
                    <i class="fas fa-rocket mr-2"></i>Iniciar Instalación
                </button>
            </form>
        <?php endif; ?>

        <div class="mt-6 text-center">
            <a href="./" class="text-purple-600 hover:text-purple-700 text-sm font-semibold">
                <i class="fas fa-arrow-left mr-1"></i>Volver al sitio
            </a>
        </div>
    </div>
</body>
</html>
