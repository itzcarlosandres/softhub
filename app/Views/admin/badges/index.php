<?php
ob_start();
?>

<div class="max-w-7xl animate-fade-in-up">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white font-outfit">Gestión de Badges Presets</h1>
            <p class="text-gray-400 mt-1">Crea etiquetas predefinidas (estilo categorías) para seleccionar al agregar software.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- New Badge Form -->
        <div class="lg:col-span-1">
            <div class="glass-panel p-6 rounded-2xl sticky top-24">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-plus-circle text-cyan-400"></i> Nuevo Badge
                </h3>
                
                <form action="<?= url('admin/badges/store') ?>" method="POST" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Nombre del Badge</label>
                        <input type="text" name="name" required placeholder="Ej: Premium, V2.0, Hot..."
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-cyan-500/50 transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Color (Clase CSS)</label>
                        <select name="color" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-cyan-500/50 transition-all appearance-none cursor-pointer [&>option]:bg-gray-900 [&>option]:text-white">
                            <option value="cyan">Cyan (Celeste)</option>
                            <option value="blue">Blue (Azul)</option>
                            <option value="purple">Purple (Morado)</option>
                            <option value="pink">Pink (Rosa)</option>
                            <option value="orange">Orange (Naranja)</option>
                            <option value="emerald">Emerald (Verde)</option>
                            <option value="rose">Rose (Rojo)</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-cyan-600 hover:bg-cyan-500 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-cyan-600/20 active:scale-95">
                        Crear Preset
                    </button>
                </form>
            </div>
        </div>

        <!-- Badges List -->
        <div class="lg:col-span-2">
            <div class="glass-panel overflow-hidden rounded-2xl">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="bg-white/5 text-gray-400 text-xs uppercase tracking-widest font-bold">
                            <th class="px-6 py-4">Badge</th>
                            <th class="px-6 py-4">Preview</th>
                            <th class="px-6 py-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <?php if (empty($badges)): ?>
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                                    No hay badges creados aún.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($badges as $badge): 
                                $colorClasses = [
                                    'cyan' => 'bg-cyan-500/10 text-cyan-400 border-cyan-500/20',
                                    'blue' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                    'purple' => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
                                    'pink' => 'bg-pink-500/10 text-pink-400 border-pink-500/20',
                                    'orange' => 'bg-orange-500/10 text-orange-400 border-orange-500/20',
                                    'emerald' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                    'rose' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                ];
                                $cls = $colorClasses[$badge['color']] ?? $colorClasses['cyan'];
                            ?>
                                <tr class="hover:bg-white/[0.02] transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-white font-bold"><?= htmlspecialchars($badge['name']) ?></div>
                                        <div class="text-[10px] text-gray-500 font-mono"><?= $badge['slug'] ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 border rounded-lg text-xs font-black uppercase tracking-widest <?= $cls ?>">
                                            <?= htmlspecialchars($badge['name']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="<?= url('admin/badges/delete/' . $badge['id']) ?>" 
                                           onclick="return confirm('¿Estás seguro? Los programas vinculados perderán este badge.')"
                                           class="w-8 h-8 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition-all inline-flex items-center justify-center">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
?>
