<?php
// Obtener el software
$slug = $params['slug'] ?? '';
$stmt = $db->prepare("SELECT s.*, c.name as category_name, c.slug as category_slug FROM software s LEFT JOIN categories c ON s.category_id = c.id WHERE s.slug = ?");
$stmt->execute([$slug]);
$software = $stmt->fetch();

if (!$software) {
    header('Location: ' . url('software'));
    exit;
}

$title = htmlspecialchars($software['name']) . ' - Descargar Gratis';
$description = htmlspecialchars($software['short_description']);

// Software relacionado (misma categoría)
$stmt = $db->prepare("SELECT * FROM software WHERE category_id = ? AND id != ? AND status = 'approved' ORDER BY downloads DESC LIMIT 6");
$stmt->execute([$software['category_id'], $software['id']]);
$related = $stmt->fetchAll();

ob_start();
?>

<!-- Hero Section con Gradiente -->
<section class="bg-gradient-to-r from-purple-600 to-blue-600 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Breadcrumb -->
            <div class="flex items-center text-sm text-purple-100 mb-6">
                <a href="<?= url() ?>" class="hover:text-white">Inicio</a>
                <i class="fas fa-chevron-right mx-2 text-xs"></i>
                <a href="<?= url('category/' . $software['category_slug']) ?>" class="hover:text-white"><?= htmlspecialchars($software['category_name']) ?></a>
                <i class="fas fa-chevron-right mx-2 text-xs"></i>
                <span class="text-white font-medium"><?= htmlspecialchars($software['name']) ?></span>
            </div>
            
            <div class="flex flex-col md:flex-row gap-8 items-start">
                <!-- Icon -->
                <div class="flex-shrink-0">
                    <div class="w-32 h-32 bg-white rounded-2xl shadow-2xl overflow-hidden p-4">
                        <?php if (!empty($software['icon'])): ?>
                            <img src="<?= url(htmlspecialchars($software['icon'])) ?>" alt="<?= htmlspecialchars($software['name']) ?>" class="w-full h-full object-contain">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-download text-purple-600 text-5xl"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Info -->
                <div class="flex-1">
                    <h1 class="text-4xl font-bold mb-3"><?= htmlspecialchars($software['name']) ?></h1>
                    <p class="text-xl text-purple-100 mb-4"><?= htmlspecialchars($software['short_description']) ?></p>
                    
                    <div class="flex flex-wrap gap-4 text-sm">
                        <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">
                            <i class="fas fa-user mr-1"></i> <?= htmlspecialchars($software['developer']) ?>
                        </span>
                        <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">
                            <i class="fas fa-code-branch mr-1"></i> v<?= htmlspecialchars($software['version']) ?>
                        </span>
                        <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">
                            <i class="fas fa-download mr-1"></i> <?= number_format($software['downloads']) ?>
                        </span>
                        <span class="bg-yellow-400 text-gray-900 px-3 py-1 rounded-full font-semibold">
                            <i class="fas fa-star mr-1"></i> <?= number_format($software['rating'], 1) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Description -->
                    <div class="bg-white rounded-xl shadow-md p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-info-circle text-purple-600 mr-2"></i>
                            Descripción
                        </h2>
                        <div class="prose max-w-none text-gray-700 leading-relaxed">
                            <?= nl2br(htmlspecialchars($software['description'])) ?>
                        </div>
                    </div>
                    
                    <!-- Requirements -->
                    <?php if (!empty($software['requirements'])): ?>
                    <div class="bg-white rounded-xl shadow-md p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-cogs text-blue-600 mr-2"></i>
                            Requisitos del Sistema
                        </h2>
                        <div class="text-gray-700 leading-relaxed bg-gray-50 p-4 rounded-lg">
                            <?= nl2br(htmlspecialchars($software['requirements'])) ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Download Card -->
                    <div class="bg-gradient-to-br from-purple-600 to-blue-600 rounded-xl shadow-xl p-6 text-white">
                        <h3 class="font-bold text-xl mb-4">Descarga Gratis</h3>
                        <div class="space-y-3 text-sm mb-6">
                            <div class="flex justify-between">
                                <span class="text-purple-100">Versión:</span>
                                <span class="font-semibold"><?= htmlspecialchars($software['version']) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-purple-100">Sistema:</span>
                                <span class="font-semibold"><?= htmlspecialchars($software['operating_system']) ?></span>
                            </div>
                            <?php if (!empty($software['file_size'])): ?>
                            <div class="flex justify-between">
                                <span class="text-purple-100">Tamaño:</span>
                                <span class="font-semibold"><?= htmlspecialchars($software['file_size']) ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="flex justify-between">
                                <span class="text-purple-100">Licencia:</span>
                                <span class="font-semibold"><?= ucfirst($software['license']) ?></span>
                            </div>
                        </div>
                        <a href="<?= url('download/' . $software['id']) ?>" class="block w-full bg-white text-purple-600 text-center py-4 rounded-lg hover:bg-purple-50 transition font-bold shadow-lg">
                            <i class="fas fa-download mr-2"></i>Descargar Ahora
                        </a>
                    </div>
                    
                    <!-- Details Card -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="font-bold text-lg text-gray-900 mb-4">Información</h3>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <dt class="text-gray-600">Desarrollador:</dt>
                                <dd class="font-medium text-gray-900"><?= htmlspecialchars($software['developer']) ?></dd>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <dt class="text-gray-600">Categoría:</dt>
                                <dd class="font-medium text-purple-600">
                                    <a href="<?= url('category/' . $software['category_slug']) ?>" class="hover:underline">
                                        <?= htmlspecialchars($software['category_name']) ?>
                                    </a>
                                </dd>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <dt class="text-gray-600">Descargas:</dt>
                                <dd class="font-medium text-green-600"><?= number_format($software['downloads']) ?></dd>
                            </div>
                            <div class="py-3 border-b border-gray-100">
                                <dt class="text-gray-600 mb-2">Valoración:</dt>
                                <dd>
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center">
                                            <i class="fas fa-star text-yellow-500 mr-1"></i>
                                            <span class="font-bold text-gray-900" id="currentRating"><?= number_format($software['rating'], 1) ?></span>
                                            <span class="text-gray-500 text-sm ml-1">/5</span>
                                        </div>
                                        <span class="text-gray-400 text-sm" id="ratingCount">(<?= $software['rating_count'] ?? 0 ?> votos)</span>
                                    </div>
                                    
                                    <!-- Sistema de calificación interactivo -->
                                    <div class="mt-3 p-4 bg-purple-50 rounded-lg">
                                        <p class="text-sm text-gray-700 mb-2 font-medium">¿Qué te pareció este software?</p>
                                        <div class="flex items-center gap-1" id="ratingStars">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <button type="button" 
                                                        class="rating-star text-3xl transition-all duration-200 hover:scale-110" 
                                                        data-rating="<?= $i ?>"
                                                        title="<?= $i ?> estrella<?= $i > 1 ? 's' : '' ?>">
                                                    <i class="far fa-star text-gray-300"></i>
                                                </button>
                                            <?php endfor; ?>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2" id="ratingMessage">Haz clic en las estrellas para calificar</p>
                                    </div>
                                </dd>
                            </div>
                        </dl>
                    </div>
                    
                    <!-- Related Software in Sidebar -->
                    <?php if (!empty($related)): ?>
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="font-bold text-lg text-gray-900 mb-4">Software Relacionado</h3>
                        <div class="space-y-3">
                            <?php foreach ($related as $rel): ?>
                                <a href="<?= url('software/' . htmlspecialchars($rel['slug'])) ?>" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition group">
                                    <div class="w-12 h-12 bg-white rounded-lg overflow-hidden flex items-center justify-center flex-shrink-0 mr-3 border border-gray-200">
                                        <?php if (!empty($rel['icon'])): ?>
                                            <img src="<?= url(htmlspecialchars($rel['icon'])) ?>" alt="<?= htmlspecialchars($rel['name']) ?>" class="w-full h-full object-contain p-1">
                                        <?php else: ?>
                                            <i class="fas fa-download text-gray-400 text-xl"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-sm text-gray-900 truncate group-hover:text-purple-600"><?= htmlspecialchars($rel['name']) ?></h4>
                                        <p class="text-xs text-gray-500"><i class="fas fa-download"></i> <?= number_format($rel['downloads']) ?></p>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Sistema de calificación con estrellas
