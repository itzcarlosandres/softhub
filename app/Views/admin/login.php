<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Login - Admin' ?></title>
    
    <!-- Favicon -->
    <?php
    $settingsModel = new \App\Models\SiteSetting();
    $favicon = $settingsModel->get('site_favicon');
    ?>
    <?php if ($favicon): ?>
        <link rel="icon" type="image/x-icon" href="<?= url($favicon) ?>">
    <?php else: ?>
        <link rel="icon" type="image/x-icon" href="<?= url('favicon.ico') ?>">
    <?php endif; ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user-shield text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Panel de Administración</h1>
            <p class="text-gray-600">Ingresa tus credenciales para continuar</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <?= $_SESSION['error'] ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="<?= url('admin/login') ?>" method="POST" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-envelope mr-2 text-purple-600"></i>Correo Electrónico
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    placeholder="admin@softhub.com"
                >
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-lock mr-2 text-purple-600"></i>Contraseña
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    placeholder="••••••••"
                >
            </div>

            <button 
                type="submit" 
                class="w-full gradient-bg text-white py-3 rounded-lg font-semibold hover:opacity-90 transition transform hover:scale-105"
            >
                <i class="fas fa-sign-in-alt mr-2"></i>Iniciar Sesión
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="<?= url() ?>" class="text-purple-600 hover:text-purple-700 text-sm font-semibold">
                <i class="fas fa-arrow-left mr-1"></i>Volver al sitio
            </a>
        </div>
    </div>
</body>
</html>
