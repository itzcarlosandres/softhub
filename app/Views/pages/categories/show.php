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

<!-- Hero Section -->
<section class="bg-gradient-to-r from-purple-600 to-blue-600 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumb -->
            <div class="flex items-center text-sm text-purple-100 mb-6">
                <a href="<?= url() ?>" class="hover:text-white">Inicio</a>
                <i class="fas fa-chevron-right mx-2 text-xs"></i>
                <a href="<?= url('categories') ?>" class="hover:text-white">Categorías</a>
                <i class="fas fa-chevron-right mx-2 text-xs"></i>
                <span class="text-white font-medium"><?= htmlspecialchars($category['name']) ?></span>
            </div>
            
            <div class="flex items-center gap-6">
                <div class="w-24 h-24 bg-white rounded-2xl shadow-2xl flex items-center justify-center text-purple-600 text-4xl flex-shrink-0">
                    <i class="<?= htmlspecialchars($category['icon'] ?: 'fas fa-folder') ?>"></i>
                </div>
                <div class="flex-1">
                    <h1 class="text-4xl font-bold mb-2"><?= htmlspecialchars($category['name']) ?></h1>
                    <?php if (!empty($category['description'])): ?>
                        <p class="text-xl text-purple-100 mb-3"><?= htmlspecialchars($category['description']) ?></p>
                    <?php endif; ?>
                    <p class="text-purple-100">
                        <i class="fas fa-download mr-2"></i><?= $total ?> programas disponibles
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Software Grid -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Main Content -->
            <div class="lg:col-span-9">
                <?php if (!empty($software)): ?>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-8">
                        <?php foreach ($software as $soft): ?>
                            <a href="<?= url('software/' . htmlspecialchars($soft['slug'])) ?>" class="bg-white rounded-lg shadow-md p-4 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group relative">
                                <!-- Badges del Sistema -->
                                <?= render_badges($soft, 'bottom-left') ?>
                                
                                <div class="aspect-square bg-gray-50 rounded-lg mb-3 overflow-hidden flex items-center justify-center">
                                    <?php if (!empty($soft['icon'])): ?>
                                        <img src="<?= url(htmlspecialchars($soft['icon'])) ?>" alt="<?= htmlspecialchars($soft['name']) ?>" class="w-full h-full object-contain p-2">
                                    <?php else: ?>
                                        <i class="fas fa-download text-gray-400 text-3xl"></i>
                                    <?php endif; ?>
                                </div>
                                <h3 class="font-semibold text-sm text-gray-900 truncate mb-1 group-hover:text-purple-600"><?= htmlspecialchars($soft['name']) ?></h3>
                                <div class="flex items-center justify-end text-xs text-gray-500">
                                    <span class="text-yellow-500"><i class="fas fa-star"></i> <?= number_format($soft['rating'], 1) ?></span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                        <div class="flex justify-center items-center space-x-2">
                            <?php if ($page > 1): ?>
                                <a href="?page=<?= $page - 1 ?>" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            <?php endif; ?>
                            
                            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                                <a href="?page=<?= $i ?>" class="px-4 py-2 <?= $i === (int)$page ? 'bg-purple-600 text-white' : 'bg-white border border-gray-300 hover:bg-gray-50' ?> rounded-lg transition">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                            
                            <?php if ($page < $totalPages): ?>
                                <a href="?page=<?= $page + 1 ?>" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-center py-16 bg-white rounded-xl shadow-md">
                        <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                        <p class="text-xl text-gray-600 mb-6">No hay software en esta categoría</p>
                        <a href="<?= url('categories') ?>" class="inline-block px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                            <i class="fas fa-arrow-left mr-2"></i>Ver Todas las Categorías
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <aside class="lg:col-span-3">
                <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 text-white p-4 relative">
                        <h3 class="text-xl font-bold flex items-center">
                            <i class="fas fa-chart-line mr-2"></i>
                            Tendencia
                        </h3>
                        <!-- Trending Badge -->
                        <div class="absolute top-2 right-2">
                            <span class="bg-yellow-400 text-purple-900 text-xs font-bold px-2 py-1 rounded-full animate-pulse">
                                🔥 HOT
                            </span>
                        </div>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        <?php 
                        // Obtener los 10 más populares de esta categoría
                        $stmtTrending = $db->prepare("
                            SELECT * FROM software 
                            WHERE category_id = ? AND status = 'approved' 
                            ORDER BY downloads DESC, rating DESC 
                            LIMIT 10
                        ");
                        $stmtTrending->execute([$category['id']]);
                        $trending = $stmtTrending->fetchAll();
                        
                        $position = 1;
                        foreach ($trending as $soft): 
                            // Colores especiales para top 3
                            if ($position == 1) {
                                $bgColor = 'bg-gradient-to-br from-yellow-50 to-orange-50';
                                $borderColor = 'border-l-4 border-yellow-500';
                                $badgeColor = 'bg-gradient-to-br from-yellow-400 to-orange-500 text-white';
                            } elseif ($position == 2) {
                                $bgColor = 'bg-gradient-to-br from-gray-50 to-slate-100';
                                $borderColor = 'border-l-4 border-gray-400';
                                $badgeColor = 'bg-gradient-to-br from-gray-400 to-slate-500 text-white';
                            } elseif ($position == 3) {
                                $bgColor = 'bg-gradient-to-br from-orange-50 to-amber-50';
                                $borderColor = 'border-l-4 border-orange-400';
                                $badgeColor = 'bg-gradient-to-br from-orange-400 to-amber-500 text-white';
                            } else {
                                $bgColor = 'hover:bg-gray-50';
                                $borderColor = '';
                                $badgeColor = 'bg-gray-200 text-gray-700';
                            }
                        ?>
                            <a href="<?= url('software/' . htmlspecialchars($soft['slug'])) ?>" class="flex items-center gap-3 p-3 transition <?= $bgColor ?> <?= $borderColor ?>">
                                <!-- Position Badge -->
                                <div class="flex-shrink-0">
                                    <span class="w-8 h-8 flex items-center justify-center rounded-full <?= $badgeColor ?> font-bold text-sm shadow-md">
                                        <?= $position ?>
                                    </span>
                                </div>
                                
                                <!-- Icon -->
                                <div class="w-12 h-12 flex-shrink-0 bg-white rounded-lg overflow-hidden shadow-sm">
                                    <?php if (!empty($soft['icon'])): ?>
                                        <img src="<?= url(htmlspecialchars($soft['icon'])) ?>" alt="<?= htmlspecialchars($soft['name']) ?>" class="w-full h-full object-contain p-1">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-download text-gray-400"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Info -->
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-sm text-gray-900 truncate"><?= htmlspecialchars($soft['name']) ?></h4>
                                    <div class="flex items-center gap-3 text-xs text-gray-500 mt-1">
                                        <span><i class="fas fa-download text-green-600"></i> <?= number_format($soft['downloads']) ?></span>
                                        <span><i class="fas fa-star text-yellow-400"></i> <?= number_format($soft['rating'], 1) ?></span>
                                    </div>
                                </div>
                            </a>
                        <?php 
                            $position++;
                        endforeach; 
                        ?>
                    </div>
                </div>
                
                <!-- Más Descargado Sidebar -->
                <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden mt-6">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-500 text-white p-4 relative">
                        <h3 class="text-xl font-bold flex items-center">
                            <span class="animate-bounce mr-2">📥</span>
                            MÁS DESCARGADO
                        </h3>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        <?php
                        // Obtener top 10 más descargados de esta categoría
                        $stmt = $db->prepare("
                            SELECT * FROM software 
                            WHERE category_id = ? AND status = 'approved'
                            ORDER BY downloads DESC
                            LIMIT 10
                        ");
                        $stmt->execute([$category['id']]);
                        $topDownloads = $stmt->fetchAll();
                        
                        $position = 1;
                        foreach ($topDownloads as $soft):
                            // Estilos especiales para top 3
                            if ($position == 1) {
                                $bgColor = 'bg-gradient-to-br from-green-50 to-emerald-50';
                                $borderColor = 'border-l-4 border-green-500';
                                $badgeColor = 'bg-gradient-to-br from-green-500 to-emerald-600 text-white';
                            } elseif ($position == 2) {
                                $bgColor = 'bg-gradient-to-br from-teal-50 to-cyan-50';
                                $borderColor = 'border-l-4 border-teal-400';
                                $badgeColor = 'bg-gradient-to-br from-teal-400 to-cyan-500 text-white';
                            } elseif ($position == 3) {
                                $bgColor = 'bg-gradient-to-br from-lime-50 to-green-50';
                                $borderColor = 'border-l-4 border-lime-400';
                                $badgeColor = 'bg-gradient-to-br from-lime-400 to-green-500 text-white';
                            } else {
                                $bgColor = 'hover:bg-gray-50';
                                $borderColor = '';
                                $badgeColor = 'bg-gray-200 text-gray-700';
                            }
                        ?>
                            <a href="<?= url('software/' . htmlspecialchars($soft['slug'])) ?>" class="flex items-center gap-3 p-3 transition <?= $bgColor ?> <?= $borderColor ?>">
                                <!-- Position Badge -->
                                <div class="flex-shrink-0">
                                    <span class="w-8 h-8 flex items-center justify-center rounded-full <?= $badgeColor ?> font-bold text-sm shadow-md">
                                        <?= $position ?>
                                    </span>
                                </div>
                                
                                <!-- Icon -->
                                <div class="w-12 h-12 flex-shrink-0 bg-white rounded-lg overflow-hidden shadow-sm">
                                    <?php if (!empty($soft['icon'])): ?>
                                        <img src="<?= url(htmlspecialchars($soft['icon'])) ?>" alt="<?= htmlspecialchars($soft['name']) ?>" class="w-full h-full object-contain p-1">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-download text-gray-400"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Info -->
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-sm text-gray-900 truncate"><?= htmlspecialchars($soft['name']) ?></h4>
                                    <div class="flex items-center gap-3 text-xs text-gray-500 mt-1">
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-download text-green-600"></i>
                                            <?= number_format($soft['downloads']) ?>
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-star text-yellow-400"></i>
                                            <?= number_format($soft['rating'], 1) ?>
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
</section>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/main.php';
?>
