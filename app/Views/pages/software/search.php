<?php
// Obtener TOP más vistos (más descargados)
$stmt = $db->prepare("SELECT * FROM software WHERE status = 'approved' ORDER BY downloads DESC LIMIT 8");
$stmt->execute();
$topViewed = $stmt->fetchAll();

// Hero Settings (we reuse them here for consistency if possible, or use defaults)
$heroDotsActive = $heroDotsActive ?? true;
$heroSpotlightActive = $heroSpotlightActive ?? true;

ob_start();
?>

<!-- Hero Section -->
<section class="relative pt-12 pb-24 overflow-hidden bg-white dark:bg-gray-900 transition-colors duration-300">
    <!-- Background Elements -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-gradient-to-b from-blue-50/50 to-transparent dark:from-blue-900/10 dark:to-transparent"></div>
        <div class="absolute inset-0 opacity-[0.05] dark:opacity-10" style="background-image: radial-gradient(currentColor 1px, transparent 1px); background-size: 24px 24px;"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-blue-50 dark:bg-blue-900/30 border border-blue-100 dark:border-blue-800/50 text-blue-600 dark:text-blue-400 text-[10px] font-black tracking-widest uppercase mb-6 shadow-sm">
                Resultados de Búsqueda
            </span>
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white mb-4 tracking-tight">
                Buscando <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400">"<?= htmlspecialchars($query) ?>"</span>
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mb-10 text-lg max-w-xl mx-auto font-medium">
                Hemos encontrado <?= count($software) ?> programas que coinciden con tu búsqueda.
            </p>
            
            <!-- Modern Search Bar -->
            <div class="max-w-2xl mx-auto relative group">
                <form action="<?= url('search') ?>" method="GET" class="relative">
                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 dark:text-gray-500 group-focus-within:text-blue-600 transition-colors"></i>
                    </div>
                    <input type="text" 
                           name="q" 
                           value="<?= htmlspecialchars($query) ?>"
                           class="block w-full pl-14 pr-32 py-5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-md dark:shadow-xl text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 dark:focus:border-blue-400 text-lg transition-all duration-300"
                           placeholder="¿Qué más estás buscando?">
                    <button type="submit" class="absolute right-2 top-2 bottom-2 bg-gray-900 dark:bg-blue-600 text-white px-8 rounded-xl hover:bg-black dark:hover:bg-blue-700 transition-all font-bold text-sm tracking-tight flex items-center gap-2">
                        Buscar <i class="fas fa-chevron-right text-[10px]"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Results Section -->
