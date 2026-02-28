<?php
$title = 'Software - Descarga Gratis';
$description = 'Explora nuestra colección completa de software gratuito';

// Filtros
$sort = $_GET['sort'] ?? 'newest'; // newest, downloads, rating
$category = $_GET['category'] ?? '';

// Paginación
$page = $_GET['page'] ?? 1;
$perPage = 24;
$offset = ($page - 1) * $perPage;

// Construir query según filtros
$orderBy = match($sort) {
    'downloads' => 'ORDER BY s.downloads DESC',
    'rating' => 'ORDER BY s.rating DESC',
    'newest' => 'ORDER BY s.created_at DESC',
    default => 'ORDER BY s.created_at DESC'
};

$whereCategory = $category ? "AND s.category_id = " . (int)$category : "";

// Obtener software
$software = $db->query("
    SELECT s.*, c.name as category_name 
    FROM software s 
    LEFT JOIN categories c ON s.category_id = c.id 
    WHERE s.status = 'approved' $whereCategory
    $orderBy
    LIMIT $perPage OFFSET $offset
")->fetchAll();

$total = $db->query("SELECT COUNT(*) as total FROM software WHERE status = 'approved' $whereCategory")->fetch()['total'];
$totalPages = ceil($total / $perPage);

// Obtener categorías para el filtro
$categories = $db->query("SELECT * FROM categories ORDER BY name")->fetchAll();

ob_start();
?>

<!-- Header -->
<div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-4xl font-bold mb-2">Todo el Software</h1>
            <p class="text-purple-100"><?= number_format($total) ?> programas disponibles</p>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white border-b border-gray-200 sticky top-0 z-10 shadow-sm">
    <div class="container mx-auto px-4 py-4">
        <div class="max-w-6xl mx-auto">
            <form method="GET" class="flex flex-wrap gap-4 items-center">
                <!-- Sort Filter -->
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium text-gray-700">Ordenar:</label>
                    <select name="sort" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Más Nuevos</option>
                        <option value="downloads" <?= $sort === 'downloads' ? 'selected' : '' ?>>Más Descargados</option>
                        <option value="rating" <?= $sort === 'rating' ? 'selected' : '' ?>>Mejor Valorados</option>
                    </select>
                </div>
                
                <!-- Category Filter -->
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium text-gray-700">Categoría:</label>
                    <select name="category" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">Todas</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= $category == $cat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Reset Button -->
                <?php if ($sort !== 'newest' || $category): ?>
                    <a href="<?= url('software') ?>" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                        <i class="fas fa-times-circle mr-1"></i>Limpiar filtros
                    </a>
                <?php endif; ?>
                
                <!-- Results Count -->
                <div class="ml-auto text-sm text-gray-600">
                    Mostrando <?= count($software) ?> de <?= number_format($total) ?> programas
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Software Grid -->
<section class="py-8 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <?php if (!empty($software)): ?>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-8">
                    <?php foreach ($software as $soft): ?>
                        <a href="<?= url('software/' . htmlspecialchars($soft['slug'])) ?>" class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-lg hover:border-purple-300 transition group">
                            <div class="aspect-square bg-gray-100 rounded-lg mb-3 overflow-hidden flex items-center justify-center">
                                <?php if (!empty($soft['icon'])): ?>
                                    <img src="<?= url(htmlspecialchars($soft['icon'])) ?>" alt="<?= htmlspecialchars($soft['name']) ?>" class="w-full h-full object-contain p-2">
                                <?php else: ?>
                                    <i class="fas fa-download text-gray-400 text-3xl"></i>
                                <?php endif; ?>
                            </div>
                            <h3 class="font-semibold text-sm text-gray-900 truncate mb-1 group-hover:text-purple-600"><?= htmlspecialchars($soft['name']) ?></h3>
                            <p class="text-xs text-gray-500 truncate mb-2"><?= htmlspecialchars($soft['category_name'] ?? 'General') ?></p>
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span><i class="fas fa-download"></i> <?= number_format($soft['downloads']) ?></span>
                                <span class="text-yellow-500"><i class="fas fa-star"></i> <?= number_format($soft['rating'], 1) ?></span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
                
                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <div class="flex justify-center items-center space-x-2">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?= $page - 1 ?>&sort=<?= $sort ?>&category=<?= $category ?>" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                            <a href="?page=<?= $i ?>&sort=<?= $sort ?>&category=<?= $category ?>" class="px-4 py-2 <?= $i === (int)$page ? 'bg-purple-600 text-white' : 'bg-white border border-gray-300 hover:bg-gray-50' ?> rounded-lg transition">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?= $page + 1 ?>&sort=<?= $sort ?>&category=<?= $category ?>" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-center py-16 bg-white rounded-xl shadow-md">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <p class="text-xl text-gray-600 mb-6">No hay software disponible con estos filtros</p>
                    <a href="<?= url('software') ?>" class="inline-block px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                        <i class="fas fa-times-circle mr-2"></i>Limpiar filtros
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/main.php';
?>
