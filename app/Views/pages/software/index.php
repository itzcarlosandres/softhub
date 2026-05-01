<?php 
ob_start(); 
?>

<style>
    .soft-card {
        background: rgba(255, 255, 255, 0.02);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .soft-card:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(59, 130, 246, 0.3);
        transform: translateY(-4px);
    }

    .icon-box {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        background: #1a1d24;
        padding: 10px;
        flex-shrink: 0;
    }

    .badge-mini {
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 2px 8px;
        border-radius: 6px;
    }
</style>

<div class="bg-[#05060f] min-h-screen text-gray-300">
    <!-- Header Minimalista -->
    <div class="pt-16 pb-12 border-b border-white/5">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h1 class="text-4xl font-black text-white tracking-tight mb-2">Explorar Software</h1>
                    <p class="text-gray-500 text-sm font-medium">Descubre las mejores herramientas y aplicaciones verificadas.</p>
                </div>
                
                <!-- Filtros Compactos -->
                <form method="GET" class="flex items-center gap-3 bg-white/5 p-2 rounded-2xl border border-white/5">
                    <select name="category" class="bg-transparent border-none text-xs font-bold text-gray-400 focus:ring-0 cursor-pointer px-4">
                        <option value="">Todas las Categorías</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= ($_GET['category'] ?? '') == $cat['id'] ? 'selected' : '' ?>><?= $cat['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="h-4 w-px bg-white/10"></div>
                    <select name="sort" class="bg-transparent border-none text-xs font-bold text-gray-400 focus:ring-0 cursor-pointer px-4">
                        <option value="latest" <?= ($_GET['sort'] ?? '') == 'latest' ? 'selected' : '' ?>>Recientes</option>
                        <option value="downloads" <?= ($_GET['sort'] ?? '') == 'downloads' ? 'selected' : '' ?>>Populares</option>
                        <option value="rating" <?= ($_GET['sort'] ?? '') == 'rating' ? 'selected' : '' ?>>Mejor Valorados</option>
                    </select>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white w-10 h-10 rounded-xl flex items-center justify-center transition-all">
                        <i class="fas fa-search text-xs"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- Main Content -->
            <div class="lg:col-span-9">
                <?php if (!empty($software)): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                        <?php foreach ($software as $soft): 
                            $isTrending = in_array($soft['id'], $trendingIds ?? []);
                            $isNew = strtotime($soft['created_at']) > strtotime('-7 days');
                        ?>
                        <a href="<?= url('software/' . $soft['slug']) ?>" class="soft-card p-4 rounded-2xl flex items-center gap-4 group no-underline">
                            <div class="icon-box group-hover:scale-105 transition-transform duration-500 overflow-hidden">
                                <img src="<?= !empty($soft['icon']) ? url($soft['icon']) : 'https://placehold.co/100x100/1a1d24/white?text=S' ?>" 
                                     alt="<?= $soft['name'] ?>" class="w-full h-full object-contain">
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="text-sm font-bold text-white truncate group-hover:text-blue-400 transition"><?= $soft['name'] ?></h3>
                                    <?php if($isTrending): ?>
                                        <i class="fas fa-fire text-[10px] text-orange-500"></i>
                                    <?php endif; ?>
                                </div>
                                <p class="text-[11px] text-gray-500 line-clamp-1 mb-2"><?= $soft['short_description'] ?></p>
                                <div class="flex items-center gap-3">
                                    <span class="badge-mini bg-blue-500/10 text-blue-500">v<?= $soft['version'] ?></span>
                                    <div class="flex items-center gap-1 text-[10px] font-bold text-gray-600">
                                        <i class="fas fa-download text-[8px]"></i>
                                        <?= number_format($soft['downloads']) ?>
                                    </div>
                                    <div class="flex items-center gap-1 text-[10px] font-bold text-yellow-500/50">
                                        <i class="fas fa-star text-[8px]"></i>
                                        <?= number_format($soft['rating'], 1) ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                    <div class="mt-16 flex justify-center gap-2">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?= $i ?><?= !empty($_GET['sort']) ? '&sort=' . $_GET['sort'] : '' ?><?= !empty($_GET['category']) ? '&category=' . $_GET['category'] : '' ?>" 
                               class="w-10 h-10 flex items-center justify-center rounded-xl font-bold text-xs transition-all <?= ($currentPage ?? 1) == $i ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'bg-white/5 text-gray-500 hover:bg-white/10 hover:text-white' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                    <?php endif; ?>

                <?php else: ?>
                    <div class="text-center py-24">
                        <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-search text-gray-700 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">No se encontraron programas</h3>
                        <p class="text-gray-500">Prueba ajustando tus criterios de búsqueda.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-3 space-y-12">
                <div>
                    <h4 class="text-xs font-black text-gray-500 uppercase tracking-widest mb-6 px-2">Top Descargas</h4>
                    <div class="space-y-2">
                        <?php 
                        $db = \App\Database::getInstance()->getConnection();
                        $trendingList = $db->query("SELECT * FROM software WHERE status = 'approved' AND trending = 1 ORDER BY downloads DESC LIMIT 5")->fetchAll();
                        foreach($trendingList as $index => $soft): 
                            $numColor = ['#22c55e', '#3b82f6', '#ec4899', '#f59e0b', '#8b5cf6'][$index % 5];
                        ?>
                        <a href="<?= url('software/' . $soft['slug']) ?>" class="relative flex items-center gap-4 group p-2 rounded-2xl hover:bg-white/5 transition-all">
                            
                            <div class="relative flex-shrink-0 z-10">
                                <!-- Insignia de posición pequeña -->
                                <span class="absolute -top-1 -left-1 w-5 h-5 flex items-center justify-center rounded-lg text-[10px] font-black text-white shadow-lg z-20"
                                      style="background: linear-gradient(135deg, <?= $numColor ?>, <?= $numColor ?>dd);">
                                    <?= $index + 1 ?>
                                </span>

                                <div class="w-11 h-11 rounded-xl bg-[#1a1d24] p-2 shadow-xl border border-white/5 group-hover:border-white/10 transition-colors">
                                    <img src="<?= url($soft['icon']) ?>" class="w-full h-full object-contain">
                                </div>
                            </div>

                            <div class="flex-1 min-w-0 z-10">
                                <h5 class="text-xs font-bold text-white truncate group-hover:text-blue-400 transition"><?= $soft['name'] ?></h5>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[9px] font-bold text-gray-600 uppercase tracking-widest"><?= number_format($soft['downloads']) ?> descargas</span>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="p-8 rounded-3xl bg-gradient-to-br from-blue-600/20 to-purple-600/20 border border-white/5">
                    <h4 class="text-sm font-bold text-white mb-4">¿Buscas algo más?</h4>
                    <p class="text-xs text-gray-400 leading-relaxed mb-6">Únete a nuestra comunidad para solicitar software específico y recibir soporte directo.</p>
                    <a href="#" class="inline-block w-full text-center py-3 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold rounded-xl transition-all">Unirse a Telegram</a>
                </div>
            </aside>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../../layouts/main.php';
?>
