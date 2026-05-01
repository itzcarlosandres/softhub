<?php
// Obtener la categoría
$slug = $params['slug'] ?? '';
$stmt = $db->prepare("SELECT * FROM categories WHERE slug = ?");
$stmt->execute([$slug]);
$category = $stmt->fetch();

if (!$category) {
    header('Location: ' . url('categories'));
    exit;
}

$title = htmlspecialchars($category['name']) . ' - Descarga Software Gratis';
$description = htmlspecialchars($category['description'] ?: 'Software de ' . $category['name']);

// Obtener software de esta categoría con paginación
$page = $_GET['page'] ?? 1;
$perPage = 24;
$offset = ($page - 1) * $perPage;

$stmt = $db->prepare("SELECT * FROM software WHERE category_id = ? AND status = 'approved' ORDER BY downloads DESC LIMIT $perPage OFFSET $offset");
$stmt->execute([$category['id']]);
$software = $stmt->fetchAll();

$stmt = $db->prepare("SELECT COUNT(*) as total FROM software WHERE category_id = ? AND status = 'approved'");
$stmt->execute([$category['id']]);
$total = $stmt->fetch()['total'];
$totalPages = ceil($total / $perPage);

ob_start();
?>

<!-- Breadcrumbs & Hero Section -->
<div class="container mx-auto px-4 pt-4 pb-8">
    <!-- Breadcrumb -->
    <nav class="flex text-sm text-gray-500 dark:text-gray-400 mb-6" aria-label="Breadcrumb">
      <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
          <a href="<?= url() ?>" class="inline-flex items-center hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
            <i class="fas fa-home mr-2"></i> Inicio
          </a>
        </li>
        <li>
          <div class="flex items-center">
            <i class="fas fa-chevron-right text-xs mx-1"></i>
            <a href="<?= url('categories') ?>" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors ml-1 md:ml-2">Categorías</a>
          </div>
        </li>
        <li aria-current="page">
          <div class="flex items-center">
            <i class="fas fa-chevron-right text-xs mx-1"></i>
            <span class="text-gray-900 dark:text-white font-medium ml-1 md:ml-2"><?= htmlspecialchars($category['name']) ?></span>
          </div>
        </li>
      </ol>
    </nav>

    <!-- Hero Card -->
    <div class="relative bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-sm border border-gray-100 dark:border-gray-700/50 transition-colors">
        <!-- Background decorative elements -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div class="absolute -top-[20%] -right-[10%] w-[300px] h-[300px] bg-blue-400/10 rounded-full blur-[80px]"></div>
            <div class="absolute -bottom-[20%] -left-[10%] w-[300px] h-[300px] bg-purple-400/10 rounded-full blur-[80px]"></div>
        </div>
        
        <div class="relative z-10 px-8 py-10 md:p-12 flex flex-col md:flex-row items-center md:items-start gap-8">
            <div class="w-24 h-24 md:w-32 md:h-32 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-2xl shadow-inner border border-gray-200 dark:border-gray-600 flex items-center justify-center flex-shrink-0 text-blue-500 text-4xl md:text-5xl group">
                <i class="<?= get_category_icon($category) ?> transition-transform group-hover:scale-110 duration-300"></i>
            </div>
            
            <div class="text-center md:text-left flex-1 border-b border-transparent">
                <h1 class="font-outfit text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white mb-3">
                    <?= htmlspecialchars($category['name']) ?>
                </h1>
                <?php if (!empty($category['description'])): ?>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-4 max-w-2xl">
                        <?= htmlspecialchars($category['description']) ?>
                    </p>
                <?php endif; ?>
                
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mt-4">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold border border-blue-100 dark:border-blue-800">
                        <i class="fas fa-layer-group"></i> <?= $total ?> programas
                    </span>
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-sm font-semibold border border-green-100 dark:border-green-800">
                        <i class="fas fa-check-circle"></i> 100% Verificado
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container mx-auto px-4 pb-16">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Software Grid Column -->
        <div class="lg:col-span-9">
            <?php if (!empty($software)): ?>
                
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2 transition-colors">
                        <i class="fas fa-th-large text-blue-500"></i>
                        Programas Disponibles
                    </h2>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-6 relative transition-opacity duration-300">
                    <?php 
                    // Obtener los IDs más populares de esta categoría para pasarlos a las cards como trending
                    $stmtTrendingIds = $db->prepare("
                        SELECT id FROM software 
                        WHERE category_id = ? AND status = 'approved' 
                        ORDER BY downloads DESC, rating DESC 
                        LIMIT 3
                    ");
                    $stmtTrendingIds->execute([$category['id']]);
                    $trendingIdsRaw = $stmtTrendingIds->fetchAll(PDO::FETCH_COLUMN);
                    $trendingIds = is_array($trendingIdsRaw) ? $trendingIdsRaw : [];

                    $showIcon = true;
                    $showBadges = true;
                    $showDesc = false;
                    $showRating = true;
                    $showDownloads = true;
                    $showPrice = false;
                    $showButton = false;

                    foreach ($software as $soft): 
                        $isTrending = in_array($soft['id'], $trendingIds);
                        include __DIR__ . '/../../partials/software_card.php';
                    endforeach; 
                    ?>
                </div>
                
                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <div class="flex justify-center mt-12">
                        <nav aria-label="Page navigation">
                            <ul class="inline-flex items-center -space-x-px">
                                <?php if ($page > 1): ?>
                                    <li>
                                        <a href="?page=<?= $page - 1 ?>" class="block px-4 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white transition-colors">
                                            <span class="sr-only">Anterior</span>
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                                    <li>
                                        <a href="?page=<?= $i ?>" class="px-4 py-2 leading-tight <?= $i === (int)$page ? 'text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white z-10' : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white' ?> transition-colors relative">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                                
                                <?php if ($page < $totalPages): ?>
                                    <li>
                                        <a href="?page=<?= $page + 1 ?>" class="block px-4 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white transition-colors">
                                            <span class="sr-only">Siguiente</span>
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>
                
            <?php else: ?>
                <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 mt-4">
                    <div class="w-24 h-24 bg-gray-50 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-inbox text-gray-400 dark:text-gray-500 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2 transition-colors">Categoría vacía</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6 transition-colors">Aún no hay programas aprobados en esta categoría.</p>
                    <a href="<?= url('categories') ?>" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-semibold shadow-md">
                        <i class="fas fa-arrow-left mr-2"></i> Volver a Explorar
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Sidebar Column -->
        <aside class="lg:col-span-3 space-y-6">
            
            <!-- Tendencia Widget -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-lg dark:shadow-gray-900/50 border border-gray-100 dark:border-gray-700/50 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2 transition-colors">
                        <i class="fas fa-fire text-orange-500"></i>
                        Tendencia
                    </h2>
                    <span class="bg-orange-100 text-orange-600 dark:bg-orange-900/40 dark:text-orange-400 text-xs px-2 py-1 rounded-md font-bold animate-pulse">HOT</span>
                </div>
                
                <div class="space-y-2">
                    <?php 
                    $stmtTrending = $db->prepare("
                        SELECT * FROM software 
                        WHERE category_id = ? AND status = 'approved' 
                        ORDER BY downloads DESC, rating DESC 
                        LIMIT 5
                    ");
                    $stmtTrending->execute([$category['id']]);
                    $trendingList = $stmtTrending->fetchAll();
                    
                    $position = 1;
                    foreach ($trendingList as $soft): 
                        if ($position == 1) {
                            $badgeBg = 'bg-yellow-400';
                            $badgeText = 'text-gray-900';
                        } elseif ($position == 2) {
                            $badgeBg = 'bg-gray-300 dark:bg-gray-500';
                            $badgeText = 'text-gray-800 dark:text-gray-100';
                        } elseif ($position == 3) {
                            $badgeBg = 'bg-orange-300 dark:bg-orange-700';
                            $badgeText = 'text-orange-900 dark:text-orange-100';
                        } else {
                            $badgeBg = 'bg-gray-100 dark:bg-gray-700';
                            $badgeText = 'text-gray-600 dark:text-gray-300';
                        }
                    ?>
                    <a href="<?= url('software/' . htmlspecialchars($soft['slug'])) ?>" 
                       class="bg-white dark:bg-gray-800 border border-gray-50 dark:border-gray-700/30 hover:border-orange-500/30 dark:hover:border-orange-500/50 rounded-lg p-2.5 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:shadow-sm transition-all duration-300 cursor-pointer flex items-center gap-3 group">
                        
                        <span class="w-6 h-6 <?= $badgeBg ?> rounded-md flex items-center justify-center text-xs font-bold <?= $badgeText ?> flex-shrink-0 shadow-sm transition-colors">
                            <?= $position ?>
                        </span>
                        
                        <div class="w-10 h-10 bg-gray-50 dark:bg-gray-700 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform border border-gray-100 dark:border-gray-600">
                            <?php if (!empty($soft['icon'])): ?>
                                <img src="<?= url(htmlspecialchars($soft['icon'])) ?>" alt="<?= htmlspecialchars($soft['name']) ?>" class="w-full h-full object-contain p-1">
                            <?php else: ?>
                                <i class="fas fa-cube text-gray-400 dark:text-gray-500"></i>
                            <?php endif; ?>
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                <?= htmlspecialchars($soft['name']) ?>
                            </h3>
                            <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                <span class="flex items-center gap-1"><i class="fas fa-star text-yellow-400"></i> <?= number_format($soft['rating'], 1) ?></span>
                                <span class="text-gray-300 dark:text-gray-600 mx-0.5">•</span>
                                <span class="flex items-center gap-1"><i class="fas fa-download text-green-500"></i> <?= number_format($soft['downloads']) ?></span>
                            </div>
                        </div>
                    </a>
                    <?php 
                    $position++;
                    endforeach; 
                    ?>
                </div>
            </div>

            <!-- Más Descargado Widget -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-lg dark:shadow-gray-900/50 border border-gray-100 dark:border-gray-700/50 transition-colors sticky top-24">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2 transition-colors">
                        <i class="fas fa-download text-green-500"></i>
                        Top Descargas
                    </h2>
                </div>
                
                <div class="space-y-2">
                    <?php
                    $stmtTop = $db->prepare("
                        SELECT * FROM software 
                        WHERE category_id = ? AND status = 'approved'
                        ORDER BY downloads DESC
                        LIMIT 5
                    ");
                    $stmtTop->execute([$category['id']]);
                    $topDownloads = $stmtTop->fetchAll();
                    
                    $position = 1;
                    foreach ($topDownloads as $soft):
                        if ($position == 1) {
                            $badgeBg = 'bg-green-500 text-white';
                            $badgeText = '';
                        } elseif ($position == 2) {
                            $badgeBg = 'bg-emerald-400 text-white';
                            $badgeText = '';
                        } elseif ($position == 3) {
                            $badgeBg = 'bg-teal-400 text-white';
                            $badgeText = '';
                        } else {
                            $badgeBg = 'bg-gray-100 dark:bg-gray-700';
                            $badgeText = 'text-gray-600 dark:text-gray-300';
                        }
                    ?>
                    <a href="<?= url('software/' . htmlspecialchars($soft['slug'])) ?>" 
                       class="bg-white dark:bg-gray-800 border border-gray-50 dark:border-gray-700/30 hover:border-green-500/30 dark:hover:border-green-500/50 rounded-lg p-2.5 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:shadow-sm transition-all duration-300 cursor-pointer flex items-center gap-3 group">
                        
                        <span class="w-6 h-6 <?= $badgeBg ?> <?= $badgeText ?> rounded-md flex items-center justify-center text-xs font-bold flex-shrink-0 shadow-sm transition-colors">
                            <?= $position ?>
                        </span>
                        
                        <div class="w-10 h-10 bg-gray-50 dark:bg-gray-700 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform border border-gray-100 dark:border-gray-600">
                            <?php if (!empty($soft['icon'])): ?>
                                <img src="<?= url(htmlspecialchars($soft['icon'])) ?>" alt="<?= htmlspecialchars($soft['name']) ?>" class="w-full h-full object-contain p-1">
                            <?php else: ?>
                                <i class="fas fa-download text-gray-400 dark:text-gray-500"></i>
                            <?php endif; ?>
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white truncate group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                                <?= htmlspecialchars($soft['name']) ?>
                            </h3>
                            <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                <span class="flex items-center gap-1 font-medium text-gray-600 dark:text-gray-300"><i class="fas fa-download text-green-500"></i> <?= number_format($soft['downloads']) ?></span>
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

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/main.php';
?>
