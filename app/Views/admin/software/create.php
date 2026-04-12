<?php
$currentPage = 'software';
$pageTitle = 'Agregar Nuevo Software';
$pageDescription = 'Completa el formulario para agregar un nuevo programa';

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
            <i class="fas fa-plus-circle text-pink-400"></i> Nuevo Software
        </h1>
        <p class="text-gray-400 mt-1">Añade un nuevo programa al catálogo.</p>
    </div>

    <form action="<?= url('admin/software/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
        
        <!-- Información Básica -->
        <div class="glass-panel p-8 rounded-2xl relative">
            <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-full blur-[50px] -mr-10 -mt-10"></div>
            
            <h3 class="text-xl font-bold text-white font-outfit mb-6 flex items-center gap-2 relative z-10">
                <i class="fas fa-info-circle text-purple-400"></i> Información Básica
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nombre del Software <span class="text-pink-500">*</span></label>
                    <input type="text" name="name" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all placeholder-gray-600"
                           placeholder="Ej: Google Chrome">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Versión <span class="text-pink-500">*</span></label>
                    <input type="text" name="version" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all placeholder-gray-600"
                           placeholder="Ej: 120.0.6099.130">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Desarrollador <span class="text-pink-500">*</span></label>
                    <input type="text" name="developer" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all placeholder-gray-600"
                           placeholder="Ej: Google LLC">
                </div>
                
                <div class="category-select-wrapper">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Categoría <span class="text-pink-500">*</span></label>
                    <select name="category_id" id="category_id" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all [&>option]:bg-gray-900">
                        <option value="">Seleccionar categoría...</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Opciones Premium / Compras -->
        <div class="glass-panel p-8 rounded-2xl relative overflow-hidden bg-gradient-to-br from-gray-900 to-purple-900/10">
            <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-full blur-[50px] -mr-10 -mt-10"></div>
            
            <h3 class="text-xl font-bold text-white font-outfit mb-6 flex items-center gap-2 relative z-10">
                <i class="fas fa-crown text-purple-400"></i> Monetización y Compras
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 flex items-center gap-2">
                        Precio del Software
                        <span class="bg-purple-500/20 text-purple-400 text-[9px] px-2 py-0.5 rounded border border-purple-500/30 uppercase">Opcional</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-gray-500 font-bold">$</span>
                        <input type="number" step="0.01" min="0" name="price"
                               class="w-full bg-white/5 border border-white/10 rounded-xl pl-8 pr-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all placeholder-gray-600"
                               placeholder="0.00">
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 flex items-center gap-2">
                        Enlace / URL de la Tienda
                        <span class="bg-purple-500/20 text-purple-400 text-[9px] px-2 py-0.5 rounded border border-purple-500/30 uppercase">Opcional</span>
                    </label>
                    <input type="url" name="buy_url"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500/50 transition-all placeholder-gray-600"
                           placeholder="Ej: https://paypal.com/... o https://stripe.com/...">
                </div>
                <!-- Helper text -->
                <div class="md:col-span-2 text-xs text-gray-500 bg-black/20 p-3 rounded-lg border border-white/5">
                    <i class="fas fa-info-circle mr-1 text-purple-400"></i> Si el precio es mayor a cero, se habilitará automáticamente el botón "Prémium" en la página pública del software.
                </div>
            </div>
        </div>
        
        <!-- Descripción -->
        <div class="glass-panel p-8 rounded-2xl relative">
             <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-[50px] -mr-10 -mt-10"></div>
            
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 relative z-10 gap-4">
                <h3 class="text-xl font-bold text-white font-outfit flex items-center gap-2">
                    <i class="fas fa-align-left text-blue-400"></i> Descripción
                </h3>
                
                <?php if ($showAI): ?>
                <button type="button" id="generateAllBtn" onclick="generateAllDescriptions()" 
                        class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-purple-600/20 transition-all hover:scale-105 flex items-center gap-2 text-sm">
                    <i class="fas fa-magic"></i>
                    Generar con IA
                </button>
                <?php endif; ?>
            </div>
            
            <?php if ($showAI): ?>
            <!-- Alerta de IA -->
            <div class="bg-blue-500/10 border-l-4 border-blue-500 p-4 mb-6 rounded-r-xl relative z-10">
                <div class="flex items-start">
                    <i class="fas fa-robot text-blue-400 text-xl mr-3 mt-1"></i>
                    <div>
                        <h4 class="font-bold text-white text-sm mb-1">Generación Automática con IA</h4>
                        <p class="text-xs text-gray-400">
                            Completa el <strong>nombre</strong>, <strong>categoría</strong> y <strong>desarrollador</strong>, luego haz clic en "Generar con IA" para crear contenido optimizado automáticamente.
                        </p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="space-y-6 relative z-10">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Descripción Corta <span class="text-pink-500">*</span></label>
                    <textarea name="short_description" id="short_description" required rows="2"
                              class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/50 transition-all placeholder-gray-600 resize-none"
                              placeholder="Breve descripción de 1-2 líneas..."></textarea>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Descripción Completa <span class="text-pink-500">*</span></label>
                    <textarea name="description" id="description" rows="10"
                              class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500/50 transition-all placeholder-gray-600"
                              placeholder="Descripción detallada..."></textarea>
                </div>
            </div>
        </div>
        
        <!-- Detalles Técnicos -->
        <div class="glass-panel p-8 rounded-2xl relative">
             <div class="absolute top-0 right-0 w-32 h-32 bg-green-500/10 rounded-full blur-[50px] -mr-10 -mt-10"></div>
            
            <h3 class="text-xl font-bold text-white font-outfit mb-6 flex items-center gap-2 relative z-10">
                <i class="fas fa-cogs text-green-400"></i> Detalles Técnicos
            </h3>
            
            <div class="space-y-6 relative z-10">
                 <!-- Tipo de Licencia -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Tipo de Licencia <span class="text-pink-500">*</span></label>
                    <select name="license" id="license_id" required
                            class="w-full md:w-1/3 bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-green-500/50 transition-all [&>option]:bg-gray-900">
                        <?php foreach ($licensesList as $licOption): ?>
                            <option value="<?= htmlspecialchars($licOption['slug']) ?>"><?= htmlspecialchars($licOption['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Sistemas Operativos -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Sistemas Operativos <span class="text-pink-500">*</span></label>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                        <label class="flex items-center p-3 bg-white/5 border border-white/10 rounded-xl cursor-pointer hover:bg-white/10 transition group">
                            <input type="checkbox" name="platforms[]" value="Windows" class="platform-checkbox w-4 h-4 rounded border-gray-600 text-blue-500 focus:ring-blue-500 bg-gray-700 mr-2">
                            <i class="fab fa-windows text-blue-400 mr-2 group-hover:scale-110 transition-transform"></i>
                            <span class="text-sm text-gray-300 group-hover:text-white">Windows</span>
                        </label>
                        <label class="flex items-center p-3 bg-white/5 border border-white/10 rounded-xl cursor-pointer hover:bg-white/10 transition group">
                            <input type="checkbox" name="platforms[]" value="Android" class="platform-checkbox w-4 h-4 rounded border-gray-600 text-green-500 focus:ring-green-500 bg-gray-700 mr-2">
                            <i class="fab fa-android text-green-500 mr-2 group-hover:scale-110 transition-transform"></i>
                            <span class="text-sm text-gray-300 group-hover:text-white">Android</span>
                        </label>
                        <label class="flex items-center p-3 bg-white/5 border border-white/10 rounded-xl cursor-pointer hover:bg-white/10 transition group">
                            <input type="checkbox" name="platforms[]" value="Torrent" class="platform-checkbox w-4 h-4 rounded border-gray-600 text-red-500 focus:ring-red-500 bg-gray-700 mr-2">
                            <i class="fas fa-magnet text-red-400 mr-2 group-hover:scale-110 transition-transform"></i>
                            <span class="text-sm text-gray-300 group-hover:text-white">Torrent / Magnet</span>
                        </label>
                    </div>
                </div>
                
                 <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Requisitos del Sistema</label>
                    <textarea name="requirements" rows="3"
                              class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-green-500/50 transition-all placeholder-gray-600 resize-none"
                              placeholder="Ej: Windows 10 o superior, 4GB RAM..."></textarea>
                </div>
            </div>
        </div>
        
        <!-- Enlaces de Descarga -->
        <div class="glass-panel p-8 rounded-2xl relative overflow-hidden">
             <div class="absolute top-0 right-0 w-32 h-32 bg-orange-500/10 rounded-full blur-[50px] -mr-10 -mt-10"></div>
            
            <h3 class="text-xl font-bold text-white font-outfit mb-6 flex items-center gap-2 relative z-10">
                <i class="fas fa-download text-orange-400"></i> Enlaces de Descarga
            </h3>
            
            <div id="download-links-container" class="space-y-4 relative z-10">
                <!-- Dynamic Content -->
            </div>
            <p id="empty-message" class="text-gray-500 text-center py-8 relative z-10 border border-dashed border-white/10 rounded-xl">
                Selecciona al menos un sistema operativo arriba para agregar enlaces.
            </p>
        </div>
        
        <!-- Imágenes & Opciones -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Icono -->
            <div class="glass-panel p-8 rounded-2xl">
                <h3 class="text-xl font-bold text-white font-outfit mb-6 flex items-center gap-2">
                    <i class="fas fa-image text-pink-400"></i> Icono
                </h3>
                
                 <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Archivo de Imagen</label>
                    <input type="file" name="icon" accept="image/*"
                           class="block w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-white/10 file:text-white hover:file:bg-white/20 cursor-pointer border border-white/10 rounded-lg p-1">
                    <p class="text-[10px] text-gray-500 mt-2">Recomendado: 256x256px PNG transparente.</p>
                </div>
            </div>
            
            <!-- Opciones -->
            <div class="glass-panel p-8 rounded-2xl">
                 <h3 class="text-xl font-bold text-white font-outfit mb-6 flex items-center gap-2">
                    <i class="fas fa-rocket text-yellow-400"></i> Publicación
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center p-4 bg-white/5 rounded-xl border border-white/5">
                        <input type="checkbox" name="featured" id="featured" value="1"
                               class="w-5 h-5 rounded border-gray-600 text-yellow-500 focus:ring-yellow-500 bg-gray-700">
                        <label for="featured" class="ml-3 text-sm font-medium text-white cursor-pointer select-none">
                            Marcar como destacado
                        </label>
                    </div>

                    <div class="p-4 bg-white/5 rounded-xl border border-white/5">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Badge (Etiqueta Predefinida)</label>
                        <select name="badge_id" class="w-full bg-black/20 border border-white/10 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-cyan-500/50 transition-all text-sm appearance-none cursor-pointer [&>option]:bg-gray-900 [&>option]:text-white">
                            <option value="">-- Sin Badge --</option>
                            <?php foreach ($badges as $badge): ?>
                                <option value="<?= $badge['id'] ?>">
                                    <?= htmlspecialchars($badge['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="text-[10px] text-gray-500 mt-2">Selecciona un badge de los que has creado en la sección "Badges".</p>
                    </div>

                    <div class="p-4 bg-white/5 rounded-xl border border-white/5">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Badge Personalizado (Opcional - Texto libre)</label>
                        <div class="relative">
                            <input type="text" name="custom_badge" 
                                   placeholder="Ej: PREMIUM, OFERTA, V0.1..."
                                   class="w-full bg-black/20 border border-white/10 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-cyan-500/50 transition-all text-sm font-bold uppercase">
                             <i class="fas fa-edit absolute right-3 top-2.5 text-gray-600 text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Botones Flotantes -->
        <div class="fixed bottom-6 right-6 z-50 flex gap-4">
             <a href="<?= url('admin/software') ?>" 
               class="bg-gray-800/80 hover:bg-gray-700 text-white font-bold py-4 px-6 rounded-full shadow-lg backdrop-blur-md border border-white/10 transition-all flex items-center gap-2">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-4 px-8 rounded-full shadow-lg shadow-blue-600/30 flex items-center gap-3 transition-all hover:scale-105 hover:-translate-y-1 backdrop-blur-md border border-white/10">
                <i class="fas fa-save text-xl"></i>
                <span class="text-lg">Guardar Software</span>
            </button>
        </div>

    </form>
</div>

<script>
// Logic management for dynamic fields (Same logic, updated HTML templates for dark mode)
const platformCheckboxes = document.querySelectorAll('.platform-checkbox');
const downloadLinksContainer = document.getElementById('download-links-container');
let linkCounter = {};
let activePlatforms = new Set();

platformCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const platform = this.value;
        if (this.checked) {
            addPlatformSection(platform);
        } else {
            removePlatformSection(platform);
        }
        updateEmptyMessage();
    });
});

