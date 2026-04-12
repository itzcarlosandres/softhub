<?php 
// Helper Icon Mapping (Podría ir en un helper global, pero lo definimos aquí por simplicidad)
$get_category_icon = function($slug) {
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
    foreach($icons as $key => $val) {
        if(strpos($slug, $key) !== false) return $val;
    }
    return 'fa-folder';
};

$title = 'Categorías - SoftHub';
$description = 'Explora nuestra colección de software premium organizado por categorías.';

ob_start(); 
?>

<!-- GLASSMORPHISM DESIGN IMPLEMENTATION -->
<div class="bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen py-20 font-sans relative overflow-hidden transition-colors duration-300">
    
    <!-- Ambient Background Blobs -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-blue-400 dark:bg-blue-600 rounded-full blur-[120px] opacity-20 animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] bg-purple-400 dark:bg-purple-600 rounded-full blur-[140px] opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-[40%] left-[60%] w-[300px] h-[300px] bg-pink-300 dark:bg-pink-600 rounded-full blur-[100px] opacity-20 animate-pulse" style="animation-delay: 4s;"></div>
    </div>

    <div class="container mx-auto px-6 max-w-7xl relative z-10">
        
        <!-- Luxe Line Header -->
        <div class="mb-16 relative z-10">
            <span class="text-[10px] font-black text-blue-500 dark:text-blue-400 uppercase tracking-[0.2em] block mb-1">CATEGORY EXPLORER</span>
            <div class="flex items-center gap-6">
                <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white whitespace-nowrap tracking-tight">
                    Navegar <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-500">Categorías</span>
                </h1>
                <div class="h-px w-full bg-gradient-to-r from-blue-500/50 to-transparent"></div>
                <div class="hidden md:flex items-center gap-2 flex-shrink-0">
                    <span class="w-3 h-3 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>
                    <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Global Library</span>
                </div>
            </div>
        </div>
        
        <!-- Grid de Categorías -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 pb-20">
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $index => $cat): ?>
                    <?php 
                    // Dynamic Colors for Icons
                    $colors = [
                        ['text' => 'text-blue-500', 'bg' => 'bg-blue-50'],
                        ['text' => 'text-purple-500', 'bg' => 'bg-purple-50'],
                        ['text' => 'text-pink-500', 'bg' => 'bg-pink-50'],
                        ['text' => 'text-indigo-500', 'bg' => 'bg-indigo-50'],
                        ['text' => 'text-cyan-500', 'bg' => 'bg-cyan-50'],
                        ['text' => 'text-rose-500', 'bg' => 'bg-rose-50']
                    ];
                    $theme = $colors[$index % count($colors)];
                    ?>
                    
                    <a href="<?= url('category/' . ($cat['slug'] ?? '#')) ?>" class="bg-white/40 dark:bg-gray-800/40 backdrop-blur-xl border border-white/60 dark:border-gray-700/60 p-8 rounded-[2rem] shadow-lg hover:shadow-2xl hover:bg-white/70 dark:hover:bg-gray-800/70 transition-all duration-300 group hover:-translate-y-2 flex flex-col h-full relative overflow-hidden">
                        
                        <!-- Shine Effect -->
                        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/40 dark:from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

                        <div class="flex items-start justify-between mb-8 relative z-10">
                            <div class="w-16 h-16 bg-white/80 dark:bg-gray-700/80 rounded-2xl flex items-center justify-center text-3xl shadow-sm border border-white dark:border-gray-600 group-hover:rotate-6 transition-transform duration-300">
                                <i class="fas <?= $get_category_icon($cat['slug']) ?> <?= $theme['text'] ?>"></i>
                            </div>
                            <span class="bg-white/60 dark:bg-gray-700/60 px-4 py-1.5 rounded-full text-xs font-bold text-gray-500 dark:text-gray-300 border border-white/60 dark:border-gray-600/60 shadow-sm backdrop-blur-md">
                                <?= $cat['software_count'] ?? 0 ?> apps
                            </span>
                        </div>
                        
                        <div class="relative z-10 flex-grow">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-blue-700 dark:group-hover:text-blue-400 transition-colors">
                                <?= $cat['name'] ?>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed mb-6 font-medium opacity-80 group-hover:opacity-100 transition-opacity">
                                <?= $cat['description'] ?? 'Encuentra las mejores herramientas y software en esta categoría especializada.' ?>
                            </p>
                        </div>
                        
                        <div class="relative z-10 mt-auto pt-6 border-t border-gray-200/30 dark:border-gray-700/50 flex items-center justify-between group/link">
                            <span class="font-bold text-sm text-gray-400 dark:text-gray-500 uppercase tracking-widest group-hover/link:text-blue-600 dark:group-hover/link:text-blue-400 transition-colors">Explorar</span>
                            <div class="w-8 h-8 rounded-full bg-white/50 dark:bg-gray-700/50 flex items-center justify-center text-gray-400 dark:text-gray-500 group-hover/link:bg-blue-600 group-hover/link:text-white transition-all duration-300 group-hover/link:translate-x-1">
                                <i class="fas fa-arrow-right text-xs"></i>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-20 bg-white/30 backdrop-blur-md rounded-3xl border border-white/50">
                    <i class="fas fa-ghost text-6xl text-gray-300 mb-6 animate-bounce"></i>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">Está un poco vacío aquí</h3>
                    <p class="text-gray-500">No hemos encontrado categorías aún.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();

// Robust Layout Inclusion Logic
$layoutPath = __DIR__ . '/../../layouts/main.php';
if (defined('BASE_PATH')) {
    $checkPath = BASE_PATH . '/app/Views/layouts/main.php';
    if (file_exists($checkPath)) $layoutPath = $checkPath;
} elseif (isset($_SERVER['DOCUMENT_ROOT'])) {
    $checkPath = $_SERVER['DOCUMENT_ROOT'] . '/programas/app/Views/layouts/main.php';
    if (file_exists($checkPath)) $layoutPath = $checkPath;
}

if (file_exists($layoutPath)) {
    include $layoutPath;
} else {
    echo $content;
}
?>
