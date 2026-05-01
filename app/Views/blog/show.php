<?php 
$title = !empty($post['seo_title']) ? $post['seo_title'] : $post['title'] . ' | SoftHub';
$description = !empty($post['seo_description']) ? $post['seo_description'] : $post['extract'];
$image = !empty($post['image']) ? url($post['image']) : null;
ob_start(); 
?>

<div class="bg-gray-50 dark:bg-gray-900 transition-colors pt-12 pb-24">
    <!-- Header del Artículo -->
    <div class="max-w-4xl mx-auto px-6 mb-10 text-center">
        <!-- Badge Categoría -->
        <?php if($post['category_slug']): ?>
            <a href="<?= url('blog/category/' . $post['category_slug']) ?>" class="inline-block bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-6 hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                <?= htmlspecialchars($post['category_name']) ?>
            </a>
        <?php endif; ?>
        
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-gray-900 dark:text-white leading-tight mb-6">
            <?= htmlspecialchars($post['title']) ?>
        </h1>
        
        <div class="text-xl text-gray-500 dark:text-gray-400 mb-8 max-w-2xl mx-auto">
            <?= htmlspecialchars($post['extract'] ?? '') ?>
        </div>
        
        <div class="flex items-center justify-center gap-6 text-sm font-medium text-gray-600 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700 pt-6">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center text-white font-bold text-xs">
                    <?= strtoupper(substr($post['author_name'] ?? 'AD', 0, 2)) ?>
                </div>
                <span><?= htmlspecialchars($post['author_name'] ?? 'Admin') ?></span>
            </div>
            <div class="hidden md:block w-1 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
            <div>
                <i class="far fa-calendar mr-1"></i> <?= date('F j, Y', strtotime($post['created_at'])) ?>
            </div>
            <div class="hidden md:block w-1 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
            <div>
                <i class="far fa-eye mr-1"></i> <?= $post['views'] ?> vistas
            </div>
        </div>
    </div>

    <!-- Imagen Destacada -->
    <?php if(!empty($post['image'])): ?>
    <div class="max-w-5xl mx-auto px-4 lg:px-6 mb-16">
        <div class="rounded-3xl overflow-hidden shadow-2xl">
            <img src="<?= url($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="w-full object-cover max-h-[600px]">
        </div>
    </div>
    <?php endif; ?>

    <!-- Contenido -->
    <div class="max-w-3xl mx-auto px-6">
        <div class="prose dark:prose-invert prose-lg prose-blue max-w-none mb-16">
            <?= $post['content'] ?? '<p>El contenido de este artículo estará disponible pronto.</p>' ?>
        </div>
        
        <!-- Compartir / Footer del artículo -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-8 mt-12 mb-16">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <span class="font-bold text-gray-900 dark:text-white">Compartir:</span>
                    <a href="https://twitter.com/intent/tweet?text=<?= urlencode($post['title']) ?>&url=<?= urlencode(url('blog/' . $post['slug'])) ?>" target="_blank" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 flex items-center justify-center hover:bg-blue-50 hover:text-blue-500 transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(url('blog/' . $post['slug'])) ?>" target="_blank" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 flex items-center justify-center hover:bg-blue-50 hover:text-blue-600 transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://wa.me/?text=<?= urlencode($post['title'] . ' - ' . url('blog/' . $post['slug'])) ?>" target="_blank" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 flex items-center justify-center hover:bg-green-50 hover:text-green-500 transition-colors">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
                <div>
                    <a href="<?= url('blog') ?>" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">
                        ← Volver al Blog
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Artículos Relacionados -->
    <?php if(!empty($relatedPosts)): ?>
    <div class="max-w-7xl mx-auto px-6 pt-12 border-t border-gray-200 dark:border-gray-800">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">También te podría interesar</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($relatedPosts as $relPost): ?>
            <article onclick="window.location='<?= url('blog/' . $relPost['slug']) ?>'" class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-500 shadow-xl shadow-gray-200/50 dark:shadow-none transition-all group cursor-pointer flex flex-col hover:-translate-y-1">
                <div class="relative h-48 overflow-hidden">
                    <img src="<?= $relPost['image'] ? url($relPost['image']) : 'https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                    <div class="absolute top-3 left-3 bg-white/90 dark:bg-black/90 backdrop-blur-sm text-gray-900 dark:text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-md shadow-sm">
                        <?= htmlspecialchars($relPost['category_name'] ?? 'General') ?>
                    </div>
                </div>
                <div class="p-6">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2 leading-snug group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2">
                        <?= htmlspecialchars($relPost['title']) ?>
                    </h4>
                    <span class="text-xs text-gray-500 font-medium">
                        <?= date('M d, Y', strtotime($relPost['created_at'])) ?>
                    </span>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
