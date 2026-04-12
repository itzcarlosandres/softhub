<?php
// Obtener el software
$softwareId = $params['id'] ?? $_GET['id'] ?? 0;
$stmt = $db->prepare("SELECT s.*, c.name as category_name, c.slug as category_slug FROM software s LEFT JOIN categories c ON s.category_id = c.id WHERE s.id = ?");
$stmt->execute([$softwareId]);
$software = $stmt->fetch();

if (!$software) {
    header('Location: ' . url('software'));
    exit;
}

// Obtener enlaces de descarga por plataforma
$stmt = $db->prepare("SELECT * FROM download_links WHERE software_id = ? ORDER BY CASE platform WHEN 'Windows' THEN 1 WHEN 'Mac' THEN 2 WHEN 'Linux' THEN 3 WHEN 'Android' THEN 4 WHEN 'iOS' THEN 5 ELSE 6 END");
$stmt->execute([$softwareId]);
$downloadLinks = $stmt->fetchAll();

// Generar título SEO dinámico
$title = seo_download_title($software['name'], $software['version']);
$description = seo_software_description($software);
$keywords = seo_software_keywords($software, $software['category_name'] ?? null);

ob_start();
?>

<!-- Download Page (Rediseño Minimalista) -->
<section class="min-h-[calc(100vh-80px)] bg-white dark:bg-gray-900 flex items-center justify-center py-12 px-6 transition-colors duration-300">
    <div class="w-full max-w-2xl">
        <!-- Main Container -->
        <div class="text-center">
            <!-- Icon with clean border -->
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-50 dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-800 p-5 mb-8 transition-colors">
                <?php if (!empty($software['icon'])): ?>
                    <img src="<?= url(htmlspecialchars($software['icon'])) ?>" alt="<?= htmlspecialchars($software['name']) ?>" class="w-full h-full object-contain">
                <?php else: ?>
                    <i class="fas fa-cube text-4xl text-blue-600 dark:text-blue-400"></i>
                <?php endif; ?>
            </div>

            <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white mb-4 tracking-tighter transition-colors">
                <?= htmlspecialchars($software['name']) ?>
            </h1>

            <div class="flex items-center justify-center gap-3 text-sm font-medium text-gray-500 dark:text-gray-400 mb-12">
                <span>Versión <?= htmlspecialchars($software['version']) ?></span>
                <span class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-700"></span>
                <span><?= htmlspecialchars($software['developer']) ?></span>
            </div>

            <!-- Download Action Area -->
            <div class="bg-gray-50/50 dark:bg-gray-800/30 rounded-[2.5rem] p-8 md:p-12 border border-gray-100 dark:border-gray-800 transition-colors">
                <?php if (!empty($downloadLinks)): ?>
                    <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-8">
                        Selecciona tu sistema operativo
                    </p>
                    
                    <div class="space-y-3">
                        <?php foreach ($downloadLinks as $link): ?>
                            <?php
                             $isTorrent = ($link['platform'] === 'Torrent');
                             $isMagnet      = $isTorrent && str_starts_with($link['download_url'], 'magnet:');
                             $isTorrentFile = $isTorrent && !$isMagnet;

                             $iconClass = match(true) {
                                $isMagnet      => 'fas fa-magnet',
                                $isTorrentFile => 'fas fa-file-arrow-down',
                                $link['platform'] === 'Windows' => 'fab fa-windows',
                                $link['platform'] === 'Mac'     => 'fab fa-apple',
                                $link['platform'] === 'Linux'   => 'fab fa-linux',
                                $link['platform'] === 'Android' => 'fab fa-android',
                                $link['platform'] === 'iOS'     => 'fab fa-apple',
                                default => 'fas fa-download'
                             };

                             $label    = $isMagnet ? 'Magnet Link' : ($isTorrentFile ? 'Archivo .torrent' : htmlspecialchars($link['platform']));
                             $subLabel = $isMagnet ? 'Abrir con cliente torrent' : ($isTorrentFile ? 'Descargar archivo .torrent' : (!empty($link['file_size']) ? htmlspecialchars($link['file_size']) : 'Descarga directa'));

                             $bgColor = $isTorrent ? 'bg-green-50/50 dark:bg-green-900/10' : 'bg-white dark:bg-gray-800';
                             $borderColor = $isTorrent ? 'border-green-200 dark:border-green-500/30' : 'border-gray-100 dark:border-gray-700';
                             $hoverBorder = $isTorrent ? 'hover:border-green-500' : 'hover:border-blue-500';
                             $hoverShadow = $isTorrent ? 'hover:shadow-green-500/20' : 'hover:shadow-blue-500/5';
                             
                             $iconBg = $isTorrent ? 'bg-green-100 dark:bg-green-900/30' : 'bg-gray-50 dark:bg-gray-900';
                             $iconColorDefault = $isTorrent ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-300';
                             $iconColorHover = $isTorrent ? 'group-hover:text-green-500' : 'group-hover:text-blue-600';
                             ?>
                            <a href="<?= url('go/' . encrypt_id($link['id'])) ?>" 
                               target="_blank" rel="noopener"
                               class="flex items-center justify-between p-5 <?= $bgColor ?> rounded-2xl border <?= $borderColor ?> <?= $hoverBorder ?> <?= $hoverShadow ?> hover:shadow-lg transition-all group">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl <?= $iconBg ?> flex items-center justify-center <?= $iconColorDefault ?> <?= $iconColorHover ?> transition-colors">
                                        <i class="<?= $iconClass ?> text-xl"></i>
                                    </div>
                                    <div class="text-left">
                                        <h3 class="font-bold text-gray-900 dark:text-white"><?= $label ?></h3>
                                        <p class="text-xs text-gray-500"><?= $subLabel ?></p>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-300 <?= $isTorrent ? 'group-hover:text-green-500' : 'group-hover:text-blue-500' ?> group-hover:translate-x-1 transition-all"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- Minimal Countdown -->
                    <?php if (!empty($software['download_url'])): ?>
                        <div id="countdown-section" class="flex flex-col items-center">
                            <div class="text-center mb-8">
                                <div id="countdown" class="text-6xl font-black text-blue-600 dark:text-blue-400 mb-2"><?= (int)($countdown ?? 5) ?></div>
                                <p class="text-sm font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Iniciando descarga</p>
                            </div>
                            
                            <a href="<?= url('go/' . encrypt_id($software['id'])) ?>?type=soft" id="download-link"
                               target="_blank" rel="noopener"
                               class="inline-flex items-center justify-center gap-3 bg-black dark:bg-blue-600 text-white px-10 py-4 rounded-2xl font-bold text-lg hover:bg-gray-800 dark:hover:bg-blue-700 transition shadow-xl shadow-gray-200 dark:shadow-none">
                                <i class="fas fa-download"></i> Descargar Ahora
                            </a>
                        </div>
                        
                        <script>
                        let countdown = <?= (int)($countdown ?? 5) ?>;
                        const countdownElement = document.getElementById('countdown');
                        const downloadLink = document.getElementById('download-link');

                        function updateCountdown() {
                            countdownElement.textContent = countdown;
                            if (countdown === 0) {
                                countdownElement.textContent = "✓";
                                // Crear enlace invisible y hacer clic (evita bloqueo de popups)
                                const a = document.createElement('a');
                                a.href = downloadLink.href;
                                a.target = '_blank';
                                a.rel = 'noopener';
                                document.body.appendChild(a);
                                a.click();
                                document.body.removeChild(a);
                            } else {
                                countdown--;
                                setTimeout(updateCountdown, 1000);
                            }
                        }
                        setTimeout(updateCountdown, 1000);
                        </script>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- Security Check Footer -->
            <div class="mt-12 flex flex-wrap justify-center gap-8 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] transition-colors">
                <div class="flex items-center gap-2">
                    <i class="fas fa-shield-alt text-blue-500"></i> Verificado
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-virus-slash text-green-500"></i> Sin Virus
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-cloud-download-alt text-purple-500"></i> Servidor Rápido
                </div>
            </div>

            <!-- Back navigation -->
            <div class="mt-12">
                <a href="<?= url('software/' . $software['slug']) ?>" class="text-sm font-bold text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors inline-flex items-center gap-2">
                    <i class="fas fa-arrow-left text-[10px]"></i>
                    Volver a <?= htmlspecialchars($software['name']) ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/main.php';
?>
