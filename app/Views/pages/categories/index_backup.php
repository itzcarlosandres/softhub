<?php
$title = 'Categorías - Descarga Software Gratis';
$description = 'Explora todas las categorías de software disponibles';

// Obtener todas las categorías con conteo de software
$stmt = $db->prepare("
    SELECT c.*, COUNT(s.id) as software_count 
    FROM categories c 
    LEFT JOIN software s ON c.id = s.category_id AND s.status = 'approved'
    GROUP BY c.id 
    ORDER BY c.name
");
$stmt->execute();
$categories = $stmt->fetchAll();

ob_start();
?>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-purple-600 to-blue-600 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-4">
                <i class="fas fa-th-large mr-3"></i>
                Todas las Categorías
            </h1>
            <p class="text-xl text-purple-100">
                Explora nuestra amplia selección de programas organizados por categoría
            </p>
        </div>
    </div>
</section>

<!-- Categories Grid -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <?php if (!empty($categories)): ?>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <?php foreach ($categories as $category): ?>
                        <a href="<?= url('category/' . $category['slug']) ?>" class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-blue-500 rounded-2xl flex items-center justify-center text-white text-3xl mb-4 group-hover:scale-110 transition-transform">
                                    <i class="<?= htmlspecialchars($category['icon'] ?: 'fas fa-folder') ?>"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-purple-600 transition"><?= htmlspecialchars($category['name']) ?></h3>
                                <?php if (!empty($category['description'])): ?>
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2"><?= htmlspecialchars($category['description']) ?></p>
                                <?php endif; ?>
                                <div class="mt-auto pt-3 border-t border-gray-100 w-full">
                                    <span class="text-sm font-semibold text-purple-600">
                                        <?= $category['software_count'] ?> programas
                                    </span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-16">
                    <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
                    <p class="text-xl text-gray-600">No hay categorías disponibles</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/main.php';
?>
