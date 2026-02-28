<?php
// show_redux.php - Vista de Rediseño con 5 Estilos
// Asegurar variables
$software = $software ?? ['name' => 'Demo App', 'version' => '1.0', 'description' => 'Descripción demo...', 'downloads' => 1234, 'rating' => 4.8];
$versions = $versions ?? [];
$related = $related ?? [];
$style = $_GET['style'] ?? 'glass'; 

// Colors helper
$colors = ['blue', 'purple', 'green', 'indigo', 'pink', 'orange'];
$mainColor = $colors[array_rand($colors)];

function echo_icon($soft) {
    if (!empty($soft['icon'])) {
        echo '<img src="' . url($soft['icon']) . '" class="w-full h-full object-contain drop-shadow-lg">';
    } else {
        echo '<i class="fas fa-cube text-4xl text-blue-500"></i>';
    }
}

// Iniciar Buffer de Salida para capturar el HTML
ob_start();
?>

<!-- Selector de Estilos Flotante -->
<div class="fixed bottom-6 right-6 z-[9999] bg-white/90 backdrop-blur-xl p-4 rounded-2xl shadow-2xl border border-gray-200/50 flex flex-col gap-2 transition-all hover:scale-105">
    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Modo Demo</div>
    <select onchange="window.location.href = window.location.pathname + '?style=' + this.value;" 
            class="bg-gray-100 border-none rounded-lg px-3 py-2 text-sm font-semibold text-gray-800 focus:ring-2 focus:ring-blue-500 cursor-pointer outline-none">
        <option value="glass" <?= $style=='glass'?'selected':'' ?>>✨ 1. Glassmorphism Pro</option>
        <option value="minimal" <?= $style=='minimal'?'selected':'' ?>>⚪ 2. SaaS Minimal</option>
        <option value="dark" <?= $style=='dark'?'selected':'' ?>>🌙 3. Dark Gaming</option>
        <option value="split" <?= $style=='split'?'selected':'' ?>>🌗 4. Split Screen</option>
        <option value="classic" <?= $style=='classic'?'selected':'' ?>>💠 5. Classic Refined</option>
    </select>
</div>

