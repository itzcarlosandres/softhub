<?php ob_start(); ?>

<div class="p-6 lg:p-10 min-h-screen">
    <!-- Header -->
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center">
                <i class="fas fa-chart-line text-blue-400"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-white">Analíticas</h1>
                <p class="text-gray-400 text-sm">Estadísticas de visitas y descargas en tiempo real</p>
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center">
                    <i class="fas fa-eye text-blue-400 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider">Vistas Totales</p>
                    <p class="text-3xl font-black text-white"><?= number_format($totals['total_views'] ?? 0) ?></p>
                </div>
            </div>
        </div>
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                    <i class="fas fa-download text-emerald-400 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider">Descargas Totales</p>
                    <p class="text-3xl font-black text-white"><?= number_format($totals['total_downloads'] ?? 0) ?></p>
                </div>
            </div>
        </div>
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-red-500/10 flex items-center justify-center">
                    <i class="fas fa-flag text-red-400 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider">Reportes Pendientes</p>
                    <p class="text-3xl font-black text-white"><?= $pendingReports ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Top by Views -->
        <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-white/10 flex items-center gap-3">
                <i class="fas fa-eye text-blue-400"></i>
                <h2 class="font-bold text-white">Top 10 más vistos</h2>
            </div>
            <div class="divide-y divide-white/5">
                <?php foreach ($topViews as $i => $soft): ?>
                <div class="flex items-center gap-4 px-6 py-4 hover:bg-white/5 transition-colors">
                    <span class="w-7 h-7 flex items-center justify-center rounded-lg
                        <?= $i === 0 ? 'bg-yellow-400 text-gray-900' : ($i === 1 ? 'bg-gray-300 text-gray-900' : ($i === 2 ? 'bg-orange-400 text-white' : 'bg-white/10 text-gray-400')) ?>
                        font-black text-xs flex-shrink-0"><?= $i + 1 ?></span>
                    <div class="flex-1 min-w-0">
                        <p class="text-white font-semibold text-sm truncate"><?= htmlspecialchars($soft['name']) ?></p>
                        <p class="text-gray-400 text-xs"><?= number_format($soft['downloads']) ?> descargas</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-blue-400 font-bold text-sm"><?= number_format($soft['views']) ?></p>
                        <p class="text-gray-500 text-xs">vistas</p>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php if (empty($topViews)): ?>
                    <p class="text-center text-gray-500 py-10">Sin datos aún</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Top by Downloads -->
        <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-white/10 flex items-center gap-3">
                <i class="fas fa-download text-emerald-400"></i>
                <h2 class="font-bold text-white">Top 10 más descargados</h2>
            </div>
            <div class="divide-y divide-white/5">
                <?php foreach ($topDownloads as $i => $soft): ?>
                <div class="flex items-center gap-4 px-6 py-4 hover:bg-white/5 transition-colors">
                    <span class="w-7 h-7 flex items-center justify-center rounded-lg
                        <?= $i === 0 ? 'bg-yellow-400 text-gray-900' : ($i === 1 ? 'bg-gray-300 text-gray-900' : ($i === 2 ? 'bg-orange-400 text-white' : 'bg-white/10 text-gray-400')) ?>
                        font-black text-xs flex-shrink-0"><?= $i + 1 ?></span>
                    <div class="flex-1 min-w-0">
                        <p class="text-white font-semibold text-sm truncate"><?= htmlspecialchars($soft['name']) ?></p>
                        <p class="text-gray-400 text-xs"><?= number_format($soft['views'] ?? 0) ?> vistas</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-emerald-400 font-bold text-sm"><?= number_format($soft['downloads']) ?></p>
                        <p class="text-gray-500 text-xs">descargas</p>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php if (empty($topDownloads)): ?>
                    <p class="text-center text-gray-500 py-10">Sin datos aún</p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
$pageTitle = 'Analíticas';
$currentPage = 'analytics';
require __DIR__ . '/../../layouts/admin.php';
?>