function addPlatformSection(platform) {
    if (activePlatforms.has(platform)) return;
    activePlatforms.add(platform);
    linkCounter[platform] = 1;
    
    const sectionHTML = `
        <div id="platform-section-${platform}" class="platform-section animate-fade-in" data-platform="${platform}">
            <div class="bg-white/5 border-l-4 border-purple-500 p-4 mb-4 rounded-r-xl">
                <h3 class="font-bold text-white flex items-center">
                    <i class="${getPlatformIconClass(platform)} text-purple-400 mr-2 text-xl"></i>
                    ${platform}
                </h3>
            </div>
            <div id="links-container-${platform}" class="space-y-4 mb-6"></div>
        </div>
    `;
    downloadLinksContainer.insertAdjacentHTML('beforeend', sectionHTML);
    addPlatformLink(platform, 0);
}

function removePlatformSection(platform) {
    const section = document.getElementById(`platform-section-${platform}`);
    if (section) {
        section.remove();
        activePlatforms.delete(platform);
    }
}

function addPlatformLink(platform, index) {
    const linkId = `${platform}_${index}`;
    const container = document.getElementById(`links-container-${platform}`);
    if (!container) return;
    
    const fieldHTML = `
        <div class="bg-black/20 p-6 rounded-xl border border-white/5" id="link-${linkId}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-bold text-gray-300 text-sm flex items-center">
                    <i class="fas fa-link text-purple-400 mr-2"></i>
                    ${index > 0 ? 'Enlace ' + (index + 1) : 'Enlace Principal'}
                </h4>
                ${index > 0 ? `<button type="button" onclick="removeLink('${linkId}')" class="text-red-400 hover:text-red-300 text-xs font-semibold flex items-center bg-red-500/10 px-2 py-1 rounded"><i class="fas fa-trash mr-1"></i>Eliminar</button>` : ''}
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                ${platform !== 'Torrent' ? `
                <div class="md:col-span-2">
                    <label class="block text-xs text-gray-500 mb-1">Arquitectura / Versión</label>
                    <input type="text" name="download_links[${platform}][${index}][version]"
                           class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-white text-sm focus:border-purple-500/50 outline-none"
                           placeholder="Ej: 64-bit, ARM">
                </div>
                ` : ''}
                <div class="md:col-span-2">
                    <label class="block text-xs text-gray-500 mb-1">URL de Descarga (Magnet) <span class="text-red-400">*</span></label>
                    <input type="${platform === 'Torrent' ? 'text' : 'url'}" name="download_links[${platform}][${index}][url]"
                           ${platform === 'Torrent' ? '' : 'required'}
                           class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-blue-300 text-sm focus:border-purple-500/50 outline-none font-mono"
                           placeholder="${platform === 'Torrent' ? 'magnet:?xt=... (opcional si subes archivo)' : 'https://...'}">
                </div>
                ${platform === 'Torrent' ? `
                <div class="md:col-span-2">
                    <label class="block text-xs text-gray-500 mb-1">O sube un archivo .torrent</label>
                    <div class="flex items-center gap-3">
                        <label class="cursor-pointer flex items-center gap-2 px-4 py-2 bg-green-500/10 border border-green-500/20 hover:bg-green-500/20 text-green-400 text-xs font-semibold rounded-lg transition-all">
                            <i class="fas fa-upload"></i> Seleccionar .torrent
                            <input type="file" accept=".torrent" name="download_links[${platform}][${index}][torrent_file]"
                                   class="hidden" onchange="showTorrentName(this)">
                        </label>
                        <span class="torrent-filename text-gray-500 text-xs italic">Ningún archivo seleccionado</span>
                    </div>
                </div>
                ` : ''}
                <div>
                   <label class="block text-xs text-gray-500 mb-1">Tamaño</label>
                    <input type="text" name="download_links[${platform}][${index}][size]"
                           class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-white text-sm focus:border-purple-500/50 outline-none"
                           placeholder="Ej: 95 MB">
                </div>
            </div>
            ${index === 0 ? `
            <div class="mt-4 pt-4 border-t border-white/5">
                <button type="button" onclick="addMoreLinks('${platform}')" class="text-purple-400 hover:text-purple-300 font-semibold text-xs flex items-center">
                    <i class="fas fa-plus-circle mr-1"></i>Agregar otro enlace para ${platform}
                </button>
            </div>
            ` : ''}
        </div>
    `;
    container.insertAdjacentHTML('beforeend', fieldHTML);
}

