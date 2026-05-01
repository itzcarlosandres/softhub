<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background: #05060f; color: #fff; scroll-behavior: smooth; }
        .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.08); }
        .text-gradient { background: linear-gradient(135deg, #fff 0%, #94a3b8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .bg-glow { position: absolute; border-radius: 50%; filter: blur(80px); pointer-events: none; opacity: 0.15; }
        
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }
        .animate-float { animation: float 6s ease-in-out infinite; }
    </style>
</head>
<body>

    <!-- Sticky Navigation -->
    <nav class="fixed top-0 w-full z-50 glass py-4 px-8 flex justify-between items-center">
        <div class="font-black text-xl tracking-tighter">HERO<span class="text-blue-500">LAB</span></div>
        <div class="flex gap-8 text-xs font-bold uppercase tracking-widest text-gray-400">
            <a href="#minimal" class="hover:text-white transition">Minimalist</a>
            <a href="#glass" class="hover:text-white transition">Glassmorphism</a>
            <a href="#bento" class="hover:text-white transition">Bento Style</a>
            <a href="#glow" class="hover:text-white transition">Gradient Glow</a>
        </div>
        <a href="<?= url('') ?>" class="bg-white text-black px-6 py-2 rounded-full font-bold text-xs">Volver a Web</a>
    </nav>

    <!-- 1. THE MINIMALIST POWER -->
    <section id="minimal" class="min-h-screen flex flex-col items-center justify-center relative overflow-hidden px-6 pt-24">
        <div class="bg-glow w-[500px] h-[500px] bg-blue-600 top-[-100px] left-[-100px]"></div>
        
        <div class="text-center max-w-4xl relative z-10">
            <span class="text-blue-500 font-black tracking-[0.3em] uppercase text-[10px] mb-6 block">Ultra Minimalist v1.0</span>
            <h1 class="text-6xl md:text-8xl font-black mb-8 leading-none tracking-tighter text-gradient">
                Simplemente <br> Potente.
            </h1>
            <p class="text-gray-500 text-lg md:text-xl mb-12 max-w-2xl mx-auto leading-relaxed">
                El software que necesitas, sin distracciones. Búsqueda instantánea en una interfaz purista y profesional.
            </p>
            
            <div class="flex flex-col md:flex-row items-center justify-center gap-4">
                <div class="relative w-full max-w-md group">
                    <div class="absolute inset-0 bg-white/5 rounded-2xl blur group-hover:bg-blue-500/10 transition"></div>
                    <input type="text" placeholder="¿Qué estás buscando?" class="relative w-full bg-[#0d0e1a] border border-white/10 rounded-2xl py-5 px-8 text-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
                <button class="w-full md:w-auto bg-white text-black px-10 py-5 rounded-2xl font-black text-lg hover:scale-105 transition-all">
                    Explorar
                </button>
            </div>
        </div>
    </section>

    <!-- 2. GLASSMORPHISM SPLIT -->
    <section id="glass" class="min-h-screen flex items-center relative overflow-hidden px-6 lg:px-24 border-t border-white/5 bg-[#080911]">
        <div class="bg-glow w-[600px] h-[600px] bg-purple-600 bottom-[-200px] right-[-100px]"></div>
        
        <div class="grid lg:grid-cols-2 gap-20 items-center w-full max-w-7xl mx-auto relative z-10">
            <div>
                <h2 class="text-5xl md:text-7xl font-black mb-8 leading-tight text-gradient">
                    Experiencia <span class="text-purple-500">Translúcida</span> y Moderna.
                </h2>
                <p class="text-gray-400 text-lg mb-12 leading-relaxed">
                    Elevamos el estándar visual con efectos de cristal y una jerarquía enfocada en el usuario. Perfecto para productos de alta gama.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="bg-purple-600 px-8 py-4 rounded-xl font-bold hover:bg-purple-500 transition shadow-lg shadow-purple-600/20">Empezar Ahora</a>
                    <a href="#" class="glass px-8 py-4 rounded-xl font-bold hover:bg-white/5 transition">Ver Tutorial</a>
                </div>
            </div>
            
            <div class="relative flex justify-center">
                <!-- Floating Glass Card -->
                <div class="glass p-8 rounded-[2.5rem] w-full max-w-md animate-float relative z-20">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center text-xl shadow-lg">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold">Premium Dashboard</div>
                            <div class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">v2.4.0 Live</div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="h-12 bg-white/5 rounded-xl border border-white/5"></div>
                        <div class="h-12 bg-white/5 rounded-xl border border-white/5 w-4/5"></div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="h-20 bg-purple-500/10 rounded-xl border border-purple-500/20"></div>
                            <div class="h-20 bg-blue-500/10 rounded-xl border border-blue-500/20"></div>
                        </div>
                    </div>
                </div>
                <!-- Decoration -->
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-500 rounded-full blur-[60px] opacity-20"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-pink-500 rounded-full blur-[80px] opacity-20"></div>
            </div>
        </div>
    </section>

    <!-- 3. BENTO DASHBOARD HERO -->
    <section id="bento" class="min-h-screen flex flex-col justify-center py-32 px-6 lg:px-24 border-t border-white/5 bg-[#05060f]">
        <div class="max-w-7xl mx-auto w-full">
            <div class="mb-20 text-center lg:text-left lg:flex items-end justify-between gap-12">
                <div class="max-w-2xl">
                    <h2 class="text-5xl md:text-6xl font-black mb-6 text-gradient">Control Total, <br> Diseño Bento.</h2>
                    <p class="text-gray-500 text-lg">La organización perfecta para contenido masivo en una sola vista profesional.</p>
                </div>
                <div class="mt-8 lg:mt-0">
                    <button class="bg-white text-black px-8 py-4 rounded-2xl font-black">Explorar Catálogo</button>
                </div>
            </div>

            <div class="grid md:grid-cols-4 gap-6">
                <!-- Large Card -->
                <div class="md:col-span-2 md:row-span-2 glass rounded-[2.5rem] p-10 flex flex-col justify-between group overflow-hidden">
                    <div class="relative z-10">
                        <i class="fas fa-bolt text-4xl text-yellow-500 mb-6"></i>
                        <h3 class="text-3xl font-bold mb-4">Velocidad Extrema</h3>
                        <p class="text-gray-500">Descargas optimizadas con servidores de alta gama en todo el mundo.</p>
                    </div>
                    <div class="mt-12 p-6 bg-white/5 rounded-2xl relative z-10 group-hover:bg-white/10 transition">
                        <div class="text-[10px] font-bold text-gray-400 uppercase mb-2">Network Status</div>
                        <div class="flex items-center gap-2">
                            <div class="h-2 flex-1 bg-gray-800 rounded-full overflow-hidden">
                                <div class="w-4/5 h-full bg-green-500"></div>
                            </div>
                            <span class="text-xs font-bold">99.9%</span>
                        </div>
                    </div>
                </div>

                <!-- Small Cards -->
                <div class="glass rounded-[2.5rem] p-8 hover:bg-white/5 transition">
                    <i class="fas fa-shield-alt text-2xl text-blue-500 mb-4"></i>
                    <h4 class="text-xl font-bold mb-2">Seguro</h4>
                    <p class="text-xs text-gray-500">Cada archivo verificado por 5 antivirus.</p>
                </div>
                <div class="glass rounded-[2.5rem] p-8 hover:bg-white/5 transition">
                    <i class="fas fa-sync text-2xl text-green-500 mb-4"></i>
                    <h4 class="text-xl font-bold mb-2">Actualizado</h4>
                    <p class="text-xs text-gray-500">Nuevas versiones cada 24 horas.</p>
                </div>
                <div class="md:col-span-2 glass rounded-[2.5rem] p-8 flex items-center justify-between">
                    <div>
                        <h4 class="text-xl font-bold">Comunidad Activa</h4>
                        <p class="text-xs text-gray-500">Únete a más de 50k usuarios.</p>
                    </div>
                    <div class="flex -space-x-4">
                        <div class="w-12 h-12 rounded-full border-4 border-[#05060f] bg-gray-700"></div>
                        <div class="w-12 h-12 rounded-full border-4 border-[#05060f] bg-gray-600"></div>
                        <div class="w-12 h-12 rounded-full border-4 border-[#05060f] bg-gray-500"></div>
                        <div class="w-12 h-12 rounded-full border-4 border-[#05060f] bg-blue-500 flex items-center justify-center font-bold text-xs">+5k</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. THE GRADIENT GLOW -->
    <section id="glow" class="min-h-screen flex flex-col items-center justify-center relative overflow-hidden px-6 bg-black">
        <!-- Complex Gradients -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-gradient-to-tr from-blue-600/20 via-purple-600/20 to-pink-600/20 blur-[120px] rounded-full animate-pulse"></div>
        
        <div class="text-center relative z-10">
            <h2 class="text-6xl md:text-9xl font-black mb-12 tracking-tighter uppercase italic text-gradient">
                Futuro <br> Digital.
            </h2>
            <div class="inline-flex glass p-2 rounded-2xl mb-12">
                <input type="text" placeholder="Escribe para buscar..." class="bg-transparent border-none px-6 py-2 text-white focus:ring-0 w-64 md:w-80">
                <button class="bg-blue-600 px-8 py-3 rounded-xl font-bold hover:bg-blue-500 transition">Buscar</button>
            </div>
            <div class="flex flex-wrap justify-center gap-6 text-xs font-bold text-gray-500 uppercase tracking-widest">
                <span>#Premium</span>
                <span class="text-gray-700">•</span>
                <span>#Minimalist</span>
                <span class="text-gray-700">•</span>
                <span>#Professional</span>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-20 text-center border-t border-white/5 glass">
        <p class="text-gray-500 text-sm">© 2026 HERO LAB Designs. Premium Minimalist Collection.</p>
    </footer>

</body>
</html>
