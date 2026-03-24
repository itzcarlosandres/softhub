<?php
/**
 * Gestor de Historial de Versiones - Diseño Mejorado
 */

session_start();
define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/app/EnvLoader.php';
EnvLoader::load(BASE_PATH);

require_once BASE_PATH . '/app/helpers.php';
require_once BASE_PATH . '/app/Database.php';

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = BASE_PATH . '/app/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

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

                // SYNC DOWNLOAD LINKS
                if (!empty($_POST['download_url'])) {
                    // Limpiar enlaces viejos
                    $db->prepare("DELETE FROM download_links WHERE software_id = ?")->execute([$_POST['software_id']]);
                    
                    $urls = explode("\n", $_POST['download_url']);
                    foreach ($urls as $url) {
                        $url = trim($url);
                        if (empty($url)) continue;
                        
                        $platform = 'Windows';
                        $urlLower = strtolower($url);
                        if (strpos($urlLower, '#mac') !== false || strpos($urlLower, '#macos') !== false) $platform = 'Mac';
                        elseif (strpos($urlLower, '#linux') !== false) $platform = 'Linux';
                        elseif (strpos($urlLower, '#android') !== false || strpos($urlLower, '.apk') !== false) $platform = 'Android';
                        elseif (strpos($urlLower, '#ios') !== false || strpos($urlLower, '.ipa') !== false) $platform = 'iOS';
                        
                        $cleanUrl = explode('#', $url)[0];
                        
                        $stmtLink = $db->prepare("INSERT INTO download_links (software_id, platform, download_url, version, file_size) VALUES (?, ?, ?, ?, ?)");
                        $stmtLink->execute([
                            $_POST['software_id'],
                            $platform,
                            trim($cleanUrl),
                            $_POST['version_number'],
                            $_POST['file_size'] ?? ''
                        ]);
                    }
                }

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
<?php
$currentPage = 'software';
$pageTitle = 'Gestión de Versiones';
ob_start();
?>

