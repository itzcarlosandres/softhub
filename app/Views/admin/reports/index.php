<?php ob_start(); ?>

<div class="p-6 lg:p-10 min-h-screen">
    <!-- Header -->
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center">
                <i class="fas fa-flag text-red-400"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-white">Reportes de Enlaces</h1>
                <p class="text-gray-400 text-sm">Gestión de enlaces rotos reportados por usuarios</p>
            </div>
        </div>
        <div class="flex items-center gap-3 mt-4">
            <span class="px-3 py-1 bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-bold rounded-full">
                <?= $pendingCount ?> pendientes
            </span>
            <span class="px-3 py-1 bg-white/5 border border-white/10 text-gray-400 text-xs font-bold rounded-full">
                <?= count($reports) ?> total
            </span>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm font-medium">
            <i class="fas fa-check-circle mr-2"></i><?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <!-- Table -->
    <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
        <?php if (empty($reports)): ?>
            <div class="text-center py-20">
                <i class="fas fa-check-double text-4xl text-emerald-400 mb-4 block"></i>
                <p class="text-gray-400 text-lg font-medium">No hay reportes pendientes</p>
                <p class="text-gray-500 text-sm mt-1">¡Todo parece estar en orden!</p>
            </div>
        <?php else: ?>
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/10 bg-white/5">
                    <th class="text-left px-6 py-4 text-gray-400 font-semibold uppercase tracking-wider text-xs">Software</th>
                    <th class="text-left px-6 py-4 text-gray-400 font-semibold uppercase tracking-wider text-xs">Razón</th>
                    <th class="text-left px-6 py-4 text-gray-400 font-semibold uppercase tracking-wider text-xs">Estado</th>
                    <th class="text-left px-6 py-4 text-gray-400 font-semibold uppercase tracking-wider text-xs">Fecha</th>
                    <th class="text-right px-6 py-4 text-gray-400 font-semibold uppercase tracking-wider text-xs">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                <?php foreach ($reports as $report): ?>
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-semibold text-white"><?= htmlspecialchars($report['software_name'] ?? 'Desconocido') ?></div>
                        <a href="<?= url('software/' . $report['software_slug']) ?>" target="_blank"
                           class="text-xs text-blue-400 hover:underline">/software/<?= $report['software_slug'] ?></a>
                    </td>
                    <td class="px-6 py-4 text-gray-300"><?= htmlspecialchars($report['reason']) ?></td>
                    <td class="px-6 py-4">
                        <?php if ($report['status'] === 'pending'): ?>
                            <span class="px-2 py-1 bg-yellow-500/10 border border-yellow-500/20 text-yellow-400 text-xs font-bold rounded-full">Pendiente</span>
                        <?php else: ?>
                            <span class="px-2 py-1 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-bold rounded-full">Resuelto</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-xs"><?= date('d/m/Y H:i', strtotime($report['created_at'])) ?></td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <?php if ($report['status'] === 'pending'): ?>
                            <a href="<?= url('admin/reports/resolve/' . $report['id']) ?>"
                               class="px-3 py-1.5 bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/20 text-emerald-400 text-xs font-semibold rounded-lg transition-all">
                                <i class="fas fa-check mr-1"></i>Resolver
                            </a>
                            <?php endif; ?>
                            <a href="<?= url('admin/reports/delete/' . $report['id']) ?>"
                               onclick="return confirm('¿Eliminar este reporte?')"
                               class="px-3 py-1.5 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 text-red-400 text-xs font-semibold rounded-lg transition-all">
                                <i class="fas fa-trash mr-1"></i>Eliminar
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
$pageTitle = 'Reportes de Enlaces';
$currentPage = 'reports';
require __DIR__ . '/../../layouts/admin.php';
?>
