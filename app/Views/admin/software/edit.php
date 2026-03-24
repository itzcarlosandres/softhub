<?php
$currentPage = 'software';
$pageTitle = 'Editar Software';
$pageDescription = 'Modifica la información del programa';

// Obtener el software
$id = $params['id'] ?? 0;
$stmt = $db->prepare("SELECT * FROM software WHERE id = ?");
$stmt->execute([$id]);
$software = $stmt->fetch();

if (!$software) {
    $_SESSION['error'] = 'Software no encontrado';
    header('Location: ' . url('admin/software'));
    exit;
}

$categories = $db->query("SELECT * FROM categories ORDER BY name")->fetchAll();
$licensesList = $db->query("SELECT * FROM licenses ORDER BY name")->fetchAll();

// Verificar si la IA está habilitada
$stmt = $db->query("SELECT setting_value FROM site_settings WHERE setting_key = 'ai_enabled'");
$aiEnabled = $stmt->fetch();
$showAI = ($aiEnabled && $aiEnabled['setting_value'] == '1');

ob_start();
?>

<div class="max-w-5xl animate-fade-in-up pb-24">
    
    <!-- Title -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white font-outfit flex items-center gap-3">
            <i class="fas fa-edit text-pink-400"></i> Editar Software
        </h1>
        <p class="text-gray-400 mt-1">Modifica la información del programa de catálogo.</p>
    </div>

    <!-- Botón de Acceso Rápido a Versiones -->
    <div class="glass-panel rounded-2xl p-6 mb-8 flex flex-col md:flex-row items-center justify-between gap-4 border-l-4 border-blue-500">
        <div class="flex items-center gap-4 text-white">
            <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center text-blue-400">
                <i class="fas fa-history text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg font-outfit">Gestionar Historial de Versiones</h3>
                <p class="text-sm text-gray-400">Agrega, edita o elimina versiones, sistemas operativos, tamaños y enlaces.</p>
            </div>
        </div>
        <a href="<?= url('manage_versions.php?software_id=' . $software['id']) ?>" 
           class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-blue-600/20 flex items-center gap-2 transition-all hover:scale-105"
           target="_blank">
            <i class="fas fa-code-branch"></i>
            Gestionar Versiones
        </a>
    </div>

    <form action="<?= url('admin/software/update/' . $software['id']) ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
        
        <!-- Información Básica -->
        <div class="glass-panel p-8 rounded-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-full blur-[50px] -mr-10 -mt-10"></div>
            
            <h3 class="text-xl font-bold text-white font-outfit mb-6 flex items-center gap-2 relative z-10">
                <i class="fas fa-info-circle text-purple-400"></i> Información Básica
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nombre del Software <span class="text-pink-500">*</span></label>
                    <input type="text" name="name" required value="<?= htmlspecialchars($software['name']) ?>"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all placeholder-gray-600">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Versión <span class="text-pink-500">*</span></label>
                    <input type="text" name="version" required value="<?= htmlspecialchars($software['version']) ?>"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all placeholder-gray-600">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Desarrollador <span class="text-pink-500">*</span></label>
                    <input type="text" name="developer" required value="<?= htmlspecialchars($software['developer']) ?>"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all placeholder-gray-600">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Categoría <span class="text-pink-500">*</span></label>
                    <select name="category_id" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all [&>option]:bg-gray-900">
                        <option value="">Seleccionar categoría...</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= $software['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Tipo de Licencia <span class="text-pink-500">*</span></label>
                    <select name="license" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all [&>option]:bg-gray-900">
                        <option value="">Seleccionar licencia...</option>
                        <?php foreach ($licensesList as $licOption): ?>
                            <option value="<?= htmlspecialchars($licOption['slug']) ?>" <?= $software['license'] == $licOption['slug'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($licOption['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Descripción -->
        <div class="glass-panel p-8 rounded-2xl relative overflow-hidden">
             <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-[50px] -mr-10 -mt-10"></div>
            
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 relative z-10 gap-4">
                <h3 class="text-xl font-bold text-white font-outfit flex items-center gap-2">
                    <i class="fas fa-align-left text-blue-400"></i> Descripción
                </h3>
                
                <?php if ($showAI): ?>
                <button type="button" id="generateAllBtn" onclick="generateAllDescriptions()" 
                        class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-purple-600/20 transition-all hover:scale-105 flex items-center gap-2 text-sm">
                    <i class="fas fa-magic"></i>
                    Generar con IA (Actualizar)
                </button>
                <?php endif; ?>
            </div>
            
            <div class="space-y-6 relative z-10">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Descripción Corta <span class="text-pink-500">*</span></label>
                    <textarea name="short_description" id="short_description" required rows="2"
                              class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/50 transition-all placeholder-gray-600 resize-none"><?= htmlspecialchars($software['short_description']) ?></textarea>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Descripción Completa <span class="text-pink-500">*</span></label>
                    <textarea name="description" id="description" rows="10"
                              class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/50 transition-all placeholder-gray-600"><?= htmlspecialchars($software['description']) ?></textarea>
                </div>
            </div>
        </div>
        
        <!-- Detalles Técnicos -->
        <div class="glass-panel p-8 rounded-2xl relative overflow-hidden">
             <div class="absolute top-0 right-0 w-32 h-32 bg-green-500/10 rounded-full blur-[50px] -mr-10 -mt-10"></div>
            
            <h3 class="text-xl font-bold text-white font-outfit mb-6 flex items-center gap-2 relative z-10">
                <i class="fas fa-cogs text-green-400"></i> Detalles Técnicos & Requisitos
            </h3>
            
            <div class="space-y-6 relative z-10">
                 <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Requisitos del Sistema</label>
                    <textarea name="requirements" rows="3"
                              class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-green-500/50 transition-all placeholder-gray-600 resize-none"><?= htmlspecialchars($software['requirements']) ?></textarea>
                </div>
            </div>
        </div>
        
        <!-- Imágenes -->
        <div class="glass-panel p-8 rounded-2xl relative overflow-hidden">
            <h3 class="text-xl font-bold text-white font-outfit mb-6 flex items-center gap-2 relative z-10">
                <i class="fas fa-images text-pink-400"></i> Imágenes Actuales y Nuevas
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                
                <!-- Icono -->
                <div class="bg-white/5 p-6 rounded-xl border border-white/5 flex flex-col justify-between">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Icono Actual</label>
                        <?php if (!empty($software['icon'])): ?>
                            <div class="mb-6 flex justify-center p-6 bg-white/5 rounded-lg border border-white/10 backdrop-blur-sm">
                                <img src="<?= url(htmlspecialchars($software['icon'])) ?>" alt="Icon" class="w-32 h-32 object-contain drop-shadow-xl">
                            </div>
                        <?php else: ?>
                            <div class="mb-6 flex justify-center items-center h-32 p-6 bg-white/5 rounded-lg border border-white/10">
                                <span class="text-gray-500 text-sm">Sin Icono</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nuevo Icono (Reemplaza al actual)</label>
                        <input type="file" name="icon" accept="image/*"
                               class="block w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-white/10 file:text-white hover:file:bg-white/20 cursor-pointer border border-white/10 rounded-lg p-1">
                    </div>
                </div>
                
                <!-- Imagen Cover -->
                <div class="bg-white/5 p-6 rounded-xl border border-white/5 flex flex-col justify-between">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Imagen Actual</label>
                        <?php if (!empty($software['image'])): ?>
                            <div class="mb-6 flex justify-center p-2 bg-white/5 rounded-lg border border-white/10 backdrop-blur-sm">
                                <img src="<?= url(htmlspecialchars($software['image'])) ?>" alt="Image" class="w-full h-32 object-cover rounded shadow-lg">
                            </div>
                        <?php else: ?>
                            <div class="mb-6 flex justify-center items-center h-32 p-6 bg-white/5 rounded-lg border border-white/10">
                                <span class="text-gray-500 text-sm">Sin Imagen Principal</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nueva Imagen (Reemplaza a la actual)</label>
                        <input type="file" name="image" accept="image/*"
                               class="block w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-white/10 file:text-white hover:file:bg-white/20 cursor-pointer border border-white/10 rounded-lg p-1">
                    </div>
                </div>
                
            </div>
        </div>
        
        
        <!-- Opciones & Estadisticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Estadísticas -->
            <div class="glass-panel p-8 rounded-2xl">
                 <h3 class="text-xl font-bold text-white font-outfit mb-6 flex items-center gap-2">
                    <i class="fas fa-chart-bar text-cyan-400"></i> Estadísticas Actuales
                </h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white/5 p-4 rounded-xl border border-white/5 text-center">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Descargas</p>
                        <p class="text-2xl font-bold text-cyan-400"><?= number_format($software['downloads']) ?></p>
                    </div>
                    
                    <div class="bg-white/5 p-4 rounded-xl border border-white/5 text-center">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Calificación</p>
                        <p class="text-2xl font-bold text-yellow-400"><?= number_format($software['rating'], 1) ?> ⭐</p>
                    </div>
                    <div class="bg-white/5 p-4 rounded-xl border border-white/5 text-center col-span-2">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Registro</p>
                        <p class="text-lg font-bold text-white"><?= date('d/m/Y', strtotime($software['created_at'])) ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Opciones -->
            <div class="glass-panel p-8 rounded-2xl">
                 <h3 class="text-xl font-bold text-white font-outfit mb-6 flex items-center gap-2">
                    <i class="fas fa-rocket text-yellow-400"></i> Publicación
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center p-4 bg-white/5 rounded-xl border border-white/5 hover:bg-white/10 transition cursor-pointer">
                        <input type="checkbox" name="featured" id="featured" value="1" <?= $software['featured'] ? 'checked' : '' ?>
                               class="w-5 h-5 rounded border-gray-600 text-yellow-500 focus:ring-yellow-500 bg-gray-700 cursor-pointer">
                        <label for="featured" class="ml-3 text-sm font-medium text-white cursor-pointer select-none">
                            <i class="fas fa-star text-yellow-500 mr-2"></i> Marcar como destacado
                        </label>
                    </div>

                    <div class="flex items-center p-4 bg-white/5 rounded-xl border border-white/5 hover:bg-white/10 transition cursor-pointer">
                        <input type="checkbox" name="badge_editors_choice" id="badge_editors_choice" value="1" <?= $software['badge_editors_choice'] ? 'checked' : '' ?>
                               class="w-5 h-5 rounded border-gray-600 text-purple-500 focus:ring-purple-500 bg-gray-700 cursor-pointer">
                        <label for="badge_editors_choice" class="ml-3 text-sm font-medium text-white cursor-pointer select-none">
                            <i class="fas fa-award text-purple-500 mr-2"></i> Editor's Choice (Medalla especial)
                        </label>
                    </div>

                    <p class="text-[10px] text-gray-400 mt-2">
                        <i class="fas fa-info-circle text-blue-400 mr-1"></i>
                        Los badges "Nuevo", "Actualizado" y "Trending" se asignan automáticamente por el sistema.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Botones Flotantes -->
        <div class="fixed bottom-6 right-6 z-50 flex gap-4">
             <a href="<?= url('admin/software/delete/' . $software['id']) ?>" 
               onclick="return confirm('¿Estás SEGURO de eliminar este software completamente?')"
               class="bg-red-800/80 hover:bg-red-700 text-white font-bold py-4 px-6 rounded-full shadow-lg backdrop-blur-md border border-red-500/20 transition-all flex items-center gap-2">
                <i class="fas fa-trash"></i> Eliminar
             </a>
             <a href="<?= url('admin/software') ?>" 
               class="bg-gray-800/80 hover:bg-gray-700 text-white font-bold py-4 px-6 rounded-full shadow-lg backdrop-blur-md border border-white/10 transition-all flex items-center gap-2">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-4 px-8 rounded-full shadow-lg shadow-blue-600/30 flex items-center gap-3 transition-all hover:scale-105 hover:-translate-y-1 backdrop-blur-md border border-white/10">
                <i class="fas fa-save text-xl"></i>
                <span class="text-lg">Actualizar Software</span>
            </button>
        </div>

    </form>
</div>

<script>
// Scripts de IA
<?php if ($showAI): ?>
async function generateAllDescriptions() {
    const btn = document.getElementById('generateAllBtn');
    const softwareName = document.querySelector('input[name="name"]').value.trim();
    const developer = document.querySelector('input[name="developer"]').value.trim();
    
    const catSelect = document.querySelector('select[name="category_id"]');
    const categoryText = catSelect.options[catSelect.selectedIndex]?.text || '';

    if (!softwareName) {
        alert('❌ Por favor ingresa el nombre del software primero');
        return;
    }
    
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Generando...';
    
    try {
        const response = await fetch('<?= url('api/ai/generate-descriptions') ?>', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ name: softwareName, category: categoryText, developer: developer, type: 'both' })
        });
        const data = await response.json();
        
        if (data.success) {
            document.getElementById('short_description').value = data.short_description;
            if (typeof tinymce !== 'undefined' && tinymce.get('description')) {
                tinymce.get('description').setContent(data.full_description);
            } else {
                document.getElementById('description').value = data.full_description;
            }
            alert('✅ Generado con éxito');
        } else {
            alert('❌ Error: ' + data.error);
        }
    } catch (e) {
        alert('❌ Error de conexión');
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-magic mr-2"></i>Generar con IA (Actualizar)';
    }
}
<?php endif; ?>
</script>

<!-- TinyMCE CDN -->
<script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.2/tinymce.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#description',
            height: 400,
            skin: 'oxide-dark',
            content_css: 'dark',
            menubar: false,
            plugins: 'lists link image table code help wordcount',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | help',
            content_style: 'body { font-family:Inter,sans-serif; font-size:14px; background-color: #0f172a; color: #cbd5e1; }'
        });
    }
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
?>
