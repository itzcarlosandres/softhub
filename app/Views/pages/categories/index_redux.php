<?php
// Debug Errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

// index_redux.php - Vista de Rediseño de Categorías con 5 Estilos
$style = $_GET['style'] ?? 'premium'; 

// Icon Mapping Helper
function get_category_icon($slug) {
    $icons = [
        'antivirus' => 'fa-shield-alt',
        'navegadores' => 'fa-globe',
        'multimedia' => 'fa-play-circle',
        'utilidades' => 'fa-cog',
        'productividad' => 'fa-briefcase',
        'juegos' => 'fa-gamepad',
        'desarrollo' => 'fa-code',
        'educacion' => 'fa-graduation-cap',
        'comunicacion' => 'fa-comments',
        'diseno' => 'fa-palette',
        'seguridad' => 'fa-lock',
        'sistema' => 'fa-desktop'
    ];
    $slug = strtolower($slug);
    // Buscar coincidencia parcial si no exacta
    foreach($icons as $key => $val) {
        if(strpos($slug, $key) !== false) return $val;
    }
    return 'fa-folder'; // Default
}

// Color Mapping Helper
function get_category_color($index) {
    $colors = ['blue', 'purple', 'emerald', 'amber', 'rose', 'cyan', 'indigo', 'teal'];
    return $colors[$index % count($colors)];
}

ob_start();
?>

<!-- Selector de Estilos Flotante -->
<div class="fixed bottom-6 right-6 z-[9999] bg-white/90 backdrop-blur-xl p-4 rounded-2xl shadow-2xl border border-gray-200/50 flex flex-col gap-2 transition-all hover:scale-105">
    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Modo Demo</div>
    <select onchange="window.location.href = window.location.pathname + '?style=' + this.value;" 
            class="bg-gray-100 border-none rounded-lg px-3 py-2 text-sm font-semibold text-gray-800 focus:ring-2 focus:ring-blue-500 cursor-pointer outline-none">
        <option value="premium" <?= $style=='premium'?'selected':'' ?>>✨ 1. Premium Grid</option>
        <option value="list" <?= $style=='list'?'selected':'' ?>>📋 2. Modern List</option>
        <option value="glass" <?= $style=='glass'?'selected':'' ?>>💎 3. Glassmorphism</option>
        <option value="minimal" <?= $style=='minimal'?'selected':'' ?>>⚪ 4. Minimal Typo</option>
        <option value="colorful" <?= $style=='colorful'?'selected':'' ?>>🎨 5. Colorful Cards</option>
    </select>
</div>

<?php if ($style === 'premium'): ?>
    <!-- ESTILO 1: Premium Grid (Clean & Elevated) -->
    <div class="bg-gray-50 min-h-screen py-16 font-outfit">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="text-center mb-16">
                <h1 class="text-5xl font-black text-gray-900 mb-4 tracking-tight">Explora Categorías</h1>
                <p class="text-xl text-gray-500 max-w-2xl mx-auto">Encuentra exactamente lo que buscas navegando por nuestra colección organizada.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach ($categories as $index => $cat): ?>
                    <a href="<?= url('category/' . ($cat['slug'] ?? '#')) ?>" class="group bg-white rounded-3xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-gray-200 hover:-translate-y-1">
                        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 text-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <i class="fas <?= get_category_icon($cat['slug']) ?>"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors"><?= $cat['name'] ?></h3>
                        <p class="text-gray-500 text-sm mb-6 line-clamp-2"><?= $cat['description'] ?? 'Descubre los mejores programas de esta categoría.' ?></p>
                        <div class="flex items-center text-xs font-bold text-gray-400 uppercase tracking-widest group-hover:text-blue-500 transition-colors">
                            <span><?= $cat['software_count'] ?? 0 ?> Apps</span>
                            <i class="fas fa-arrow-right ml-auto transform group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>


