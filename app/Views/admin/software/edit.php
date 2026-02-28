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

ob_start();
?>

<div class="max-w-4xl">
    <!-- Botón de Acceso Rápido a Versiones -->
    <div class="bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl shadow-lg p-4 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3 text-white">
                <i class="fas fa-history text-2xl"></i>
                <div>
                    <h3 class="font-bold text-lg">Gestionar Historial de Versiones</h3>
                    <p class="text-sm text-blue-100">Agrega, edita o elimina versiones anteriores de este software</p>
                </div>
            </div>
            <a href="<?= url('manage_versions.php?software_id=' . $software['id']) ?>" 
               class="px-6 py-3 bg-white text-blue-600 rounded-lg hover:bg-blue-50 transition font-bold shadow-md flex items-center gap-2"
               target="_blank">
                <i class="fas fa-code-branch"></i>
                Gestionar Versiones
            </a>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="<?= url('admin/software/update/' . $software['id']) ?>" method="POST" enctype="multipart/form-data">
            <!-- Información Básica -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-info-circle text-purple-600 mr-2"></i>
                    Información Básica
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre del Software <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" required value="<?= htmlspecialchars($software['name']) ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Versión <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="version" required value="<?= htmlspecialchars($software['version']) ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Desarrollador <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="developer" required value="<?= htmlspecialchars($software['developer']) ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Categoría <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Seleccionar categoría...</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= $software['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Descripción -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-align-left text-purple-600 mr-2"></i>
                    Descripción
                </h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción Corta <span class="text-red-500">*</span>
                        </label>
                        <textarea name="short_description" required rows="2"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"><?= htmlspecialchars($software['short_description']) ?></textarea>
                    </div>
                    
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Descripción Completa <span class="text-red-500">*</span>
                            </label>
                            <button type="button" onclick="generateDescription()" 
                                    class="px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:shadow-lg transition font-semibold text-sm flex items-center gap-2">
                                <i class="fas fa-magic"></i>
                                Generar con IA
                            </button>
                        </div>
                        <!-- Editor Quill -->
                        <div id="description" style="height: 300px;"></div>
                        <!-- Textarea oculto para enviar datos -->
                        <textarea name="description" required class="hidden"><?= htmlspecialchars($software['description']) ?></textarea>
                        <div id="ai-loading" class="hidden mt-2 text-purple-600 text-sm">
                            <i class="fas fa-spinner fa-spin mr-2"></i>Generando descripción con IA...
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Nota sobre Detalles Técnicos -->
            <div class="mb-8">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 text-2xl mr-4 mt-1"></i>
                        <div>
                            <h4 class="font-bold text-blue-900 mb-2">📋 Gestión de Versiones y Enlaces</h4>
                            <p class="text-blue-800 mb-3">
                                Los <strong>detalles técnicos</strong> (Sistema Operativo, Tamaño, URLs de descarga) 
                                se gestionan desde el <strong>Historial de Versiones</strong>.
                            </p>
                            <a href="<?= url('manage_versions.php?software_id=' . $software['id']) ?>" 
                               target="_blank"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                                <i class="fas fa-code-branch mr-2"></i>
                                Gestionar Versiones y Enlaces
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Requisitos del Sistema -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-list-check text-purple-600 mr-2"></i>
                    Requisitos del Sistema
                </h3>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Requisitos del Sistema
                    </label>
                    <textarea name="requirements" rows="5"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"><?= htmlspecialchars($software['requirements']) ?></textarea>
                </div>
            </div>
            
            <!-- Imágenes Actuales -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-images text-purple-600 mr-2"></i>
                    Imágenes
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <?php if (!empty($software['icon'])): ?>
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-2">Icono Actual:</p>
                            <img src="<?= url(htmlspecialchars($software['icon'])) ?>" alt="Icon" class="w-32 h-32 object-contain border border-gray-300 rounded-lg p-2 bg-white">
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($software['image'])): ?>
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-2">Imagen Actual:</p>
                            <img src="<?= url(htmlspecialchars($software['image'])) ?>" alt="Image" class="w-full h-32 object-cover border border-gray-300 rounded-lg">
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nuevo Icono (opcional)
                        </label>
                        <input type="file" name="icon" accept="image/*"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nueva Imagen (opcional)
                        </label>
                        <input type="file" name="image" accept="image/*"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
            </div>
            
            <!-- Estadísticas -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-chart-bar text-purple-600 mr-2"></i>
                    Estadísticas
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Descargas Totales</p>
                        <p class="text-2xl font-bold text-purple-600"><?= number_format($software['downloads']) ?></p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Calificación</p>
                        <p class="text-2xl font-bold text-yellow-600"><?= number_format($software['rating'], 1) ?> ⭐</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Fecha de Creación</p>
                        <p class="text-lg font-semibold text-gray-800"><?= date('d/m/Y', strtotime($software['created_at'])) ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Opciones de Publicación -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-rocket text-purple-600 mr-2"></i>
                    Opciones de Publicación
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="featured" id="featured" value="1" <?= $software['featured'] ? 'checked' : '' ?>
                               class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        <label for="featured" class="ml-3 text-sm font-medium text-gray-700">
                            <i class="fas fa-star text-yellow-500 mr-1"></i>
                            Marcar como destacado
                        </label>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" name="badge_editors_choice" id="badge_editors_choice" value="1" <?= $software['badge_editors_choice'] ? 'checked' : '' ?>
                               class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        <label for="badge_editors_choice" class="ml-3 text-sm font-medium text-gray-700">
                            <i class="fas fa-award text-purple-500 mr-1"></i>
                            Editor's Choice (Badge especial)
                        </label>
                    </div>
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-4">
                        <p class="text-sm text-blue-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Nota:</strong> Los badges "Nuevo", "Actualizado" y "Trending" se asignan automáticamente. 
                            Solo "Editor's Choice" se asigna manualmente.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Botones de Acción -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="<?= url('admin/software/delete/' . $software['id']) ?>" 
                   onclick="return confirm('¿Estás seguro de eliminar este software?')"
                   class="px-6 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition">
                    <i class="fas fa-trash mr-2"></i>Eliminar
                </a>
                
                <div class="flex items-center space-x-4">
                    <a href="<?= url('admin/software') ?>" 
                       class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i>Cancelar
                    </a>
                    <button type="submit" 
                            class="btn-primary text-white px-6 py-3 rounded-lg font-semibold">
                        <i class="fas fa-save mr-2"></i>Actualizar Software
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<script>
// Función para generar descripción con IA
async function generateDescription() {
    const softwareName = document.querySelector('input[name="name"]').value;
    const category = document.querySelector('select[name="category_id"]').options[document.querySelector('select[name="category_id"]').selectedIndex].text;
    const loadingIndicator = document.getElementById('ai-loading');
    
    if (!softwareName) {
        alert('Por favor, ingresa el nombre del software primero');
        return;
    }
    
    // Mostrar indicador de carga
    loadingIndicator.classList.remove('hidden');
    
    try {
        const response = await fetch('<?= url('api/generate-description') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                software_name: softwareName,
                category: category
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Actualizar Quill editor
            if (typeof quillEditor !== 'undefined') {
                quillEditor.root.innerHTML = data.description;
            }
        } else {
            alert('Error al generar descripción: ' + (data.error || 'Error desconocido'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al conectar con el servidor');
    } finally {
        loadingIndicator.classList.add('hidden');
    }
}
</script>

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
// Inicializar Quill Editor
var quillEditor = new Quill('#description', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, 3, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'align': [] }],
            ['link', 'image'],
            [{ 'color': [] }, { 'background': [] }],
            ['clean']
        ]
    },
    placeholder: 'Escribe la descripción completa del software...'
});

// Sincronizar contenido con el textarea oculto al enviar el formulario
document.querySelector('form').addEventListener('submit', function() {
    // Obtener el HTML del editor
    var html = quillEditor.root.innerHTML;
    // Actualizar el textarea original
    document.querySelector('textarea[name="description"]').value = html;
});

// Cargar contenido inicial si existe
var initialContent = document.querySelector('textarea[name="description"]').value;
if (initialContent) {
    quillEditor.root.innerHTML = initialContent;
}
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
?>
