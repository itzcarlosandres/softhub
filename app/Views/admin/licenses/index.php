<?php
$currentPage = 'licenses';
ob_start();

// Obtener licencias con conteo de software
$licenses = $db->query("
    SELECT l.*, COUNT(s.id) as software_count 
    FROM licenses l 
    LEFT JOIN software s ON s.license = l.slug 
    GROUP BY l.id 
    ORDER BY l.name
")->fetchAll();
?>

<div class="space-y-6 animate-fade-in-up">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white font-outfit flex items-center gap-3">
                <i class="fas fa-id-badge text-blue-400"></i> Tipo de Licencias
            </h1>
            <p class="text-gray-400 mt-1">Administra los tipos de licencias disponibles para el software.</p>
        </div>
        <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl shadow-lg shadow-blue-600/20 transition-all hover:scale-105 font-medium flex items-center gap-2">
            <i class="fas fa-plus"></i> Nueva Licencia
        </button>
    </div>

    <!-- Licenses Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($licenses as $lic): ?>
        <div class="glass-panel p-6 rounded-2xl group hover:border-blue-500/30 transition-all relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-500/10 to-indigo-500/10 rounded-bl-[100px] -mr-4 -mt-4 transition-all group-hover:scale-110"></div>
            
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="w-14 h-14 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-400 text-2xl border border-blue-500/10 shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fas fa-key"></i>
                </div>
                <div class="flex gap-2">
                    <button onclick="deleteLicense(<?= $lic['id'] ?>, '<?= htmlspecialchars($lic['name']) ?>')" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-red-500 hover:text-white flex items-center justify-center text-gray-400 transition-all">
                        <i class="fas fa-trash text-xs"></i>
                    </button>
                </div>
            </div>

            <h3 class="text-xl font-bold text-white font-outfit mb-1 relative z-10"><?= htmlspecialchars($lic['name']) ?></h3>
            <p class="text-xs text-gray-500 mb-4"><?= $lic['software_count'] ?> programas usándonla</p>

            <div class="pt-4 border-t border-white/5 flex justify-between items-center relative z-10">
                <code class="text-xs text-blue-300 bg-blue-500/10 px-2 py-1 rounded">slug: <?= htmlspecialchars($lic['slug']) ?></code>
            </div>
        </div>
        <?php endforeach; ?>

        <?php if (empty($licenses)): ?>
        <div class="col-span-full glass-panel p-12 text-center rounded-2xl">
            <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-folder-open text-4xl text-gray-600"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">No hay licencias</h3>
            <p class="text-gray-500">Agrega un tipo de licencia para comenzar.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal -->
<div id="licenseModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>

    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-[#0f172a] border border-white/10 rounded-2xl shadow-2xl transform transition-all scale-100 flex flex-col max-h-[90vh]">
            
            <div class="p-6 border-b border-white/10 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white font-outfit" id="modalTitle">Nuevo Tipo de Licencia</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <form id="licenseForm" method="POST" class="p-6 space-y-4 overflow-y-auto" action="<?= url('admin/licenses/store') ?>">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nombre de Licencia</label>
                    <input type="text" id="licenseName" name="name" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/50 focus:bg-white/10 transition-all placeholder-gray-600" placeholder="Ej: Pago, Freemium, Trial...">
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="closeModal()" class="flex-1 px-4 py-2.5 rounded-xl border border-white/10 text-gray-400 hover:text-white hover:bg-white/5 transition-colors font-medium">Cancelar</button>
                    <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold shadow-lg shadow-blue-600/20 transition-all">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const modal = document.getElementById('licenseModal');
const form = document.getElementById('licenseForm');

function openModal() {
    form.reset();
    modal.classList.remove('hidden');
}

function closeModal() {
    modal.classList.add('hidden');
}

function deleteLicense(id, name) {
    if(confirm('¿Seguro quieres eliminar eliminar la licencia de tipo ' + name + '?')) {
        window.location.href = '<?= url('admin/licenses/delete/') ?>' + id;
    }
}
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
?>
