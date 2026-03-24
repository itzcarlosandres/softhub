<?php ob_start(); ?>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-white mb-2">Categorías del Blog</h1>
        <p class="text-gray-400">Gestiona las recuentos de categorías del blog.</p>
    </div>
    <button onclick="document.getElementById('createCategoryModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-medium transition-colors shadow-lg shadow-blue-600/20 flex items-center gap-2">
        <i class="fas fa-plus"></i> Nueva Categoría
    </button>
</div>

<div class="glass-panel rounded-2xl border border-white/5 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white/5 border-b border-white/5">
                    <th class="p-4 text-sm font-semibold text-gray-300">#</th>
                    <th class="p-4 text-sm font-semibold text-gray-300">Nombre</th>
                    <th class="p-4 text-sm font-semibold text-gray-300">Slug</th>
                    <th class="p-4 text-sm font-semibold text-gray-300">Artículos</th>
                    <th class="p-4 text-sm font-semibold text-gray-300 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                <?php if (empty($categories)): ?>
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-400">
                            <i class="fas fa-folder-open text-3xl mb-3 opacity-50 block"></i>
                            No hay categorías creadas.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($categories as $index => $category): ?>
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="p-4 text-gray-400"><?= $index + 1 ?></td>
                            <td class="p-4">
                                <span class="font-medium text-white"><?= htmlspecialchars($category['name']) ?></span>
                            </td>
                            <td class="p-4 text-gray-400">
                                <?= htmlspecialchars($category['slug']) ?>
                            </td>
                            <td class="p-4">
                                <span class="bg-blue-500/10 text-blue-400 px-2.5 py-1 rounded-lg text-xs font-medium border border-blue-500/20">
                                    <?= $category['posts_count'] ?? 0 ?> artículos
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button onclick="editCategory(<?= htmlspecialchars(json_encode($category)) ?>)" class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 flex items-center justify-center transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="<?= url('admin/blog-categories/delete/' . $category['id']) ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría? (Los artículos pasarán a la categoría General)')" class="w-8 h-8 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 flex items-center justify-center transition-colors">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Create -->
<div id="createCategoryModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center">
    <div class="glass-panel w-full max-w-md rounded-2xl border border-white/10 overflow-hidden shadow-2xl scale-100 transition-transform">
        <div class="p-6 border-b border-white/10 flex justify-between items-center">
            <h3 class="text-xl font-bold text-white">Nueva Categoría</h3>
            <button onclick="document.getElementById('createCategoryModal').classList.add('hidden')" class="text-gray-400 hover:text-white transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="<?= url('admin/blog-categories/store') ?>" method="POST" class="p-6">
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-300 mb-2">Nombre de Categoría</label>
                <input type="text" name="name" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-inter" placeholder="Ej: Tutoriales">
            </div>
            
            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="document.getElementById('createCategoryModal').classList.add('hidden')" class="px-5 py-2.5 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition-colors font-medium">
                    Cancelar
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors shadow-lg shadow-blue-600/20">
                    Guardar Categoría
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="editCategoryModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center">
    <div class="glass-panel w-full max-w-md rounded-2xl border border-white/10 overflow-hidden shadow-2xl">
        <div class="p-6 border-b border-white/10 flex justify-between items-center">
            <h3 class="text-xl font-bold text-white">Editar Categoría</h3>
            <button onclick="document.getElementById('editCategoryModal').classList.add('hidden')" class="text-gray-400 hover:text-white transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="editCategoryForm" method="POST" class="p-6">
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-300 mb-2">Nombre de Categoría</label>
                <input type="text" name="name" id="editName" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-inter">
            </div>
            
            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="document.getElementById('editCategoryModal').classList.add('hidden')" class="px-5 py-2.5 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition-colors font-medium">
                    Cancelar
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors shadow-lg shadow-blue-600/20">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function editCategory(category) {
    document.getElementById('editName').value = category.name;
    document.getElementById('editCategoryForm').action = `<?= url('admin/blog-categories/update/') ?>${category.id}`;
    document.getElementById('editCategoryModal').classList.remove('hidden');
}
</script>

<?php
$content = ob_get_clean();
$currentPage = 'blog_categories';
require __DIR__ . '/../../layouts/admin.php';
?>
