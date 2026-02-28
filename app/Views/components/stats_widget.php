<?php
/**
 * Widget de Estadísticas Públicas
 * Muestra estadísticas generales del sitio
 */

$db = \App\Database::getInstance()->getConnection();

// Obtener estadísticas actuales
$stmt = $db->query("
    SELECT 
        COALESCE(SUM(downloads), 0) as total_downloads,
        COUNT(*) as total_software
    FROM software WHERE status = 'approved'
");
$stats = $stmt->fetch();

$stmt = $db->query("SELECT COUNT(*) as total FROM categories");
$totalCategories = $stmt->fetch()['total'];

$stmt = $db->query("SELECT COUNT(*) as total FROM reviews");
$totalReviews = $stmt->fetch()['total'];
?>

<!-- Estadísticas Públicas -->
<section class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white py-12 mb-16 rounded-2xl shadow-xl">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-8">
            <i class="fas fa-chart-line mr-2"></i>Estadísticas del Sitio
        </h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Total Descargas -->
            <div class="text-center bg-white/10 backdrop-blur-sm rounded-xl p-6 hover:bg-white/20 transition">
                <div class="text-4xl font-bold mb-2">
                    <i class="fas fa-download text-yellow-300"></i>
                </div>
                <div class="text-3xl font-bold mb-1" data-counter="<?= $stats['total_downloads'] ?>">
                    <?= number_format($stats['total_downloads']) ?>
                </div>
                <div class="text-sm opacity-90">Descargas Totales</div>
            </div>
            
            <!-- Total Software -->
            <div class="text-center bg-white/10 backdrop-blur-sm rounded-xl p-6 hover:bg-white/20 transition">
                <div class="text-4xl font-bold mb-2">
                    <i class="fas fa-box-open text-green-300"></i>
                </div>
                <div class="text-3xl font-bold mb-1">
                    <?= number_format($stats['total_software']) ?>
                </div>
                <div class="text-sm opacity-90">Programas Disponibles</div>
            </div>
            
            <!-- Total Categorías -->
            <div class="text-center bg-white/10 backdrop-blur-sm rounded-xl p-6 hover:bg-white/20 transition">
                <div class="text-4xl font-bold mb-2">
                    <i class="fas fa-folder text-purple-300"></i>
                </div>
                <div class="text-3xl font-bold mb-1">
                    <?= number_format($totalCategories) ?>
                </div>
                <div class="text-sm opacity-90">Categorías</div>
            </div>
            
            <!-- Total Reseñas -->
            <div class="text-center bg-white/10 backdrop-blur-sm rounded-xl p-6 hover:bg-white/20 transition">
                <div class="text-4xl font-bold mb-2">
                    <i class="fas fa-star text-orange-300"></i>
                </div>
                <div class="text-3xl font-bold mb-1">
                    <?= number_format($totalReviews) ?>
                </div>
                <div class="text-sm opacity-90">Reseñas</div>
            </div>
        </div>
    </div>
</section>
