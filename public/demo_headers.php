<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Header Designs V2 - SoftHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background: #0b0f19; color: white; padding-bottom: 100px; }
        .dots-bg {
            background-image: radial-gradient(#3b82f633 1px, transparent 1px);
            background-size: 15px 15px;
        }
    </style>
</head>
<body class="p-6 md:p-12 space-y-12">

    <div class="max-w-4xl mx-auto text-center mb-6">
        <h1 class="text-3xl font-extrabold mb-2 text-blue-500">🎨 Headers Optimizados (V2)</h1>
        <p class="text-gray-500 text-sm">Más compactos y adaptados a tus colores corporativos.</p>
    </div>

    <!-- ESTILO 1: DARK DOT GRID (Versión Compacta & Blue) -->
    <div class="max-w-5xl mx-auto">
        <h3 class="text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Opción 1: Dark Dot Grid (Compacto + Azul/Púrpura)</h3>
        <div class="relative overflow-hidden bg-[#0a0a0c] rounded-2xl p-6 border border-white/5 dots-bg group shadow-2xl">
            <!-- Accento Lateral Fino -->
            <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-full my-4 ml-1.5 shadow-[0_0_10px_rgba(59,130,246,0.5)]"></div>
            
            <div class="pl-6 flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                        <span class="text-[9px] font-black text-blue-400/80 uppercase tracking-[0.3em]">CONTENIDO VERIFICADO</span>
                    </div>
                    <h2 class="text-3xl font-bold font-montserrat tracking-tight text-white">
                        Software <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">Destacado</span>
                    </h2>
                </div>
                <div class="hidden md:flex gap-3">
                    <div class="text-right">
                        <div class="text-lg font-bold text-white">100%</div>
                        <div class="text-[9px] text-gray-500 font-bold uppercase">Seguro</div>
                    </div>
                    <div class="w-px h-8 bg-white/10 my-auto"></div>
                    <div class="text-right">
                        <div class="text-lg font-bold text-blue-500">PRO</div>
                        <div class="text-[9px] text-gray-500 font-bold uppercase">Versión</div>
                    </div>
                </div>
            </div>
            <!-- Flare Effect Sutil -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 blur-[50px] -mr-16 -mt-16"></div>
        </div>
    </div>

    <!-- ESTILO 2: GLASS BLUE (Compact) -->
    <div class="max-w-5xl mx-auto">
        <h3 class="text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Opción 2: Glassmorphism Blue (Compact)</h3>
        <div class="relative overflow-hidden bg-gradient-to-r from-blue-500/10 to-transparent backdrop-blur-md rounded-xl p-5 border border-white/10 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-600/20">
                    <i class="fas fa-clock text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">Últimos agregados</h2>
                    <p class="text-gray-500 text-[10px] uppercase font-bold tracking-wider">RECIÉN SUBIDOS A LA PLATAFORMA</p>
                </div>
            </div>
            <div class="hidden sm:block">
                <i class="fas fa-chevron-right text-white/20 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- ESTILO 3: MINIMAL BORDER ACCENT -->
    <div class="max-w-5xl mx-auto">
        <h3 class="text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Opción 3: Acento Minimalista</h3>
        <div class="bg-gray-900/50 rounded-lg p-6 flex items-center justify-between border-l-4 border-indigo-500">
            <div>
                <h2 class="text-2xl font-black text-white uppercase tracking-tighter italic">Top Descargas</h2>
                <div class="w-12 h-0.5 bg-gradient-to-r from-indigo-500 to-transparent mt-1"></div>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                <span class="text-xs font-bold text-indigo-400">MAYOR RATING</span>
            </div>
        </div>
    </div>

    <!-- ESTILO 4: LUXE LINE -->
    <div class="max-w-5xl mx-auto">
        <h3 class="text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Opción 4: Luxe Line (Clean)</h3>
        <div class="flex items-center gap-6">
            <h2 class="text-2xl font-extrabold text-white whitespace-nowrap">Apps Recomendadas</h2>
            <div class="h-px w-full bg-gradient-to-r from-blue-500 to-transparent"></div>
            <div class="w-8 h-8 rounded-full border border-blue-500/30 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-arrow-right text-[10px] text-blue-500"></i>
            </div>
        </div>
    </div>

    <!-- ESTILO 5: NEON GLOW COMPACT -->
    <div class="max-w-5xl mx-auto">
        <h3 class="text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Opción 5: Neon Glow</h3>
        <div class="bg-indigo-600/5 border border-indigo-500/20 rounded-2xl p-6 flex flex-col md:flex-row md:items-center justify-between shadow-[0_0_30px_rgba(79,70,229,0.05)]">
            <div class="flex items-center gap-4">
               <div class="p-2 bg-indigo-500/10 rounded-full">
                   <div class="w-3 h-3 bg-indigo-500 rounded-full shadow-[0_0_10px_#6366f1]"></div>
               </div>
               <h2 class="text-2xl font-bold text-white">Selección Especial</h2>
            </div>
            <p class="text-indigo-400/60 text-xs font-medium md:max-w-[200px] md:text-right mt-2 md:mt-0">Curated software with highest quality standards.</p>
        </div>
    </div>

    <div class="py-10 text-center">
        <p class="text-gray-600 italic text-sm">¿Qué te parece la Opción 1 con esta altura reducida y colores azules? Revisa de nuevo en tu localhost.</p>
    </div>

</body>
</html>
