<?php ob_start(); ?>

<!-- TinyMCE (Para edición rica del blog) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#contentEditor',
        height: 500,
        menubar: false,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic forecolor | link unlink | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
        content_style: 'body { font-family:Inter,sans-serif; font-size:16px }',
        skin: 'oxide-dark',
        content_css: 'dark'
    });
</script>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-white mb-2 font-outfit">Editar Artículo</h1>
    </div>
    <a href="<?= url('admin/blog-posts') ?>" class="text-gray-400 hover:text-white transition-colors bg-white/5 py-2 px-4 rounded-xl border border-white/5 block flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<form action="<?= url('admin/blog-posts/update/' . $post['id']) ?>" method="POST" enctype="multipart/form-data">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Main Form -->
        <div class="lg:col-span-2 space-y-6">
            <div class="glass-panel rounded-2xl border border-white/5 p-6">
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Título del Artículo <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required value="<?= htmlspecialchars($post['title']) ?>"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition-colors font-outfit text-lg">
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Extracto / Bajada (Se muestra en portadas)</label>
                    <textarea name="extract" rows="3" 
                              class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition-colors"><?= htmlspecialchars($post['extract'] ?? '') ?></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Contenido <span class="text-red-500">*</span></label>
                    <!-- AI Button -->
                    <?php
                    $settingsModel = new \App\Models\SiteSetting();
                    if ($settingsModel->get('ai_enabled', '0') == '1' && !empty($settingsModel->get('gemini_api_key'))):
                    ?>
                    <button type="button" id="btn-generate-content" class="mb-2 w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white px-4 py-3 rounded-xl font-medium transition-colors shadow-lg shadow-purple-500/20 text-sm flex items-center justify-center gap-2 group">
                        <i class="fas fa-magic text-purple-200 group-hover:scale-110 transition-transform"></i>
                        <span>Regenerar Artículo con IA (SEO)</span>
                    </button>
                    <?php endif; ?>
                    <textarea id="contentEditor" name="content"><?= htmlspecialchars($post['content'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- SEO Section -->
            <div class="glass-panel rounded-2xl border border-white/5 p-6 space-y-6">
                <div class="flex items-center justify-between border-b border-white/10 pb-4">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <i class="fas fa-search text-blue-400"></i> Optimización SEO
                    </h3>
                    <button type="button" id="btn-generate-seo" class="text-xs bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 border border-blue-500/20 px-3 py-1.5 rounded-lg transition-all flex items-center gap-2">
                        <i class="fas fa-magic"></i> Regenerar SEO con IA
                    </button>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Meta Título (SEO)</label>
                        <input type="text" name="seo_title" id="seo_title" 
                               value="<?= htmlspecialchars($post['seo_title'] ?? '') ?>"
                               placeholder="Ej: Los mejores programas para... | SoftHub"
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition-colors">
                        <p class="text-[10px] text-gray-500 mt-1">Recomendado: 50-60 caracteres.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Meta Descripción (SEO)</label>
                        <textarea name="seo_description" id="seo_description" rows="3" 
                                  placeholder="Escribe una descripción atractiva para los resultados de búsqueda..."
                                  class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition-colors"><?= htmlspecialchars($post['seo_description'] ?? '') ?></textarea>
                        <p class="text-[10px] text-gray-500 mt-1">Recomendado: 150-160 caracteres.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Sidebar -->
        <div class="space-y-6">
            
            <!-- Settings Card -->
            <div class="glass-panel rounded-2xl border border-white/5 p-6">
                <h3 class="text-lg font-bold text-white mb-4 border-b border-white/10 pb-2">Configuración</h3>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Categoría</label>
                    <select name="blog_category_id" required class="w-full bg-[#1e293b] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition-colors appearance-none">
                        <option value="">Seleccione una categoría</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= $post['blog_category_id'] == $cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <hr class="border-white/10 mb-6">
                
                <!-- Destacado -->
                <label class="flex items-center gap-3 cursor-pointer group mb-6">
                    <div class="relative">
                        <input type="checkbox" name="is_featured" value="1" <?= $post['is_featured'] ? 'checked' : '' ?> class="sr-only peer">
                        <div class="w-11 h-6 bg-white/10 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors">
                        Destacar Artículo <i class="fas fa-fire ml-1 text-orange-400"></i>
                    </span>
                </label>
            </div>

            <!-- Media Card -->
            <div class="glass-panel rounded-2xl border border-white/5 p-6">
                <h3 class="text-lg font-bold text-white mb-4 border-b border-white/10 pb-2">Imagen de Portada</h3>
                
                <div class="border-2 border-dashed border-white/20 rounded-xl p-8 text-center hover:bg-white/5 transition-colors group cursor-pointer relative">
                    <input type="file" name="image" id="imageInput" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div id="imagePreviewContainer" class="<?= $post['image'] ? '' : 'hidden' ?>">
                        <img id="imagePreview" src="<?= $post['image'] ? url($post['image']) : '' ?>" class="w-full h-auto rounded-lg mb-4">
                        <p class="text-xs text-blue-400 mt-2">Haz clic para cambiar la imagen</p>
                    </div>
                    <div id="imagePlaceholder" class="<?= $post['image'] ? 'hidden' : '' ?>">
                        <div class="w-16 h-16 bg-blue-500/20 text-blue-400 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 group-hover:bg-blue-500/30 transition-all">
                            <i class="fas fa-image text-2xl"></i>
                        </div>
                        <p class="text-sm text-gray-400">Arrastra una imagen o haz clic para subir</p>
                        <p class="text-xs text-gray-500 mt-2">JPG, PNG o WebP (Max. 2MB)</p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 rounded-xl font-bold transition-all shadow-lg shadow-blue-600/20 text-lg flex items-center justify-center gap-2 group">
                Actualizar Artículo
                <i class="fas fa-save group-hover:scale-110 transition-transform"></i>
            </button>
        </div>
    </div>
</form>

<script>
// Image Preview
document.getElementById('imageInput').addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('imagePreviewContainer').classList.remove('hidden');
            document.getElementById('imagePlaceholder').classList.add('hidden');
        }
        reader.readAsDataURL(e.target.files[0]);
    }
});