const ratingStars = document.querySelectorAll('.rating-star');
const softwareId = <?= $software['id'] ?>;
let userRating = 0;

// Hover effect
ratingStars.forEach((star, index) => {
    star.addEventListener('mouseenter', () => {
        highlightStars(index + 1);
    });
    
    star.addEventListener('mouseleave', () => {
        if (userRating === 0) {
            resetStars();
        } else {
            highlightStars(userRating);
        }
    });
    
    star.addEventListener('click', () => {
        const rating = parseInt(star.dataset.rating);
        submitRating(rating);
    });
});

function highlightStars(count) {
    ratingStars.forEach((star, index) => {
        const icon = star.querySelector('i');
        if (index < count) {
            icon.classList.remove('far', 'text-gray-300');
            icon.classList.add('fas', 'text-yellow-500');
        } else {
            icon.classList.remove('fas', 'text-yellow-500');
            icon.classList.add('far', 'text-gray-300');
        }
    });
}

function resetStars() {
    ratingStars.forEach(star => {
        const icon = star.querySelector('i');
        icon.classList.remove('fas', 'text-yellow-500');
        icon.classList.add('far', 'text-gray-300');
    });
}

function submitRating(rating) {
    userRating = rating;
    highlightStars(rating);
    
    // Mostrar mensaje de carga
    const messageEl = document.getElementById('ratingMessage');
    messageEl.textContent = 'Enviando tu calificación...';
    messageEl.className = 'text-xs text-blue-600 mt-2';
    
    // Enviar calificación al servidor
    fetch('<?= url('api/rate-software') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            software_id: softwareId,
            rating: rating
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Actualizar rating mostrado
            document.getElementById('currentRating').textContent = data.new_rating.toFixed(1);
            document.getElementById('ratingCount').textContent = `(${data.rating_count} votos)`;
            
            // Mensaje de éxito
            messageEl.textContent = '¡Gracias por tu calificación!';
            messageEl.className = 'text-xs text-green-600 mt-2 font-semibold';
            
            // Guardar en localStorage
            localStorage.setItem(`rated_software_${softwareId}`, rating);
            
            // Deshabilitar estrellas
            ratingStars.forEach(star => {
                star.disabled = true;
                star.style.cursor = 'not-allowed';
                star.style.opacity = '0.6';
            });
        } else {
            messageEl.textContent = data.message || 'Error al enviar calificación';
            messageEl.className = 'text-xs text-red-600 mt-2';
            resetStars();
            userRating = 0;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        messageEl.textContent = 'Error al enviar calificación. Intenta de nuevo.';
        messageEl.className = 'text-xs text-red-600 mt-2';
        resetStars();
        userRating = 0;
    });
}

// Verificar si el usuario ya calificó (usando localStorage)
const ratedKey = `rated_software_${softwareId}`;
if (localStorage.getItem(ratedKey)) {
    const previousRating = parseInt(localStorage.getItem(ratedKey));
    userRating = previousRating;
    highlightStars(previousRating);
    document.getElementById('ratingMessage').textContent = 'Ya calificaste este software';
    document.getElementById('ratingMessage').className = 'text-xs text-gray-500 mt-2';
    ratingStars.forEach(star => {
        star.disabled = true;
        star.style.cursor = 'not-allowed';
        star.style.opacity = '0.6';
    });
}
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/main.php';
?>
