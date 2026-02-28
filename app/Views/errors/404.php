<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página No Encontrada</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="text-center text-white">
        <div class="mb-8">
            <i class="fas fa-exclamation-triangle text-9xl mb-6 opacity-80"></i>
        </div>
        <h1 class="text-6xl md:text-8xl font-bold mb-4">404</h1>
        <h2 class="text-2xl md:text-4xl font-semibold mb-6">Página No Encontrada</h2>
        <p class="text-lg md:text-xl mb-8 text-purple-100">
            Lo sentimos, la página que buscas no existe o ha sido movida.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="<?= url() ?>" class="bg-white text-purple-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-purple-100 transition transform hover:scale-105">
                <i class="fas fa-home mr-2"></i>Ir al Inicio
            </a>
            <a href="<?= url('software') ?>" class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-white hover:text-purple-600 transition">
                <i class="fas fa-download mr-2"></i>Ver Software
            </a>
        </div>
    </div>
</body>
</html>