<?php elseif ($style === 'list'): ?>
    <!-- ESTILO 2: Modern List (Dashboard Style) -->
    <div class="bg-white min-h-screen py-16 font-inter">
        <div class="container mx-auto px-6 max-w-5xl">
            <div class="flex items-end justify-between mb-12 border-b border-gray-100 pb-8">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Categorías</h1>
                    <p class="text-gray-500">Todo el software organizado para ti.</p>
                </div>
                <div class="text-sm font-medium text-gray-400">
                    <?= count($categories) ?> Resultados
                </div>
            </div>
            
            <div class="space-y-4">
                <?php foreach ($categories as $index => $cat): ?>
                    <a href="<?= url('category/' . ($cat['slug'] ?? '#')) ?>" class="flex items-center p-6 rounded-2xl border border-gray-100 hover:border-indigo-500 hover:shadow-md transition-all group bg-white">
                        <div class="w-14 h-14 bg-gray-50 text-gray-600 rounded-xl flex items-center justify-center text-xl mr-6 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                            <i class="fas <?= get_category_icon($cat['slug']) ?>"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-indigo-600 transition-colors"><?= $cat['name'] ?></h3>
                            <p class="text-gray-500 text-sm truncate"><?= $cat['description'] ?? 'Explora esta colección de software.' ?></p>
                        </div>
                        <div class="flex items-center gap-6 ml-6">
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full group-hover:bg-indigo-100 group-hover:text-indigo-700 transition-colors whitespace-nowrap">
                                <?= $cat['software_count'] ?? 0 ?> items
                            </span>
                            <div class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 group-hover:border-indigo-500 group-hover:text-indigo-500 transition-colors">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>


<?php elseif ($style === 'glass'): ?>
    <!-- ESTILO 3: Glassmorphism (Apple Style) -->
    <div class="bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 min-h-screen py-20 font-sans relative overflow-hidden">
        <!-- Background Blobs -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute top-10 left-10 w-96 h-96 bg-blue-300 rounded-full blur-[100px] opacity-30"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-purple-300 rounded-full blur-[100px] opacity-30"></div>
        </div>

        <div class="container mx-auto px-6 max-w-7xl relative z-10">
            <h1 class="text-5xl font-black text-gray-900 text-center mb-16 tracking-tight">Navega por <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600">Categorías</span></h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($categories as $index => $cat): ?>
                    <a href="<?= url('category/' . ($cat['slug'] ?? '#')) ?>" class="bg-white/40 backdrop-blur-xl border border-white/60 p-8 rounded-3xl shadow-lg hover:shadow-2xl hover:bg-white/60 transition-all duration-300 group hover:-translate-y-2">
                        <div class="flex items-start justify-between mb-8">
                            <div class="w-16 h-16 bg-white/80 rounded-2xl flex items-center justify-center text-3xl shadow-sm group-hover:rotate-12 transition-transform duration-300">
                                <?php 
                                $colors = ['text-blue-500', 'text-purple-500', 'text-pink-500', 'text-indigo-500'];
                                $colorClass = $colors[$index % count($colors)];
                                ?>
                                <i class="fas <?= get_category_icon($cat['slug']) ?> <?= $colorClass ?>"></i>
                            </div>
                            <span class="bg-white/50 px-3 py-1 rounded-full text-xs font-bold text-gray-500 border border-white/50">
                                <?= $cat['software_count'] ?? 0 ?>
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3"><?= $cat['name'] ?></h3>
                        <p class="text-gray-600 text-sm leading-relaxed mb-6">
                            <?= $cat['description'] ?? 'Encuentra las mejores herramientas y software en esta categoría especializada.' ?>
                        </p>
                        <div class="flex items-center text-blue-600 font-bold text-sm tracking-wide group-hover:gap-2 transition-all">
                            Explorar <i class="fas fa-arrow-right ml-2"></i>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>


