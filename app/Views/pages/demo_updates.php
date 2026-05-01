<?php ob_start(); ?>

<div class="container mx-auto px-6 py-12">
    <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-12 text-center">Propuestas de Diseño: Recién Actualizados</h1>

    <!-- PROPUESTA 1: Glassmorphism List -->
    <section class="mb-24">
        <h2 class="text-xl font-bold text-blue-500 mb-8 border-b border-blue-500/20 pb-2">Propuesta 1: Glassmorphism List (Modern & Clean)</h2>
        <div class="max-w-4xl mx-auto space-y-3">
            <?php 
            $demos = [
                ['name' => 'Adobe Photoshop 2024', 'version' => 'v25.3.1', 'icon' => 'https://cdn-icons-png.flaticon.com/512/5968/5968520.png', 'time' => 'Hace 5 min'],
                ['name' => 'WinRAR Professional', 'version' => 'v7.01', 'icon' => 'https://cdn-icons-png.flaticon.com/512/732/732255.png', 'time' => 'Hace 2 horas'],
                ['name' => 'Microsoft Office 2021 LTSC', 'version' => 'v16.0.14332', 'icon' => 'https://cdn-icons-png.flaticon.com/512/732/732221.png', 'time' => 'Hace 5 horas'],
                ['name' => 'VLC Media Player', 'version' => 'v3.0.21', 'icon' => 'https://cdn-icons-png.flaticon.com/512/732/732252.png', 'time' => 'Hace 1 día'],
            ];
            foreach($demos as $d): ?>
            <div class="bg-white/50 dark:bg-gray-800/40 backdrop-blur-md border border-gray-200 dark:border-gray-700 p-4 rounded-2xl flex items-center justify-between hover:border-blue-500 transition-all group">
                <div class="flex items-center gap-4">
                    <img src="<?= $d['icon'] ?>" class="w-12 h-12 rounded-xl object-contain bg-white p-1" alt="">
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white"><?= $d['name'] ?></h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="bg-blue-500/10 text-blue-500 text-[10px] font-black px-2 py-0.5 rounded-full border border-blue-500/20"><?= $d['version'] ?></span>
                            <span class="text-gray-400 text-[10px]"><i class="far fa-clock mr-1"></i><?= $d['time'] ?></span>
                        </div>
                    </div>
                </div>
                <button class="bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold px-4 py-2 rounded-lg transition-all shadow-lg shadow-blue-600/20">
                    Ver Actualización
                </button>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- PROPUESTA 2: Modern Cards (Vibrant) -->
    <section class="mb-24">
        <h2 class="text-xl font-bold text-purple-500 mb-8 border-b border-purple-500/20 pb-2">Propuesta 2: Modern Grid Cards (Visual Focus)</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach($demos as $d): ?>
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-gray-100 dark:border-gray-700 shadow-xl shadow-gray-200/50 dark:shadow-none hover:-translate-y-2 transition-all group relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/5 rounded-full -mr-10 -mt-10 group-hover:bg-purple-500/10 transition-all"></div>
                <img src="<?= $d['icon'] ?>" class="w-16 h-16 rounded-2xl object-contain mb-4 shadow-md bg-white p-2" alt="">
                <h3 class="font-black text-gray-900 dark:text-white mb-2 leading-tight"><?= $d['name'] ?></h3>
                <div class="flex items-center justify-between mt-4">
                    <span class="text-purple-500 font-bold text-sm"><?= $d['version'] ?></span>
                    <span class="text-gray-400 text-[10px] font-medium uppercase tracking-widest"><?= $d['time'] ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- PROPUESTA 3: Minimalist Table (Professional) -->
    <section class="mb-24">
        <h2 class="text-xl font-bold text-green-500 mb-8 border-b border-green-500/20 pb-2">Propuesta 3: Minimalist Table (Efficient)</h2>
        <div class="bg-white dark:bg-gray-800 rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-700 shadow-lg">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Programa</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Versión</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Fecha</th>
                        <th class="px-6 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    <?php foreach($demos as $d): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="<?= $d['icon'] ?>" class="w-8 h-8 object-contain" alt="">
                                <span class="font-bold text-gray-900 dark:text-white"><?= $d['name'] ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-xs font-mono bg-green-500/10 text-green-600 px-2 py-1 rounded"><?= $d['version'] ?></span>
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-500"><?= $d['time'] ?></td>
                        <td class="px-6 py-4 text-right">
                            <i class="fas fa-chevron-right text-gray-300"></i>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- PROPUESTA 4: Bento Grid (Trending style) -->
    <section class="mb-24">
        <h2 class="text-xl font-bold text-pink-500 mb-8 border-b border-pink-500/20 pb-2">Propuesta 4: Bento Style (Dynamic Layout)</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2 md:row-span-2 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[2rem] p-8 text-white relative overflow-hidden group">
                <div class="relative z-10">
                    <span class="bg-white/20 backdrop-blur-md text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full">Última Gran Actualización</span>
                    <h3 class="text-3xl font-black mt-4 mb-4"><?= $demos[0]['name'] ?></h3>
                    <p class="text-blue-100 text-sm mb-6">Nueva versión <?= $demos[0]['version'] ?> disponible con mejoras críticas de rendimiento y seguridad.</p>
                    <button class="bg-white text-blue-700 font-bold px-6 py-3 rounded-2xl hover:scale-105 transition-transform">Descargar Ahora</button>
                </div>
                <img src="<?= $demos[0]['icon'] ?>" class="absolute -right-8 -bottom-8 w-48 h-48 opacity-20 group-hover:scale-110 transition-transform duration-700" alt="">
            </div>
            <?php for($i=1; $i<4; $i++): ?>
            <div class="bg-white dark:bg-gray-800 rounded-[2rem] p-6 border border-gray-100 dark:border-gray-700 flex flex-col justify-center items-center text-center hover:shadow-2xl transition-shadow group">
                <img src="<?= $demos[$i]['icon'] ?>" class="w-12 h-12 mb-4 group-hover:rotate-12 transition-transform" alt="">
                <h4 class="font-bold text-gray-900 dark:text-white text-sm"><?= $demos[$i]['name'] ?></h4>
                <span class="text-pink-500 text-xs font-bold mt-2"><?= $demos[$i]['version'] ?></span>
            </div>
            <?php endfor; ?>
        </div>
    </section>

    <!-- PROPUESTA 5: Neomorphic List (Soft & Subtle) -->
    <section class="mb-24">
        <h2 class="text-xl font-bold text-gray-400 mb-8 border-b border-gray-400/20 pb-2">Propuesta 5: Neomorphic List (Minimalist Contrast)</h2>
        <div class="space-y-6">
            <?php foreach($demos as $d): ?>
            <div class="bg-gray-50 dark:bg-gray-900 p-6 rounded-[2rem] shadow-[10px_10px_20px_rgba(0,0,0,0.05),-10px_-10px_20px_rgba(255,255,255,0.8)] dark:shadow-[10px_10px_20px_rgba(0,0,0,0.4),-10px_-10px_20px_rgba(255,255,255,0.02)] flex items-center gap-6">
                <div class="w-16 h-16 rounded-2xl bg-gray-100 dark:bg-gray-800 shadow-inner flex items-center justify-center">
                    <img src="<?= $d['icon'] ?>" class="w-10 h-10 object-contain" alt="">
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-black text-gray-800 dark:text-gray-200"><?= $d['name'] ?></h3>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Version <?= $d['version'] ?> • <?= $d['time'] ?></p>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center shadow-lg shadow-blue-500/30">
                    <i class="fas fa-download"></i>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
