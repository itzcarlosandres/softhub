<?php
$currentPage = 'software';
// Page Layout
ob_start();

// Pagination Logic
$page = $_GET['page'] ?? 1;
$perPage = 15;
$offset = ($page - 1) * $perPage;

// Filters
$where = ["1=1"];
$params = [];

if (!empty($_GET['search'])) {
    $where[] = "(s.name LIKE ? OR s.developer LIKE ?)";
    $val = '%' . $_GET['search'] . '%';
    $params[] = $val;
    $params[] = $val;
}
if (!empty($_GET['category'])) {
    $where[] = "s.category_id = ?";
    $params[] = $_GET['category'];
}
if (isset($_GET['featured']) && $_GET['featured'] !== '') {
    $where[] = "s.featured = ?";
    $params[] = $_GET['featured'];
}
if (isset($_GET['trending']) && $_GET['trending'] !== '') {
    $where[] = "s.trending = ?";
    $params[] = $_GET['trending'];
}

$whereClause = implode(' AND ', $where);

// Data Query
$stmt = $db->prepare("
    SELECT s.*, c.name as category_name 
    FROM software s 
    LEFT JOIN categories c ON s.category_id = c.id 
    WHERE $whereClause
    ORDER BY s.created_at DESC 
    LIMIT $perPage OFFSET $offset
");
$stmt->execute($params);
$software = $stmt->fetchAll();

// Count Query
$stmtCount = $db->prepare("SELECT COUNT(*) as total FROM software s WHERE $whereClause");
$stmtCount->execute($params);
$total = $stmtCount->fetch()['total'];
$totalPages = ceil($total / $perPage);

// Categories for Filter
$categories = $db->query("SELECT * FROM categories ORDER BY name")->fetchAll();
?>

<div class="space-y-6 animate-fade-in-up">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white font-outfit flex items-center gap-3">
                <i class="fas fa-boxes text-purple-400"></i> Gestión de Software
            </h1>
            <p class="text-gray-400 mt-1">Administra el catálogo de aplicaciones de SoftHub.</p>
        </div>
        <a href="<?= url('admin/software/create') ?>" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl shadow-lg shadow-blue-600/20 transition-all hover:scale-105 font-medium flex items-center gap-2">
            <i class="fas fa-plus"></i> Nuevo Software
        </a>
    </div>

    <!-- Filters Panel -->
    <div class="glass-panel p-6 rounded-2xl">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-4">
            
            <!-- Search -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Buscar</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-3 text-gray-500"></i>
                    <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
                        placeholder="Nombre, desarrollador..." 
                        class="w-full bg-white/5 border border-white/10 rounded-xl py-2.5 pl-10 pr-4 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500/50 focus:bg-white/10 transition-all">
                </div>
            </div>

            <!-- Category -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Categoría</label>
                <select name="category" class="w-full bg-white/5 border border-white/10 rounded-xl py-2.5 px-4 text-white focus:outline-none focus:border-blue-500/50 focus:bg-white/10 transition-all appearance-none cursor-pointer">
                    <option value="" class="bg-gray-900 text-gray-400">Todas</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" class="bg-gray-900" <?= ($_GET['category'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Status Filters -->
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Destacado</label>
                    <select name="featured" class="w-full bg-white/5 border border-white/10 rounded-xl py-2.5 px-2 text-white text-sm focus:outline-none focus:border-blue-500/50 transition-all appearance-none cursor-pointer">
                        <option value="" class="bg-gray-900">Todos</option>
                        <option value="1" class="bg-gray-900" <?= ($_GET['featured'] ?? '') == '1' ? 'selected' : '' ?>>Sí</option>
                        <option value="0" class="bg-gray-900" <?= ($_GET['featured'] ?? '') == '0' ? 'selected' : '' ?>>No</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Trending</label>
                    <select name="trending" class="w-full bg-white/5 border border-white/10 rounded-xl py-2.5 px-2 text-white text-sm focus:outline-none focus:border-blue-500/50 transition-all appearance-none cursor-pointer">
                        <option value="" class="bg-gray-900">Todos</option>
                        <option value="1" class="bg-gray-900" <?= ($_GET['trending'] ?? '') == '1' ? 'selected' : '' ?>>Sí</option>
                        <option value="0" class="bg-gray-900" <?= ($_GET['trending'] ?? '') == '0' ? 'selected' : '' ?>>No</option>
                    </select>
                </div>
            </div>

            <!-- Filter Button -->
            <div class="flex items-end">
                <button type="submit" class="w-full bg-purple-600/80 hover:bg-purple-600 text-white font-medium py-2.5 rounded-xl transition-all border border-purple-500/30">
                    <i class="fas fa-filter mr-2"></i> Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Software Table -->
    <div class="glass-panel rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-black/20 text-gray-400 text-xs uppercase font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Software</th>
                        <th class="px-6 py-4">Categoría</th>
                        <th class="px-6 py-4">Estado</th>
                        <th class="px-6 py-4 text-center">Stats</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-sm">
                    <?php if (empty($software)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-ghost text-2xl text-gray-600"></i>
                                </div>
                                <h3 class="text-lg font-bold text-white">No se encontraron resultados</h3>
                                <p class="text-gray-500">Intenta ajustar los filtros de búsqueda.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($software as $soft): ?>
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-gray-800 flex items-center justify-center overflow-hidden border border-white/10 group-hover:border-blue-500/50 transition-colors shadow-lg">
                                        <?php if (!empty($soft['icon'])): ?>
                                            <img src="<?= url(htmlspecialchars($soft['icon'])) ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <i class="fas fa-box text-gray-500"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="font-bold text-white group-hover:text-blue-400 transition-colors"><?= htmlspecialchars($soft['name']) ?></div>
                                        <div class="text-xs text-gray-500"><?= htmlspecialchars($soft['developer'] ?? 'Desconocido') ?> • v<?= htmlspecialchars($soft['version']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-white/5 text-gray-300 border border-white/10">
                                    <?= htmlspecialchars($soft['category_name'] ?? 'General') ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <?php if ($soft['featured']): ?>
                                        <span class="w-8 h-8 rounded-lg bg-yellow-500/10 text-yellow-500 flex items-center justify-center border border-yellow-500/20" title="Destacado">
                                            <i class="fas fa-star text-xs"></i>
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($soft['trending']): ?>
                                        <span class="w-8 h-8 rounded-lg bg-orange-500/10 text-orange-500 flex items-center justify-center border border-orange-500/20" title="Trending">
                                            <i class="fas fa-fire text-xs"></i>
                                        </span>
                                    <?php endif; ?>
                                    <?php if (!$soft['featured'] && !$soft['trending']): ?>
                                        <span class="text-gray-600 text-xs">-</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="font-bold text-white"><?= number_format($soft['downloads']) ?></span>
                                    <span class="text-[10px] text-gray-500 uppercase tracking-widest">Descargas</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                                    <a href="<?= url('admin/software/edit/' . $soft['id']) ?>" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-blue-600 hover:text-white flex items-center justify-center text-gray-400 transition-all" title="Editar">
                                        <i class="fas fa-pencil-alt text-xs"></i>
                                    </a>
                                    
                                    <?php if ($soft['featured']): ?>
                                        <a href="<?= url('admin/software/toggle-featured/' . $soft['id']) ?>" class="w-8 h-8 rounded-lg bg-yellow-500/20 text-yellow-500 hover:bg-yellow-500 hover:text-black flex items-center justify-center transition-all" title="Quitar Destacado">
                                            <i class="fas fa-star text-xs"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= url('admin/software/toggle-featured/' . $soft['id']) ?>" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-yellow-500 hover:text-black text-gray-500 flex items-center justify-center transition-all" title="Hacer Destacado">
                                            <i class="far fa-star text-xs"></i>
                                        </a>
                                    <?php endif; ?>

                                    <button onclick="confirmDelete(<?= $soft['id'] ?>, '<?= htmlspecialchars($soft['name']) ?>')" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-red-600 hover:text-white flex items-center justify-center text-gray-400 transition-all" title="Eliminar">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
        <div class="border-t border-white/5 p-4 flex items-center justify-between">
            <div class="text-xs text-gray-500">
                Página <?= $page ?> de <?= $totalPages ?>
            </div>
            <div class="flex gap-2">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>" class="px-3 py-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-white text-xs border border-white/5 transition-colors">Anterior</a>
                <?php endif; ?>
                
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>" class="px-3 py-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-white text-xs border border-white/5 transition-colors">Siguiente</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    if (confirm(`¿Eliminar ${name}? Esta acción no se puede deshacer.`)) {
        window.location.href = '<?= url('admin/software/delete/') ?>' + id;
    }
}
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
?>
