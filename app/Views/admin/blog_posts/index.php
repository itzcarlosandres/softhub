<?php ob_start(); ?>

<div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
    <div>
        <h1 class="text-3xl font-bold text-white mb-2 font-outfit">Artículos del Blog</h1>
        <p class="text-gray-400">Gestiona entradas, tutoriales y noticias publicadas en el blog.</p>
    </div>
    
    <div class="flex items-center gap-3">
        <a href="<?= url('admin/blog-posts/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors shadow-lg shadow-blue-600/20 flex items-center gap-2">
            <i class="fas fa-plus"></i> Redactar Artículo
        </a>
    </div>
</div>

<div class="glass-panel rounded-2xl border border-white/5 overflow-hidden">
    <!-- Tabla -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white/5 border-b border-white/5">
                    <th class="p-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Detalles del Artículo</th>
                    <th class="p-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Categoría</th>
                    <th class="p-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Estadísticas</th>
                    <th class="p-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Estado</th>
                    <th class="p-4 text-xs font-semibold text-gray-400 uppercase tracking-wider text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                <?php if(empty($posts)): ?>
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-400">
                            <i class="fas fa-file-alt text-4xl mb-3 opacity-50 block"></i>
                            <p>No hay artículos redactados aún.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($posts as $post): ?>
                        <tr class="hover:bg-white/5 transition-colors group">
                            <!-- Detalles -->
                            <td class="p-4 min-w-[300px]">
                                <div class="flex items-center gap-4">
                                    <?php if ($post['image']): ?>
                                        <div class="w-16 h-12 rounded-lg overflow-hidden flex-shrink-0">
                                            <img src="<?= url($post['image']) ?>" alt="" class="w-full h-full object-cover">
                                        </div>
                                    <?php else: ?>
                                        <div class="w-16 h-12 rounded-lg bg-gray-800 flex items-center justify-center flex-shrink-0 border border-gray-700">
                                            <i class="fas fa-image text-gray-600"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div>
                                        <div class="font-medium text-white text-base mb-1 line-clamp-1" title="<?= htmlspecialchars($post['title']) ?>">
                                            <?= htmlspecialchars($post['title']) ?>
                                        </div>
                                        <div class="text-xs text-gray-500 flex items-center gap-3 block">
                                            <span><i class="far fa-user mr-1"></i> <?= htmlspecialchars($post['author_name'] ?? 'Admin') ?></span>
                                            <span><i class="far fa-calendar mr-1"></i> <?= date('d M Y', strtotime($post['created_at'])) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Categoría -->
                            <td class="p-4 whitespace-nowrap text-sm">
                                <span class="bg-blue-500/10 text-blue-400 px-2.5 py-1 rounded-lg text-xs font-medium border border-blue-500/20">
                                    <?= htmlspecialchars($post['category_name'] ?? 'General') ?>
                                </span>
                            </td>

                            <!-- Estadísticas -->
                            <td class="p-4 whitespace-nowrap">
                                <span class="text-gray-300 text-sm flex items-center gap-2">
                                    <i class="far fa-eye text-gray-500"></i> <?= $post['views'] ?> vistas
                                </span>
                            </td>

                            <!-- Estado (Destacado) -->
                            <td class="p-4 whitespace-nowrap">
                                <a href="<?= url('admin/blog-posts/toggle-featured/' . $post['id']) ?>" class="<?= $post['is_featured'] ? 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 hover:bg-yellow-500/20' : 'bg-gray-500/10 text-gray-400 border border-gray-500/20 hover:bg-gray-500/20' ?> px-3 py-1.5 rounded-lg text-xs font-medium inline-flex items-center gap-1.5 transition-colors">
                                    <i class="fas fa-star <?= $post['is_featured'] ? 'animate-pulse' : '' ?>"></i> 
                                    <?= $post['is_featured'] ? 'Destacado' : 'Normal' ?>
                                </a>
                            </td>
                            
                            <!-- Acciones -->
                            <td class="p-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="<?= url('blog/' . $post['slug']) ?>" target="_blank" class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 flex items-center justify-center transition-colors" title="Ver en sitio web">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    <a href="<?= url('admin/blog-posts/edit/' . $post['id']) ?>" class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 flex items-center justify-center transition-colors" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= url('admin/blog-posts/delete/' . $post['id']) ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este artículo?')" class="w-8 h-8 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 flex items-center justify-center transition-colors" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
$currentPage = 'blog_posts';
require __DIR__ . '/../../layouts/admin.php';
?>
