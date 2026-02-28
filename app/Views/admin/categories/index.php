<?php
$currentPage = 'categories';
ob_start();

// Obtener categorías con conteo de software
$categories = $db->query("
    SELECT c.*, COUNT(s.id) as software_count 
    FROM categories c 
    LEFT JOIN software s ON c.id = s.category_id 
    GROUP BY c.id 
    ORDER BY c.name
")->fetchAll();
?>

<div class="space-y-6 animate-fade-in-up">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white font-outfit flex items-center gap-3">
                <i class="fas fa-layer-group text-pink-400"></i> Categorías
            </h1>
            <p class="text-gray-400 mt-1">Organiza tu software en secciones claras.</p>
        </div>
        <button onclick="openModal()" class="bg-pink-600 hover:bg-pink-500 text-white px-6 py-3 rounded-xl shadow-lg shadow-pink-600/20 transition-all hover:scale-105 font-medium flex items-center gap-2">
            <i class="fas fa-plus"></i> Nueva Categoría
        </button>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($categories as $cat): ?>
        <div class="glass-panel p-6 rounded-2xl group hover:border-pink-500/30 transition-all relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-pink-500/10 to-purple-500/10 rounded-bl-[100px] -mr-4 -mt-4 transition-all group-hover:scale-110"></div>
            
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="w-14 h-14 rounded-xl bg-pink-500/20 flex items-center justify-center text-pink-400 text-2xl border border-pink-500/10 shadow-lg group-hover:scale-110 transition-transform">
                    <i class="<?= htmlspecialchars($cat['icon'] ?: 'fas fa-folder') ?>"></i>
                </div>
                <div class="flex gap-2">
                    <button onclick='editCategory(<?= json_encode($cat) ?>)' class="w-8 h-8 rounded-lg bg-white/5 hover:bg-blue-500 hover:text-white flex items-center justify-center text-gray-400 transition-all">
                        <i class="fas fa-pencil-alt text-xs"></i>
                    </button>
                    <button onclick="deleteCategory(<?= $cat['id'] ?>, '<?= htmlspecialchars($cat['name']) ?>')" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-red-500 hover:text-white flex items-center justify-center text-gray-400 transition-all">
                        <i class="fas fa-trash text-xs"></i>
                    </button>
                </div>
            </div>

            <h3 class="text-xl font-bold text-white font-outfit mb-1 relative z-10"><?= htmlspecialchars($cat['name']) ?></h3>
            <p class="text-xs text-gray-500 mb-4"><?= $cat['software_count'] ?> programas</p>
            
            <?php if (!empty($cat['description'])): ?>
                <p class="text-sm text-gray-400 line-clamp-2 mb-4 h-10"><?= htmlspecialchars($cat['description']) ?></p>
            <?php else: ?>
                <p class="text-sm text-gray-600 italic mb-4 h-10">Sin descripción</p>
            <?php endif; ?>

            <div class="pt-4 border-t border-white/5 flex justify-between items-center relative z-10">
                <code class="text-xs text-pink-300 bg-pink-500/10 px-2 py-1 rounded">/<?= htmlspecialchars($cat['slug']) ?></code>
                <a href="<?= url('category/' . $cat['slug']) ?>" target="_blank" class="text-xs text-gray-500 hover:text-white flex items-center gap-1 transition-colors">
                    Ver <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
        </div>
        <?php endforeach; ?>

        <?php if (empty($categories)): ?>
        <div class="col-span-full glass-panel p-12 text-center rounded-2xl">
            <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-folder-open text-4xl text-gray-600"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">No hay categorías</h3>
            <p class="text-gray-500">Comienza creando una nueva categoría para organizar tu software.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal -->
<div id="categoryModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>

    <!-- Modal Content -->
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-[#0f172a] border border-white/10 rounded-2xl shadow-2xl transform transition-all scale-100 flex flex-col max-h-[90vh]">
            
            <div class="p-6 border-b border-white/10 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white font-outfit" id="modalTitle">Nueva Categoría</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <form id="categoryForm" method="POST" class="p-6 space-y-4 overflow-y-auto">
                <input type="hidden" id="categoryId" name="id">
                
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nombre</label>
                    <input type="text" id="categoryName" name="name" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-pink-500/50 focus:bg-white/10 transition-all placeholder-gray-600" placeholder="Ej: Utilidades">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Icono (FontAwesome)</label>
                    <div class="relative">
                        <i class="fas fa-icons absolute left-4 top-3.5 text-gray-500"></i>
                        <input type="text" id="categoryIcon" name="icon" class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-3 text-white focus:outline-none focus:border-pink-500/50 focus:bg-white/10 transition-all placeholder-gray-600" placeholder="fas fa-tools">
                    </div>
                    <p class="text-[10px] text-gray-500 mt-1 pl-1">Busca iconos en FontAwesome v6</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Descripción</label>
                    <textarea id="categoryDescription" name="description" rows="3" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-pink-500/50 focus:bg-white/10 transition-all placeholder-gray-600 resize-none" placeholder="Breve descripción..."></textarea>
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="closeModal()" class="flex-1 px-4 py-2.5 rounded-xl border border-white/10 text-gray-400 hover:text-white hover:bg-white/5 transition-colors font-medium">Cancelar</button>
                    <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl bg-pink-600 hover:bg-pink-500 text-white font-bold shadow-lg shadow-pink-600/20 transition-all">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const modal = document.getElementById('categoryModal');
const form = document.getElementById('categoryForm');
const modalTitle = document.getElementById('modalTitle');

function openModal() {
    modalTitle.textContent = 'Nueva Categoría';
    form.action = '<?= url('admin/categories/store') ?>';
    form.reset();
    document.getElementById('categoryId').value = '';
    modal.classList.remove('hidden');
}

function editCategory(cat) {
    modalTitle.textContent = 'Editar Categoría';
    form.action = '<?= url('admin/categories/update/') ?>' + cat.id;
    document.getElementById('categoryId').value = cat.id;
    document.getElementById('categoryName').value = cat.name;
    document.getElementById('categoryIcon').value = cat.icon;
    document.getElementById('categoryDescription').value = cat.description;
    modal.classList.remove('hidden');
}

function closeModal() {
    modal.classList.add('hidden');
}

function deleteCategory(id, name) {
    if(confirm('¿Eliminar ' + name + '?')) {
        window.location.href = '<?= url('admin/categories/delete/') ?>' + id;
    }
}
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
?>
