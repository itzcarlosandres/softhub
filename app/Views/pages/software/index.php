<?php 
ob_start(); 
?>

<!-- Hero Section -->
<section class="bg-white dark:bg-gray-900 py-12 border-b border-gray-100 dark:border-gray-800 transition-colors duration-300">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold text-gray-900 dark:text-white mb-4 transition-colors">
                Catálogo <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-500">Premium</span>
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 transition-colors">
                Explora nuestra colección curada de software verificado y seguro
            </p>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-12 transition-colors duration-300">
    <div class="container mx-auto px-4">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Main Column -->
            <div class="lg:col-span-9">
                <!-- Filtros -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-8 transition-colors">
                    <form method="GET" class="flex flex-wrap gap-4 items-end">
                        <!-- Ordenar por -->
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Ordenar por</label>
                            <select name="sort" class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white font-medium transition-colors">
                                <option value="latest" <?= ($_GET['sort'] ?? '') == 'latest' ? 'selected' : '' ?>>Más recientes</option>
                                <option value="downloads" <?= ($_GET['sort'] ?? '') == 'downloads' ? 'selected' : '' ?>>Más descargados</option>
                                <option value="rating" <?= ($_GET['sort'] ?? '') == 'rating' ? 'selected' : '' ?>>Mejor valorados</option>
                                <option value="name" <?= ($_GET['sort'] ?? '') == 'name' ? 'selected' : '' ?>>Nombre A-Z</option>
                            </select>
                        </div>
                        
                        <!-- Categoría -->
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Categoría</label>
                            <select name="category" class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white font-medium transition-colors">
                                <option value="">Todas las categorías</option>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>" <?= ($_GET['category'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <!-- Botón -->
                        <div>
                            <button type="submit" class="bg-gray-900 dark:bg-blue-600 hover:bg-black dark:hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold transition-all shadow-lg hover:shadow-xl">
                                <i class="fas fa-filter mr-2"></i>Filtrar
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Contador de resultados -->
                <?php if (!empty($software)): ?>
                    <div class="mb-8">
                        <p class="text-gray-600 dark:text-gray-400 text-lg transition-colors">
                            <span class="font-bold text-gray-900 dark:text-white"><?= count($software) ?></span> programas encontrados
                        </p>
                    </div>
                <?php endif; ?>
                
                <!-- Grid de Software - Cards Minimalistas -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php 
                    if (!empty($software)): 
                        $colors = ['blue', 'purple', 'green', 'orange', 'red', 'indigo', 'pink', 'teal'];
                        $colorIndex = 0;
                        
                        // Get trending software IDs (marked as trending in admin)
                        $db = \App\Database::getInstance()->getConnection();
                        $stmtTrending = $db->query("
                            SELECT id FROM software 
                            WHERE status = 'approved' AND trending = 1
                            ORDER BY downloads DESC 
                            LIMIT 10
                        ");
                        $trendingIds = array_column($stmtTrending->fetchAll(PDO::FETCH_ASSOC), 'id');
                        
                        foreach ($software as $index => $soft): 
                            $color = $colors[$colorIndex % count($colors)];
                            $colorIndex++;
                            $iconPath = !empty($soft['icon']) ? $soft['icon'] : $soft['image'];
                            $isNew = strtotime($soft['created_at']) > strtotime('-7 days');
                            $isTrending = in_array($soft['id'], $trendingIds);
                            $isPremium = !empty($soft['price']) && $soft['price'] > 0;
                    ?>
                    <div class="group cursor-pointer">
                        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 p-5 border border-gray-100 dark:border-gray-700/50 hover:border-blue-500 dark:hover:border-blue-500 transition-all duration-500 hover:shadow-xl">
                            <!-- Icon -->
                            <div class="mb-4 relative">
                                <div class="w-14 h-14 bg-white dark:bg-gray-700 rounded-xl shadow-md flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
                                    <?php if ($iconPath): ?>
                                        <img src="<?= url($iconPath) ?>" alt="<?= htmlspecialchars($soft['name']) ?>" class="w-12 h-12 object-contain p-1">
                                    <?php else: ?>
                                        <i class="fas fa-cube text-2xl text-<?= $color ?>-600 dark:text-<?= $color ?>-400"></i>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Badge superior derecho -->
                                <div class="absolute -top-1 -right-1 w-7 h-7 rounded-full flex items-center justify-center shadow-md">
                                    <?php if ($isTrending): ?>
                                        <div class="w-7 h-7 bg-gradient-to-br from-orange-500 to-red-500 rounded-full flex items-center justify-center animate-pulse">
                                            <i class="fas fa-fire text-white text-xs"></i>
                                        </div>
                                    <?php elseif ($isNew): ?>
                                        <div class="w-7 h-7 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-star text-white text-xs"></i>
                                        </div>
                                    <?php elseif ($isPremium): ?>
                                        <div class="w-7 h-7 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-crown text-white text-xs"></i>
                                        </div>
                                    <?php else: ?>
                                        <div class="w-7 h-7 bg-green-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-<?= $color ?>-600 dark:group-hover:text-<?= $color ?>-400 transition line-clamp-1">
                                <?= htmlspecialchars($soft['name']) ?>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4 leading-relaxed line-clamp-2 text-sm">
                                <?= htmlspecialchars(substr($soft['short_description'] ?? $soft['description'] ?? '', 0, 100)) ?>...
                            </p>
                            
                            <!-- Stats -->
                            <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400 mb-4 transition-colors">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-download text-<?= $color ?>-500 dark:text-<?= $color ?>-400"></i>
                                    <span class="font-medium text-gray-700 dark:text-gray-300"><?= number_format($soft['downloads'] ?? 0) ?></span>
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-star text-yellow-500"></i>
                                    <span class="font-medium text-gray-700 dark:text-gray-300"><?= number_format($soft['rating'] ?? 4.5, 1) ?></span>
                                </span>
                            </div>
                            
                            <!-- Button -->
                            <div class="flex items-center justify-between">
                                <?php if ($isPremium): ?>
                                    <span class="text-xs font-bold text-purple-600 dark:text-purple-400">$<?= number_format($soft['price'], 2) ?></span>
                                <?php else: ?>
                                    <span class="text-xs font-bold text-gray-900 dark:text-white">Gratis</span>
                                <?php endif; ?>
                                <a href="<?= url('software/' . $soft['slug']) ?>" class="px-4 py-2 bg-gray-900 dark:bg-gray-700 text-white rounded-full text-xs font-medium hover:bg-<?= $color ?>-600 dark:hover:bg-<?= $color ?>-500 transition-all transform group-hover:translate-x-1 inline-flex items-center gap-1">
                                    Ver <i class="fas fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                            
                            <!-- Trending Badge (si aplica) -->
                            <?php if ($isTrending): ?>
                                <div class="absolute top-3 left-3">
                                    <span class="px-2 py-1 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-full text-xs font-bold shadow-lg flex items-center gap-1">
                                        <i class="fas fa-fire text-xs"></i> HOT
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php 
                        endforeach; 
                    else: 
                    ?>
                        <div class="col-span-full text-center py-20">
                            <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6 transition-colors">
                                <i class="fas fa-inbox text-gray-300 dark:text-gray-600 text-5xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2 transition-colors">No se encontraron programas</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-lg transition-colors">Intenta ajustar los filtros de búsqueda</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Paginación -->
                <?php if (!empty($totalPages) && $totalPages > 1): ?>
                    <div class="mt-16 flex justify-center">
                        <nav class="flex gap-2">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a href="?page=<?= $i ?><?= !empty($_GET['sort']) ? '&sort=' . $_GET['sort'] : '' ?><?= !empty($_GET['category']) ? '&category=' . $_GET['category'] : '' ?>" 
                                   class="px-6 py-3 rounded-xl font-bold transition-all shadow-sm <?= ($currentPage ?? 1) == $i ? 'bg-gray-900 dark:bg-blue-600 text-white shadow-lg' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                        </nav>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <aside class="lg:col-span-3">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden sticky top-24 transition-colors">
                    <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white p-6 relative">
                        <h3 class="text-2xl font-bold flex items-center">
                            <i class="fas fa-fire mr-2"></i>
                            Trending
                        </h3>
                        <p class="text-white/80 text-sm mt-1">Los más populares</p>
                        <div class="absolute top-4 right-4">
                            <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full animate-pulse">
                                🔥 HOT
                            </span>
                        </div>
                    </div>
                    
                    <div class="divide-y divide-gray-100 dark:divide-gray-700/50 transition-colors">
                        <?php 
                        // Get trending software (marked by admin)
                        $db = \App\Database::getInstance()->getConnection();
                        $stmtTrendingList = $db->query("
                            SELECT * FROM software 
                            WHERE status = 'approved' AND trending = 1
                            ORDER BY downloads DESC, rating DESC 
                            LIMIT 10
                        ");
                        $trendingList = $stmtTrendingList->fetchAll();
                        
                        $position = 1;
                        foreach ($trendingList as $soft): 
                            // Colores especiales para top 3
                            if ($position == 1) {
                                $bgColor = 'bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20';
                                $borderColor = 'border-l-4 border-yellow-500';
                                $badgeColor = 'bg-gradient-to-br from-yellow-400 to-orange-500 text-white';
                            } elseif ($position == 2) {
                                $bgColor = 'bg-gradient-to-br from-gray-50 to-slate-100 dark:from-gray-800 dark:to-slate-800';
                                $borderColor = 'border-l-4 border-gray-400';
                                $badgeColor = 'bg-gradient-to-br from-gray-400 to-slate-500 text-white';
                            } elseif ($position == 3) {
                                $bgColor = 'bg-gradient-to-br from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20';
                                $borderColor = 'border-l-4 border-orange-400';
                                $badgeColor = 'bg-gradient-to-br from-orange-400 to-amber-500 text-white';
                            } else {
                                $bgColor = 'hover:bg-gray-50 dark:hover:bg-gray-700/50';
                                $borderColor = 'border-l-4 border-transparent';
                                $badgeColor = 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
                            }
                        ?>
                            <a href="<?= url('software/' . htmlspecialchars($soft['slug'])) ?>" class="flex items-center gap-3 p-4 transition <?= $bgColor ?> <?= $borderColor ?>">
                                <div class="flex-shrink-0">
                                    <span class="w-10 h-10 flex items-center justify-center rounded-full <?= $badgeColor ?> font-bold text-sm shadow-md">
                                        <?= $position ?>
                                    </span>
                                </div>
                                
                                <div class="w-12 h-12 flex-shrink-0 bg-white dark:bg-gray-700 rounded-xl overflow-hidden shadow-sm border border-gray-100 dark:border-gray-600/50 transition-colors">
                                    <?php if (!empty($soft['icon'])): ?>
                                        <img src="<?= url(htmlspecialchars($soft['icon'])) ?>" alt="<?= htmlspecialchars($soft['name']) ?>" class="w-full h-full object-contain p-1">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-download text-gray-400 dark:text-gray-500"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-sm text-gray-900 dark:text-white truncate transition-colors"><?= htmlspecialchars($soft['name']) ?></h4>
                                    <div class="flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400 mt-1 transition-colors">
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-download text-green-600 dark:text-green-400"></i>
                                            <span class="text-gray-700 dark:text-gray-300"><?= number_format($soft['downloads']) ?></span>
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-star text-yellow-400"></i>
                                            <span class="text-gray-700 dark:text-gray-300"><?= number_format($soft['rating'], 1) ?></span>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        <?php 
                            $position++;
                        endforeach; 
                        ?>
                    </div>
                </div>
            </aside>
            
        </div>
        
    </div>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../../layouts/main.php';
?>
