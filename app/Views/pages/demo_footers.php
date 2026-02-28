<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo de Footers Premium - SoftHub</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#8b5cf6',
                    },
                    fontFamily: {
                        'outfit': ['Outfit', 'sans-serif'],
                        'inter': ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Header Simulado -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-cube text-white text-sm"></i>
                </div>
                <span class="font-bold text-xl">SoftHub</span>
            </div>
            <a href="<?= url('/') ?>" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center gap-1">
                <i class="fas fa-arrow-left"></i> Volver al Inicio
            </a>
        </div>
    </header>

    <div class="container mx-auto px-4 py-12 text-center">
        <h1 class="text-4xl font-extrabold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600">Galería de Diseños de Footer</h1>
        <p class="text-gray-600 max-w-2xl mx-auto mb-12">Explora estos 5 diseños exclusivos. Elige el que mejor se adapte a la identidad de SoftHub. Cada footer es completamente responsivo y optimizado.</p>
    </div>

    <!-- OPCIÓN 1: Dark Glassmorphism -->
    <div class="relative py-8 bg-gray-50 border-t border-b border-gray-200">
        <div class="absolute top-0 left-0 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-br-lg">OPCIÓN 1: Dark Glassmorphism</div>
        
        <footer class="bg-[#0f172a] text-white pt-16 pb-8 relative overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 opacity-20 pointer-events-none">
                <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-blue-600 blur-[100px]"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-purple-600 blur-[100px]"></div>
            </div>

            <div class="container mx-auto px-6 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 mb-16">
                    <!-- Brand Column -->
                    <div class="lg:col-span-4 space-y-6">
                        <a href="#" class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/10">
                                <i class="fas fa-cube text-blue-400 text-lg"></i>
                            </div>
                            <span class="text-2xl font-bold font-outfit tracking-tight">SoftHub</span>
                        </a>
                        <p class="text-gray-400 leading-relaxed max-w-sm">
                            Descarga software verificado y seguro. La plataforma líder para profesionales y creativos que buscan herramientas de calidad.
                        </p>
                        <div class="flex items-center gap-4">
                            <a href="#" class="w-10 h-10 rounded-full bg-white/5 hover:bg-blue-600/20 hover:text-blue-400 flex items-center justify-center transition-all duration-300 border border-white/5 hover:border-blue-500/30">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-white/5 hover:bg-blue-600/20 hover:text-blue-400 flex items-center justify-center transition-all duration-300 border border-white/5 hover:border-blue-500/30">
                                <i class="fab fa-github"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-white/5 hover:bg-blue-600/20 hover:text-blue-400 flex items-center justify-center transition-all duration-300 border border-white/5 hover:border-blue-500/30">
                                <i class="fab fa-discord"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Links Columns -->
                    <div class="lg:col-span-2 space-y-6">
                        <h4 class="text-lg font-semibold text-white">Producto</h4>
                        <ul class="space-y-3 text-gray-400">
                            <li><a href="#" class="hover:text-blue-400 transition-colors">Novedades</a></li>
                            <li><a href="#" class="hover:text-blue-400 transition-colors">Populares</a></li>
                            <li><a href="#" class="hover:text-blue-400 transition-colors">Categorías</a></li>
                            <li><a href="#" class="hover:text-blue-400 transition-colors">Precios</a></li>
                        </ul>
                    </div>

                    <div class="lg:col-span-2 space-y-6">
                        <h4 class="text-lg font-semibold text-white">Recursos</h4>
                        <ul class="space-y-3 text-gray-400">
                            <li><a href="#" class="hover:text-blue-400 transition-colors">Comunidad</a></li>
                            <li><a href="#" class="hover:text-blue-400 transition-colors">Ayuda</a></li>
                            <li><a href="#" class="hover:text-blue-400 transition-colors">Blog</a></li>
                            <li><a href="#" class="hover:text-blue-400 transition-colors">API</a></li>
                        </ul>
                    </div>

                    <!-- Newsletter -->
                    <div class="lg:col-span-4 space-y-6">
                        <h4 class="text-lg font-semibold text-white">Mantente actualizado</h4>
                        <p class="text-gray-400 text-sm">Recibe las últimas herramientas y actualizaciones semanales.</p>
                        <form class="relative">
                            <input type="email" placeholder="tu@email.com" class="w-full bg-white/5 border border-white/10 rounded-lg py-3 px-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            <button class="absolute right-1 top-1 bottom-1 bg-blue-600 hover:bg-blue-700 text-white px-4 rounded-md transition-colors font-medium text-sm">
                                Suscribir
                            </button>
                        </form>
                    </div>
                </div>

                <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-gray-500 text-sm">&copy; 2026 SoftHub Inc. All rights reserved.</p>
                    <div class="flex gap-6 text-sm text-gray-500">
                        <a href="#" class="hover:text-white transition-colors">Privacidad</a>
                        <a href="#" class="hover:text-white transition-colors">Términos</a>
                        <a href="#" class="hover:text-white transition-colors">Cookies</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>


    <!-- OPCIÓN 2: Minimalist Clean -->
    <div class="relative py-8 bg-gray-50 border-b border-gray-200">
        <div class="absolute top-0 left-0 bg-gray-900 text-white text-xs font-bold px-3 py-1 rounded-br-lg">OPCIÓN 2: Minimalist Clean</div>
        
        <footer class="bg-white text-gray-900 py-16">
            <div class="container mx-auto px-6">
                <div class="flex flex-col md:flex-row justify-between items-start gap-12 mb-16 border-b border-gray-100 pb-16">
                    <div class="max-w-xs">
                        <a href="#" class="text-2xl font-bold tracking-tight mb-4 block">SoftHub.</a>
                        <p class="text-gray-500 mb-6">Curated software for modern creators. Simple, fast, secure.</p>
                        <div class="flex gap-4">
                            <a href="#" class="text-gray-400 hover:text-black transition-colors"><i class="fab fa-twitter text-xl"></i></a>
                            <a href="#" class="text-gray-400 hover:text-black transition-colors"><i class="fab fa-instagram text-xl"></i></a>
                            <a href="#" class="text-gray-400 hover:text-black transition-colors"><i class="fab fa-linkedin text-xl"></i></a>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-12">
                        <div>
                            <h5 class="font-bold mb-4">Platform</h5>
                            <ul class="space-y-3 text-sm text-gray-500">
                                <li><a href="#" class="hover:text-black hover:underline underline-offset-4 decoration-2 transition-all">Browse</a></li>
                                <li><a href="#" class="hover:text-black hover:underline underline-offset-4 decoration-2 transition-all">Top Rates</a></li>
                                <li><a href="#" class="hover:text-black hover:underline underline-offset-4 decoration-2 transition-all">Essentials</a></li>
                            </ul>
                        </div>
                        <div>
                            <h5 class="font-bold mb-4">About</h5>
                            <ul class="space-y-3 text-sm text-gray-500">
                                <li><a href="#" class="hover:text-black hover:underline underline-offset-4 decoration-2 transition-all">Mission</a></li>
                                <li><a href="#" class="hover:text-black hover:underline underline-offset-4 decoration-2 transition-all">Contact</a></li>
                                <li><a href="#" class="hover:text-black hover:underline underline-offset-4 decoration-2 transition-all">Partners</a></li>
                            </ul>
                        </div>
                        <div>
                            <h5 class="font-bold mb-4">Legal</h5>
                            <ul class="space-y-3 text-sm text-gray-500">
                                <li><a href="#" class="hover:text-black hover:underline underline-offset-4 decoration-2 transition-all">Privacy</a></li>
                                <li><a href="#" class="hover:text-black hover:underline underline-offset-4 decoration-2 transition-all">Terms</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
                    <p>&copy; 2026 SoftHub. Made with <i class="fas fa-heart text-red-400"></i> in 2026.</p>
                    <div class="flex items-center gap-2 mt-4 md:mt-0">
                        <span class="w-2 h-2 rounded-full bg-green-500 block"></span>
                        <span>Systems Operational</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>


    <!-- OPCIÓN 3: Bento Grid Layout -->
    <div class="relative py-8 bg-gray-50 border-b border-gray-200">
        <div class="absolute top-0 left-0 bg-purple-600 text-white text-xs font-bold px-3 py-1 rounded-br-lg">OPCIÓN 3: Bento Grid</div>
        
        <footer class="bg-gray-100 py-12">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <!-- Box 1: Brand -->
                    <div class="bg-white p-8 rounded-3xl col-span-1 md:col-span-2 flex flex-col justify-between h-64 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div>
                            <div class="w-12 h-12 bg-black text-white rounded-xl flex items-center justify-center text-xl mb-4">
                                <i class="fas fa-cube"></i>
                            </div>
                            <h3 class="text-2xl font-bold mb-2">SoftHub Pro.</h3>
                            <p class="text-gray-500 max-w-sm">La plataforma definitiva para gestionar, descargar y actualizar tu software esencial.</p>
                        </div>
                        <div class="flex gap-3">
                            <a href="#" class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-full text-sm font-medium transition-colors">Descargar App</a>
                            <a href="#" class="bg-black text-white hover:bg-gray-800 px-4 py-2 rounded-full text-sm font-medium transition-colors">Documentación</a>
                        </div>
                    </div>

                    <!-- Box 2: Links -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-md transition-shadow duration-300">
                        <h4 class="font-bold mb-4 text-lg">Explorar</h4>
                        <ul class="space-y-3">
                            <li class="flex justify-between items-center group cursor-pointer">
                                <span class="text-gray-600 group-hover:text-black font-medium transition-colors">Software</span>
                                <i class="fas fa-arrow-right text-gray-300 group-hover:text-black -translate-x-2 group-hover:translate-x-0 transition-all opacity-0 group-hover:opacity-100"></i>
                            </li>
                            <li class="flex justify-between items-center group cursor-pointer">
                                <span class="text-gray-600 group-hover:text-black font-medium transition-colors">Categorías</span>
                                <i class="fas fa-arrow-right text-gray-300 group-hover:text-black -translate-x-2 group-hover:translate-x-0 transition-all opacity-0 group-hover:opacity-100"></i>
                            </li>
                            <li class="flex justify-between items-center group cursor-pointer">
                                <span class="text-gray-600 group-hover:text-black font-medium transition-colors">Colecciones</span>
                                <i class="fas fa-arrow-right text-gray-300 group-hover:text-black -translate-x-2 group-hover:translate-x-0 transition-all opacity-0 group-hover:opacity-100"></i>
                            </li>
                            <li class="flex justify-between items-center group cursor-pointer">
                                <span class="text-gray-600 group-hover:text-black font-medium transition-colors">Blog</span>
                                <i class="fas fa-arrow-right text-gray-300 group-hover:text-black -translate-x-2 group-hover:translate-x-0 transition-all opacity-0 group-hover:opacity-100"></i>
                            </li>
                        </ul>
                    </div>

                    <!-- Box 3: Social & More -->
                    <div class="bg-blue-600 p-8 rounded-3xl text-white shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col justify-between">
                        <div>
                            <h4 class="font-bold mb-2 text-xl">Únete a nosotros</h4>
                            <p class="text-blue-200 text-sm">Más de 50,000 usuarios activos.</p>
                        </div>
                        <div class="flex gap-4 mt-8">
                            <a href="#" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-colors backdrop-blur-sm"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-colors backdrop-blur-sm"><i class="fab fa-discord"></i></a>
                            <a href="#" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-colors backdrop-blur-sm"><i class="fab fa-telegram"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="bg-white p-4 rounded-2xl flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500 shadow-sm">
                    <p>&copy; 2026 SoftHub Inc.</p>
                    <div class="flex gap-6">
                        <a href="#" class="hover:text-black">Privacy Policy</a>
                        <a href="#" class="hover:text-black">Terms of Service</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>


    <!-- OPCIÓN 4: Gradient Brand -->
    <div class="relative py-8 bg-gray-50 border-b border-gray-200">
        <div class="absolute top-0 left-0 bg-pink-600 text-white text-xs font-bold px-3 py-1 rounded-br-lg">OPCIÓN 4: Gradient Brand</div>
        
        <footer class="bg-gradient-to-br from-[#1a1c2e] to-[#0f1016] text-white pt-20 pb-10 relative">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500"></div>
            
            <div class="container mx-auto px-6">
                <div class="flex flex-col items-center text-center mb-16">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-purple-500/30">
                        <i class="fas fa-cube text-2xl"></i>
                    </div>
                    <h2 class="text-3xl md:text-5xl font-bold mb-6 font-outfit">Todo el software que necesitas.</h2>
                    <p class="text-gray-400 max-w-xl text-lg mb-8">Únete a miles de desarrolladores y creadores que confían en SoftHub para sus herramientas diarias.</p>
                    
                    <div class="flex gap-4">
                        <button class="bg-white text-gray-900 px-8 py-3 rounded-full font-bold hover:bg-gray-100 transition-colors">Empezar ahora</button>
                        <button class="bg-transparent border border-gray-700 text-white px-8 py-3 rounded-full font-bold hover:bg-gray-800 transition-colors">Contáctanos</button>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 border-t border-gray-800 pt-12">
                    <div>
                        <h4 class="font-bold text-lg mb-4 text-blue-400">Hub</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors">Explorar</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Destacados</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg mb-4 text-purple-400">Compañía</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors">Nosotros</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Empleo</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg mb-4 text-pink-400">Legal</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors">Privacidad</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Términos</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg mb-4 text-yellow-400">Social</h4>
                        <div class="flex gap-4 text-gray-400">
                            <a href="#" class="hover:text-white transition-colors"><i class="fab fa-twitter text-xl"></i></a>
                            <a href="#" class="hover:text-white transition-colors"><i class="fab fa-instagram text-xl"></i></a>
                            <a href="#" class="hover:text-white transition-colors"><i class="fab fa-linkedin text-xl"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="mt-12 text-center text-gray-600 text-sm">
                    &copy; 2026 SoftHub. Designed with boldness.
                </div>
            </div>
        </footer>
    </div>


    <!-- OPCIÓN 5: Corporate SaaS -->
    <div class="relative py-8 bg-gray-50">
        <div class="absolute top-0 left-0 bg-indigo-800 text-white text-xs font-bold px-3 py-1 rounded-br-lg">OPCIÓN 5: Corporate SaaS</div>
        
        <footer class="bg-slate-50 border-t border-gray-200 pt-16 pb-12">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-12 mb-16">
                    <div class="md:col-span-2">
                        <a href="#" class="flex items-center gap-2 mb-6">
                            <div class="w-8 h-8 bg-indigo-600 rounded flex items-center justify-center text-white">
                                <i class="fas fa-cube"></i>
                            </div>
                            <span class="font-bold text-xl text-slate-900">SoftHub</span>
                        </a>
                        <p class="text-slate-500 text-sm leading-relaxed mb-6">
                            SoftHub proporciona infraestructura de software segura para internet. Empresas de todos los tamaños usan nuestro catálogo para gestionar sus herramientas.
                        </p>
                        <form>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Suscríbete al boletín</label>
                            <div class="flex gap-2">
                                <input type="email" placeholder="email@empresa.com" class="bg-white border border-gray-300 text-slate-900 text-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md text-sm px-4 py-2.5 transition-colors">OK</button>
                            </div>
                        </form>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Productos</h3>
                        <ul class="space-y-3 text-sm text-slate-500">
                            <li><a href="#" class="hover:text-indigo-600 transition-colors">Catálogo</a></li>
                            <li><a href="#" class="hover:text-indigo-600 transition-colors">API</a></li>
                            <li><a href="#" class="hover:text-indigo-600 transition-colors">Integraciones</a></li>
                            <li><a href="#" class="hover:text-indigo-600 transition-colors">Precios</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Recursos</h3>
                        <ul class="space-y-3 text-sm text-slate-500">
                            <li><a href="#" class="hover:text-indigo-600 transition-colors">Documentación</a></li>
                            <li><a href="#" class="hover:text-indigo-600 transition-colors">Guías</a></li>
                            <li><a href="#" class="hover:text-indigo-600 transition-colors">Soporte</a></li>
                            <li><a href="#" class="hover:text-indigo-600 transition-colors">Estado</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Compañía</h3>
                        <ul class="space-y-3 text-sm text-slate-500">
                            <li><a href="#" class="hover:text-indigo-600 transition-colors">Sobre Nosotros</a></li>
                            <li><a href="#" class="hover:text-indigo-600 transition-colors">Blog</a></li>
                            <li><a href="#" class="hover:text-indigo-600 transition-colors">Empleo</a></li>
                            <li><a href="#" class="hover:text-indigo-600 transition-colors">Prensa</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Legal</h3>
                        <ul class="space-y-3 text-sm text-slate-500">
                            <li><a href="#" class="hover:text-indigo-600 transition-colors">Privacidad</a></li>
                            <li><a href="#" class="hover:text-indigo-600 transition-colors">Términos</a></li>
                            <li><a href="#" class="hover:text-indigo-600 transition-colors">Cookies</a></li>
                            <li><a href="#" class="hover:text-indigo-600 transition-colors">Licencias</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-sm text-slate-500">&copy; 2026 SoftHub Inc.</p>
                    <div class="flex gap-4">
                        <a href="#" class="text-slate-400 hover:text-indigo-600 text-xl transition-colors"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-slate-400 hover:text-indigo-600 text-xl transition-colors"><i class="fab fa-github"></i></a>
                        <a href="#" class="text-slate-400 hover:text-indigo-600 text-xl transition-colors"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

</body>
</html>
