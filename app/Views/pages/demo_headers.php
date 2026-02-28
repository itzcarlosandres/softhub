<?php
// Mock data for demo purposes
$siteName = 'SoftHub'; 
if (function_exists('env')) {
    $siteName = env('SITE_NAME', 'SoftHub');
}
$logo = '';
if (function_exists('env')) {
    $logo = env('SITE_LOGO', '');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Headers - Rediseño Premium</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#e0f2fe',
                            100: '#bae6fd',
                            500: '#0284c7',
                            600: '#0369a1',
                            700: '#075985',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #f3f4f6; padding-bottom: 100px; }
        .demo-section { margin-bottom: 60px; border-bottom: 1px dashed #cbd5e1; padding-bottom: 40px; }
        .demo-label { 
            background: #1e293b; color: white; padding: 8px 16px; 
            border-radius: 9999px; display: inline-block; margin-bottom: 20px;
            font-size: 0.875rem; font-weight: 600; letter-spacing: 0.05em;
        }
        
        /* Glassmorphism Classes */
        .glass-nav {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        /* Floating Island Classes */
        .floating-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 40px -10px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.5);
        }
    </style>
</head>
<body>

    <div class="container mx-auto px-4 py-8 text-center">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Propuestas de Rediseño de Header</h1>
        <p class="text-gray-600">5 Estilos Premium, Minimalistas y Elegantes</p>
    </div>

    <!-- OPCIÓN 1: GLASSMORPHISM & CENTERED -->
    <section class="demo-section">
        <div class="container mx-auto px-4 text-center">
            <span class="demo-label">OPCIÓN 1: GLASSMORPHISM & CENTERED</span>
        </div>
        
        <header class="glass-nav sticky top-0 z-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center gap-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg transform rotate-3 hover:rotate-0 transition-all duration-300 cursor-pointer">
                            <i class="fas fa-cube text-white text-lg"></i>
                        </div>
                        <span class="font-bold text-xl tracking-tight text-gray-900 cursor-pointer hover:text-blue-600 transition">Soft<span class="text-blue-600">Hub</span></span>
                    </div>

                    <!-- Centered Nav -->
                    <nav class="hidden md:flex space-x-8 bg-white/50 px-6 py-2 rounded-full border border-white/50 shadow-sm backdrop-blur-sm">
                        <a href="#" class="text-gray-900 hover:text-blue-600 font-medium text-sm transition relative group">
                            Inicio
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-blue-600 font-medium text-sm transition relative group">
                            Categorías
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-blue-600 font-medium text-sm transition relative group">
                            Top Descargas
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-blue-600 font-medium text-sm transition relative group">
                            Novedades
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                        </a>
                    </nav>

                    <!-- Right Actions -->
                    <div class="flex items-center gap-4">
                        <button class="text-gray-500 hover:text-blue-600 transition p-2 rounded-full hover:bg-blue-50">
                            <i class="fas fa-search text-lg"></i>
                        </button>
                        <a href="#" class="hidden sm:flex items-center gap-2 bg-gray-900 text-white px-5 py-2.5 rounded-xl hover:bg-gray-800 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm font-medium">
                            <span>Acceder</span>
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <div class="h-64 bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center">
            <p class="text-gray-400 font-light">Contenido Hero Section...</p>
        </div>
    </section>

    <!-- OPCIÓN 2: MINIMALIST BORDERLESS -->
    <section class="demo-section">
        <div class="container mx-auto px-4 text-center">
            <span class="demo-label">OPCIÓN 2: MINIMALIST BORDERLESS</span>
        </div>

        <header class="bg-white py-6">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <!-- Left: Menu Trigger + Search -->
                    <div class="flex items-center gap-4 w-1/3">
                        <button class="group flex items-center gap-2 text-gray-900 hover:text-blue-600 transition">
                            <div class="flex flex-col gap-1.5 group-hover:gap-2 transition-all">
                                <span class="w-6 h-0.5 bg-current"></span>
                                <span class="w-4 h-0.5 bg-current group-hover:w-6 transition-all"></span>
                            </div>
                            <span class="font-medium text-sm uppercase tracking-wider ml-2 hidden sm:block">Menú</span>
                        </button>
                        <div class="h-6 w-px bg-gray-200 mx-2 hidden sm:block"></div>
                        <button class="text-gray-400 hover:text-gray-900 transition hidden sm:block">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>

                    <!-- Center: Logo Typography -->
                    <div class="w-1/3 text-center flex justify-center">
                        <a href="#" class="text-2xl font-black tracking-widest text-gray-900 uppercase hover:tracking-[0.2em] transition-all duration-500">
                            SOFTHUB<span class="text-blue-500">.</span>
                        </a>
                    </div>

                    <!-- Right: Quick Links -->
                    <div class="w-1/3 flex justify-end items-center gap-6">
                        <nav class="hidden md:flex gap-6">
                            <a href="#" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition">Populares</a>
                            <a href="#" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition">Nuevos</a>
                        </nav>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-all duration-300">
                            <i class="far fa-user"></i>
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <div class="h-10 bg-gray-50"></div>
    </section>

    <!-- OPCIÓN 3: DOUBLE LEVEL PROFESSIONAL -->
    <section class="demo-section">
        <div class="container mx-auto px-4 text-center">
            <span class="demo-label">OPCIÓN 3: DOUBLE LEVEL PROFESSIONAL</span>
        </div>

        <!-- Top Bar -->
        <div class="bg-slate-900 text-slate-300 text-xs py-2 border-b border-slate-800">
            <div class="container mx-auto px-4 flex justify-between items-center">
                <div class="flex gap-4">
                    <span><i class="fas fa-shield-alt text-green-400 mr-1.5"></i>Software 100% Verificado</span>
                    <span class="hidden sm:inline"><i class="fas fa-bolt text-yellow-400 mr-1.5"></i>Descargas Rápidas</span>
                </div>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-white transition">Soporte</a>
                    <a href="#" class="hover:text-white transition">Premium</a>
                </div>
            </div>
        </div>

        <!-- Main Header -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-40 shadow-sm">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <a href="#" class="flex items-center gap-2.5 group">
                        <div class="relative">
                            <div class="absolute inset-0 bg-blue-500 blur opacity-20 rounded-lg group-hover:opacity-40 transition"></div>
                            <div class="relative w-9 h-9 bg-white border border-gray-100 rounded-lg flex items-center justify-center shadow-sm">
                                <i class="fas fa-layer-group text-blue-600"></i>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-gray-900 leading-none text-lg">SoftHub</span>
                            <span class="text-[10px] text-gray-500 font-medium tracking-wide uppercase">Marketplace</span>
                        </div>
                    </a>

                    <!-- Search Bar Wide -->
                    <div class="hidden md:flex max-w-xl w-full mx-8">
                        <div class="relative w-full group">
                            <input type="text" placeholder="¿Qué software necesitas hoy?" 
                                class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 block w-full pl-10 p-2.5 transition-all group-hover:bg-white group-hover:shadow-sm">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fas fa-search text-gray-400 group-hover:text-blue-500 transition"></i>
                            </div>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <span class="text-xs text-gray-400 border border-gray-200 rounded px-1.5 py-0.5">Ctrl+K</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-3">
                        <button class="hidden sm:flex p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition" title="Modo Oscuro">
                            <i class="far fa-moon"></i>
                        </button>
                        <div class="h-6 w-px bg-gray-200 hidden sm:block"></div>
                        <a href="#" class="text-sm font-medium text-gray-700 hover:text-blue-600 px-3 py-2 rounded-lg hover:bg-gray-50 transition">Iniciar Sesión</a>
                        <a href="#" class="text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                            Registrarse
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <div class="h-20 bg-gray-50"></div>
    </section>

    <!-- OPCIÓN 4: FLOATING ISLAND (iOS Style) -->
    <section class="demo-section relative">
        <div class="container mx-auto px-4 text-center">
            <span class="demo-label">OPCIÓN 4: FLOATING ISLAND (iOS Style)</span>
        </div>
        
        <!-- Background simulating page content -->
        <div class="absolute inset-x-0 top-32 h-64 bg-gradient-to-r from-violet-500 to-fuchsia-500 opacity-10"></div>

        <div class="sticky top-4 z-50 px-4 flex justify-center mt-4">
            <header class="floating-nav w-full max-w-5xl rounded-2xl px-2 py-2 flex items-center justify-between">
                <!-- Logo -->
                <a href="#" class="flex items-center gap-2 pl-4 pr-2">
                    <div class="w-8 h-8 bg-black rounded-full flex items-center justify-center text-white">
                        <i class="fas fa-infinity text-xs"></i>
                    </div>
                    <span class="font-bold text-gray-900">SoftHub</span>
                </a>

                <!-- Nav Links -->
                <nav class="hidden md:flex items-center gap-1 bg-gray-100/50 p-1 rounded-xl">
                    <a href="#" class="px-4 py-1.5 rounded-lg bg-white shadow-sm text-sm font-medium text-gray-900">Explorar</a>
                    <a href="#" class="px-4 py-1.5 rounded-lg hover:bg-white/50 text-sm font-medium text-gray-500 hover:text-gray-900 transition">Windows</a>
                    <a href="#" class="px-4 py-1.5 rounded-lg hover:bg-white/50 text-sm font-medium text-gray-500 hover:text-gray-900 transition">Mac</a>
                    <a href="#" class="px-4 py-1.5 rounded-lg hover:bg-white/50 text-sm font-medium text-gray-500 hover:text-gray-900 transition">Android</a>
                </nav>

                <!-- Search & Action -->
                <div class="flex items-center gap-2 pr-2">
                    <button class="w-10 h-10 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-500 transition">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="#" class="bg-black text-white px-5 py-2.5 rounded-xl font-medium text-sm hover:bg-gray-800 transition">
                        Descargar App
                    </a>
                </div>
            </header>
        </div>
        <div class="h-32"></div>
    </section>

    <!-- OPCIÓN 5: DARK MODE PREMIUM -->
    <section class="demo-section bg-gray-900 py-10 rounded-xl mx-4">
        <div class="container mx-auto px-4 text-center">
            <span class="demo-label border border-white/20">OPCIÓN 5: DARK MODE PREMIUM</span>
        </div>

        <header class="bg-black/40 backdrop-blur-md border border-white/10 rounded-2xl mx-auto max-w-7xl">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <div class="flex items-center gap-3">
                        <div class="relative group">
                            <div class="absolute -inset-1 bg-gradient-to-r from-pink-600 to-purple-600 rounded-lg blur opacity-40 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
                            <div class="relative w-10 h-10 bg-black rounded-lg flex items-center justify-center border border-white/10">
                                <span class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-purple-500 text-xl">S</span>
                            </div>
                        </div>
                        <span class="text-white font-bold text-xl tracking-wide">SoftHub <span class="text-purple-500 text-xs align-top">PRO</span></span>
                    </div>

                    <!-- Nav -->
                    <nav class="hidden lg:flex items-center gap-8">
                        <a href="#" class="text-gray-300 hover:text-white font-medium text-sm transition flex items-center gap-2 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-purple-500 opacity-0 group-hover:opacity-100 transition mr-1"></span>
                            Destacados
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white font-medium text-sm transition flex items-center gap-2 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-purple-500 opacity-0 group-hover:opacity-100 transition mr-1"></span>
                            Juegos
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white font-medium text-sm transition flex items-center gap-2 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-purple-500 opacity-0 group-hover:opacity-100 transition mr-1"></span>
                            Utilidades
                        </a>
                    </nav>

                    <!-- Search Input Dark -->
                    <div class="hidden md:flex items-center bg-white/5 px-4 py-2 rounded-full border border-white/10 focus-within:border-purple-500/50 focus-within:bg-white/10 transition w-64">
                        <i class="fas fa-search text-gray-400 text-sm"></i>
                        <input type="text" placeholder="Buscar..." class="bg-transparent border-none focus:ring-0 text-white text-sm w-full ml-3 placeholder-gray-500">
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="far fa-bell text-lg"></i>
                        </a>
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-purple-500 to-pink-500 p-[2px] cursor-pointer">
                            <img src="https://ui-avatars.com/api/?name=User&background=000&color=fff" class="rounded-full w-full h-full" alt="Avatar">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Submenu Category Bar -->
            <div class="border-t border-white/5 py-2 px-6 flex items-center gap-6 overflow-x-auto scrollbar-hide">
                <a href="#" class="text-xs font-medium text-white bg-white/10 px-3 py-1 rounded-full whitespace-nowrap hover:bg-purple-600 hover:text-white transition">Todo</a>
                <a href="#" class="text-xs font-medium text-gray-400 hover:text-white whitespace-nowrap transition">Windows 11</a>
                <a href="#" class="text-xs font-medium text-gray-400 hover:text-white whitespace-nowrap transition">Adobe CC</a>
                <a href="#" class="text-xs font-medium text-gray-400 hover:text-white whitespace-nowrap transition">Office</a>
                <a href="#" class="text-xs font-medium text-gray-400 hover:text-white whitespace-nowrap transition">Seguridad</a>
                <a href="#" class="text-xs font-medium text-gray-400 hover:text-white whitespace-nowrap transition">Desarrollo</a>
            </div>
        </header>
    </section>

</body>
</html>