<div class="max-w-7xl mx-auto pb-24 animate-fade-in-up">
    <!-- Header ya no repetido, Admin layout tiene uno, pero pondremos un pequeño top bar -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white font-outfit flex items-center gap-3">
                <i class="fas fa-code-branch text-blue-400"></i> Gestión de Versiones
            </h1>
            <p class="text-gray-400 mt-1">Administra el historial de versiones de tu software</p>
        </div>
        <?php if ($selectedSoftware): ?>
            <a href="<?= url('admin/software/edit/' . $selectedSoftware['id']) ?>" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition backdrop-blur-sm border border-white/10 flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Volver al Software
            </a>
        <?php else: ?>
            <a href="<?= url('admin/software') ?>" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition backdrop-blur-sm border border-white/10 flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Volver a Catálogo
            </a>
        <?php endif; ?>
    </div>

    <!-- Mensaje de estado -->
    <?php if ($message): ?>
        <div class="mb-8 p-4 rounded-xl <?= $messageType === 'success' ? 'bg-green-500/10 border-green-500/30 text-green-400' : 'bg-red-500/10 border-red-500/30 text-red-400' ?> border animate-fade-in flex items-center gap-3">
            <i class="fas <?= $messageType === 'success' ? 'fa-check-circle text-green-400 text-xl' : 'fa-exclamation-circle text-red-400 text-xl' ?>"></i>
            <span class="font-medium whitespace-pre-line"><?= htmlspecialchars($message) ?></span>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 relative z-10">
        <!-- Sidebar - Selección y Formulario -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Seleccionar Software -->
            <div class="glass-panel rounded-2xl overflow-hidden shadow-lg shadow-black/20">
                <div class="bg-white/5 border-b border-white/5 p-5 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/20 rounded-full blur-[30px] -mr-10 -mt-10"></div>
                    <h2 class="text-lg font-bold text-white flex items-center gap-2 font-outfit relative z-10">
                        <i class="fas fa-search text-blue-400"></i> Buscar Software
                    </h2>
                </div>
                <div class="p-5">
                    <!-- Buscador -->
                    <div class="mb-4">
                        <div class="relative">
                            <input 
                                type="text" 
                                id="searchSoftware" 
                                placeholder="🔍 Buscar..." 
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 pl-10 text-white focus:outline-none focus:border-blue-500/50 transition-all placeholder-gray-500"
                                onkeyup="filterSoftware()"
                            >
                            <i class="fas fa-search absolute left-4 top-3.5 text-gray-500"></i>
                        </div>
                    </div>
                    
                    <div class="bg-black/20 rounded-xl overflow-hidden border border-white/5">
                        <select 
                            id="softwareSelect" 
                            onchange="window.location.href='?software_id=' + this.value" 
                            class="w-full bg-transparent text-gray-300 p-2 focus:outline-none custom-scrollbar"
                            size="6"
                            style="background-image: none;"
                        >
                            <option value="" class="text-gray-500 bg-gray-900">-- Seleccionar --</option>
                            <?php foreach ($softwareList as $soft): ?>
                                <option 
                                    value="<?= $soft['id'] ?>" 
                                    <?= isset($_GET['software_id']) && $_GET['software_id'] == $soft['id'] ? 'selected' : '' ?>
                                    data-name="<?= strtolower(htmlspecialchars($soft['name'])) ?>"
                                    class="py-2 px-3 bg-gray-900 border-b border-white/5 hover:bg-white/5 cursor-pointer <?= isset($_GET['software_id']) && $_GET['software_id'] == $soft['id'] ? 'bg-blue-600/20 text-white font-bold' : '' ?>"
                                >
                                    <?= htmlspecialchars($soft['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <?php if ($selectedSoftware): ?>
                        <div class="mt-5 p-4 bg-blue-500/10 rounded-xl border border-blue-500/20">
                            <p class="text-[10px] text-blue-400 font-bold mb-1 uppercase tracking-wider">VERSIÓN ACTUAL</p>
                            <p class="text-xl font-bold text-white font-outfit">
                                v<?= htmlspecialchars($selectedSoftware['version'] ?? 'No especificada') ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Formulario Agregar Versión -->
            <?php if ($selectedSoftware): ?>
            <div class="glass-panel rounded-2xl overflow-hidden shadow-lg shadow-black/20">
                <div class="bg-white/5 border-b border-white/5 p-5 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-green-500/20 rounded-full blur-[30px] -mr-10 -mt-10"></div>
                    <h2 class="text-lg font-bold text-white flex items-center gap-2 font-outfit relative z-10">
                        <i class="fas fa-plus-circle text-green-400"></i> Nueva Versión
                    </h2>
                </div>
                <form method="POST" class="p-5">
                    <input type="hidden" name="software_id" value="<?= $selectedSoftware['id'] ?>">
                    <input type="hidden" name="action" value="add">
                    
                    <div class="space-y-5">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">VERSIÓN <span class="text-green-400">*</span></label>
                            <input type="text" name="version_number" required placeholder="5.2.1" 
                                   class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-green-500/50 transition-all placeholder-gray-600">
                        </div>
                        
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">FECHA <span class="text-green-400">*</span></label>
                            <input type="date" name="release_date" required 
                                   class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-green-500/50 transition-all placeholder-gray-600"
                                   style="color-scheme: dark;">
                        </div>
                        
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">TAMAÑO DEL ARCHIVO</label>
                            <input type="text" name="file_size" placeholder="Ej: 6.77 MB" 
                                   class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-green-500/50 transition-all placeholder-gray-600">
                            <p class="text-[10px] text-gray-500 mt-2"><i class="fas fa-info-circle"></i> Ejemplo: 50 MB, 1.2 GB, 800 KB</p>
                        </div>
                        
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">CHANGELOG</label>
                            <textarea name="changelog" rows="3" placeholder="Descripción de cambios..." 
                                      class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-green-500/50 transition-all placeholder-gray-600 resize-none text-sm"></textarea>
                        </div>
                        
                        <div class="pt-4 border-t border-white/10">
                            <div class="flex items-center justify-between mb-3">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                    <i class="fas fa-link mr-1 text-purple-400"></i>
                                    ENLACES DE DESCARGA
                                </label>
                            </div>
                            
                            <p class="text-[10px] text-gray-500 mb-3 bg-white/5 p-2 rounded-lg border border-white/5 text-center">
                                Usa los tags <span class="text-white font-mono bg-black/50 px-1 rounded">#win</span> <span class="text-white font-mono bg-black/50 px-1 rounded">#mac</span> <span class="text-white font-mono bg-black/50 px-1 rounded">#android</span> <span class="text-white font-mono bg-black/50 px-1 rounded">#linux</span> <span class="text-white font-mono bg-black/50 px-1 rounded">#ios</span>
                            </p>
                            
                            <!-- Lista de Enlaces -->
                            <div id="linksList" class="space-y-2 mb-4 max-h-48 overflow-y-auto custom-scrollbar">
                                <p class="text-gray-500 text-center py-3 text-xs italic">No hay enlaces agregados aún</p>
                            </div>
                            
                            <!-- Input para agregar -->
                            <div class="flex gap-2">
                                <input 
                                    type="text" 
                                    id="newLinkInput" 
                                    placeholder="URL #win, URL #android (pega varios juntos)" 
                                    class="flex-1 bg-black/40 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500/50 placeholder-gray-600 font-mono"
                                    onkeypress="if(event.key === 'Enter') { event.preventDefault(); addLink(); }"
                                >
                                <button type="button" onclick="addLink()" class="px-3 py-2 bg-gradient-to-br from-purple-600 to-blue-600 text-white rounded-xl hover:scale-105 transition-all shadow-lg shadow-purple-500/20">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            
                            <!-- Campo oculto para el formulario -->
                            <input type="hidden" id="downloadUrlsHidden" name="download_url">
                        </div>
                        
                        <button type="submit" class="w-full px-4 py-4 mt-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl font-bold shadow-lg shadow-green-600/20 hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-save text-lg"></i> Guardar Versión
                        </button>
                    </div>
                </form>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Contenido Principal - Lista de Versiones -->
        <div class="lg:col-span-2">
            <?php if ($selectedSoftware): ?>
                <div class="glass-panel rounded-2xl overflow-hidden shadow-xl shadow-black/20 pb-4">
                    <div class="bg-gradient-to-r from-purple-600/30 to-blue-600/30 border-b border-white/10 p-8 relative overflow-hidden backdrop-blur-xl">
                        <div class="absolute inset-0 bg-black/40 pointer-events-none"></div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-4">
                                <?php if (!empty($selectedSoftware['icon'])): ?>
                                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center p-2 backdrop-blur-md border border-white/20 shadow-lg">
                                        <img src="<?= url($selectedSoftware['icon']) ?>" class="w-full h-full object-contain drop-shadow-md">
                                    </div>
                                <?php else: ?>
                                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center p-2 backdrop-blur-md border border-white/20 shadow-lg">
                                        <i class="fas fa-cube text-3xl text-white opacity-80"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <h2 class="text-3xl font-black text-white font-outfit uppercase tracking-wider block">
                                        <?= htmlspecialchars($selectedSoftware['name']) ?>
                                    </h2>
                                    <p class="text-purple-200 mt-1 text-sm font-medium flex items-center gap-2">
                                        <i class="fas fa-history text-purple-400"></i>
                                        <?= count($versions) ?> versiones registradas
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-8">
                        <?php if (empty($versions)): ?>
                            <div class="text-center py-20 bg-white/5 rounded-2xl border border-white/5 border-dashed">
                                <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-500 text-4xl">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <h3 class="text-xl font-bold text-white font-outfit mb-2">Aún no hay versiones</h3>
                                <p class="text-gray-400 text-sm max-w-sm mx-auto">Agrega la primera versión del software utilizando el formulario lateral para habilitar las descargas públicas.</p>
                            </div>
                        <?php else: ?>
                            <div class="space-y-6 relative before:absolute before:inset-y-0 before:left-7 before:w-0.5 before:bg-gradient-to-b before:from-purple-500/50 before:to-transparent">
                                <?php foreach ($versions as $index => $ver): ?>
                                    <div class="relative flex gap-6 z-10">
                                        <!-- Timeline Node -->
                                        <div class="flex-none mt-1">
                                            <div class="w-14 h-14 rounded-full bg-gray-900 border-4 border-gray-800 shadow-[0_0_15px_rgba(168,85,247,0.4)] flex items-center justify-center relative z-20 <?= $index === 0 ? 'border-purple-500 overflow-hidden' : 'border-gray-700' ?>">
                                                <?php if($index === 0): ?>
                                                    <div class="absolute inset-0 bg-purple-500/20 blur-md"></div>
                                                    <i class="fas fa-star text-yellow-400 text-xl drop-shadow-lg relative z-10"></i>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-sm font-bold opacity-50">#<?= count($versions) - $index ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <!-- Card Record -->
                                        <div class="flex-1 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-purple-500/40 rounded-2xl p-6 transition-all duration-300 group">
                                            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-4">
                                                <div>
                                                    <div class="flex flex-wrap items-center gap-3 mb-2">
                                                        <span class="px-4 py-1.5 <?= $index === 0 ? 'bg-gradient-to-r from-purple-500 to-indigo-500 shadow-lg shadow-purple-500/20' : 'bg-white/10 text-gray-300' ?> text-white rounded-lg text-lg font-black font-outfit tracking-wider">
                                                            v<?= htmlspecialchars($ver['version_number']) ?>
                                                        </span>
                                                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest bg-black/30 px-3 py-1.5 rounded-lg border border-white/5 flex items-center gap-1.5">
                                                            <i class="fas fa-calendar-day text-blue-400"></i>
                                                            <?= date('d M Y', strtotime($ver['release_date'])) ?>
                                                        </span>
                                                        <?php if ($index === 0): ?>
                                                            <span class="text-[10px] bg-green-500/20 text-green-400 uppercase font-black px-2 py-1 rounded border border-green-500/30">ACTUAL</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    
                                                    <?php if (!empty($ver['file_size'])): ?>
                                                        <div class="mt-3 inline-flex items-center gap-2 px-3 py-1 bg-white/5 rounded-md border border-white/5 text-xs text-gray-300 font-medium whitespace-nowrap">
                                                            <i class="fas fa-hdd text-gray-400"></i>
                                                            <?= htmlspecialchars($ver['file_size']) ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <form method="POST" onsubmit="return confirm('¿ELIMINAR ESTA VERSIÓN PERMANENTEMENTE? Los enlaces se perderán.')">
                                                    <input type="hidden" name="version_id" value="<?= $ver['id'] ?>">
                                                    <input type="hidden" name="action" value="delete">
                                                    <button type="submit" class="w-10 h-10 bg-red-500/10 hover:bg-red-500/30 border border-red-500/20 text-red-400 hover:text-red-300 rounded-xl transition-all flex items-center justify-center" title="Eliminar registro">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            
                                            <?php if (!empty($ver['changelog'])): ?>
                                                <div class="mt-4 bg-black/40 rounded-xl p-4 border border-white/5">
                                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 flex items-center gap-2">
                                                        <i class="fas fa-file-alt text-gray-600"></i> Cambios en esta versión
                                                    </p>
                                                    <p class="text-sm text-gray-300 leading-relaxed font-sans whitespace-pre-line pl-2 border-l border-white/10"><?= htmlspecialchars($ver['changelog']) ?></p>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($ver['download_url'])): ?>
                                                <div class="mt-6 pt-5 border-t border-white/10">
                                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3 flex items-center gap-2">
                                                        <i class="fas fa-cloud-download-alt text-blue-400"></i> Enlaces de descarga configurados
                                                    </p>
                                                    <?php 
                                                    $urls = explode("\n", $ver['download_url']);
                                                    $urls = array_filter(array_map('trim', $urls));
                                                    ?>
                                                    <div class="flex flex-wrap gap-2">
                                                        <?php foreach ($urls as $i => $url): ?>
                                                            <?php
                                                                $platformIcon = 'fas fa-link text-gray-400';
                                                                $lowUrl = strtolower($url);
                                                                if(str_contains($lowUrl,'windows') || str_contains($lowUrl,'#win') || str_contains($lowUrl,'.exe')) $platformIcon = 'fab fa-windows text-blue-400';
                                                                elseif(str_contains($lowUrl,'#mac') || str_contains($lowUrl,'.dmg')) $platformIcon = 'fab fa-apple text-gray-300';
                                                                elseif(str_contains($lowUrl,'#android') || str_contains($lowUrl,'.apk')) $platformIcon = 'fab fa-android text-green-400';
                                                            ?>
                                                            <a href="<?= htmlspecialchars($url) ?>" target="_blank" 
                                                               class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/5 hover:bg-white/10 rounded border border-white/10 text-[11px] font-mono text-gray-300 transition group-hover:border-white/20">
                                                                <i class="<?= $platformIcon ?>"></i>
                                                                URL <?= $i + 1 ?>
                                                            </a>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="glass-panel rounded-2xl p-16 text-center border border-white/5 flex flex-col items-center justify-center min-h-[400px]">
                    <div class="w-24 h-24 bg-white/5 rounded-3xl flex items-center justify-center shadow-inner mb-6 text-gray-500 text-5xl">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white font-outfit mb-3">Ningún software seleccionado</h3>
                    <p class="text-gray-400 max-w-sm">Utiliza la barra lateral izquierda para buscar y seleccionar el software cuyo historial de versiones deseas gestionar.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
let originalOptions = [];

function initSoftwareSearch() {
    if (originalOptions.length > 0) return; // Ya inicializado
    
    const select = document.getElementById('softwareSelect');
    if (!select) return;
    
    Array.from(select.options).forEach(opt => {
        if (opt.value !== '') {
            originalOptions.push({
                value: opt.value,
                text: opt.textContent,
                dataName: opt.getAttribute('data-name') || '',
                selected: opt.selected,
                className: opt.className
            });
        }
    });
}

// Inicializar síncronamente por si acaso, ya que el DOM ya cargó este punto
initSoftwareSearch();

function filterSoftware() {
    initSoftwareSearch(); // Asegurar inicialización
    
    const searchInput = document.getElementById('searchSoftware');
    const select = document.getElementById('softwareSelect');
    if(!select || !searchInput) return;
    
    const filter = searchInput.value.toLowerCase().trim();
    
    // Remove all options except the first one (value="")
    while (select.options.length > 1) {
        select.remove(1);
    }
    
    // Add back matching options
    originalOptions.forEach(optData => {
        if (!filter || optData.dataName.includes(filter)) {
            const newOption = document.createElement('option');
            newOption.value = optData.value;
            newOption.textContent = optData.text;
            newOption.setAttribute('data-name', optData.dataName);
            newOption.className = optData.className;
            if (optData.selected) {
                newOption.selected = true;
            }
            select.appendChild(newOption);
        }
    });
}

// Gestor Visual de Enlaces
let links = [];

function detectOS(url) {
    const urlLower = url.toLowerCase();
    
    if (urlLower.includes('#win') || urlLower.includes('#windows')) return 'windows';
    if (urlLower.includes('#mac') || urlLower.includes('#macos')) return 'mac';
    if (urlLower.includes('#linux')) return 'linux';
    if (urlLower.includes('#android')) return 'android';
    if (urlLower.includes('#ios')) return 'ios';
    if (urlLower.includes('#all') || urlLower.includes('#multi')) return 'all';
    
    if (urlLower.includes('.apk')) return 'android';
    if (urlLower.includes('.ipa')) return 'ios';
    if (urlLower.includes('.exe') || urlLower.includes('.msi')) return 'windows';
    if (urlLower.includes('.dmg') || urlLower.includes('.pkg')) return 'mac';
    if (urlLower.includes('.deb') || urlLower.includes('.rpm') || urlLower.includes('.appimage')) return 'linux';
    
    return 'unknown';
}

function getOSConfig(os) {
    const configs = {
        'windows': { name: 'Windows', icon: 'fab fa-windows', color: 'blue', text: 'text-blue-400', bg: 'bg-blue-500/10', border: 'border-blue-500/20' },
        'mac': { name: 'macOS', icon: 'fab fa-apple', color: 'gray', text: 'text-gray-300', bg: 'bg-white/5', border: 'border-white/10' },
        'linux': { name: 'Linux', icon: 'fab fa-linux', color: 'yellow', text: 'text-yellow-500', bg: 'bg-yellow-500/10', border: 'border-yellow-500/20' },
        'android': { name: 'Android', icon: 'fab fa-android', color: 'green', text: 'text-green-400', bg: 'bg-green-500/10', border: 'border-green-500/20' },
        'ios': { name: 'iOS', icon: 'fab fa-app-store-ios', color: 'slate', text: 'text-slate-300', bg: 'bg-slate-500/10', border: 'border-slate-500/20' },
        'all': { name: 'Multiplataforma', icon: 'fas fa-globe', color: 'purple', text: 'text-purple-400', bg: 'bg-purple-500/10', border: 'border-purple-500/20' },
        'unknown': { name: 'Desconocido', icon: 'fas fa-link', color: 'gray', text: 'text-gray-500', bg: 'bg-white/5', border: 'border-white/10' }
    };
    return configs[os] || configs['unknown'];
}

function addLink() {
    const input = document.getElementById('newLinkInput');
    const rawUrls = input.value.trim();
    
    if (!rawUrls) return;
    
    const urlArray = rawUrls.split(/[\s,]+/);
    
    urlArray.forEach(url => {
        if (!url.trim()) return;
        const cleanUrl = url.split('#')[0].trim();
        const os = detectOS(url);
        const config = getOSConfig(os);
        
        links.push({ url: cleanUrl, os, config, original: url });
    });
    
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
        container.innerHTML = '<p class="text-gray-500 text-center py-3 text-xs italic bg-white/5 rounded-lg border border-white/5">No hay enlaces agregados aún</p>';
        return;
    }
    
    container.innerHTML = links.map((link, index) => `
        <div class="flex items-center gap-3 p-2.5 ${link.config.bg} border ${link.config.border} rounded-xl group transition-all">
            <div class="w-8 h-8 bg-black/40 rounded-lg flex items-center justify-center ${link.config.text} text-sm shadow-inner border border-white/5">
                <i class="${link.config.icon}"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-bold text-[11px] text-gray-300 uppercase tracking-widest">${link.config.name}</p>
                <p class="text-[10px] text-gray-500 font-mono truncate" title="${link.url}">${link.url.replace(/^https?:\\/\\//i, '')}</p>
            </div>
            <button type="button" onclick="removeLink(${index})" class="w-7 h-7 bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white rounded-lg transition-colors flex items-center justify-center" title="Quitar">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `).join('');
}

function updateHiddenField() {
    const code = links.map(link => link.original).join('\\n');
    document.getElementById('downloadUrlsHidden').value = code;
}

// Inicializar
renderLinks();
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../app/Views/layouts/admin.php';
?>