<?php if ($style === 'glass'): ?>
    <!-- ESTILO 1: Glassmorphism Pro (Apple Style) -->
    <div class="bg-gray-50 min-h-screen font-outfit pb-20">
        
        <!-- Hero Blur Output -->
        <div class="relative overflow-hidden bg-white pb-16 pt-12 rounded-b-[3rem] shadow-sm">
            <div class="absolute inset-0 z-0 opacity-40">
                <div class="absolute -top-20 -left-20 w-96 h-96 bg-blue-300 rounded-full blur-[120px]"></div>
                <div class="absolute top-20 right-0 w-80 h-80 bg-purple-300 rounded-full blur-[120px]"></div>
            </div>
            
            <div class="container mx-auto px-6 relative z-10 max-w-6xl">
                 <nav class="text-sm text-gray-500 mb-8 font-medium flex items-center gap-2">
                    <a href="<?= url() ?>" class="hover:text-black transition bg-white/50 px-3 py-1 rounded-full backdrop-blur-sm">Inicio</a> 
                    <span class="text-gray-300">/</span>
                    <span class="bg-white/50 px-3 py-1 rounded-full backdrop-blur-sm"><?= htmlspecialchars($software['category_name'] ?? 'Software') ?></span>
                </nav>
                
                <div class="flex flex-col md:flex-row items-center md:items-start gap-10">
                    <!-- Icono Grande -->
                    <div class="w-40 h-40 bg-white rounded-[2.5rem] shadow-2xl shadow-blue-500/10 flex items-center justify-center p-6 transform hover:scale-105 transition-all duration-500 ring-1 ring-black/5 flex-shrink-0">
                        <?php echo_icon($software); ?>
                    </div>
                    
                    <div class="flex-1 text-center md:text-left pt-2">
                        <div class="flex flex-col md:flex-row items-center gap-4 mb-4">
                            <h1 class="text-4xl md:text-6xl font-black text-gray-900 tracking-tight leading-tight">
                                <?= htmlspecialchars($software['name']) ?>
                            </h1>
                            <?php if(!empty($software['badge_trending'])): ?>
                                <span class="bg-gradient-to-r from-orange-500 to-pink-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg shadow-orange-500/30 uppercase tracking-wide">HOT</span>
                            <?php endif; ?>
                        </div>
                        
                        <p class="text-xl md:text-2xl text-gray-500 font-medium mb-8 max-w-2xl leading-relaxed mx-auto md:mx-0">
                            <?= htmlspecialchars($software['short_description']) ?>
                        </p>
                        
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-5">
                            <a href="<?= url('download/' . $software['id']) ?>" class="bg-black text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-gray-800 transition-all shadow-xl shadow-gray-200 hover:shadow-2xl hover:-translate-y-1 flex items-center gap-3 group">
                                <span>Descargar</span>
                                <i class="fas fa-arrow-down bg-white/20 rounded-full p-1.5 text-xs group-hover:bg-white/30 transition"></i>
                            </a>
                            
                            <div class="flex items-center gap-6 px-6 py-3 bg-white/40 backdrop-blur-md rounded-2xl border border-white/60 shadow-sm">
                                <div class="flex flex-col items-center md:items-start">
                                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Rating</span>
                                    <div class="flex items-center text-yellow-500 text-sm gap-1">
                                        <span class="text-gray-900 font-black text-lg"><?= $software['rating'] ?></span> <i class="fas fa-star text-xs"></i>
                                    </div>
                                </div>
                                <div class="w-px h-8 bg-gray-300/50"></div>
                                <div class="flex flex-col items-center md:items-start">
                                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Versión</span>
                                    <span class="text-gray-900 font-bold text-lg">v<?= $software['version'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Content Sections -->
        <div class="container mx-auto px-6 py-16 max-w-6xl">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Main Column -->
                <main class="lg:col-span-8 space-y-12">
                    <!-- About Section -->
                    <section>
                         <h2 class="text-3xl font-bold mb-6 text-gray-900 flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-sm"><i class="fas fa-info"></i></span>
                            Sobre la App
                        </h2>
                        <div class="bg-white rounded-[2rem] p-8 md:p-10 shadow-sm border border-gray-100 prose prose-lg prose-blue max-w-none text-gray-600 leading-relaxed">
                            <?= $software['description'] ?>
                        </div>
                    </section>
                    
                    <!-- Versions Section -->
                    <section>
                        <h2 class="text-3xl font-bold mb-6 text-gray-900 flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-sm"><i class="fas fa-history"></i></span>
                            Historial
                        </h2>
                        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100">
                             <?php foreach(array_slice($versions, 0, 3) as $ver): ?>
                                <div class="flex items-center justify-between p-4 rounded-2xl hover:bg-gray-50 transition cursor-pointer group border-b border-gray-50 last:border-0">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-blue-500 group-hover:text-white transition shadow-sm">
                                            <i class="fas fa-code-branch"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 text-lg">Versión <?= $ver['version_number'] ?></div>
                                            <div class="text-xs text-gray-500 font-medium bg-gray-100 inline-block px-2 py-0.5 rounded mt-1"><?= date('d M, Y', strtotime($ver['release_date'])) ?></div>
                                        </div>
                                    </div>
                                    <div class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center group-hover:border-blue-500 group-hover:text-blue-500 transition">
                                        <i class="fas fa-download text-sm"></i>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                </main>
                
                <!-- Sidebar -->
                <aside class="lg:col-span-4 space-y-8">
                    <!-- Info Card -->
                    <div class="bg-white rounded-[2.5rem] p-8 shadow-lg shadow-gray-200/50 border border-gray-100 sticky top-8">
                        <h3 class="font-bold text-gray-900 mb-8 text-xl">Detalles</h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 font-medium">Licencia</span>
                                <span class="font-bold text-gray-900 bg-gray-100 px-3 py-1 rounded-lg"><?= ucfirst($software['license'] ?? 'Free') ?></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 font-medium">Plataforma</span>
                                <span class="font-bold text-gray-900 flex items-center gap-2">
                                    <i class="fab fa-windows text-blue-500"></i> Windows
                                </span>
                            </div>
                             <div class="flex items-center justify-between">
                                <span class="text-gray-500 font-medium">Tamaño</span>
                                <span class="font-bold text-gray-900">~ MB</span>
                            </div>
                             <div class="pt-6 border-t border-gray-100 mt-6">
                                 <span class="text-gray-500 font-medium block mb-3">Categoría</span>
                                 <a href="#" class="inline-block bg-blue-50 text-blue-600 font-bold px-4 py-2 rounded-xl text-sm hover:bg-blue-100 transition">
                                     <?= $software['category_name'] ?? 'General' ?>
                                 </a>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>


<?php elseif ($style === 'minimal'): ?>
    <!-- ESTILO 2: SaaS Minimal (Stripe Style) -->
    <div class="bg-white min-h-screen text-slate-800 font-inter">
        <div class="container mx-auto px-6 py-24 max-w-5xl text-center">
            
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold uppercase tracking-wider mb-10 border border-indigo-100">
                <span class="flex h-2 w-2 relative">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                </span>
                Verificado Oficialmente
            </div>
            
            <div class="w-28 h-28 bg-white border border-slate-100 shadow-[0_20px_50px_-12px_rgba(0,0,0,0.1)] rounded-3xl mx-auto mb-10 flex items-center justify-center p-6 transition hover:-translate-y-2 duration-500">
                 <?php echo_icon($software); ?>
            </div>
            
            <h1 class="text-5xl md:text-7xl font-black text-slate-900 mb-8 tracking-tight bg-clip-text text-transparent bg-gradient-to-br from-slate-900 via-slate-800 to-slate-500 pb-2">
                <?= htmlspecialchars($software['name']) ?>
            </h1>
            
            <p class="text-xl md:text-2xl text-slate-500 mb-12 leading-relaxed max-w-3xl mx-auto font-medium">
                <?= htmlspecialchars($software['short_description']) ?>
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-5 mb-24">
                <a href="<?= url('download/' . $software['id']) ?>" class="bg-[#635bff] text-white px-10 py-5 rounded-full font-bold text-lg hover:bg-[#4d46e5] transition shadow-xl shadow-indigo-200 transform hover:scale-105">
                    Descargar Ahora &rarr;
                </a>
                <button class="px-10 py-5 rounded-full font-bold border border-slate-200 text-slate-600 hover:bg-slate-50 transition bg-white shadow-sm hover:shadow-md">
                    Ver versiones
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-left border-t border-slate-100 pt-20">
                <!-- Feature 1 -->
                <div class="group">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 text-xl group-hover:scale-110 transition duration-300 shadow-sm">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 mb-3 text-lg">Seguro y Limpio</h3>
                    <p class="text-slate-500 leading-relaxed">Verificado por nuestros expertos de seguridad.</p>
                </div>
                <!-- Feature 2 -->
                <div class="group">
                    <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-6 text-xl group-hover:scale-110 transition duration-300 shadow-sm">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 mb-3 text-lg">Ultra Rápido</h3>
                    <p class="text-slate-500 leading-relaxed">Descargas optimizadas desde servidores CDN globales.</p>
                </div>
                <!-- Feature 3 -->
                <div class="group">
                    <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-6 text-xl group-hover:scale-110 transition duration-300 shadow-sm">
                        <i class="fas fa-sync"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 mb-3 text-lg">Actualizado</h3>
                    <p class="text-slate-500 leading-relaxed">Siempre tendrás acceso a la última versión estable.</p>
                </div>
            </div>
            
            <div class="text-left mt-24 bg-slate-50 rounded-[2.5rem] p-12 border border-slate-100 max-w-4xl mx-auto">
                <h3 class="font-bold text-slate-900 mb-8 text-2xl flex items-center gap-3">
                    <i class="fas fa-align-left text-slate-400"></i>
                    Descripción detallada
                </h3>
                <div class="prose prose-lg prose-slate max-w-none text-slate-600 leading-8">
                     <?= $software['description'] ?>
                </div>
            </div>
        </div>
    </div>


<?php elseif ($style === 'dark'): ?>
    <!-- ESTILO 3: Dark Gaming (Futuristic) -->
    <div class="bg-[#0b0c15] min-h-screen text-gray-300 font-sans selection:bg-cyan-500 selection:text-black pb-20">
        
        <!-- Navbar Mock -->
        <nav class="border-b border-white/5 bg-[#0b0c15]/80 backdrop-blur-md sticky top-0 z-50">
            <div class="container mx-auto px-6 h-20 flex items-center justify-between">
                <div class="text-2xl font-black text-white tracking-widest uppercase italic bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 to-blue-600">GAMERHUB</div>
                <div class="flex gap-6 text-sm font-bold text-gray-400 uppercase">
                    <a href="#" class="hover:text-cyan-400 transition">Store</a>
                    <a href="#" class="hover:text-cyan-400 transition">Library</a>
                    <a href="#" class="hover:text-cyan-400 transition">Community</a>
                </div>
            </div>
        </nav>

        <!-- Hero Area -->
        <div class="relative pt-16 pb-12 overflow-hidden mb-12">
             <!-- Cyberpunk Grids -->
             <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
             <div class="absolute top-0 right-0 w-2/3 h-full bg-gradient-to-l from-blue-900/20 to-transparent pointer-events-none"></div>
             
             <div class="container mx-auto px-6 relative z-10">
                 <div class="flex flex-col lg:flex-row gap-12 items-end">
                     <!-- Cover Art Mock -->
                     <div class="w-full lg:w-96 aspect-[3/4] bg-[#1a1b26] rounded-2xl border border-white/10 shadow-[0_0_50px_rgba(0,0,0,0.5)] relative overflow-hidden group">
                         <div class="absolute inset-0 flex items-center justify-center bg-black/40 group-hover:bg-black/20 transition duration-500">
                             <?php echo_icon($software); ?>
                         </div>
                         <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black via-black/80 to-transparent">
                             <div class="flex items-center gap-2">
                                 <span class="bg-cyan-500 text-black text-xs font-bold px-2 py-1 rounded uppercase">Verified</span>
                             </div>
                         </div>
                     </div>
                     
                     <div class="flex-1 pb-6">
                         <h1 class="text-5xl lg:text-7xl font-black text-white mb-4 uppercase tracking-tighter italic drop-shadow-md">
                             <?= htmlspecialchars($software['name']) ?>
                         </h1>
                         
                         <div class="flex flex-wrap items-center gap-6 text-sm font-bold uppercase tracking-widest text-cyan-500 mb-8 border-b border-white/10 pb-8">
                             <span><i class="fas fa-layer-group mr-2"></i><?= $software['category_name'] ?></span>
                             <span class="text-gray-600">|</span>
                             <span><i class="fas fa-star mr-2"></i><?= $software['rating'] ?> Rating</span>
                             <span class="text-gray-600">|</span>
                             <span><i class="fas fa-download mr-2"></i><?= number_format($software['downloads']) ?></span>
                         </div>
                         
                         <div class="flex flex-wrap gap-4">
                             <a href="<?= url('download/' . $software['id']) ?>" class="bg-cyan-500 hover:bg-cyan-400 text-black text-xl font-bold py-4 px-10 rounded-lg transition-all shadow-[0_0_20px_rgba(6,182,212,0.4)] hover:shadow-[0_0_40px_rgba(6,182,212,0.6)] uppercase italic transform skew-x-[-10deg] inline-block hover:-translate-y-1">
                                 <div class="skew-x-[10deg] flex items-center gap-3">
                                     <i class="fas fa-download"></i> Download
                                 </div>
                             </a>
                             <button class="bg-[#1a1b26] hover:bg-[#252736] text-white text-xl font-bold py-4 px-8 rounded-lg border border-white/10 transition uppercase italic transform skew-x-[-10deg] inline-block">
                                <div class="skew-x-[10deg]"><i class="fas fa-heart text-pink-500"></i></div>
                             </button>
                         </div>
                     </div>
                 </div>
             </div>
        </div>
        
        <div class="container mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-10">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-[#13141c] border border-white/5 rounded-2xl p-8 shadow-xl">
                    <h3 class="text-2xl text-white font-bold mb-6 border-l-4 border-cyan-500 pl-4 uppercase">System Overview</h3>
                    <div class="prose prose-invert prose-lg max-w-none text-gray-400">
                        <?= $software['description'] ?>
                    </div>
                </div>
                
                 <!-- Specs Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-[#13141c] p-4 rounded-xl border border-white/5 text-center">
                        <div class="text-gray-500 text-xs uppercase font-bold mb-2">Version</div>
                        <div class="text-white font-bold text-lg"><?= $software['version'] ?></div>
                    </div>
                    <div class="bg-[#13141c] p-4 rounded-xl border border-white/5 text-center">
                        <div class="text-gray-500 text-xs uppercase font-bold mb-2">License</div>
                        <div class="text-cyan-400 font-bold text-lg uppercase"><?= $software['license'] ?></div>
                    </div>
                    <div class="bg-[#13141c] p-4 rounded-xl border border-white/5 text-center">
                        <div class="text-gray-500 text-xs uppercase font-bold mb-2">Platform</div>
                        <div class="text-white font-bold text-lg uppercase">Windows</div>
                    </div>
                    <div class="bg-[#13141c] p-4 rounded-xl border border-white/5 text-center">
                        <div class="text-gray-500 text-xs uppercase font-bold mb-2">Size</div>
                        <div class="text-white font-bold text-lg">Unknown</div>
                    </div>
                </div>
            </div>
            
            <div class="space-y-6">
                <!-- Similar Games/Software -->
                <div class="bg-[#13141c] border border-white/5 rounded-2xl p-6">
                    <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-sm flex justify-between items-center">
                        Similar Software
                        <i class="fas fa-layer-group text-cyan-500"></i>
                    </h4>
                    <div class="space-y-3">
                         <?php foreach(array_slice($related, 0, 5) as $rel): ?>
                            <a href="#" class="flex items-center gap-3 p-2 rounded-lg hover:bg-white/5 transition group">
                                <div class="w-12 h-12 bg-black rounded border border-white/10 flex items-center justify-center shrink-0">
                                    <?php echo_icon($rel); ?>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-200 group-hover:text-cyan-400 transition text-sm"><?= $rel['name'] ?></div>
                                    <div class="text-xs text-gray-500">Free Download</div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php elseif ($style === 'split'): ?>
    <!-- ESTILO 4: Split Screen (Modern Editorial) -->
    <div class="bg-white min-h-screen font-outfit text-gray-900 border-t-8 border-black">
        <div class="flex flex-col lg:flex-row min-h-screen">
            <!-- Left Side (Sticky Info) -->
            <div class="lg:w-5/12 bg-gray-50 p-8 lg:p-20 flex flex-col justify-start lg:h-screen lg:sticky lg:top-0 border-r border-gray-200 overflow-y-auto">
                <a href="<?= url() ?>" class="font-black text-2xl tracking-tighter mb-12 block md:hidden">SOFTHUB.</a>
                
                <div class="flex-1 flex flex-col justify-center">
                     <div class="w-32 h-32 bg-white rounded-3xl shadow-xl flex items-center justify-center p-6 mb-10 ring-1 ring-black/5 mx-auto lg:mx-0">
                        <?php echo_icon($software); ?>
                     </div>
                     
                     <h1 class="text-5xl lg:text-7xl font-black text-gray-900 mb-6 tracking-tighter leading-[0.9] text-center lg:text-left">
                        <?= htmlspecialchars($software['name']) ?>
                        <span class="text-blue-600 text-7xl leading-none">.</span>
                     </h1>
                     
                     <p class="text-xl lg:text-3xl text-gray-500 font-light leading-snug mb-12 text-center lg:text-left">
                         <?= htmlspecialchars($software['short_description']) ?>
                     </p>
                     
                     <div class="space-y-4 max-w-sm mx-auto lg:mx-0 w-full">
                         <a href="<?= url('download/' . $software['id']) ?>" class="block w-full bg-black text-white text-center py-5 rounded-xl font-bold text-xl hover:bg-gray-800 transition shadow-xl shadow-gray-300">
                             Download Now
                         </a>
                         <div class="flex justify-between px-4 text-sm font-bold text-gray-400 uppercase tracking-widest">
                             <span>v<?= $software['version'] ?></span>
                             <span>Free License</span>
                         </div>
                     </div>
                </div>
                
                <div class="hidden lg:block mt-auto text-sm text-gray-400 pt-12">
                     &copy; 2024 SoftHub Inc. All rights reserved.
                </div>
            </div>
            
            <!-- Right Side (Scrollable Content) -->
            <div class="lg:w-7/12 bg-white p-8 lg:p-24">
                <a href="<?= url() ?>" class="hidden lg:block font-black text-2xl tracking-tighter mb-20 text-right opacity-20 hover:opacity-100 transition">SOFTHUB.</a>
                
                <header class="mb-16 border-b-2 border-black pb-8">
                     <h2 class="font-black text-4xl mb-4">The Breakdown</h2>
                     <p class="text-xl text-gray-500">Everything you need to know about this software.</p>
                </header>
                
                <article class="prose prose-xl prose-gray max-w-none text-gray-600 mb-20 leading-loose">
                     <?= $software['description'] ?>
                </article>
                
                <section class="bg-black text-white p-12 rounded-3xl mb-20">
                    <h3 class="font-bold text-2xl mb-8 border-b border-white/20 pb-4">Specs Sheet</h3>
                    <dl class="grid grid-cols-2 gap-y-8 gap-x-4">
                        <div>
                            <dt class="text-gray-500 text-sm uppercase font-bold mb-1">Developer</dt>
                            <dd class="text-xl font-bold"><?= $software['developer'] ?? 'Unknown' ?></dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm uppercase font-bold mb-1">Latest Version</dt>
                            <dd class="text-xl font-bold">v<?= $software['version'] ?></dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm uppercase font-bold mb-1">License Type</dt>
                            <dd class="text-xl font-bold text-yellow-500"><?= ucfirst($software['license'] ?? 'Free') ?></dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 text-sm uppercase font-bold mb-1">Total Downloads</dt>
                            <dd class="text-xl font-bold"><?= number_format($software['downloads']) ?></dd>
                        </div>
                    </dl>
                </section>
                
                <section>
                    <h3 class="font-black text-3xl mb-8">Related Tools</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <?php foreach(array_slice($related, 0, 4) as $rel): ?>
                            <a href="#" class="group border-2 border-gray-100 p-6 rounded-2xl hover:border-black transition">
                                <div class="flex items-center justify-between mb-4">
                                     <div class="w-12 h-12 bg-gray-50 rounded-lg flex items-center justify-center grayscale group-hover:grayscale-0 transition">
                                         <?php echo_icon($rel); ?>
                                     </div>
                                     <i class="fas fa-arrow-right -rotate-45 group-hover:rotate-0 transition duration-300"></i>
                                </div>
                                <div class="font-bold text-xl mb-1"><?= $rel['name'] ?></div>
                                <div class="text-gray-400 text-sm">Download for free</div>
                            </a>
                         <?php endforeach; ?>
                    </div>
                </section>
            </div>
        </div>
    </div>


<?php else: ?>
    <!-- ESTILO 5: Classic Refined (Standard) -->
    <div class="bg-gray-50 min-h-screen py-10 font-sans text-gray-600">
        <div class="container mx-auto px-4 max-w-6xl">
            
            <!-- Breadcrumb -->
            <nav class="flex text-sm text-gray-500 mb-6 bg-white px-6 py-3 rounded-lg shadow-sm border border-gray-100 w-fit">
                <a href="<?= url() ?>" class="hover:text-blue-600">Inicio</a>
                <span class="mx-2">/</span>
                <span class="text-gray-800 font-medium"><?= htmlspecialchars($software['name']) ?></span>
            </nav>
        
            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Center Column -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Header Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 flex flex-col md:flex-row items-center md:items-start gap-8">
                        <div class="w-32 h-32 bg-gray-50 rounded-2xl flex-shrink-0 flex items-center justify-center p-4 border border-gray-100">
                            <?php echo_icon($software); ?>
                        </div>
                        
                        <div class="flex-1 text-center md:text-left">
                            <h1 class="text-3xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($software['name']) ?></h1>
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 mb-4 text-sm">
                                <span class="bg-green-100 text-green-700 font-bold px-3 py-1 rounded-full"><i class="fas fa-check-circle mr-1"></i> Verificado</span>
                                <span class="bg-blue-100 text-blue-700 font-bold px-3 py-1 rounded-full">v<?= $software['version'] ?></span>
                            </div>
                            <p class="text-gray-500 mb-6 line-clamp-2"><?= htmlspecialchars($software['short_description']) ?></p>
                            
                            <div class="flex gap-4 justify-center md:justify-start">
                                <a href="<?= url('download/' . $software['id']) ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow hover:shadow-lg transition flex items-center gap-2">
                                    <i class="fas fa-download"></i> Descargar
                                </a>
                                <button class="bg-white border border-gray-300 text-gray-700 font-bold py-3 px-4 rounded-lg hover:bg-gray-50 transition">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                        <div class="border-b border-gray-100 pb-4 mb-6">
                            <h2 class="text-xl font-bold text-gray-800">Descripción</h2>
                        </div>
                        <div class="prose max-w-none text-gray-600">
                            <?= $software['description'] ?>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <aside class="space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Ficha Técnica</h3>
                        <ul class="space-y-4 text-sm">
                            <li class="flex justify-between items-center">
                                <span class="text-gray-500">Última actualización</span>
                                <span class="font-medium text-gray-900">Hoy</span>
                            </li>
                             <li class="flex justify-between items-center">
                                <span class="text-gray-500">Licencia</span>
                                <span class="bg-gray-100 px-2 py-0.5 rounded font-medium text-gray-800"><?= ucfirst($software['license'] ?? 'Free') ?></span>
                            </li>
                             <li class="flex justify-between items-center">
                                <span class="text-gray-500">Desarrollador</span>
                                <span class="font-medium text-blue-600"><?= $software['developer'] ?? 'Unknown' ?></span>
                            </li>
                             <li class="flex justify-between items-center">
                                <span class="text-gray-500">Descargas</span>
                                <span class="font-medium text-gray-900"><?= number_format($software['downloads']) ?></span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="bg-blue-50 rounded-xl border border-blue-100 p-6 text-center">
                        <i class="fas fa-shield-alt text-4xl text-blue-500 mb-3"></i>
                        <h3 class="font-bold text-blue-900 mb-2">100% Seguro</h3>
                        <p class="text-sm text-blue-700">Este software ha sido escaneado y verificado como libre de virus.</p>
                    </div>
                </aside>
                
            </div>
        </div>
    </div>
<?php endif; ?>

<?php
// Capture output content
$content = ob_get_clean();
// Include Main Layout
include __DIR__ . '/../../layouts/main.php';
?>