<?php elseif ($style === 'minimal'): ?>
    <!-- ESTILO 4: Minimal Typographic (Editorial) -->
    <div class="bg-white min-h-screen py-20 font-serif">
        <div class="container mx-auto px-6 max-w-6xl">
            <h1 class="text-6xl font-serif italic mb-20 text-center border-b border-black pb-10">Colecciones</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-16">
                <?php foreach ($categories as $index => $cat): ?>
                    <a href="<?= url('category/' . ($cat['slug'] ?? '#')) ?>" class="group block border-t border-gray-200 pt-8 hover:border-black transition-colors duration-500">
                        <div class="flex items-baseline justify-between mb-4">
                            <span class="text-xs font-sans font-bold text-gray-400 uppercase tracking-widest group-hover:text-black transition-colors">0<?= $index + 1 ?></span>
                            <span class="text-xs font-sans font-bold text-gray-400 uppercase tracking-widest text-right">
                                <?= $cat['software_count'] ?? 0 ?> items
                            </span>
                        </div>
                        <div class="flex items-start gap-6">
                            <h3 class="text-4xl font-serif text-gray-900 group-hover:italic transition-all duration-300 flex-1">
                                <?= $cat['name'] ?>
                            </h3>
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-500 transform translate-y-2 group-hover:translate-y-0 text-xl">
                                <i class="fas fa-arrow-right -rotate-45 group-hover:rotate-0 transition-transform duration-500"></i>
                            </div>
                        </div>
                        <p class="mt-4 text-gray-500 font-sans text-sm max-w-xs group-hover:text-gray-800 transition-colors">
                            <?= $cat['description'] ?? 'Software seleccionado.' ?>
                        </p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>


<?php elseif ($style === 'colorful'): ?>
    <!-- ESTILO 5: Colorful Cards (Vibrant) -->
    <div class="bg-zinc-900 min-h-screen py-16 font-outfit">
        <div class="container mx-auto px-6 max-w-7xl">
            <h1 class="text-5xl font-black text-white mb-4">Discover Categories</h1>
            <p class="text-zinc-400 text-xl mb-16">Explore our curated software collections.</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach ($categories as $index => $cat): 
                    $color = get_category_color($index);
                    $bgColors = [
                        'blue' => 'bg-blue-600', 'purple' => 'bg-purple-600', 'emerald' => 'bg-emerald-600', 
                        'amber' => 'bg-amber-600', 'rose' => 'bg-rose-600', 'cyan' => 'bg-cyan-600', 
                        'indigo' => 'bg-indigo-600', 'teal' => 'bg-teal-600'
                    ];
                    $hoverColors = [
                        'blue' => 'hover:bg-blue-500', 'purple' => 'hover:bg-purple-500', 'emerald' => 'hover:bg-emerald-500', 
                        'amber' => 'hover:bg-amber-500', 'rose' => 'hover:bg-rose-500', 'cyan' => 'hover:bg-cyan-500', 
                        'indigo' => 'hover:bg-indigo-500', 'teal' => 'hover:bg-teal-500'
                    ];
                    $bg = $bgColors[$color];
                    $hover = $hoverColors[$color];
                ?>
                    <a href="<?= url('category/' . ($cat['slug'] ?? '#')) ?>" class="<?= $bg ?> <?= $hover ?> relative rounded-[2rem] p-8 text-white transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-<?= $color ?>-500/30 overflow-hidden group h-64 flex flex-col justify-between">
                        <!-- Decorative Circle -->
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-white opacity-10 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                        
                        <div class="relative z-10 w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <i class="fas <?= get_category_icon($cat['slug']) ?> text-xl"></i>
                        </div>
                        
                        <div class="relative z-10">
                            <h3 class="text-2xl font-bold mb-2"><?= $cat['name'] ?></h3>
                            <div class="flex items-center text-xs font-bold uppercase tracking-widest opacity-70">
                                <?= $cat['software_count'] ?? 0 ?> Products
                            </div>
                        </div>
                        
                        <div class="absolute bottom-6 right-6 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0">
                            <i class="fas fa-arrow-right text-2xl"></i>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

<?php endif; ?>

<?php 
$content = ob_get_clean();

// Robust Layout Inclusion
$layoutPath = __DIR__ . '/../../layouts/main.php';

if (defined('BASE_PATH')) {
    $checkPath = BASE_PATH . '/app/Views/layouts/main.php';
    if (file_exists($checkPath)) {
        $layoutPath = $checkPath;
    }
} elseif (isset($_SERVER['DOCUMENT_ROOT'])) {
    $checkPath = $_SERVER['DOCUMENT_ROOT'] . '/programas/app/Views/layouts/main.php';
    if (file_exists($checkPath)) {
        $layoutPath = $checkPath;
    }
}

if (file_exists($layoutPath)) {
    include $layoutPath;
} else {
    echo $content;
}
?>
