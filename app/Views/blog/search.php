<?php ob_start(); ?>

<!-- Header de la Búsqueda -->
<section class="relative pt-24 pb-16 overflow-hidden bg-white dark:bg-gray-900 transition-colors duration-300">
    <div class="absolute inset-0 bg-blue-50/50 dark:bg-gray-800/20"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white tracking-tight mb-4 transition-colors">
            Resultados para: <span class="text-blue-600 dark:text-blue-400">"<?= htmlspecialchars($query) ?>"</span>
        </h1>
        <p class="text-lg text-gray-500 dark:text-gray-400 font-medium">
            Mostrando <?= count($posts) ?> resultados encontrados en el blog
        </p>

        <!-- Buscador del Blog -->
        <form action="<?= url('blog/search') ?>" method="GET" class="max-w-xl mx-auto mt-8 relative group">
            <input type="text" name="q" value="<?= htmlspecialchars($query) ?>" placeholder="¿Qué tema estás buscando? Ej: Windows 11, Antivirus..." 
                   class="w-full bg-white dark:bg-gray-800 border-2 border-gray-100 dark:border-gray-700 rounded-full py-4 pl-6 pr-14 text-gray-700 dark:text-gray-300 focus:outline-none focus:border-blue-500 dark:focus:border-blue-500 shadow-xl shadow-black/5 transition-all outline-none">
            <button type="submit" class="absolute right-2 top-2 bg-blue-600 hover:bg-blue-700 text-white w-10 h-10 rounded-full flex items-center justify-center transition-transform hover:scale-105">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</section>

<!-- Categorías -->
<section class="py-6 border-y border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50 transition-colors">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-nowrap overflow-x-auto gap-4 scrollbar-hide pb-2" style="scrollbar-width: none;">
            <a href="<?= url('blog') ?>" class="px-5 py-2 whitespace-nowrap bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:border-blue-500 transition-all rounded-full font-medium text-sm">
                Todo
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="<?= url('blog/category/' . htmlspecialchars($cat['slug'])) ?>" class="px-5 py-2 whitespace-nowrap bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:border-blue-500 transition-all rounded-full font-bold text-sm">
                    <?= htmlspecialchars($cat['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Content Grid -->
<section class="py-16 bg-white dark:bg-gray-900 transition-colors min-h-[500px]">
    <div class="max-w-7xl mx-auto px-6">
        
        <?php if(empty($posts)): ?>
            <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                <i class="fas fa-search text-4xl mb-4 text-blue-300 dark:text-gray-600"></i>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No se encontraron resultados</h3>
                <p>No hay artículos que coincidan con "<?= htmlspecialchars($query) ?>". Intenta con otros términos.</p>
                <a href="<?= url('blog') ?>" class="mt-6 inline-block text-blue-600 dark:text-blue-400 hover:underline">← Volver al blog principal</a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($posts as $post): ?>
                <!-- Post Card -->
                <article onclick="window.location='<?= url('blog/' . $post['slug']) ?>'" class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-500 shadow-xl shadow-gray-200/50 dark:shadow-none transition-all group cursor-pointer flex flex-col hover:-translate-y-1">
                    <div class="relative h-48 overflow-hidden">
                        <img src="<?= $post['image'] ? url($post['image']) : 'https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                        <div class="absolute top-3 left-3 bg-white/90 dark:bg-black/90 backdrop-blur-sm text-gray-900 dark:text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-md shadow-sm">
                            <?= htmlspecialchars($post['category_name'] ?? 'General') ?>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 leading-snug group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            <?= htmlspecialchars($post['title']) ?>
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm line-clamp-2 mb-6">
                            <?= htmlspecialchars($post['extract'] ?? 'Haz clic para leer más.') ?>
                        </p>
                        <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between text-xs text-gray-500 font-medium">
                            <span class="flex items-center gap-1.5"><i class="far fa-calendar text-gray-400"></i> <?= date('M d, Y', strtotime($post['created_at'])) ?></span>
                            <span class="flex items-center gap-1.5"><i class="far fa-eye text-gray-400"></i> <?= $post['views'] ?></span>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
    </div>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
