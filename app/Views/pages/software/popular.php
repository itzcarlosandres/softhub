<?php 
ob_start(); 
?>

<!-- Header Section -->
<section class="bg-white dark:bg-gray-900 pt-24 pb-12 overflow-hidden relative transition-colors duration-300">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-50 dark:bg-blue-900/20 rounded-full blur-[120px] -mr-32 -mt-32 opacity-60 transition-colors"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-50 dark:bg-purple-900/20 rounded-full blur-[100px] -ml-32 -mb-32 opacity-60 transition-colors"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100/50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 text-[10px] font-bold uppercase tracking-wider mb-6 border border-blue-200/50 dark:border-blue-800/50 transition-colors">
                <i class="fas fa-fire animate-pulse text-orange-500"></i> Tendencias en tiempo real
            </span>
            <h1 class="text-5xl md:text-7xl font-black text-gray-900 dark:text-white mb-6 tracking-tighter leading-none transition-colors">
                Los Más <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-500">Populares.</span>
            </h1>
            <p class="text-xl text-gray-500 dark:text-gray-400 font-light leading-relaxed max-w-2xl transition-colors">
                Descubre las herramientas digitales más descargadas por nuestra comunidad. Software verificado, seguro y de alto rendimiento.
            </p>
        </div>
    </div>
</section>

<!-- Stats Bar -->
<div class="container mx-auto px-4 -mt-8 relative z-20">
    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl border border-gray-100 dark:border-gray-700/50 rounded-3xl p-6 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.08)] dark:shadow-none transition-colors">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 divide-x divide-gray-100 dark:divide-gray-700/50">
            <div class="text-center px-4">
                <div class="text-2xl font-black text-gray-900 dark:text-white transition-colors"><?= count($popular) ?></div>
                <div class="text-[10px] text-gray-400 dark:text-gray-500 font-bold uppercase tracking-widest transition-colors">Top Programas</div>
            </div>
            <div class="text-center px-4">
                <div class="text-2xl font-black text-blue-600 dark:text-blue-400 transition-colors">50k+</div>
                <div class="text-[10px] text-gray-400 dark:text-gray-500 font-bold uppercase tracking-widest transition-colors">Descargas Hoy</div>
            </div>
            <div class="text-center px-4">
                <div class="text-2xl font-black text-gray-900 dark:text-white transition-colors">24/7</div>
                <div class="text-[10px] text-gray-400 dark:text-gray-500 font-bold uppercase tracking-widest transition-colors">Actualizaciones</div>
            </div>
            <div class="text-center px-4">
                <div class="text-2xl font-black text-green-500 dark:text-green-400 transition-colors">100%</div>
                <div class="text-[10px] text-gray-400 dark:text-gray-500 font-bold uppercase tracking-widest transition-colors">Seguridad</div>
            </div>
        </div>
    </div>
</div>

