<?php include BASE_PATH . '/app/Views/layouts/main.php'; ?>

<!-- Latest Software Hero -->
<div class="relative bg-white border-b border-gray-200 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-gray-50 to-white z-0"></div>
    <div class="absolute right-0 top-0 w-1/3 h-full bg-gradient-to-l from-blue-50 to-transparent z-0 opacity-50"></div>
    
    <div class="container mx-auto px-4 py-12 relative z-10">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-blue-600 text-xs font-semibold uppercase tracking-wider mb-4">
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                Actualizado en tiempo real
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">
                Novedades <span class="text-blue-600">Premium</span>
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl leading-relaxed">
                Descubre los programas más recientes añadidos a nuestra colección. Software verificado, limpio y listo para mejorar tu productividad.
            </p>
        </div>
    </div>
</div>

<!-- Compact Grid -->
<div class="bg-gray-50 py-12 min-h-screen">
    <div class="container mx-auto px-4">
        
        <?php if (empty($latest)): ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-box-open text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay novedades por ahora</h3>
                <p class="text-gray-500">Estamos trabajando en agregar más software increíble.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                <?php foreach ($latest as $soft): ?>
                <a href="<?= url('software/' . $soft['slug']) ?>" class="group block">
                    <div class="bg-white rounded-xl border border-gray-200/60 p-4 transition-all duration-300 hover:shadow-xl hover:shadow-blue-500/10 hover:border-blue-500/30 hover:-translate-y-1 relative overflow-hidden h-full flex flex-col">
                        <!-- New Badge -->
                        <?php if (strtotime($soft['created_at']) > strtotime('-7 days')): ?>
                        <div class="absolute top-3 right-3">
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                            </span>
                        </div>
                        <?php endif; ?>

                        <!-- Icon & Header -->
                        <div class="flex items-start gap-4 mb-3">
                            <div class="flex-shrink-0 w-14 h-14 bg-gray-50 rounded-xl flex items-center justify-center p-2 group-hover:scale-105 transition-transform duration-300 shadow-sm border border-gray-100">
                                <?php 
                                $iconPath = !empty($soft['icon']) ? $soft['icon'] : $soft['image'];
                                if ($iconPath): 
                                ?>
                                    <img src="<?= url($iconPath) ?>" alt="<?= htmlspecialchars($soft['name']) ?>" class="w-full h-full object-contain">
                                <?php else: ?>
                                    <i class="fas fa-cube text-gray-400 text-xl group-hover:text-blue-500 transition-colors"></i>
                                <?php endif; ?>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-sm font-bold text-gray-900 truncate group-hover:text-blue-600 transition-colors mb-0.5">
                                    <?= htmlspecialchars($soft['name']) ?>
                                </h3>
                                <p class="text-xs text-gray-500 truncate">
                                    <?= htmlspecialchars($soft['developer'] ?? 'Desconocido') ?>
                                </p>
                            </div>
                        </div>

                        <!-- Description (Truncated) -->
                        <p class="text-xs text-gray-500 line-clamp-3 mb-4 flex-1 leading-relaxed">
                            <?= htmlspecialchars($soft['short_description'] ?? '') ?>
                        </p>

                        <!-- Action Button -->
                        <div class="mt-auto pt-3 border-t border-gray-50">
                            <span class="block w-full py-2 px-3 rounded-lg bg-blue-50/50 hover:bg-blue-600 text-blue-600 hover:text-white text-xs font-bold transition-all duration-300 text-center flex items-center justify-center gap-2 group-hover:shadow-lg hover:-translate-y-0.5 border border-blue-100/50 hover:border-blue-600">
                                <span>Leer más</span>
                                <i class="fas fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
                            </span>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            
            <!-- Load More Container -->
            <div class="mt-12 text-center" id="load-more-container">
                <button id="load-more-btn" data-page="2" class="inline-flex items-center gap-2 px-8 py-3 rounded-full bg-white text-blue-600 font-bold text-sm shadow-lg hover:shadow-xl hover:bg-blue-50 transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 group">
                    <i class="fas fa-sync-alt group-hover:rotate-180 transition-transform" id="load-more-icon"></i>
                    <span id="load-more-text">Cargar más novedades</span>
                </button>
            </div>
            
            <!-- End of Content Message (Hidden initially) -->
            <div id="end-of-content" class="mt-12 text-center hidden">
                <div class="inline-flex items-center gap-2 text-sm text-gray-400 font-medium">
                    <i class="fas fa-check-circle text-green-500"></i>
                    Has visto todas las novedades recientes
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('load-more-btn');
    const container = document.querySelector('.grid'); // The grid container
    const endMessage = document.getElementById('end-of-content');
    const loadMoreContainer = document.getElementById('load-more-container');
    const loadMoreIcon = document.getElementById('load-more-icon');
    const loadMoreText = document.getElementById('load-more-text');

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            const page = this.getAttribute('data-page');
            
            // Set loading state
            loadMoreIcon.classList.add('fa-spin');
            loadMoreText.textContent = 'Cargando...';
            loadMoreBtn.classList.add('opacity-75', 'cursor-not-allowed');
            loadMoreBtn.disabled = true;

            // Fetch data
            fetch(`<?= url('api/latest-software') ?>?page=${page}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        // Append items
                        data.forEach(soft => {
                            const card = createCard(soft);
                            container.insertAdjacentHTML('beforeend', card);
                        });

                        // Update page for next request
                        loadMoreBtn.setAttribute('data-page', parseInt(page) + 1);
                        
                        // Reset button state
                        loadMoreIcon.classList.remove('fa-spin');
                        loadMoreText.textContent = 'Cargar más novedades';
                        loadMoreBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                        loadMoreBtn.disabled = false;
                    } else {
                        // No more items
                        loadMoreContainer.classList.add('hidden');
                        endMessage.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error loading more items:', error);
                    loadMoreIcon.classList.remove('fa-spin');
                    loadMoreText.textContent = 'Error al cargar';
                    loadMoreBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                    loadMoreBtn.disabled = false;
                });
        });
    }

    function createCard(soft) {
        const baseUrl = '<?= url('') ?>';
        const detailUrl = `${baseUrl}/software/${soft.slug}`;
        const iconUrl = soft.icon ? `${baseUrl}/${soft.icon}` : (soft.image ? `${baseUrl}/${soft.image}` : '');
        
        // Check if new (last 7 days)
        const createdDate = new Date(soft.created_at);
        const diffDays = (new Date() - createdDate) / (1000 * 60 * 60 * 24);
        const isNew = diffDays <= 7;

        return `
        <a href="${detailUrl}" class="group block fade-in-up">
            <div class="bg-white rounded-xl border border-gray-200/60 p-4 transition-all duration-300 hover:shadow-xl hover:shadow-blue-500/10 hover:border-blue-500/30 hover:-translate-y-1 relative overflow-hidden h-full flex flex-col">
                ${isNew ? `
                <div class="absolute top-3 right-3">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                    </span>
                </div>` : ''}

                <div class="flex items-start gap-4 mb-3">
                    <div class="flex-shrink-0 w-14 h-14 bg-gray-50 rounded-xl flex items-center justify-center p-2 group-hover:scale-105 transition-transform duration-300 shadow-sm border border-gray-100">
                        ${iconUrl ? 
                            `<img src="${iconUrl}" alt="${soft.name}" class="w-full h-full object-contain">` : 
                            `<i class="fas fa-cube text-gray-400 text-xl group-hover:text-blue-500 transition-colors"></i>`
                        }
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-sm font-bold text-gray-900 truncate group-hover:text-blue-600 transition-colors mb-0.5">
                            ${soft.name}
                        </h3>
                        <p class="text-xs text-gray-500 truncate">
                            ${soft.developer || 'Desconocido'}
                        </p>
                    </div>
                </div>

                <p class="text-xs text-gray-500 line-clamp-3 mb-4 flex-1 leading-relaxed">
                    ${soft.short_description || ''}
                </p>

                <div class="mt-auto pt-3 border-t border-gray-50">
                    <span class="block w-full py-2 px-3 rounded-lg bg-blue-50/50 hover:bg-blue-600 text-blue-600 hover:text-white text-xs font-bold transition-all duration-300 text-center flex items-center justify-center gap-2 group-hover:shadow-lg hover:-translate-y-0.5 border border-blue-100/50 hover:border-blue-600">
                        <span>Leer más</span>
                        <i class="fas fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </div>
            </div>
        </a>
        `;
    }
});
</script>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translate3d(0, 20px, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}
.fade-in-up {
    animation: fadeInUp 0.5s ease-out forwards;
}
</style>

<?php include BASE_PATH . '/app/Views/layouts/footer.php'; ?>