// AI Generation Logic (Basic generation from Title and Extract)
document.getElementById('btn-generate-content')?.addEventListener('click', async function() {
    const title = document.querySelector('input[name="title"]').value;
    const catSelect = document.querySelector('select[name="blog_category_id"]');
    const category = catSelect.options[catSelect.selectedIndex].text;
    
    if (!title) {
        alert("Escribe un título primero para generar el contenido basado en él.");
        return;
    }
    
    // Confirm before overwriting existing content
    if (!confirm("¿Generar un nuevo artículo con IA? Esto reemplazará el contenido actual del editor.")) {
        return;
    }
    
    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando contenido optimizado... (30s)';
    this.disabled = true;
    
    try {
        const formData = new FormData();
        formData.append('title', title);
        formData.append('category', category);
        
        const response = await fetch('<?= url('api/ai/generate-blog-post') ?>', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            tinymce.get('contentEditor').setContent(data.text);
        } else {
            alert(data.error || 'Error al generar contenido');
        }
    } catch (error) {
        alert("Error de conexión al generar.");
    } finally {
        this.innerHTML = '<i class="fas fa-magic text-purple-200"></i><span>Regenerar Artículo con IA (SEO)</span>';
        this.disabled = false;
    }
});

// AI SEO Generation Logic
document.getElementById('btn-generate-seo')?.addEventListener('click', async function() {
    const title = document.querySelector('input[name="title"]').value;
    
    if (!title) {
        alert("Escribe un título primero.");
        return;
    }
    
    const originalContent = this.innerHTML;
    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    this.disabled = true;
    
    try {
        const formData = new FormData();
        formData.append('title', title);
        formData.append('type', 'blog_seo');
        
        const response = await fetch('<?= url('api/ai/generate-descriptions') ?>', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            document.getElementById('seo_title').value = data.short || '';
            document.getElementById('seo_description').value = data.full || '';
        } else {
            alert(data.error || 'Error al generar SEO');
        }
    } catch (error) {
        alert("Error de conexión.");
    } finally {
        this.innerHTML = originalContent;
        this.disabled = false;
    }
});
</script>

<?php
$content = ob_get_clean();
$currentPage = 'blog_posts';
require __DIR__ . '/../../layouts/admin.php';
?>
