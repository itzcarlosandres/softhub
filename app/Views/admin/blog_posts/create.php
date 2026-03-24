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
        <h1 class="text-3xl font-bold text-white mb-2 font-outfit">Redactar Artículo</h1>
    </div>
    <a href="<?= url('admin/blog-posts') ?>" class="text-gray-400 hover:text-white transition-colors bg-white/5 py-2 px-4 rounded-xl border border-white/5 block flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<form action="<?= url('admin/blog-posts/store') ?>" method="POST" enctype="multipart/form-data">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Main Form -->
        <div class="lg:col-span-2 space-y-6">
            <div class="glass-panel rounded-2xl border border-white/5 p-6">
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Título del Artículo <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required 
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition-colors font-outfit text-lg">
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Extracto / Bajada (Se muestra en portadas)</label>
                    <textarea name="extract" rows="3" 
                              class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition-colors"></textarea>
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
                        <span>Generar Artículo con IA Básico</span>
                    </button>
                    <?php endif; ?>
                    <textarea id="contentEditor" name="content"></textarea>
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
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <hr class="border-white/10 mb-6">
                
                <!-- Destacado -->
                <label class="flex items-center gap-3 cursor-pointer group mb-6">
                    <div class="relative">
                        <input type="checkbox" name="is_featured" value="1" class="sr-only peer">
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
                    <div id="imagePreviewContainer" class="hidden">
                        <img id="imagePreview" src="" class="w-full h-auto rounded-lg mb-4">
                    </div>
                    <div id="imagePlaceholder">
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
                Publicar Artículo
                <i class="fas fa-paper-plane group-hover:translate-x-1 transition-transform"></i>
            </button>
            <p class="text-xs text-gray-500 text-center mt-2">Guardar este formulario enviará el artículo y se mostrará inmediatamente al público asignando tu usuario como autor.</p>
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
    
    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando contenido... (30s)';
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
        this.innerHTML = '<i class="fas fa-magic text-purple-200"></i><span>Generar Artículo con IA Básico</span>';
        this.disabled = false;
    }
});
</script>

<?php
$content = ob_get_clean();
$currentPage = 'blog_posts';
require __DIR__ . '/../../layouts/admin.php';
?>
