<?php
/**
 * Gestor de Historial de Versiones - Diseño Mejorado
 */

require_once __DIR__ . '/../app/EnvLoader.php';
require_once __DIR__ . '/../app/Database.php';

EnvLoader::load(dirname(__DIR__));

$db = \App\Database::getInstance()->getConnection();

// Procesar formulario
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add' && isset($_POST['software_id'], $_POST['version_number'], $_POST['release_date'])) {
        try {
            $stmt = $db->prepare("
                INSERT INTO software_versions (software_id, version_number, release_date, changelog, download_url, file_size) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $result = $stmt->execute([
                $_POST['software_id'],
                $_POST['version_number'],
                $_POST['release_date'],
                $_POST['changelog'] ?? '',
                $_POST['download_url'] ?? '',
                $_POST['file_size'] ?? ''
            ]);
            
            if ($result) {
                // ACTUALIZACIÓN AUTOMÁTICA: Sincronizar con la tabla principal de software
                $stmtMain = $db->prepare("UPDATE software SET version = ? WHERE id = ?");
                $stmtMain->execute([$_POST['version_number'], $_POST['software_id']]);

                $message = "✅ Versión agregada y software actualizado a v" . $_POST['version_number'];
                $messageType = "success";
            } else {
                $message = "❌ Error al agregar la versión";
                $messageType = "error";
            }
        } catch (Exception $e) {
            $message = "❌ Error: " . $e->getMessage();
            $messageType = "error";
        }
    } elseif ($action === 'delete' && isset($_POST['version_id'])) {
        try {
            $stmt = $db->prepare("DELETE FROM software_versions WHERE id = ?");
            $stmt->execute([$_POST['version_id']]);
            $message = "✅ Versión eliminada";
            $messageType = "success";
        } catch (Exception $e) {
            $message = "❌ Error al eliminar: " . $e->getMessage();
            $messageType = "error";
        }
    }
}

// Obtener lista de software
$stmt = $db->query("SELECT id, name FROM software WHERE status = 'approved' ORDER BY name");
$softwareList = $stmt->fetchAll();

