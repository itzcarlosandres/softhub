<?php
// Dashboard - Deep Glassmorphism Style
// Datos pasados desde el controlador: $stats, $topSoftware, $recentActivity
$currentPage = 'dashboard';
ob_start();

// Helper seguro para fechas
if (!function_exists('timeAgo')) {
    function timeAgo($datetime) {
        $time = strtotime($datetime);
        $diff = time() - $time;
        if ($diff < 60) return 'Hace un momento';
        if ($diff < 3600) return 'Hace ' . floor($diff / 60) . 'm';
        if ($diff < 86400) return 'Hace ' . floor($diff / 3600) . 'h';
        return date('d/m', $time);
    }
}
?>

<div class="space-y-8 animate-fade-in-up">
    
    <!-- Welcome Section -->
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-white font-outfit">Resumen General</h1>
            <p class="text-gray-400 mt-1">Métricas y rendimiento de SoftHub en tiempo real.</p>
        </div>
        <div class="hidden md:block">
            <span class="px-3 py-1 rounded-full bg-blue-500/10 text-blue-400 text-xs border border-blue-500/20">
                <i class="fas fa-circle text-[8px] mr-1 animate-pulse"></i> Sistema Operativo
            </span>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="glass-card p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/10 rounded-full blur-[40px] -mr-4 -mt-4 transition-all group-hover:bg-blue-500/20"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-400 group-hover:text-white group-hover:scale-110 transition-all border border-blue-500/10">
                        <i class="fas fa-box text-xl"></i>
                    </div>
                    <span class="text-green-400 text-xs bg-green-500/10 px-2 py-1 rounded-lg border border-green-500/20">+4%</span>
                </div>
                <div class="text-3xl font-bold text-white font-outfit mb-1"><?= number_format($stats['total_software'] ?? 0) ?></div>
                <p class="text-gray-500 text-xs uppercase tracking-wider font-semibold">Total Software</p>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="glass-card p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/10 rounded-full blur-[40px] -mr-4 -mt-4 transition-all group-hover:bg-purple-500/20"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center text-purple-400 group-hover:text-white group-hover:scale-110 transition-all border border-purple-500/10">
                        <i class="fas fa-download text-xl"></i>
                    </div>
                    <span class="text-green-400 text-xs bg-green-500/10 px-2 py-1 rounded-lg border border-green-500/20">+12%</span>
                </div>
                <div class="text-3xl font-bold text-white font-outfit mb-1"><?= number_format($stats['total_downloads'] ?? 0) ?></div>
                <p class="text-gray-500 text-xs uppercase tracking-wider font-semibold">Descargas Totales</p>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="glass-card p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-pink-500/10 rounded-full blur-[40px] -mr-4 -mt-4 transition-all group-hover:bg-pink-500/20"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-pink-500/20 flex items-center justify-center text-pink-400 group-hover:text-white group-hover:scale-110 transition-all border border-pink-500/10">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                </div>
                <div class="text-3xl font-bold text-white font-outfit mb-1"><?= number_format($stats['total_users'] ?? 0) ?></div>
                <p class="text-gray-500 text-xs uppercase tracking-wider font-semibold">Usuarios Registrados</p>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="glass-card p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-orange-500/10 rounded-full blur-[40px] -mr-4 -mt-4 transition-all group-hover:bg-orange-500/20"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-orange-500/20 flex items-center justify-center text-orange-400 group-hover:text-white group-hover:scale-110 transition-all border border-orange-500/10">
                        <i class="fas fa-tags text-xl"></i>
                    </div>
                </div>
                <div class="text-3xl font-bold text-white font-outfit mb-1"><?= number_format($stats['total_categories'] ?? 0) ?></div>
                <p class="text-gray-500 text-xs uppercase tracking-wider font-semibold">Categorías Activas</p>
            </div>
        </div>
    </div>

    <!-- Main Content Split -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: Top Downloads -->
        <div class="lg:col-span-2 glass-panel rounded-2xl overflow-hidden flex flex-col">
            <div class="p-6 border-b border-white/5 flex justify-between items-center">
                <h3 class="font-bold text-white font-outfit flex items-center gap-2">
                    <i class="fas fa-trophy text-yellow-400"></i> Top Descargas
                </h3>
                <button class="text-xs text-blue-400 hover:text-white transition-colors">Ver Todo</button>
            </div>
            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-black/20 text-gray-400 text-xs uppercase font-semibold">
                        <tr>
                            <th class="px-6 py-4">Software</th>
                            <th class="px-6 py-4">Descargas</th>
                            <th class="px-6 py-4 text-right">Tendencia</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm">
                        <?php if(!empty($topSoftware)): ?>
                            <?php foreach ($topSoftware as $index => $soft): ?>
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="w-6 text-center font-bold <?= $index < 3 ? 'text-yellow-500' : 'text-gray-600' ?>">#<?= $index + 1 ?></span>
                                        <div class="w-8 h-8 rounded-lg bg-gray-800 flex items-center justify-center overflow-hidden border border-white/10 group-hover:border-blue-500/50 transition-colors">
                                            <?php if(!empty($soft['icon'])): ?>
                                                <img src="<?= url($soft['icon']) ?>" class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <i class="fas fa-box text-gray-500 text-xs"></i>
                                            <?php endif; ?>
                                        </div>
                                        <span class="text-gray-300 font-medium group-hover:text-white transition-colors"><?= htmlspecialchars($soft['name']) ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-400"><?= number_format($soft['downloads']) ?></td>
                                <td class="px-6 py-4 text-right">
                                    <div class="w-full h-1 bg-gray-800 rounded-full overflow-hidden ml-auto max-w-[80px]">
                                        <div class="h-full bg-blue-500 rounded-full" style="width: <?= rand(40, 95) ?>%"></div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="3" class="p-6 text-center text-gray-500">No hay datos disponibles</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Column: Recent Activity & Quick Actions -->
        <div class="space-y-6">
            
            <!-- Quick Actions -->
            <div class="glass-panel p-6 rounded-2xl">
                <h3 class="font-bold text-white font-outfit mb-4">Acciones Rápidas</h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="<?= url('admin/software/create') ?>" class="bg-blue-600 hover:bg-blue-500 text-white p-3 rounded-xl flex flex-col items-center justify-center gap-2 transition-all hover:-translate-y-1 shadow-lg shadow-blue-600/20 col-span-2">
                        <i class="fas fa-plus-circle text-xl"></i>
                        <span class="text-xs font-bold">Nuevo Software</span>
                    </a>
                    <a href="<?= url('admin/categories') ?>" class="bg-white/5 hover:bg-white/10 border border-white/5 text-gray-300 hover:text-white p-3 rounded-xl flex flex-col items-center justify-center gap-2 transition-all">
                        <i class="fas fa-tags"></i>
                        <span class="text-xs font-medium">Categorías</span>
                    </a>
                    <a href="<?= url('admin/settings') ?>" class="bg-white/5 hover:bg-white/10 border border-white/5 text-gray-300 hover:text-white p-3 rounded-xl flex flex-col items-center justify-center gap-2 transition-all">
                        <i class="fas fa-cog"></i>
                        <span class="text-xs font-medium">Ajustes</span>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="glass-panel rounded-2xl overflow-hidden p-6">
                <h3 class="font-bold text-white font-outfit mb-4">Añadidos Recientemente</h3>
                <div class="space-y-4">
                    <?php if(!empty($recentActivity)): ?>
                        <?php foreach ($recentActivity as $activity): ?>
                        <div class="flex items-center gap-3 group cursor-default">
                            <div class="w-10 h-10 rounded-lg bg-gray-800/50 flex items-center justify-center border border-white/5 group-hover:border-purple-500/30 transition-colors">
                                <i class="fas fa-history text-purple-400 text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-300 truncate group-hover:text-white transition-colors"><?= htmlspecialchars($activity['name']) ?></p>
                                <p class="text-xs text-gray-500"><?= timeAgo($activity['created_at']) ?></p>
                            </div>
                            <div class="text-xs text-gray-500 bg-white/5 px-2 py-1 rounded">
                                <i class="fas fa-download mr-1"></i><?= $activity['downloads'] ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center text-gray-500 text-sm">Sin actividad reciente</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php'; 
?>