function addMoreLinks(platform) {
    const index = (linkCounter[platform] || 1) + 1;
    linkCounter[platform] = index;
    addPlatformLink(platform, index - 1);
}

function removeLink(linkId) {
    document.getElementById('link-' + linkId)?.remove();
}

function showTorrentName(input) {
    const label = input.closest('div').querySelector('.torrent-filename');
    if (label) {
        label.textContent = input.files.length > 0 ? input.files[0].name : 'Ningún archivo seleccionado';
        label.classList.toggle('text-green-400', input.files.length > 0);
        label.classList.toggle('text-gray-500', input.files.length === 0);
    }
}

function updateEmptyMessage() {
    const msg = document.getElementById('empty-message');
    if (activePlatforms.size === 0) {
        msg?.classList.remove('hidden');
    } else {
        msg?.classList.add('hidden');
    }
}

function getPlatformIconClass(platform) {
    const icons = { 
        'Windows': 'fab fa-windows', 
        'Android': 'fab fa-android', 
        'iOS': 'fab fa-apple', 
        'Torrent': 'fas fa-magnet' 
    };
    return icons[platform] || 'fas fa-download';
}

updateEmptyMessage(); // Init

// Scripts de IA
<?php if ($showAI): ?>
async function generateAllDescriptions() {
    const btn = document.getElementById('generateAllBtn');
    const softwareName = document.querySelector('input[name="name"]').value.trim();
    const developer = document.querySelector('input[name="developer"]').value.trim();
    
    // Quick Fix for category text
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
            // Simple notification logic
            alert('✅ Generado con éxito');
        } else {
            alert('❌ Error: ' + data.error);
        }
    } catch (e) {
        alert('❌ Error de conexión');
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-magic mr-2"></i>Generar con IA';
    }
}
<?php endif; ?>
</script>