// Si se seleccionó un software, obtener sus versiones
$selectedSoftware = null;
$versions = [];
if (isset($_GET['software_id'])) {
    $softwareId = $_GET['software_id'];
    
    $stmt = $db->prepare("SELECT * FROM software WHERE id = ?");
    $stmt->execute([$softwareId]);
    $selectedSoftware = $stmt->fetch();
    
    if ($selectedSoftware) {
        $stmt = $db->prepare("
            SELECT * FROM software_versions 
            WHERE software_id = ? 
            ORDER BY release_date DESC, id DESC
        ");
        $stmt->execute([$softwareId]);
        $versions = $stmt->fetchAll();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Versiones - SoftHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <div class="gradient-bg text-white py-8 shadow-lg">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold flex items-center gap-3">
                        <i class="fas fa-code-branch"></i>
                        Gestión de Versiones
                    </h1>
                    <p class="text-purple-100 mt-2">Administra el historial de versiones de tu software</p>
                </div>
                <a href="<?= env('APP_URL') ?: '/laravel/public' ?>" class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg transition backdrop-blur-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
            </div>
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Mensaje de estado -->
        <?php if ($message): ?>
            <div class="mb-6 p-4 rounded-lg <?= $messageType === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : 'bg-red-50 border border-red-200 text-red-800' ?> animate-fade-in">
                <div class="flex items-center gap-2">
                    <i class="fas <?= $messageType === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' ?>"></i>
                    <?= $message ?>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Sidebar - Selección y Formulario -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Seleccionar Software -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden card-hover">
                    <div class="bg-gradient-to-r from-blue-500 to-cyan-500 p-4">
                        <h2 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-search"></i>
                            Buscar Software
                        </h2>
                    </div>
                    <div class="p-4">
                        <!-- Buscador -->
                        <div class="mb-3">
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="searchSoftware" 
                                    placeholder="🔍 Buscar..." 
                                    class="w-full px-4 py-2.5 pl-10 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    onkeyup="filterSoftware()"
                                >
                                <i class="fas fa-search absolute left-3 top-3.5 text-gray-400"></i>
                            </div>
                        </div>
                        
                        <select 
                            id="softwareSelect" 
                            onchange="window.location.href='?software_id=' + this.value" 
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 transition"
                            size="6"
                        >
                            <option value="">-- Seleccionar --</option>
                            <?php foreach ($softwareList as $soft): ?>
                                <option 
                                    value="<?= $soft['id'] ?>" 
                                    <?= isset($_GET['software_id']) && $_GET['software_id'] == $soft['id'] ? 'selected' : '' ?>
                                    data-name="<?= strtolower(htmlspecialchars($soft['name'])) ?>"
                                >
                                    <?= htmlspecialchars($soft['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        
                        <?php if ($selectedSoftware): ?>
                            <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-100">
                                <p class="text-xs text-blue-600 font-semibold mb-1">VERSIÓN ACTUAL</p>
                                <p class="text-lg font-bold text-blue-900">
                                    v<?= htmlspecialchars($selectedSoftware['version'] ?? 'No especificada') ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Formulario Agregar Versión -->
                <?php if ($selectedSoftware): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden card-hover">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-500 p-4">
                        <h2 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-plus-circle"></i>
                            Nueva Versión
                        </h2>
                    </div>
                    <form method="POST" class="p-4">
                        <input type="hidden" name="software_id" value="<?= $selectedSoftware['id'] ?>">
                        <input type="hidden" name="action" value="add">
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">VERSIÓN *</label>
                                <input type="text" name="version_number" required placeholder="5.2.1" 
                                       class="w-full px-3 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 transition">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">FECHA *</label>
                                <input type="date" name="release_date" required 
                                       class="w-full px-3 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 transition">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">TAMAÑO DEL ARCHIVO</label>
                                <input type="text" name="file_size" placeholder="Ej: 6.77 MB" 
                                       class="w-full px-3 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 transition">
                                <p class="text-xs text-gray-500 mt-1">Opcional. Ejemplo: 50 MB, 1.2 GB, 800 KB</p>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">CHANGELOG</label>
                                <textarea name="changelog" rows="3" placeholder="Descripción de cambios..." 
                                          class="w-full px-3 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 transition text-sm"></textarea>
                            </div>
                            
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="block text-xs font-bold text-gray-700">
                                        <i class="fas fa-link mr-1 text-blue-500"></i>
                                        ENLACES DE DESCARGA
                                    </label>
                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">
                                        #win #mac #linux #android #ios
                                    </span>
                                </div>
                                
                                <!-- Lista de Enlaces -->
                                <div id="linksList" class="space-y-2 mb-2 max-h-48 overflow-y-auto">
                                    <p class="text-gray-400 text-center py-3 text-xs">No hay enlaces</p>
                                </div>
                                
                                <!-- Input para agregar -->
                                <div class="flex gap-2">
                                    <input 
                                        type="url" 
                                        id="newLinkInput" 
                                        placeholder="URL + #win" 
                                        class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                                        onkeypress="if(event.key === 'Enter') { event.preventDefault(); addLink(); }"
                                    >
                                    <button type="button" onclick="addLink()" class="px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                
                                <!-- Campo oculto para el formulario -->
                                <input type="hidden" id="downloadUrlsHidden" name="download_url">
                            </div>
                            
                            <button type="submit" class="w-full px-4 py-3 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-lg font-bold hover:shadow-lg transition">
                                <i class="fas fa-plus mr-2"></i>Agregar Versión
                            </button>
                        </div>
                    </form>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Contenido Principal - Lista de Versiones -->
            <div class="lg:col-span-2">
                <?php if ($selectedSoftware): ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-6">
                            <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                                <i class="fas fa-layer-group"></i>
                                <?= htmlspecialchars($selectedSoftware['name']) ?>
                            </h2>
                            <p class="text-purple-100 mt-1">
                                <i class="fas fa-history mr-1"></i>
                                <?= count($versions) ?> versiones registradas
                            </p>
                        </div>
                        
                        <div class="p-6">
                            <?php if (empty($versions)): ?>
                                <div class="text-center py-16">
                                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500 text-lg">No hay versiones registradas</p>
                                    <p class="text-gray-400 text-sm mt-2">Agrega la primera versión usando el formulario</p>
                                </div>
                            <?php else: ?>
                                <div class="space-y-3">
                                    <?php foreach ($versions as $ver): ?>
                                        <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 hover:shadow-md transition card-hover">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-3 mb-2">
                                                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-bold">
                                                            v<?= htmlspecialchars($ver['version_number']) ?>
                                                        </span>
                                                        <span class="text-sm text-gray-500">
                                                            <i class="fas fa-calendar mr-1"></i>
                                                            <?= date('d/m/Y', strtotime($ver['release_date'])) ?>
                                                        </span>
                                                    </div>
                                                    
                                                    <?php if (!empty($ver['file_size'])): ?>
                                                        <div class="mb-2">
                                                            <span class="text-sm text-gray-600">
                                                                <i class="fas fa-hdd mr-1 text-green-500"></i>
                                                                Tamaño: <strong><?= htmlspecialchars($ver['file_size']) ?></strong>
                                                            </span>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <?php if (!empty($ver['changelog'])): ?>
                                                        <p class="text-sm text-gray-700 mb-3 pl-3 border-l-2 border-purple-200">
                                                            <?= htmlspecialchars($ver['changelog']) ?>
                                                        </p>
                                                    <?php endif; ?>
                                                    
                                                    <?php if (!empty($ver['download_url'])): ?>
                                                        <div class="text-sm">
                                                            <p class="font-semibold text-gray-700 mb-1">
                                                                <i class="fas fa-link mr-1 text-blue-500"></i>
                                                                Enlaces:
                                                            </p>
                                                            <?php 
                                                            $urls = explode("\n", $ver['download_url']);
                                                            $urls = array_filter(array_map('trim', $urls));
                                                            ?>
                                                            <div class="flex flex-wrap gap-2">
                                                                <?php foreach ($urls as $index => $url): ?>
                                                                    <a href="<?= htmlspecialchars($url) ?>" target="_blank" 
                                                                       class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-xs font-medium">
                                                                        <i class="fas fa-external-link-alt mr-1"></i>
                                                                        Enlace <?= $index + 1 ?>
                                                                    </a>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <form method="POST" onsubmit="return confirm('¿Eliminar esta versión?')">
                                                    <input type="hidden" name="version_id" value="<?= $ver['id'] ?>">
                                                    <input type="hidden" name="action" value="delete">
                                                    <button type="submit" class="px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-16 text-center">
                        <i class="fas fa-arrow-left text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 text-xl font-medium">Selecciona un software</p>
                        <p class="text-gray-400 mt-2">Usa el buscador de la izquierda para comenzar</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script>
    function filterSoftware() {
        const searchInput = document.getElementById('searchSoftware');
        const select = document.getElementById('softwareSelect');
        const filter = searchInput.value.toLowerCase();
        const options = select.getElementsByTagName('option');
        
        for (let i = 0; i < options.length; i++) {
            const option = options[i];
            const name = option.getAttribute('data-name') || '';
            
            if (name.includes(filter) || option.value === '') {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        }
    }
    
    // Gestor Visual de Enlaces
    let links = [];
    
    function detectOS(url) {
        const urlLower = url.toLowerCase();
        
        // PRIORIDAD 1: Etiquetas explícitas
        if (urlLower.includes('#win') || urlLower.includes('#windows')) return 'windows';
        if (urlLower.includes('#mac') || urlLower.includes('#macos')) return 'mac';
        if (urlLower.includes('#linux')) return 'linux';
        if (urlLower.includes('#android')) return 'android';
        if (urlLower.includes('#ios')) return 'ios';
        if (urlLower.includes('#all') || urlLower.includes('#multi')) return 'all';
        
        // PRIORIDAD 2: Extensiones
        if (urlLower.includes('.apk')) return 'android';
        if (urlLower.includes('.ipa')) return 'ios';
        if (urlLower.includes('.exe') || urlLower.includes('.msi')) return 'windows';
        if (urlLower.includes('.dmg') || urlLower.includes('.pkg')) return 'mac';
        if (urlLower.includes('.deb') || urlLower.includes('.rpm') || urlLower.includes('.appimage')) return 'linux';
        
        return 'unknown';
    }
    
    function getOSConfig(os) {
        const configs = {
            'windows': { name: 'Windows', icon: 'fab fa-windows', color: 'blue', bg: 'bg-blue-50', border: 'border-blue-200', iconBg: 'bg-blue-500' },
            'mac': { name: 'macOS', icon: 'fab fa-apple', color: 'gray', bg: 'bg-gray-50', border: 'border-gray-200', iconBg: 'bg-gray-700' },
            'linux': { name: 'Linux', icon: 'fab fa-linux', color: 'yellow', bg: 'bg-yellow-50', border: 'border-yellow-200', iconBg: 'bg-yellow-600' },
            'android': { name: 'Android', icon: 'fab fa-android', color: 'green', bg: 'bg-green-50', border: 'border-green-200', iconBg: 'bg-green-500' },
            'ios': { name: 'iOS', icon: 'fab fa-app-store-ios', color: 'slate', bg: 'bg-slate-50', border: 'border-slate-200', iconBg: 'bg-slate-700' },
            'all': { name: 'Multiplataforma', icon: 'fas fa-globe', color: 'purple', bg: 'bg-purple-50', border: 'border-purple-200', iconBg: 'bg-purple-500' },
            'unknown': { name: 'Desconocido', icon: 'fas fa-question', color: 'gray', bg: 'bg-gray-50', border: 'border-gray-200', iconBg: 'bg-gray-400' }
        };
        return configs[os] || configs['unknown'];
    }
    
    function addLink() {
        const input = document.getElementById('newLinkInput');
        const url = input.value.trim();
        
        if (!url) return;
        
        const cleanUrl = url.split('#')[0].trim();
        const os = detectOS(url);
        const config = getOSConfig(os);
        
        links.push({ url: cleanUrl, os, config, original: url });
        input.value = '';
        
        renderLinks();
        updateHiddenField();
    }
    
    function removeLink(index) {
        links.splice(index, 1);
        renderLinks();
        updateHiddenField();
    }
    
    function renderLinks() {
        const container = document.getElementById('linksList');
        
        if (links.length === 0) {
            container.innerHTML = '<p class="text-gray-400 text-center py-3 text-xs">No hay enlaces</p>';
            return;
        }
        
        container.innerHTML = links.map((link, index) => `
            <div class="flex items-center gap-2 p-2 ${link.config.bg} border ${link.config.border} rounded-lg group">
                <div class="w-6 h-6 ${link.config.iconBg} rounded flex items-center justify-center text-white text-xs">
                    <i class="${link.config.icon}"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-xs text-gray-900">${link.config.name}</p>
                    <p class="text-xs text-gray-500 truncate">${link.url.split('/').pop()}</p>
                </div>
                <button type="button" onclick="removeLink(${index})" class="px-2 py-1 bg-red-500 text-white rounded text-xs opacity-0 group-hover:opacity-100 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `).join('');
    }
    
    function updateHiddenField() {
        const code = links.map(link => link.original).join('\n');
        document.getElementById('downloadUrlsHidden').value = code;
    }
    
    // Inicializar
    renderLinks();
    </script>
</body>
</html>
