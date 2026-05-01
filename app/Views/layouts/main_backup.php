<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- SEO Meta Tags -->
    <title><?= $title ?? seo_site_title() ?></title>
    <meta name="description" content="<?= $description ?? seo_site_description() ?>">
    <meta name="keywords" content="<?= $keywords ?? seo_site_keywords() ?>">
    <meta name="author" content="<?= seo_site_title() ?>">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= url($_SERVER['REQUEST_URI'] ?? '') ?>">
    <meta property="og:title" content="<?= $title ?? seo_site_title() ?>">
    <meta property="og:description" content="<?= $description ?? seo_site_description() ?>">
    <meta property="og:image" content="<?= url('assets/images/og-image.jpg') ?>">
    <meta property="og:site_name" content="<?= seo_site_title() ?>">
    <meta property="og:locale" content="es_ES">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?= url($_SERVER['REQUEST_URI'] ?? '') ?>">
    <meta name="twitter:title" content="<?= $title ?? seo_site_title() ?>">
    <meta name="twitter:description" content="<?= $description ?? seo_site_description() ?>">
    <meta name="twitter:image" content="<?= url('assets/images/twitter-card.jpg') ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?= url($_SERVER['REQUEST_URI'] ?? '') ?>">
    
    <!-- Favicon -->
    <?php
    $settingsModel = new \App\Models\SiteSetting();
    $favicon = $settingsModel->get('site_favicon');
    ?>
    <?php if ($favicon): ?>
        <link rel="icon" type="image/x-icon" href="<?= url($favicon) ?>">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= url($favicon) ?>">
    <?php else: ?>
        <link rel="icon" type="image/x-icon" href="<?= url('favicon.ico') ?>">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= url('apple-touch-icon.png') ?>">
    <?php endif; ?>
    
    <!-- PWA Configuration -->
    <link rel="manifest" href="<?= url('manifest.json') ?>">
    <meta name="theme-color" content="#0369a1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="<?= seo_site_title() ?>">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="<?= seo_site_title() ?>">
    <meta name="msapplication-TileColor" content="#0369a1">
    <meta name="msapplication-tap-highlight" content="no">
    
    <!-- Preconnect for Performance -->
    <link rel="preconnect" href="https://cdn.tailwindcss.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- DNS Prefetch -->
    <link rel="dns-prefetch" href="https://cdn.tailwindcss.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    
    <!-- Tailwind CSS (Debe ser síncrono para evitar FOUC) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': {
                            50: '#e0f2fe',
                            100: '#bae6fd',
                            200: '#7dd3fc',
                            300: '#38bdf8',
                            400: '#0ea5e9',
                            500: '#0284c7',
                            600: '#0369a1',
                            700: '#075985',
                            800: '#0c4a6e',
                            900: '#082f49',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome (Async Loading) -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></noscript>
    <style>
        /* Optimized Google Fonts - Solo pesos necesarios */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        /* ========== REEMPLAZO GLOBAL DE COLORES PÚRPURA A AZUL PASTEL ========== */
        
        /* Backgrounds púrpura -> azul */
        .bg-purple-50 { background-color: #e0f2fe !important; }
        .bg-purple-100 { background-color: #bae6fd !important; }
        .bg-purple-200 { background-color: #7dd3fc !important; }
        .bg-purple-300 { background-color: #38bdf8 !important; }
        .bg-purple-400 { background-color: #0ea5e9 !important; }
        .bg-purple-500 { background-color: #0284c7 !important; }
        .bg-purple-600 { background-color: #0369a1 !important; }
        .bg-purple-700 { background-color: #075985 !important; }
        .bg-purple-800 { background-color: #0c4a6e !important; }
        .bg-purple-900 { background-color: #082f49 !important; }
        
        /* Text púrpura -> azul */
        .text-purple-50 { color: #e0f2fe !important; }
        .text-purple-100 { color: #bae6fd !important; }
        .text-purple-200 { color: #7dd3fc !important; }
        .text-purple-300 { color: #38bdf8 !important; }
        .text-purple-400 { color: #0ea5e9 !important; }
        .text-purple-500 { color: #0284c7 !important; }
        .text-purple-600 { color: #0369a1 !important; }
        .text-purple-700 { color: #075985 !important; }
        .text-purple-800 { color: #0c4a6e !important; }
        .text-purple-900 { color: #082f49 !important; }
        
        /* Border púrpura -> azul */
        .border-purple-50 { border-color: #e0f2fe !important; }
        .border-purple-100 { border-color: #bae6fd !important; }
        .border-purple-200 { border-color: #7dd3fc !important; }
        .border-purple-300 { border-color: #38bdf8 !important; }
        .border-purple-400 { border-color: #0ea5e9 !important; }
        .border-purple-500 { border-color: #0284c7 !important; }
        .border-purple-600 { border-color: #0369a1 !important; }
        .border-purple-700 { border-color: #075985 !important; }
        .border-purple-800 { border-color: #0c4a6e !important; }
        .border-purple-900 { border-color: #082f49 !important; }
        
        /* Ring púrpura -> azul */
        .ring-purple-50 { --tw-ring-color: #e0f2fe !important; }
        .ring-purple-100 { --tw-ring-color: #bae6fd !important; }
        .ring-purple-200 { --tw-ring-color: #7dd3fc !important; }
        .ring-purple-300 { --tw-ring-color: #38bdf8 !important; }
        .ring-purple-400 { --tw-ring-color: #0ea5e9 !important; }
        .ring-purple-500 { --tw-ring-color: #0284c7 !important; }
        .ring-purple-600 { --tw-ring-color: #0369a1 !important; }
        .ring-purple-700 { --tw-ring-color: #075985 !important; }
        .ring-purple-800 { --tw-ring-color: #0c4a6e !important; }
        .ring-purple-900 { --tw-ring-color: #082f49 !important; }
        
        /* Gradientes púrpura -> azul */
        .from-purple-400 { --tw-gradient-from: #0ea5e9 !important; }
        .from-purple-500 { --tw-gradient-from: #0284c7 !important; }
        .from-purple-600 { --tw-gradient-from: #0369a1 !important; }
        .from-purple-700 { --tw-gradient-from: #075985 !important; }
        
        .to-purple-400 { --tw-gradient-to: #0ea5e9 !important; }
        .to-purple-500 { --tw-gradient-to: #0284c7 !important; }
        .to-purple-600 { --tw-gradient-to: #0369a1 !important; }
        .to-purple-700 { --tw-gradient-to: #075985 !important; }
        
        .via-purple-400 { --tw-gradient-via: #0ea5e9 !important; }
        .via-purple-500 { --tw-gradient-via: #0284c7 !important; }
        .via-purple-600 { --tw-gradient-via: #0369a1 !important; }
        
        /* Hover states púrpura -> azul */
        .hover\:bg-purple-50:hover { background-color: #e0f2fe !important; }
        .hover\:bg-purple-100:hover { background-color: #bae6fd !important; }
        .hover\:bg-purple-600:hover { background-color: #0369a1 !important; }
        .hover\:bg-purple-700:hover { background-color: #075985 !important; }
        
        .hover\:text-purple-200:hover { color: #7dd3fc !important; }
        .hover\:text-purple-400:hover { color: #0ea5e9 !important; }
        .hover\:text-purple-600:hover { color: #0369a1 !important; }
        
        .hover\:border-purple-300:hover { border-color: #38bdf8 !important; }
        
        /* Focus states púrpura -> azul */
        .focus\:ring-purple-500:focus { --tw-ring-color: #0284c7 !important; }
        .focus\:border-purple-500:focus { border-color: #0284c7 !important; }
        
        /* Animated Gradient Background */
        .gradient-bg {
            background: linear-gradient(-45deg, #0ea5e9, #0284c7, #38bdf8, #06b6d4);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            position: relative;
            overflow: hidden;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Glassmorphism Effect */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(14, 165, 233, 0.37);
        }
        
        /* Enhanced Card Hover */
        .card-hover {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
        }
        
        .card-hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: inherit;
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(6, 182, 212, 0.1));
            opacity: 0;
            transition: opacity 0.4s ease;
            pointer-events: none;
        }
        
        .card-hover:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px rgba(14, 165, 233, 0.3);
        }
        
        .card-hover:hover::before {
            opacity: 1;
        }
        
        /* Button Animations */
        .btn-primary {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn-primary:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(14, 165, 233, 0.4);
        }
        
        /* Text Gradient */
        .text-gradient {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Category Card Glow */
        .category-card {
            transition: all 0.3s ease;
            position: relative;
        }
        
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(14, 165, 233, 0.2);
        }
        
        .category-card::after {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #0ea5e9, #0284c7, #38bdf8, #06b6d4);
            border-radius: inherit;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
            background-size: 400% 400%;
            animation: gradientShift 3s ease infinite;
        }
        
        .category-card:hover::after {
            opacity: 0.7;
        }
        
        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Neon Glow */
        .neon-glow {
            text-shadow: 0 0 10px rgba(14, 165, 233, 0.5),
                         0 0 20px rgba(14, 165, 233, 0.3),
                         0 0 30px rgba(14, 165, 233, 0.2);
        }
        
        /* Estilos para contenido HTML generado por IA (TinyMCE) */
        .prose {
            line-height: 1.75;
        }
        
        .prose p {
            margin-bottom: 1.25rem;
            color: #374151;
        }
        
        .prose strong {
            font-weight: 600;
            color: #1f2937;
        }
        
        .prose h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            margin-top: 2rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .prose h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }
        
        .prose ul {
            list-style-type: disc;
            margin-left: 1.5rem;
            margin-bottom: 1.25rem;
        }
        
        .prose ol {
            list-style-type: decimal;
            margin-left: 1.5rem;
            margin-bottom: 1.25rem;
        }
        
        .prose li {
            margin-bottom: 0.5rem;
            color: #4b5563;
        }
        
        .prose li strong {
            color: #0369a1;
        }
        
        .prose a {
            color: #0369a1;
            text-decoration: underline;
        }
        
        .prose a:hover {
            color: #0284c7;
        }
        
        /* 📱 OPTIMIZACIONES MÓVIL */
        
        /* Touch targets mínimos 44x44px */
        @media (max-width: 768px) {
            button, a.btn, input[type="submit"] {
                min-height: 44px;
                min-width: 44px;
            }
            
            /* Títulos responsive */
            h1 {
                font-size: 1.875rem !important; /* 30px */
            }
            
            h2 {
                font-size: 1.5rem !important; /* 24px */
            }
            
            h3 {
                font-size: 1.25rem !important; /* 20px */
            }
            
            /* Padding reducido en móvil */
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            /* Cards más compactas */
            .card {
                padding: 1rem;
            }
            
            /* Botones full-width en móvil */
            .btn-mobile-full {
                width: 100%;
            }
        }
        
        /* Scroll suave en toda la página */
        html {
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Prevenir zoom en inputs en iOS */
        @media screen and (max-width: 768px) {
            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="search"],
            textarea,
            select {
                font-size: 16px !important;
            }
        }
        
        /* Mejorar tap highlight */
        * {
            -webkit-tap-highlight-color: rgba(3, 105, 161, 0.2);
        }
        
        /* Ocultar scrollbar horizontal innecesaria */
        body {
            overflow-x: hidden;
        }
        
        /* Ocultar scrollbar pero mantener funcionalidad */
        .scrollbar-hide {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        
        .scrollbar-hide::-webkit-scrollbar {
            display: none;  /* Chrome, Safari and Opera */
        }
        
        /* Lazy loading placeholder */
        img[data-src] {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
    
    <!-- Structured Data (JSON-LD) for SEO -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "<?= seo_site_title() ?>",
        "url": "<?= url() ?>",
        "description": "<?= seo_site_description() ?>",
        "potentialAction": {
            "@type": "SearchAction",
            "target": {
                "@type": "EntryPoint",
                "urlTemplate": "<?= url('search?q={search_term_string}') ?>"
            },
            "query-input": "required name=search_term_string"
        },
        "publisher": {
            "@type": "Organization",
            "name": "<?= seo_site_title() ?>",
            "url": "<?= url() ?>",
            "logo": {
                "@type": "ImageObject",
                "url": "<?= url('assets/images/logo.png') ?>"
            }
        }
    }
    </script>
    
    <?php if (isset($software)): ?>
    <!-- Software Product Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "SoftwareApplication",
        "name": "<?= htmlspecialchars($software['name'] ?? '') ?>",
        "description": "<?= htmlspecialchars($software['short_description'] ?? '') ?>",
        "applicationCategory": "<?= htmlspecialchars($software['category_name'] ?? 'Software') ?>",
        "operatingSystem": "<?= htmlspecialchars($software['operating_system'] ?? 'Windows, Mac, Linux') ?>",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "USD"
        },
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "<?= max(1, min(5, floatval($software['rating'] ?? 5))) ?>",
            "ratingCount": "<?= max(1, intval($software['rating_count'] ?? 1)) ?>",
            "bestRating": "5",
            "worstRating": "1"
        },
        "softwareVersion": "<?= htmlspecialchars($software['version'] ?? '1.0') ?>",
        "author": {
            "@type": "Organization",
            "name": "<?= htmlspecialchars($software['developer'] ?? 'Unknown') ?>"
        }
    }
    </script>
    <?php endif; ?>
</head>
<body class="bg-gray-50">
    <!-- Header Responsive -->
    <header class="sticky top-0 z-50 bg-white border-b border-blue-200 shadow-sm">
        <div class="container mx-auto px-3 sm:px-4">
            <div class="flex items-center justify-between h-14 sm:h-16 lg:h-20 gap-2 sm:gap-4">
                <?php
                $logo = $settingsModel->get('site_logo');
                $siteName = $settingsModel->get('site_name', 'SoftHub');
                $logoHeight = $settingsModel->get('logo_height', 48);
                ?>
                
                <!-- Menú Hamburguesa (Móvil) -->
                <button id="mobile-menu-button" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition flex-shrink-0">
                    <i class="fas fa-bars text-gray-700 text-lg sm:text-xl"></i>
                </button>
                
                <!-- Logo Container (Responsive) -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="<?= url() ?>" class="block">
                        <?php if ($logo): ?>
                            <img src="<?= url($logo) ?>" 
                                 alt="<?= htmlspecialchars($siteName) ?>" 
                                 class="h-10 sm:h-12 lg:h-14 w-auto object-contain max-w-[160px] sm:max-w-[180px] lg:max-w-[220px]"
                                 style="max-height: <?= min($logoHeight, 56) ?>px;">
                        <?php else: ?>
                            <div class="flex items-center space-x-2">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-download text-white text-base sm:text-xl"></i>
                                </div>
                                <span class="text-lg sm:text-xl font-bold bg-gradient-to-r from-blue-400 to-cyan-500 bg-clip-text text-transparent hidden sm:inline"><?= htmlspecialchars($siteName) ?></span>
                            </div>
                        <?php endif; ?>
                    </a>
                </div>
                
                <!-- Barra de Búsqueda (Desktop) -->
                <div class="flex-1 hidden md:block max-w-2xl mx-auto">
                    <div class="relative">
                        <input type="text" 
                               id="search-input"
                               placeholder="Buscar programas, juegos..." 
                               class="w-full px-4 py-2.5 pl-11 pr-10 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-gray-50 hover:bg-white"
                               autocomplete="off">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        
                        <!-- Botón limpiar búsqueda -->
                        <button id="clear-search" class="hidden absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                        
                        <!-- Resultados de búsqueda -->
                        <div id="search-results" class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-2xl border border-gray-200 max-h-96 overflow-y-auto z-50">
                            <!-- Los resultados se cargan aquí dinámicamente -->
                        </div>
                    </div>
                </div>

                <!-- Botón de búsqueda móvil -->
                <button id="mobile-search-button" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition flex-shrink-0">
                    <i class="fas fa-search text-gray-700 text-lg sm:text-xl"></i>
                </button>
                
                <!-- Nav Desktop -->
                <nav class="hidden lg:flex items-center space-x-6 flex-shrink-0">
                    <a href="<?= url('categories') ?>" class="text-gray-600 hover:text-blue-600 font-medium transition flex items-center gap-2">
                        <i class="fas fa-th-large"></i>
                        <span>Categorías</span>
                    </a>
                    <a href="<?= url('software') ?>" class="text-gray-600 hover:text-blue-600 font-medium transition flex items-center gap-2">
                        <i class="fas fa-box-open"></i>
                        <span>Programas</span>
                    </a>
                </nav>
            </div>
        </div>
    </header>
        
        <!-- Menú Móvil (Slide-in desde la izquierda) -->
        <div id="mobile-menu" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden lg:hidden">
            <div id="mobile-menu-panel" class="fixed left-0 top-0 bottom-0 w-64 bg-white shadow-2xl transform -translate-x-full transition-transform duration-300">
                <!-- Header del menú móvil -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200">
                    <span class="text-xl font-bold text-gray-900">Menú</span>
                    <button id="mobile-menu-close" class="p-2 rounded-lg hover:bg-gray-100 transition">
                        <i class="fas fa-times text-gray-700 text-xl"></i>
                    </button>
                </div>
                
                <!-- Links del menú móvil -->
                <nav class="p-4 space-y-2">
                    <a href="<?= url() ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition">
                        <i class="fas fa-home text-lg w-6"></i>
                        <span class="font-medium">Inicio</span>
                    </a>
                    <a href="<?= url('categories') ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition">
                        <i class="fas fa-th-large text-lg w-6"></i>
                        <span class="font-medium">Categorías</span>
                    </a>
                    <a href="<?= url('software') ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition">
                        <i class="fas fa-box-open text-lg w-6"></i>
                        <span class="font-medium">Programas</span>
                    </a>
                </nav>
            </div>
        </div>
    </header>
    
    <!-- Modal de Búsqueda Móvil -->
    <div id="mobile-search-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden md:hidden">
        <div id="mobile-search-panel" class="fixed top-0 left-0 right-0 bg-white shadow-2xl transform -translate-y-full transition-transform duration-300">
            <!-- Header del modal de búsqueda -->
            <div class="flex items-center gap-3 p-4 border-b border-gray-200">
                <button id="mobile-search-close" class="p-2 rounded-lg hover:bg-gray-100 transition">
                    <i class="fas fa-arrow-left text-gray-700 text-lg"></i>
                </button>
                
                <div class="flex-1 relative">
                    <input type="text" 
                           id="mobile-search-input"
                           placeholder="Buscar programas, juegos..." 
                           class="w-full px-4 py-2.5 pl-11 pr-10 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-gray-50"
                           autocomplete="off">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    
                    <!-- Botón limpiar búsqueda móvil -->
                    <button id="mobile-clear-search" class="hidden absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <!-- Resultados de búsqueda móvil -->
            <div id="mobile-search-results" class="overflow-y-auto" style="max-height: calc(100vh - 80px);">
                <div class="p-4 text-center text-gray-500">
                    <i class="fas fa-search text-4xl mb-3 text-gray-300"></i>
                    <p>Escribe para buscar programas</p>
                </div>
            </div>
        </div>
    </div>
    </header>
    
    <script>
    // Menú móvil
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuPanel = document.getElementById('mobile-menu-panel');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    
    function openMobileMenu() {
        mobileMenu.classList.remove('hidden');
        setTimeout(() => {
            mobileMenuPanel.classList.remove('-translate-x-full');
        }, 10);
        document.body.style.overflow = 'hidden';
    }
    
    function closeMobileMenu() {
        mobileMenuPanel.classList.add('-translate-x-full');
        setTimeout(() => {
            mobileMenu.classList.add('hidden');
            document.body.style.overflow = '';
        }, 300);
    }
    
    mobileMenuButton.addEventListener('click', openMobileMenu);
    mobileMenuClose.addEventListener('click', closeMobileMenu);
    
    // Cerrar al hacer click fuera del menú
    mobileMenu.addEventListener('click', (e) => {
        if (e.target === mobileMenu) {
            closeMobileMenu();
        }
    });
    
    // Cerrar con tecla ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
            closeMobileMenu();
        }
    });
    
    // 🔍 BÚSQUEDA MÓVIL
    const mobileSearchButton = document.getElementById('mobile-search-button');
    const mobileSearchModal = document.getElementById('mobile-search-modal');
    const mobileSearchPanel = document.getElementById('mobile-search-panel');
    const mobileSearchClose = document.getElementById('mobile-search-close');
    const mobileSearchInput = document.getElementById('mobile-search-input');
    const mobileSearchResults = document.getElementById('mobile-search-results');
    const mobileClearSearch = document.getElementById('mobile-clear-search');
    let mobileSearchTimeout;
    
    function openMobileSearch() {
        mobileSearchModal.classList.remove('hidden');
        setTimeout(() => {
            mobileSearchPanel.classList.remove('-translate-y-full');
            mobileSearchInput.focus();
        }, 10);
        document.body.style.overflow = 'hidden';
    }
    
    function closeMobileSearch() {
        mobileSearchPanel.classList.add('-translate-y-full');
        setTimeout(() => {
            mobileSearchModal.classList.add('hidden');
            document.body.style.overflow = '';
            mobileSearchInput.value = '';
            mobileClearSearch.classList.add('hidden');
            mobileSearchResults.innerHTML = '<div class="p-4 text-center text-gray-500"><i class="fas fa-search text-4xl mb-3 text-gray-300"></i><p>Escribe para buscar programas</p></div>';
        }, 300);
    }
    
    mobileSearchButton.addEventListener('click', openMobileSearch);
    mobileSearchClose.addEventListener('click', closeMobileSearch);
    
    // Cerrar al hacer click fuera
    mobileSearchModal.addEventListener('click', (e) => {
        if (e.target === mobileSearchModal) {
            closeMobileSearch();
        }
    });
    
    // Cerrar con ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !mobileSearchModal.classList.contains('hidden')) {
            closeMobileSearch();
        }
    });
    
    // Búsqueda en tiempo real (móvil)
    if (mobileSearchInput) {
        mobileSearchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            if (query.length > 0) {
                mobileClearSearch.classList.remove('hidden');
            } else {
                mobileClearSearch.classList.add('hidden');
                mobileSearchResults.innerHTML = '<div class="p-4 text-center text-gray-500"><i class="fas fa-search text-4xl mb-3 text-gray-300"></i><p>Escribe para buscar programas</p></div>';
                return;
            }
            
            clearTimeout(mobileSearchTimeout);
            mobileSearchTimeout = setTimeout(() => {
                performMobileSearch(query);
            }, 300);
        });
        
        mobileClearSearch.addEventListener('click', function() {
            mobileSearchInput.value = '';
            mobileClearSearch.classList.add('hidden');
            mobileSearchResults.innerHTML = '<div class="p-4 text-center text-gray-500"><i class="fas fa-search text-4xl mb-3 text-gray-300"></i><p>Escribe para buscar programas</p></div>';
            mobileSearchInput.focus();
        });
    }
    
    function performMobileSearch(query) {
        if (query.length < 2) {
            mobileSearchResults.innerHTML = '<div class="p-4 text-center text-gray-500"><i class="fas fa-search text-4xl mb-3 text-gray-300"></i><p>Escribe al menos 2 caracteres</p></div>';
            return;
        }
        
        mobileSearchResults.innerHTML = '<div class="p-4 text-center text-gray-500"><i class="fas fa-spinner fa-spin mr-2"></i>Buscando...</div>';
        
        fetch(`<?= url('api/search') ?>?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                displayMobileSearchResults(data);
            })
            .catch(error => {
                console.error('Error:', error);
                mobileSearchResults.innerHTML = '<div class="p-4 text-center text-red-500"><i class="fas fa-exclamation-circle mr-2"></i>Error en la búsqueda</div>';
            });
    }
    
    function displayMobileSearchResults(results) {
        if (results.length === 0) {
            mobileSearchResults.innerHTML = '<div class="p-4 text-center text-gray-500"><i class="fas fa-search text-4xl mb-3 text-gray-300"></i><p>No se encontraron resultados</p></div>';
            return;
        }
        
        const baseUrl = '<?= url('') ?>';
        
        let html = '<div class="divide-y divide-gray-100">';
        results.forEach(software => {
            const imageUrl = software.icon ? `${baseUrl}/${software.icon}` : '';
            const softwareUrl = `${baseUrl}/software/${software.slug}`;
            
            html += `
                <a href="${softwareUrl}" class="flex items-center gap-3 p-4 hover:bg-blue-50 transition group">
                    ${software.icon ? 
                        `<img src="${imageUrl}" alt="${software.name}" class="w-12 h-12 object-contain flex-shrink-0" loading="lazy">` :
                        `<div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-box text-white"></i>
                        </div>`
                    }
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-gray-900 group-hover:text-blue-600 truncate">${software.name}</div>
                        <div class="text-xs text-gray-500 truncate">${software.category_name || 'Software'}</div>
                    </div>
                    <div class="text-xs text-gray-400 flex-shrink-0">
                        <i class="fas fa-download mr-1"></i>${software.downloads || 0}
                    </div>
                </a>
            `;
        });
        html += '</div>';
        
        // Agregar link para ver todos
        html += `
            <div class="border-t border-gray-200 p-4 text-center bg-gray-50">
                <a href="<?= url('search') ?>?q=${encodeURIComponent(mobileSearchInput.value)}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">
                    Ver todos los resultados <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        `;
        
        mobileSearchResults.innerHTML = html;
    }
    
    
    // 🔍 BÚSQUEDA AVANZADA
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');
    const clearSearch = document.getElementById('clear-search');
    let searchTimeout;
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            // Mostrar/ocultar botón de limpiar
            if (query.length > 0) {
                clearSearch.classList.remove('hidden');
            } else {
                clearSearch.classList.add('hidden');
                searchResults.classList.add('hidden');
                return;
            }
            
            // Debounce: esperar 300ms después de que el usuario deje de escribir
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch(query);
            }, 300);
        });
        
        // Limpiar búsqueda
        clearSearch.addEventListener('click', function() {
            searchInput.value = '';
            searchResults.classList.add('hidden');
            clearSearch.classList.add('hidden');
            searchInput.focus();
        });
        
        // Cerrar resultados al hacer click fuera
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });
    }
    
    function performSearch(query) {
        if (query.length < 2) {
            searchResults.classList.add('hidden');
            return;
        }
        
        // Mostrar loading
        searchResults.innerHTML = '<div class="p-4 text-center text-gray-500"><i class="fas fa-spinner fa-spin mr-2"></i>Buscando...</div>';
        searchResults.classList.remove('hidden');
        
        // Realizar búsqueda AJAX
        fetch(`<?= url('api/search') ?>?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                displaySearchResults(data);
            })
            .catch(error => {
                console.error('Error:', error);
                searchResults.innerHTML = '<div class="p-4 text-center text-red-500"><i class="fas fa-exclamation-circle mr-2"></i>Error en la búsqueda</div>';
            });
    }
    
    function displaySearchResults(results) {
        if (results.length === 0) {
            searchResults.innerHTML = '<div class="p-4 text-center text-gray-500"><i class="fas fa-search mr-2"></i>No se encontraron resultados</div>';
            return;
        }
        
        const baseUrl = '<?= url('') ?>';
        
        let html = '<div class="p-2">';
        results.forEach(software => {
            const imageUrl = software.icon ? `${baseUrl}/${software.icon}` : '';
            const softwareUrl = `${baseUrl}/software/${software.slug}`;
            
            html += `
                <a href="${softwareUrl}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 transition group">
                    ${software.icon ? 
                        `<img src="${imageUrl}" alt="${software.name}" class="w-10 h-10 object-contain">` :
                        `<div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-box text-white"></i>
                        </div>`
                    }
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-gray-900 group-hover:text-blue-600 truncate">${software.name}</div>
                        <div class="text-xs text-gray-500 truncate">${software.category_name || 'Software'}</div>
                    </div>
                    <div class="text-xs text-gray-400">
                        <i class="fas fa-download mr-1"></i>${software.downloads || 0}
                    </div>
                </a>
            `;
        });
        html += '</div>';
        
        // Agregar link para ver todos los resultados
        html += `
            <div class="border-t border-gray-200 p-3 text-center">
                <a href="<?= url('search') ?>?q=${encodeURIComponent(searchInput.value)}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">
                    Ver todos los resultados <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        `;
        
        searchResults.innerHTML = html;
    }
    </script>

    <!-- Main Content -->
    <main>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="container mx-auto px-4 mt-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline"><?= $_SESSION['success'] ?></span>
                </div>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="container mx-auto px-4 mt-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline"><?= $_SESSION['error'] ?></span>
                </div>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-20">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4 flex items-center space-x-2">
                        <i class="fas fa-download"></i>
                        <span>SoftHub</span>
                    </h3>
                    <p class="text-gray-400">Tu fuente confiable para descargar software gratis y seguro.</p>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Enlaces Rápidos</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="<?= url() ?>" class="hover:text-white transition">Inicio</a></li>
                        <li><a href="<?= url('categories') ?>" class="hover:text-white transition">Categorías</a></li>
                        <li><a href="<?= url('software') ?>" class="hover:text-white transition">Todos los Programas</a></li>
                        <li><a href="<?= url('about') ?>" class="hover:text-white transition">Acerca de</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="<?= url('terms') ?>" class="hover:text-white transition">Términos y Condiciones</a></li>
                        <li><a href="<?= url('privacy') ?>" class="hover:text-white transition">Política de Privacidad</a></li>
                    </ul>
                </div>
                
                
                <div>
                    <h4 class="font-semibold mb-4">Categorías Populares</h4>
                    <ul class="space-y-2 text-gray-400">
                        <?php
                        // Obtener categorías populares para el footer
                        $db = \App\Database::getInstance()->getConnection();
                        $stmt = $db->query("
                            SELECT c.name, c.slug 
                            FROM categories c 
                            LEFT JOIN software s ON c.id = s.category_id 
                            GROUP BY c.id 
                            ORDER BY COUNT(s.id) DESC 
                            LIMIT 4
                        ");
                        $footerCategories = $stmt->fetchAll();
                        
                        if (!empty($footerCategories)):
                            foreach ($footerCategories as $cat):
                        ?>
                            <li><a href="<?= url('category/' . htmlspecialchars($cat['slug'])) ?>" class="hover:text-white transition"><?= htmlspecialchars($cat['name']) ?></a></li>
                        <?php 
                            endforeach;
                        else:
                            // Si no hay categorías, mostrar enlace a todas las categorías
                        ?>
                            <li><a href="<?= url('categories') ?>" class="hover:text-white transition">Ver todas las categorías</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Síguenos</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-2xl hover:text-purple-400 transition"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-2xl hover:text-purple-400 transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-2xl hover:text-purple-400 transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-2xl hover:text-purple-400 transition"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; <?= date('Y') ?> SoftHub. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
    
    <!-- PWA Install Button (Hidden by default) -->
    <button id="install-pwa-button" 
            style="display: none;"
            class="fixed bottom-6 right-6 bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-6 py-3 rounded-full shadow-2xl hover:shadow-3xl transition-all duration-300 flex items-center gap-3 z-50 animate-bounce">
        <i class="fas fa-download text-xl"></i>
        <span class="font-semibold">Instalar App</span>
    </button>
    
    
    <!-- PWA Script -->
    <script src="<?= url('assets/js/pwa.js') ?>"></script>
    
    <!-- Lazy Loading Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lazy loading para todas las imágenes con data-src
        const images = document.querySelectorAll('img[data-src]');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.add('loaded');
                        img.removeAttribute('data-src');
                        observer.unobserve(img);
                    }
                });
            }, {
                rootMargin: '50px'
            });
            
            images.forEach(img => imageObserver.observe(img));
        } else {
            // Fallback para navegadores antiguos
            images.forEach(img => {
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
            });
        }
    });
    </script>
    
    <style>
    img[data-src] {
        opacity: 0;
        transition: opacity 0.3s ease;
        background: linear-gradient(90deg, #e0f2fe 25%, #bae6fd 50%, #e0f2fe 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }

    img[data-src].loaded {
        opacity: 1;
    }
    
    @keyframes shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
    </style>
</body>
</html>