<!-- Tom Select -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<style>
/* Tom Select Dark Theme Overrides */
.ts-control {
    background: rgba(255, 255, 255, 0.05) !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    border-radius: 0.75rem !important;
    padding: 0.75rem 1rem !important;
    color: #fff !important;
    font-size: 0.875rem !important;
    box-shadow: none !important;
    transition: all 0.2s !important;
}
.ts-wrapper.focus .ts-control {
    border-color: rgba(168, 85, 247, 0.5) !important;
}
.ts-dropdown {
    background: #1e1b4b !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    border-radius: 0.75rem !important;
    color: #fff !important;
    margin-top: 0.5rem !important;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.6) !important;
    z-index: 9999 !important;
}
.ts-dropdown-content {
    max-height: 280px !important;
}
.ts-dropdown .active {
    background: #4f46e5 !important;
    color: #fff !important;
}
.ts-dropdown .option {
    padding: 0.75rem 1rem !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    cursor: pointer;
}
.ts-dropdown .option:last-child {
    border-bottom: none;
}
.ts-control input {
    color: #fff !important;
}
.ts-wrapper .ts-control {
    display: flex !important;
    align-items: center !important;
}
/* Highlight color for the search text */
.ts-dropdown .highlight {
    background: rgba(79, 70, 229, 0.4) !important;
    border-radius: 2px;
    padding: 0 2px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar Tom Select para Categorías
    if (document.getElementById('category_id')) {
        new TomSelect("#category_id",{
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            placeholder: "Buscar categoría...",
            allowEmptyOption: false
        });
    }

    // Inicializar Tom Select para Licencias
    if (document.getElementById('license_id')) {
        new TomSelect("#license_id",{
            create: false,
            placeholder: "Buscar licencia...",
        });
    }

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