<!-- Main Grid -->
<section class="py-20 bg-gray-50/30 dark:bg-gray-900 transition-colors duration-300">
    <div class="container mx-auto px-4">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php 
            if (!empty($popular)): 
                $rank = 1;
                foreach ($popular as $soft): 
                    $isTop3 = $rank <= 3;
                    $rankColor = $rank == 1 ? 'bg-yellow-400 dark:bg-yellow-500' : ($rank == 2 ? 'bg-slate-300 dark:bg-gray-400' : ($rank == 3 ? 'bg-orange-300 dark:bg-orange-500' : 'bg-gray-100 dark:bg-gray-700/50'));
                    $rankText = $rank == 1 ? 'text-white' : ($rank == 2 ? 'text-slate-600 dark:text-gray-900' : ($rank == 3 ? 'text-orange-700 dark:text-white' : 'text-gray-500 dark:text-gray-400'));
            ?>
                <a href="<?= url('software/' . $soft['slug']) ?>" 
                   class="group bg-white dark:bg-gray-800 rounded-[2rem] p-6 border border-gray-100 dark:border-gray-700/50 hover:border-blue-500/30 dark:hover:border-blue-500/50 hover:shadow-[0_20px_50px_-12px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_20px_50px_-12px_rgba(0,0,0,0.4)] transition-all duration-500 relative flex flex-col h-full transform hover:-translate-y-1">
                    
                    <!-- Ranking Badge -->
                    <div class="absolute -top-3 -left-3 w-10 h-10 <?= $rankColor ?> <?= $rankText ?> rounded-2xl flex items-center justify-center font-black text-lg shadow-lg shadow-current/10 z-10 rotate-[-5deg] group-hover:rotate-0 transition-transform">
                        <?= $rank ?>
                    </div>

                    <!-- Compact Header -->
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-3 group-hover:bg-blue-50 dark:group-hover:bg-gray-700 transition-colors duration-500 flex-shrink-0 flex items-center justify-center border border-gray-100 dark:border-gray-600/50 shadow-sm relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/40 dark:from-white/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <?php if (!empty($soft['icon'])): ?>
                                <img src="<?= url($soft['icon']) ?>" alt="<?= htmlspecialchars($soft['name']) ?>" class="w-full h-full object-contain relative z-10 group-hover:scale-110 transition-transform duration-500">
                            <?php else: ?>
                                <i class="fas fa-cube text-2xl text-gray-300 dark:text-gray-500 relative z-10 transition-colors"></i>
                            <?php endif; ?>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-0.5 truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                <?= htmlspecialchars($soft['name']) ?>
                            </h3>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest transition-colors">
                                <?= htmlspecialchars($soft['category_name'] ?? 'General') ?>
                            </span>
                        </div>
                    </div>

                    <!-- Meta Info Compact -->
                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <div class="bg-gray-50/50 dark:bg-gray-700/50 rounded-xl p-2 text-center border border-gray-100/50 dark:border-gray-600/30 transition-colors">
                            <div class="text-xs font-black text-gray-900 dark:text-white transition-colors"><?= number_format($soft['downloads']) ?></div>
                            <div class="text-[9px] text-gray-400 dark:text-gray-500 font-bold uppercase transition-colors">Descargas</div>
                        </div>
                        <div class="bg-gray-50/50 dark:bg-gray-700/50 rounded-xl p-2 text-center border border-gray-100/50 dark:border-gray-600/30 transition-colors">
                            <div class="text-xs font-black text-gray-900 dark:text-white transition-colors"><?= number_format($soft['rating'], 1) ?></div>
                            <div class="text-[9px] text-gray-400 dark:text-gray-500 font-bold uppercase transition-colors">Rating</div>
                        </div>
                    </div>

                    <!-- Description - Compact -->
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-6 line-clamp-2 transition-colors">
                        <?= htmlspecialchars($soft['short_description'] ?? '') ?>
                    </p>

                    <!-- Footer -->
                    <div class="mt-auto pt-6 border-t border-gray-50 dark:border-gray-700/50 flex items-center justify-between transition-colors">
                        <span class="text-[10px] font-black <?= !empty($soft['price']) && $soft['price'] > 0 ? 'text-purple-600 dark:text-purple-400' : 'text-green-600 dark:text-green-400' ?> uppercase tracking-widest transition-colors">
                            <?= !empty($soft['price']) && $soft['price'] > 0 ? '$' . number_format($soft['price'], 2) : 'Gratis' ?>
                        </span>
                        <div class="w-8 h-8 rounded-full bg-gray-900 dark:bg-gray-700 text-white flex items-center justify-center group-hover:bg-blue-600 dark:group-hover:bg-blue-600 transition-colors">
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </div>
                    </div>
                </a>
            <?php 
                $rank++;
                endforeach; 
            else: 
            ?>
                <div class="col-span-full text-center py-20 bg-white dark:bg-gray-800 rounded-[3rem] border border-gray-100 dark:border-gray-700 shadow-sm transition-colors">
                    <div class="w-24 h-24 bg-gray-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300 dark:text-gray-500 transition-colors">
                        <i class="fas fa-chart-line text-4xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2 transition-colors">Aún no hay tendencias</h2>
                    <p class="text-gray-500 dark:text-gray-400 transition-colors">Estamos analizando las descargas del día...</p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<!-- Call to action -->
<section class="py-24 overflow-hidden relative bg-white dark:bg-gray-900 transition-colors duration-300">
    <div class="container mx-auto px-4 text-center relative z-10">
        <h2 class="text-3xl md:text-5xl font-black text-gray-900 dark:text-white mb-8 tracking-tight transition-colors">¿No encuentras lo que buscas?</h2>
        <a href="<?= url('software') ?>" class="inline-flex items-center gap-4 bg-black dark:bg-blue-600 text-white px-10 py-5 rounded-2xl font-bold text-lg hover:bg-gray-800 dark:hover:bg-blue-700 transition-all shadow-xl shadow-gray-200 dark:shadow-none hover:-translate-y-1">
            Explora el Catálogo Completo
            <i class="fas fa-th-large"></i>
        </a>
    </div>
</section>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../../layouts/main.php';
?>
