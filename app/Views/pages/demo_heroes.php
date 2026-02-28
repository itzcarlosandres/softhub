<?php
// Config: Avoid footer/header double include since we'll use a clean layout for demos
// Ideally this would be inside main layout but we want to show 5 distinct heroes
// We'll mimic the main layout structure for each hero to show how it'd look in context.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo: Diseños de Hero Premium</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-outfit { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Navigation for Demos -->
    <div class="fixed top-0 left-0 right-0 z-[100] bg-gray-900 text-white p-4 shadow-xl flex justify-between items-center">
        <h1 class="font-bold text-lg">Galería de Diseños Hero Premium</h1>
        <a href="<?= url('latest') ?>" class="text-sm bg-white/10 px-3 py-1 rounded hover:bg-white/20 transition">Volver</a>
    </div>
    
    <div class="pt-20 pb-20 space-y-24 px-4 max-w-[1600px] mx-auto">

        <!-- DESIGN 1: GLASSMORPHISM & BLUR -->
        <section class="relative rounded-3xl overflow-hidden shadow-2xl bg-white group">
            <div class="absolute top-4 left-4 bg-black/80 text-white text-xs font-bold px-3 py-1 rounded-full z-20">OPCIÓN 1: GLASSMORPHISM & BLUR</div>
            
            <!-- Hero Container -->
            <div class="relative bg-gray-50 min-h-[500px] flex items-center justify-center overflow-hidden">
                <!-- Background Elements -->
                <div class="absolute inset-0 bg-white">
                    <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-blue-100/50 via-gray-50 to-white"></div>
                    <div class="absolute -top-[20%] -right-[10%] w-[600px] h-[600px] bg-blue-400/20 rounded-full blur-[100px] animate-pulse"></div>
                    <div class="absolute -bottom-[20%] -left-[10%] w-[500px] h-[500px] bg-purple-400/20 rounded-full blur-[100px]"></div>
                </div>

                <!-- Content -->
                <div class="relative z-10 container mx-auto px-6 text-center max-w-4xl">
                    <span class="inline-block py-1 px-3 rounded-full bg-blue-50 border border-blue-100 text-blue-600 text-xs font-bold tracking-wide uppercase mb-6 animate-fade-in-up">
                        Nueva Actualización v2.0
                    </span>
                    <h1 class="font-outfit text-5xl md:text-7xl font-extrabold text-gray-900 mb-6 leading-tight tracking-tight">
                        Descubre Software <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Premium & Verificado</span>
                    </h1>
                    <p class="text-xl text-gray-500 mb-10 max-w-2xl mx-auto leading-relaxed font-light">
                        Explora nuestra colección curada de herramientas esenciales. Actualizaciones diarias, descargas seguras y sin publicidad invasiva.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <button class="px-8 py-4 bg-gray-900 text-white rounded-xl font-bold hover:bg-black transition-all shadow-lg hover:shadow-xl hover:-translate-y-1 flex items-center gap-2">
                            Explorar Novedades
                            <i class="fas fa-arrow-right"></i>
                        </button>
                        <button class="px-8 py-4 bg-white text-gray-700 border border-gray-200 rounded-xl font-bold hover:bg-gray-50 transition-all hover:border-gray-300 flex items-center gap-2">
                            <i class="fas fa-play text-blue-600"></i>
                            Ver Demo
                        </button>
                    </div>

                    <!-- Floating Stats (Glass) -->
                    <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-4 max-w-3xl mx-auto">
                        <div class="bg-white/60 backdrop-blur-md p-4 rounded-2xl border border-white/50 shadow-sm">
                            <div class="text-2xl font-bold text-gray-900">500+</div>
                            <div class="text-xs text-gray-500 font-medium uppercase tracking-wider">Programas</div>
                        </div>
                        <div class="bg-white/60 backdrop-blur-md p-4 rounded-2xl border border-white/50 shadow-sm">
                            <div class="text-2xl font-bold text-blue-600">Diario</div>
                            <div class="text-xs text-gray-500 font-medium uppercase tracking-wider">Actualizaciones</div>
                        </div>
                        <div class="bg-white/60 backdrop-blur-md p-4 rounded-2xl border border-white/50 shadow-sm">
                            <div class="text-2xl font-bold text-gray-900">100%</div>
                            <div class="text-xs text-gray-500 font-medium uppercase tracking-wider">Seguro</div>
                        </div>
                        <div class="bg-white/60 backdrop-blur-md p-4 rounded-2xl border border-white/50 shadow-sm">
                            <div class="text-2xl font-bold text-purple-600">24/7</div>
                            <div class="text-xs text-gray-500 font-medium uppercase tracking-wider">Soporte</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- DESIGN 2: DARK MODE & NEON -->
        <section class="relative rounded-3xl overflow-hidden shadow-2xl bg-gray-900 group">
            <div class="absolute top-4 left-4 bg-white text-black text-xs font-bold px-3 py-1 rounded-full z-20">OPCIÓN 2: DARK MODE & NEON</div>
            
            <div class="relative bg-[#0B0F19] min-h-[500px] flex items-center overflow-hidden">
                <!-- Grid Background -->
                <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
                <div class="absolute inset-0" style="background-image: linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px); background-size: 50px 50px;"></div>
                
                <!-- Glows -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-500/10 rounded-full blur-[120px]"></div>

                <div class="container mx-auto px-6 relative z-10 flex flex-col md:flex-row items-center gap-12">
                    <div class="w-full md:w-1/2 text-left">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            <span class="text-sm font-mono text-green-400">Sistema Operativo v1.02 Online</span>
                        </div>
                        <h1 class="font-outfit text-5xl md:text-6xl font-black text-white mb-6 leading-tight">
                            El Futuro del <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">Software Libre</span>
                        </h1>
                        <p class="text-lg text-gray-400 mb-8 max-w-lg leading-relaxed border-l-2 border-gray-700 pl-4">
                            Accede a herramientas de desarrollo, diseño y productividad sin límites. Una plataforma construida para creadores.
                        </p>
                        
                        <div class="flex items-center gap-4">
                            <button class="px-8 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded font-bold hover:shadow-[0_0_20px_rgba(59,130,246,0.5)] transition-all">
                                Comenzar Ahora
                            </button>
                            <button class="px-8 py-3 bg-white/5 text-white border border-white/10 rounded font-bold hover:bg-white/10 transition-all backdrop-blur-sm">
                                Documentación
                            </button>
                        </div>
                    </div>
                    
                    <!-- Abstract 3D Representation -->
                    <div class="w-full md:w-1/2 flex justify-center relative">
                        <div class="relative w-80 h-80 bg-gradient-to-tr from-blue-600 to-purple-600 rounded-3xl rotate-12 shadow-[0_0_50px_rgba(37,99,235,0.4)] flex items-center justify-center transform hover:rotate-6 transition-all duration-700 border border-white/20">
                            <div class="absolute inset-2 bg-[#0B0F19]/90 backdrop-blur-xl rounded-2xl flex items-center justify-center">
                                <i class="fas fa-code text-6xl text-white opacity-90"></i>
                            </div>
                            <!-- Floating Elements -->
                            <div class="absolute -top-10 -right-10 w-24 h-24 bg-gray-800 rounded-xl shadow-xl flex items-center justify-center border border-gray-700 animate-bounce" style="animation-duration: 3s">
                                <i class="fab fa-python text-4xl text-yellow-400"></i>
                            </div>
                            <div class="absolute -bottom-5 -left-10 w-20 h-20 bg-gray-800 rounded-xl shadow-xl flex items-center justify-center border border-gray-700 animate-bounce" style="animation-duration: 4s; animation-delay: 1s;">
                                <i class="fab fa-js text-3xl text-yellow-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- DESIGN 3: MINIMALIST & CLEAN -->
        <section class="relative rounded-3xl overflow-hidden shadow-2xl bg-white group border border-gray-100">
            <div class="absolute top-4 left-4 bg-black text-white text-xs font-bold px-3 py-1 rounded z-20">OPCIÓN 3: MINIMALIST & CLEAN</div>
            
            <div class="bg-white min-h-[500px] flex items-center relative">
                <div class="container mx-auto px-6 max-w-5xl">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-center">
                        <div class="md:col-span-7">
                            <h1 class="font-outfit text-5xl md:text-7xl font-bold text-gray-900 mb-6 tracking-tighter">
                                Software.<br>Simplificado.
                            </h1>
                            <p class="text-xl text-gray-500 mb-8 font-light leading-relaxed">
                                Sin distracciones. Sin esperas. Solo las herramientas que necesitas para llevar tu trabajo al siguiente nivel. Diseño puro, rendimiento máximo.
                            </p>
                            
                            <form class="relative max-w-md">
                                <input type="text" placeholder="¿Qué buscas hoy?" class="w-full pl-6 pr-14 py-4 bg-gray-50 border-2 border-gray-100 rounded-full focus:outline-none focus:border-black focus:bg-white transition-all text-gray-900 placeholder-gray-400 font-medium">
                                <button type="button" class="absolute right-2 top-2 h-10 w-10 bg-black text-white rounded-full flex items-center justify-center hover:scale-105 transition-transform">
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                            </form>
                            
                            <div class="mt-8 flex items-center gap-6 text-sm text-gray-400">
                                <span>Trending:</span>
                                <a href="#" class="text-gray-600 font-medium underline decoration-gray-300 hover:decoration-black underline-offset-4 transition-all">Photoshop</a>
                                <a href="#" class="text-gray-600 font-medium underline decoration-gray-300 hover:decoration-black underline-offset-4 transition-all">VS Code</a>
                                <a href="#" class="text-gray-600 font-medium underline decoration-gray-300 hover:decoration-black underline-offset-4 transition-all">Premiere</a>
                            </div>
                        </div>
                        
                        <div class="md:col-span-5 relative h-full min-h-[300px] flex items-center justify-center bg-gray-50 rounded-2xl overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1481487484168-9b930d5b7d91?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Minimal" class="absolute inset-0 w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700 transform scale-105 hover:scale-100">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- DESIGN 4: ASYMMETRICAL & BOLD -->
        <section class="relative rounded-3xl overflow-hidden shadow-2xl bg-[#f0f0f0] group">
            <div class="absolute top-4 left-4 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded z-20">OPCIÓN 4: ASYMMETRICAL & BOLD</div>
            
            <div class="min-h-[500px] flex flex-col md:flex-row">
                <!-- Left Content (White) -->
                <div class="w-full md:w-1/2 bg-white p-12 md:p-20 flex flex-col justify-center">
                    <div class="w-12 h-1 bg-red-600 mb-8"></div>
                    <h1 class="font-outfit text-4xl md:text-6xl font-black text-gray-900 mb-6 uppercase tracking-wider">
                        Power<br>Your<br>Work flow
                    </h1>
                    <p class="text-gray-500 mb-8 text-lg">
                        La biblioteca definitiva para profesionales creativos.
                    </p>
                    <a href="#" class="group inline-flex items-center gap-3 font-bold text-gray-900 hover:text-red-600 transition-colors">
                        <span class="border-b-2 border-gray-900 group-hover:border-red-600 pb-1 transition-colors">Ver Catálogo Completo</span>
                        <i class="fas fa-long-arrow-alt-right transform group-hover:translate-x-2 transition-transform"></i>
                    </a>
                </div>
                
                <!-- Right Content (Image/Color) -->
                <div class="w-full md:w-1/2 bg-gray-900 relative overflow-hidden flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1550745165-9bc0b252726f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="Tech" class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-overlay">
                    <div class="relative z-10 text-white text-center p-8">
                        <i class="fas fa-bolt text-6xl text-yellow-500 mb-4 animate-pulse"></i>
                        <h3 class="text-2xl font-bold">Ultra Rápido</h3>
                        <p class="text-gray-400 mt-2">Servidores optimizados</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- DESIGN 5: CENTERED IMMERSIVE (VIDEO STYLE) -->
        <section class="relative rounded-3xl overflow-hidden shadow-2xl bg-black group h-[600px]">
            <div class="absolute top-4 left-4 bg-white/20 backdrop-blur text-white text-xs font-bold px-3 py-1 rounded z-20">OPCIÓN 5: CENTERED IMMERSIVE</div>
            
            <!-- Video Background Placeholder -->
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1519389950473-47ba0277781c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');"></div>
            <div class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"></div>
            
             <!-- Content -->
            <div class="relative z-10 h-full flex flex-col items-center justify-center text-center px-6">
                <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mb-8 border border-white/20 shadow-xl animate-bounce-slow">
                    <i class="fas fa-cube text-3xl text-white"></i>
                </div>
                
                <h1 class="font-outfit text-5xl md:text-7xl font-bold text-white mb-6 drop-shadow-xl tracking-tight">
                    SoftHub Premium
                </h1>
                
                <p class="text-xl text-gray-200 mb-10 max-w-2xl font-light drop-shadow-md">
                    Experimenta la nueva era de descargas digitales. Diseño intuitivo, velocidad inigualable y la seguridad que mereces.
                </p>
                
                <!-- Search Floating -->
                <div class="w-full max-w-2xl relative group">
                    <div class="absolute inset-0 bg-white/20 rounded-2xl blur-xl group-hover:bg-white/30 transition-all"></div>
                    <div class="relative bg-white/10 backdrop-blur-xl border border-white/30 rounded-2xl p-2 flex items-center shadow-2xl">
                        <i class="fas fa-search text-white/70 text-xl ml-4"></i>
                        <input type="text" placeholder="Busca 'Adobe Photoshop 2024'..." class="w-full bg-transparent border-none text-white placeholder-white/50 text-lg px-4 py-3 focus:outline-none focus:ring-0">
                        <button class="bg-white text-black font-bold px-6 py-3 rounded-xl hover:bg-gray-100 transition-colors">
                            Buscar
                        </button>
                    </div>
                </div>
                
                <div class="mt-8 flex gap-6 text-white/60 text-sm font-medium">
                    <span class="flex items-center gap-2"><i class="fas fa-check text-green-400"></i> Verificado</span>
                    <span class="flex items-center gap-2"><i class="fas fa-check text-green-400"></i> Seguro</span>
                    <span class="flex items-center gap-2"><i class="fas fa-check text-green-400"></i> Rápido</span>
                </div>
            </div>
        </section>

    </div>

    <!-- Instructions Footer -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t p-4 z-50 flex justify-center items-center shadow-lg">
        <p class="text-gray-600 text-sm font-medium mr-4">
            Selecciona el diseño que más te guste para implementarlo.
        </p>
    </div>

</body>
</html>