<section class="py-16 bg-gray-50 dark:bg-[#0b0c10] transition-colors duration-300 min-h-[600px]">
    <div class="container mx-auto px-4 mt-8 relative z-20">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-8 order-last lg:order-first">
                    <!-- TOP Vistos -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700/50">
                        <h3 class="text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                            <i class="fas fa-fire text-orange-500"></i> TOP Vistos
                        </h3>
                        
                        <div class="space-y-4">
                            <?php foreach ($topViewed as $index => $soft): ?>
                                <a href="<?= url('software/' . htmlspecialchars($soft['slug'])) ?>" class="flex items-center gap-4 p-3 rounded-2xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all group">
                                    <div class="w-8 h-8 flex items-center justify-center font-black text-xs <?= $index < 3 ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/20' : 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400' ?> rounded-lg flex-shrink-0">
                                        <?= $index + 1 ?>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-bold text-sm text-gray-900 dark:text-white truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors"><?= htmlspecialchars($soft['name']) ?></h4>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <i class="fas fa-download text-[10px] text-gray-400"></i>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter"><?= number_format($soft['downloads']) ?></span>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Search Tips -->
                    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-8 text-white shadow-xl shadow-blue-500/20">
                        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-6 backdrop-blur-sm">
                            <i class="fas fa-lightbulb text-xl"></i>
                        </div>
                        <h3 class="text-lg font-black mb-4 tracking-tight">Tips Pro</h3>
                        <ul class="space-y-4 list-none p-0">
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-blue-200 mt-1"></i>
                                <span class="text-sm font-medium text-blue-50">Usa palabras clave cortas</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-blue-200 mt-1"></i>
                                <span class="text-sm font-medium text-blue-50">Busca por el nombre exacto</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Results Main -->
                <div class="lg:col-span-3">
                    <?php if (empty($software)): ?>
                        <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-16 text-center shadow-sm border border-gray-100 dark:border-gray-700/50">
                            <div class="w-24 h-24 bg-gray-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-8">
                                <i class="fas fa-search-minus text-4xl text-gray-300 dark:text-gray-600"></i>
                            </div>
                            <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-4 tracking-tight">Vaya, no hay coincidencias</h2>
                            <p class="text-gray-500 dark:text-gray-400 mb-10 max-w-sm mx-auto font-medium">
                                No pudimos encontrar resultados para <span class="text-gray-900 dark:text-white font-bold">"<?= htmlspecialchars($query) ?>"</span>. ¿Por qué no pruebas con algo diferente?
                            </p>
                            <a href="<?= url('software') ?>" class="inline-flex items-center gap-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-10 py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:scale-105 transition-all">
                                <i class="fas fa-arrow-left text-xs"></i> Explorar Catálogo
                            </a>
                        </div>
                    <?php else: ?>
                        <!-- Results Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php foreach ($software as $soft): 
                                $isPremium = !empty($soft['price']) && $soft['price'] > 0;
                                $iconPath = !empty($soft['icon']) ? $soft['icon'] : $soft['image'];
                            ?>
                                <a href="<?= url('software/' . htmlspecialchars($soft['slug'])) ?>" class="group block h-full">
                                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700/50 transition-all duration-500 hover:shadow-2xl hover:-translate-y-1 h-full flex flex-col relative overflow-hidden">
                                        <!-- Animated Background Hover -->
                                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/0 to-blue-500/0 group-hover:from-blue-500/[0.02] group-hover:to-purple-500/[0.02] transition-all duration-500"></div>
                                        
                                        <div class="flex items-start gap-5 relative z-10">
                                            <div class="w-16 h-16 rounded-2xl bg-white dark:bg-gray-700 shadow-md border border-gray-100 dark:border-gray-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-500 overflow-hidden">
                                                <?php if ($iconPath): ?>
                                                    <img src="<?= url($iconPath) ?>" alt="<?= htmlspecialchars($soft['name']) ?>" class="w-12 h-12 object-contain p-1">
                                                <?php else: ?>
                                                    <i class="fas fa-cube text-2xl text-blue-500"></i>
                                                <?php endif; ?>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <h3 class="text-lg font-black text-gray-900 dark:text-white truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                                        <?= htmlspecialchars($soft['name']) ?>
                                                    </h3>
                                                    <?php if (!empty($soft['version'])): ?>
                                                        <span class="text-[9px] font-black bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 px-2 py-0.5 rounded-full uppercase tracking-widest">
                                                            v<?= htmlspecialchars($soft['version']) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed font-medium mb-3">
                                                    <?= htmlspecialchars($soft['short_description'] ?? $soft['description'] ?? '') ?>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="mt-auto pt-6 flex items-center justify-between relative z-10">
                                            <div class="flex items-center gap-4 text-[10px] font-black uppercase tracking-widest text-gray-400">
                                                <span class="flex items-center gap-1.5">
                                                    <i class="fas fa-download text-green-500"></i>
                                                    <?= number_format($soft['downloads']) ?>
                                                </span>
                                                <span class="flex items-center gap-1.5">
                                                    <i class="fas fa-star text-yellow-500"></i>
                                                    <?= number_format($soft['rating'] ?? 4.5, 1) ?>
                                                </span>
                                            </div>
                                            
                                            <div class="flex items-center gap-3">
                                                <?php if ($isPremium): ?>
                                                    <span class="text-[10px] font-black text-purple-600 dark:text-purple-400 uppercase tracking-widest">PREMIUM</span>
                                                <?php else: ?>
                                                    <span class="text-[10px] font-black text-green-600 dark:text-green-400 uppercase tracking-widest">GRATIS</span>
                                                <?php endif; ?>
                                                <span class="w-8 h-8 rounded-full bg-gray-900 dark:bg-gray-700 text-white flex items-center justify-center group-hover:bg-blue-600 transition-colors">
                                                    <i class="fas fa-arrow-right text-[10px]"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</section>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../../layouts/main.php';
?>
