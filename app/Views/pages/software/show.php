<?php
// Debug Errors (TEMPORAL)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Obtener el software
$slug = $params['slug'] ?? '';
$db = \App\Database::getInstance()->getConnection();
$stmt = $db->prepare("
    SELECT s.*, c.name as category_name, c.slug as category_slug, l.name as license_name 
    FROM software s 
    LEFT JOIN categories c ON s.category_id = c.id 
    LEFT JOIN licenses l ON s.license = l.slug 
    WHERE s.slug = ?
");
$stmt->execute([$slug]);
$software = $stmt->fetch();

if (!$software) {
    header('Location: ' . url('software'));
    exit;
}

// Generar título y meta tags SEO dinámicos
$title = seo_download_title($software['name'], $software['version']);
$description = seo_software_description($software);
$keywords = seo_software_keywords($software, $software['category_name'] ?? null);

// Software relacionado (misma categoría)
$stmt = $db->prepare("SELECT * FROM software WHERE category_id = ? AND id != ? AND status = 'approved' ORDER BY downloads DESC LIMIT 6");
$stmt->execute([$software['category_id'], $software['id']]);
$related = $stmt->fetchAll();

// Obtener enlaces de descarga
$stmt = $db->prepare("SELECT * FROM download_links WHERE software_id = ? ORDER BY platform");
$stmt->execute([$software['id']]);
$downloadLinks = $stmt->fetchAll();

// Obtener alternativas
$stmt = $db->prepare("
    SELECT s.* 
    FROM software s
    INNER JOIN software_alternatives sa ON s.id = sa.alternative_id
    WHERE sa.software_id = ? AND s.status = 'approved'
    ORDER BY s.downloads DESC
    LIMIT 6
");
$stmt->execute([$software['id']]);
$alternatives = $stmt->fetchAll();

// Si no hay alternativas manuales, sugerir por categoría
if (empty($alternatives)) {
    $stmt = $db->prepare("SELECT * FROM software WHERE category_id = ? AND id != ? AND status = 'approved' ORDER BY downloads DESC LIMIT 6");
    $stmt->execute([$software['category_id'], $software['id']]);
    $alternatives = $stmt->fetchAll();
}

// Obtener historial de versiones
$stmt = $db->prepare("SELECT * FROM software_versions WHERE software_id = ? ORDER BY release_date DESC, id DESC LIMIT 10");
$stmt->execute([$software['id']]);
$versions = $stmt->fetchAll();

// Helper Icon Function (Closure)
$get_icon_url = function($soft) {
    return !empty($soft['icon']) ? url($soft['icon']) : '';
};

ob_start();
?>

<!-- SPLIT SCREEN LAYOUT IMPLEMENTATION -->
<div class="bg-white dark:bg-gray-900 min-h-screen font-outfit text-gray-900 dark:text-white border-t-8 border-black dark:border-transparent transition-colors duration-300">
    <div class="flex flex-col lg:flex-row min-h-screen">
        
        <!-- Left Side (Sticky Info) -->
        <div class="lg:w-5/12 bg-gray-50 dark:bg-gray-800/50 p-8 lg:p-20 flex flex-col justify-start h-auto lg:h-[calc(100vh-60px)] lg:sticky lg:top-0 border-r border-gray-200 dark:border-gray-800 overflow-y-auto transition-colors">
            
            <!-- Breadcrumb Mobile -->
            <nav class="lg:hidden text-sm text-gray-500 dark:text-gray-400 mb-6 flex items-center gap-2">
                <a href="<?= url() ?>"><?= __('home', 'Inicio') ?></a> / <span><?= htmlspecialchars($software['name']) ?></span>
            </nav>

            <div class="flex-1 flex flex-col justify-center">
                 <div class="w-32 h-32 bg-white dark:bg-gray-800 rounded-3xl shadow-xl flex items-center justify-center mb-10 ring-1 ring-black/5 dark:ring-white/5 mx-auto lg:mx-0 transition-transform hover:scale-105 duration-500 overflow-hidden">
                    <?php if($get_icon_url($software)): ?>
                        <img src="<?= $get_icon_url($software) ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <i class="fas fa-cube text-5xl text-blue-600"></i>
                    <?php endif; ?>
                 </div>
                  <h1 class="text-3xl lg:text-5xl font-black text-gray-900 dark:text-white mb-6 tracking-tighter leading-tight text-center lg:text-left transition-colors flex flex-wrap items-center justify-center lg:justify-start gap-3">
                    <span class="inline-block"><?= htmlspecialchars($software['name']) ?><span class="text-blue-600 dark:text-blue-400">.</span></span>
                    
                    <?php 
                    $bName = !empty($software['badge_name']) ? $software['badge_name'] : ($software['custom_badge'] ?? '');
                    $bColor = !empty($software['badge_color']) ? $software['badge_color'] : 'cyan';
                    
                    $colorClasses = [
                        'cyan' => 'bg-cyan-500/10 dark:bg-cyan-400/10 border-cyan-500/20 text-cyan-600 dark:text-cyan-400',
                        'blue' => 'bg-blue-500/10 dark:bg-blue-400/10 border-blue-500/20 text-blue-600 dark:text-blue-400',
                        'purple' => 'bg-purple-500/10 dark:bg-purple-400/10 border-purple-500/20 text-purple-600 dark:text-purple-400',
                        'pink' => 'bg-pink-500/10 dark:bg-pink-400/10 border-pink-500/20 text-pink-600 dark:text-pink-400',
                        'orange' => 'bg-orange-500/10 dark:bg-orange-400/10 border-orange-500/20 text-orange-600 dark:text-orange-400',
                        'emerald' => 'bg-emerald-500/10 dark:bg-emerald-400/10 border-emerald-500/20 text-emerald-600 dark:text-emerald-400',
                        'rose' => 'bg-rose-500/10 dark:bg-rose-400/10 border-rose-500/20 text-rose-600 dark:text-rose-400',
                    ];
                    $cls = $colorClasses[$bColor] ?? $colorClasses['cyan'];
                    ?>

                    <?php if (!empty($bName)): ?>
                        <span class="inline-flex px-3 py-1 border text-xs lg:text-sm font-black rounded-xl uppercase tracking-widest align-middle flex-shrink-0 <?= $cls ?>">
                            <?= htmlspecialchars($bName) ?>
                        </span>
                    <?php endif; ?>
                  </h1>

                 <?php if (!empty($software['badge_editors_choice'])): ?>
                     <div class="flex justify-center lg:justify-start mb-6">
                         <span class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-sm font-bold uppercase tracking-wider rounded-full shadow-lg shadow-purple-500/20">
                             <i class="fas fa-award"></i> <?= __('editors_choice', "Editor's Choice") ?>
                         </span>
                     </div>
                 <?php endif; ?>
                 
                 <p class="text-xl lg:text-3xl text-gray-500 dark:text-gray-400 font-light leading-snug mb-12 text-center lg:text-left transition-colors">
                     <?= htmlspecialchars($software['short_description']) ?>
                 </p>
                 
                 <div class="flex flex-row gap-3 w-full max-w-md mx-auto mt-4">
                     <a href="<?= url('download/' . $software['id']) ?>" class="flex-1 flex justify-center items-center bg-black dark:bg-blue-600 text-white py-3.5 px-2 rounded-xl font-bold text-sm sm:text-base hover:bg-gray-800 dark:hover:bg-blue-700 transition shadow-lg shadow-gray-200 dark:shadow-none transform hover:-translate-y-1">
                         <i class="fas fa-download mr-1.5 sm:mr-2"></i> <span class="truncate"><?= __('download', 'Descargar') ?></span>
                     </a>
                     
                     <?php if (!empty($software['price']) && $software['price'] > 0): ?>
                     <a href="<?= !empty($software['buy_url']) ? htmlspecialchars($software['buy_url']) : '#' ?>" target="_blank" class="flex-1 flex justify-center items-center bg-gradient-to-r from-yellow-400 to-amber-500 text-white py-3.5 px-2 rounded-xl font-bold text-sm sm:text-base hover:from-yellow-300 hover:to-amber-400 transition-all duration-300 border border-yellow-300/50 relative group overflow-hidden drop-shadow-md" style="animation: pulse-glow 2.5s infinite ease-in-out;">
                         <style>
                             @keyframes pulse-glow {
                                 0%, 100% { box-shadow: 0 0 10px rgba(251, 191, 36, 0.3); transform: scale(1); }
                                 50% { box-shadow: 0 0 20px rgba(251, 191, 36, 0.7); transform: scale(1.02); }
                             }
                         </style>
                         <div class="flex items-center justify-center relative z-10 transition-transform group-hover:scale-105 w-full">
                             <i class="fas fa-crown relative -top-[1px] group-hover:animate-bounce mr-1.5"></i>
                             <span class="truncate"><?= __('premium', 'Prémium') ?></span>
                             <span class="bg-black/20 text-white px-1.5 py-0.5 rounded shadow-inner text-[10px] sm:text-xs ml-1.5 border border-white/20 font-bold">$<?= number_format($software['price'], 2) ?></span>
                         </div>
                     </a>
                     <?php endif; ?>
                 </div>
            </div>
            
            <!-- Metadata Footer Left -->
            <div class="hidden lg:flex mt-auto pt-12 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest justify-between items-end border-t border-gray-200/50 dark:border-gray-700/50 transition-colors">
                 <div>
                     <div class="mb-1"><?= __('updated', 'Actualizado') ?></div>
                     <div class="text-gray-900 dark:text-white text-base font-black transition-colors"><?= $software['updated_at'] ? date('d M Y', strtotime($software['updated_at'])) : __('recent', 'Reciente') ?></div>
                 </div>
                 <div class="text-right">
                     <div class="mb-1"><?= __('total_downloads', 'Descargas Totales') ?></div>
                     <div class="text-gray-900 dark:text-white text-base font-black transition-colors"><?= number_format($software['downloads']) ?></div>
                 </div>
            </div>
        </div>
        
        <!-- Right Side (Scrollable Content) -->
        <div class="lg:w-7/12 bg-white dark:bg-gray-900 p-8 lg:p-24 transition-colors">
            
            <!-- Content Header (Removed) -->
            
            <h2 class="font-black text-3xl mb-6 border-b-2 border-gray-100 dark:border-gray-800 pb-3 flex items-center gap-3 text-transparent bg-clip-text bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300 transition-colors">
                <?= __('description', 'Descripción') ?>
                <span class="w-3 h-3 rounded-full bg-blue-500 shadow-[0_0_12px_rgba(59,130,246,0.6)]"></span>
            </h2>
            
            <!-- Description with Read More -->
            <div id="description-wrapper" class="relative mb-20 overflow-hidden transition-[max-height] duration-700 ease-in-out" style="max-height: 280px;">
                <article id="description-text" class="prose prose-xl prose-slate dark:prose-invert max-w-none text-gray-800 dark:text-gray-100 font-medium leading-[1.8] tracking-wide transition-colors">
                     <?= $software['description'] ?>
                </article>
                
                <!-- Read More Button Overlay -->
                <div id="read-more-overlay" class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-white via-white/90 dark:from-gray-900 dark:via-gray-900/90 to-transparent flex items-end justify-center pb-4 transition-opacity duration-500">
                    <button onclick="toggleDescription()" class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-900 dark:text-white font-bold py-2 px-6 rounded-full shadow-sm border border-gray-200 dark:border-gray-700 text-sm flex items-center gap-2 transition-colors">
                        <span><?= __('read_more_description', 'Leer descripción completa') ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
            </div>

            <script>
            function toggleDescription() {
                const wrapper = document.getElementById('description-wrapper');
                const overlay = document.getElementById('read-more-overlay');
                
                // Set height to scrollHeight to animate
                wrapper.style.maxHeight = wrapper.scrollHeight + "px";
                
                // Fade out overlay
                overlay.style.opacity = '0';
                overlay.style.pointerEvents = 'none';
                
                // Remove max-height restriction after animation
                setTimeout(() => {
                    wrapper.style.maxHeight = 'none';
                    overlay.style.display = 'none';
                }, 700);
            }
            </script>
            
            <!-- Specs Grid -->
            <section class="bg-zinc-900 dark:bg-gray-800 text-white p-12 rounded-[2.5rem] mb-20 relative overflow-hidden transition-colors">
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-600/20 rounded-full blur-[80px] -mr-16 -mt-16 pointer-events-none"></div>
                
                <h2 class="font-bold text-2xl mb-10 border-b border-white/10 pb-4 relative z-10 flex justify-between items-center text-white">
                    <?= __('technical_specs', 'Especificaciones Técnicas') ?>
                    <i class="fas fa-microchip text-blue-500"></i>
                </h2>
                
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-y-10 gap-x-8 relative z-10">
                    <div>
                        <dt class="text-gray-400 text-xs uppercase font-bold mb-2 tracking-widest"><?= __('developer', 'Desarrollador') ?></dt>
                        <dd class="text-xl font-bold truncate text-white"><?= $software['developer'] ?? __('unknown', 'Desconocido') ?></dd>
                    </div>
                    <div>
                        <dt class="text-gray-400 text-xs uppercase font-bold mb-2 tracking-widest"><?= __('current_version', 'Versión Actual') ?></dt>
                        <dd class="text-xl font-bold text-white">v<?= $software['version'] ?></dd>
                    </div>
                    <div>
                        <dt class="text-gray-400 text-xs uppercase font-bold mb-2 tracking-widest"><?= __('license', 'Licencia') ?></dt>
                        <dd class="text-xl font-bold text-blue-400">
                            <?= !empty($software['license_name']) ? htmlspecialchars($software['license_name']) : ucfirst(htmlspecialchars($software['license'] ?? 'Free')) ?>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-400 text-xs uppercase font-bold mb-2 tracking-widest"><?= __('platform', 'Plataforma') ?></dt>
                        <dd class="text-xl font-bold flex items-center gap-2 text-white">
                            <i class="fab fa-windows"></i> Windows
                        </dd>
                    </div>
                    <div class="sm:col-span-2 border-t border-white/10 pt-6 mt-2">
                        <dt class="text-gray-400 text-xs uppercase font-bold mb-2 tracking-widest"><?= __('category', 'Categoría') ?></dt>
                        <dd class="text-lg font-medium text-gray-300">
                            <a href="<?= url('category/' . ($software['category_slug'] ?? '')) ?>" class="hover:text-white transition decoration-blue-500 underline underline-offset-4 decoration-2">
                                <?php $catShow = $software['category_name'] ?? 'General'; ?>
                                <?= htmlspecialchars(__($catShow, $catShow)) ?>
                            </a>
                        </dd>
                    </div>
                </dl>
            </section>

            <!-- 🚩 Report Broken Link -->
            <div class="mb-12 mt-2 flex flex-wrap items-center gap-3">
                <button id="report-link-btn"
                    class="inline-flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 hover:text-red-500 dark:hover:text-red-400 transition-colors font-medium border border-gray-200 dark:border-gray-700 rounded-full px-4 py-2 hover:border-red-300 dark:hover:border-red-700">
                    <i class="fas fa-flag text-xs"></i> Report broken link
                </button>
                <div id="report-form" class="hidden flex flex-wrap gap-2 items-center">
                    <select id="report-reason" class="text-sm border border-gray-200 dark:border-gray-700 rounded-lg px-3 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                        <option value="Enlace roto">Download link broken</option>
                        <option value="Archivo incorrecto">Wrong file</option>
                        <option value="Virus detectado">Virus detected</option>
                        <option value="Otro">Other</option>
                    </select>
                    <button id="report-submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-bold rounded-lg transition-colors">
                        Send Report
                    </button>
                    <span id="report-thanks" class="hidden text-emerald-500 text-xs font-medium"><i class="fas fa-check mr-1"></i>Thanks for reporting!</span>
                </div>
            </div>

            <!-- Versions Section -->
            <?php if(!empty($versions)): ?>
            <section class="mb-20">
                <h2 class="font-black text-3xl mb-8 flex items-center gap-3 text-gray-900 dark:text-white transition-colors">
                    <?= __('history', 'Historial') ?>
                    <span class="text-sm font-normal text-gray-400 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full transition-colors"><?= count($versions) ?> <?= __('versions', 'versiones') ?></span>
                </h2>
                
                <div class="space-y-4">
                    <?php foreach(array_slice($versions, 0, 3) as $ver): ?>
                        <a href="<?= url('download/' . $software['id'] . '?v=' . urlencode(ltrim($ver['version_number'], 'vV'))) ?>" class="flex items-center justify-between p-6 rounded-2xl border border-gray-100 dark:border-gray-800 hover:border-black dark:hover:border-white transition group cursor-pointer bg-white dark:bg-gray-800 shadow-sm hover:shadow-md">
                            <div class="flex items-center gap-6 text-left">
                                <div class="font-bold text-2xl text-gray-900 dark:text-white min-w-[140px] whitespace-nowrap transition-colors">v<?= ltrim($ver['version_number'], 'vV') ?></div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wide border-l border-gray-200 dark:border-gray-700 pl-6 transition-colors">
                                    <?= __('released_on', 'Publicado el') ?> <br>
                                    <span class="text-gray-900 dark:text-gray-200 transition-colors"><?= date('M d, Y', strtotime($ver['release_date'])) ?></span>
                                </div>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-black dark:bg-white text-white dark:text-black flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all transform translate-x-4 group-hover:translate-x-0 shadow-lg shrink-0">
                                <i class="fas fa-download text-sm"></i>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>
            
            <!-- Related Analysis -->
            <?php if (!empty($related) || !empty($alternatives)): ?>
            <section>
                <h2 class="font-black text-3xl mb-10 text-gray-900 dark:text-white transition-colors"><?= __('similar_alternatives', 'Alternativas Similares') ?></h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <?php 
                     $displayItems = !empty($alternatives) ? $alternatives : $related;
                     foreach(array_slice($displayItems, 0, 4) as $rel): 
                     ?>
                        <a href="<?= url('software/' . $rel['slug']) ?>" class="group border-2 border-gray-100 dark:border-gray-800 p-8 rounded-[2rem] hover:border-black dark:hover:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition duration-300 flex flex-col h-full bg-white dark:bg-transparent">
                            <div class="flex items-center justify-between mb-6">
                                 <div class="w-14 h-14 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-center group-hover:scale-110 transition duration-300 overflow-hidden">
                                     <?php if($get_icon_url($rel)): ?>
                                        <img src="<?= $get_icon_url($rel) ?>" class="w-full h-full object-cover">
                                     <?php else: ?>
                                        <i class="fas fa-cube text-gray-400 dark:text-gray-500"></i>
                                     <?php endif; ?>
                                 </div>
                                 <i class="fas fa-arrow-right -rotate-45 group-hover:rotate-0 transition duration-300 text-2xl text-gray-300 dark:text-gray-600 group-hover:text-black dark:group-hover:text-white"></i>
                            </div>
                            <div class="font-bold text-xl mb-2 text-gray-900 dark:text-white transition-colors"><?= $rel['name'] ?></div>
                            <div class="text-gray-500 dark:text-gray-400 text-sm mb-4 line-clamp-2 flex-grow transition-colors">
                                <?= $rel['short_description'] ?>
                            </div>
                             <div class="text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest mt-auto transition-colors">
                                <?= !empty($rel['license_name']) ? htmlspecialchars($rel['license_name']) : __('free_download', 'Descarga gratis') ?>
                            </div>
                        </a>
                     <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>
            
            <!-- Footer Simple Right -->
            <footer class="mt-24 pt-12 border-t border-gray-100 dark:border-gray-800 text-center lg:text-left text-gray-400 dark:text-gray-500 text-sm transition-colors">
                <p>&copy; <?= date('Y') ?> SoftHub. <?= __('all_rights_reserved', 'Todos los derechos reservados.') ?></p>
            </footer>
        </div>
    </div>
</div>

<script>
// ---- Track View ----
fetch('<?= url('api/track-view') ?>', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'software_id=<?= $software['id'] ?>'
});

// ---- Report Broken Link ----
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('report-link-btn');
    const form = document.getElementById('report-form');
    const submit = document.getElementById('report-submit');
    const thanks = document.getElementById('report-thanks');

    if (btn && form) {
        btn.addEventListener('click', function() {
            form.classList.toggle('hidden');
        });
    }

    if (submit) {
        submit.addEventListener('click', function() {
            const reason = document.getElementById('report-reason').value;
            fetch('<?= url('api/report-link') ?>', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'software_id=<?= $software['id'] ?>&reason=' + encodeURIComponent(reason)
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    submit.classList.add('hidden');
                    thanks.classList.remove('hidden');
                }
            });
        });
    }
});
</script>

<?php
$content = ob_get_clean();

$layoutPath = __DIR__ . '/../../layouts/main.php';

// Try to find the correct path dynamically
if (defined('BASE_PATH')) {
    $layoutPath = BASE_PATH . '/app/Views/layouts/main.php';
} elseif (isset($_SERVER['DOCUMENT_ROOT'])) {
    $testPath = $_SERVER['DOCUMENT_ROOT'] . '/programas/app/Views/layouts/main.php';
    if (file_exists($testPath)) {
        $layoutPath = $testPath;
    }
}

if (file_exists($layoutPath)) {
    include $layoutPath;
} else {
    // Last resort fallback
    echo $content;
    /* echo "<hr>Error: Layout main.php not found at $layoutPath"; */
}
?>