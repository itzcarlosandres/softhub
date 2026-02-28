<?php 
ob_start(); 
$title = 'Novedades de Software - SoftHub';
$description = 'Descubre las últimas adiciones a nuestra colección de software. Programas verificados y actualizados diariamente.';
?>

<!-- Latest Software Hero -->
<div class="relative bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 transition-colors duration-300 overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-blue-50/50 to-transparent dark:from-blue-900/10 dark:to-transparent"></div>
        <div class="absolute inset-0 opacity-[0.03] dark:opacity-10" style="background-image: radial-gradient(currentColor 1px, transparent 1px); background-size: 32px 32px;"></div>
    </div>
    
    <div class="container mx-auto px-4 py-16 md:py-24 relative z-10">
        <div class="max-w-4xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-900/30 border border-blue-100 dark:border-blue-800/50 text-blue-600 dark:text-blue-400 text-[10px] font-black uppercase tracking-widest mb-6 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                Actualizado en tiempo real
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-gray-900 dark:text-white mb-6 tracking-tight leading-tight">
                Novedades <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">Premium</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-500 dark:text-gray-400 max-w-2xl leading-relaxed font-medium">
                Descubre los programas más recientes añadidos a nuestra colección. Software verificado, limpio y listo para elevar tu productividad al siguiente nivel.
            </p>
        </div>
    </div>
</div>

<!-- Main Grid Section -->
<div class="bg-gray-50 dark:bg-[#0b0c10] py-16 transition-colors duration-300 min-h-screen">
    <div class="container mx-auto px-4">
        
        <?php if (empty($latest)): ?>
            <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-16 text-center shadow-sm border border-gray-100 dark:border-gray-700/50 max-w-4xl mx-auto">
                <div class="w-24 h-24 bg-gray-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-8 border border-gray-100 dark:border-gray-700">
                    <i class="fas fa-box-open text-3xl text-gray-300 dark:text-gray-600"></i>
                </div>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-4 tracking-tight">Vaya, estamos preparando cosas nuevas</h3>
                <p class="text-gray-500 dark:text-gray-400 font-medium">Vuelve pronto para descubrir el software más reciente que tenemos para ti.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                <?php foreach ($latest as $soft): 
                    $iconPath = !empty($soft['icon']) ? $soft['icon'] : $soft['image'];
                    $isNew = strtotime($soft['created_at']) > strtotime('-7 days');
                ?>
                <a href="<?= url('software/' . $soft['slug']) ?>" class="group block h-full">
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700/50 transition-all duration-500 hover:shadow-2xl h-full flex flex-col relative overflow-hidden">
                        <!-- Animated Background Hover -->
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/0 to-blue-500/0 group-hover:from-blue-500/[0.02] group-hover:to-indigo-500/[0.02] transition-all duration-500"></div>

                        <!-- New Indicator -->
                        <?php if ($isNew): ?>
                        <div class="absolute top-4 right-4 z-20">
                            <span class="flex h-3 w-3 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-600"></span>
                            </span>
                        </div>
                        <?php endif; ?>

                        <div class="flex items-start gap-5 relative z-10 mb-6">
                            <div class="w-16 h-16 rounded-2xl bg-white dark:bg-gray-700 shadow-md border border-gray-100 dark:border-gray-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-500 overflow-hidden">
                                <?php if ($iconPath): ?>
                                    <img src="<?= url($iconPath) ?>" alt="<?= htmlspecialchars($soft['name']) ?>" class="w-12 h-12 object-contain p-1">
                                <?php else: ?>
                                    <i class="fas fa-cube text-2xl text-blue-500"></i>
                                <?php endif; ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-black text-gray-900 dark:text-white truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors mb-0.5">
                                    <?= htmlspecialchars($soft['name']) ?>
                                </h3>
                                <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest truncate">
                                    <?= htmlspecialchars($soft['developer'] ?? 'Desconocido') ?>
                                </p>
                            </div>
                        </div>

                        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3 leading-relaxed font-medium mb-8 flex-1">
                            <?= htmlspecialchars($soft['short_description'] ?? '') ?>
                        </p>

                        <div class="mt-auto pt-6 flex items-center justify-between relative z-10 border-t border-gray-50 dark:border-gray-700/50">
                            <div class="flex items-center gap-3">
                                <?php if (!empty($soft['price']) && $soft['price'] > 0): ?>
                                    <span class="text-[10px] font-black text-purple-600 dark:text-purple-400 uppercase tracking-widest bg-purple-50 dark:bg-purple-900/30 px-2 py-0.5 rounded-full">PREMIUM</span>
                                <?php else: ?>
                                    <span class="text-[10px] font-black text-green-600 dark:text-green-400 uppercase tracking-widest bg-green-50 dark:bg-green-900/30 px-2 py-0.5 rounded-full">GRATIS</span>
                                <?php endif; ?>
                            </div>
                            <span class="w-10 h-10 rounded-full bg-gray-900 dark:bg-gray-700 text-white flex items-center justify-center group-hover:bg-blue-600 group-hover:shadow-lg group-hover:shadow-blue-500/20 transition-all">
                                <i class="fas fa-chevron-right text-[10px]"></i>
                            </span>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            
            <!-- Load More Container -->
            <div class="mt-16 text-center" id="load-more-container">
                <button id="load-more-btn" data-page="2" class="inline-flex items-center gap-3 px-10 py-5 rounded-2xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-black text-xs uppercase tracking-widest shadow-xl dark:shadow-2xl hover:shadow-2xl hover:-translate-y-1 transition-all group border border-gray-100 dark:border-gray-700">
                    <i class="fas fa-sync-alt group-hover:rotate-180 transition-transform duration-500" id="load-more-icon"></i>
                    <span id="load-more-text">Cargar más programas</span>
                </button>
            </div>
            
            <!-- End Message -->
            <div id="end-of-content" class="mt-16 text-center hidden">
                <div class="inline-flex items-center gap-3 bg-white dark:bg-gray-800 px-8 py-4 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700/50">
                    <div class="w-8 h-8 bg-green-50 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-green-500 text-xs"></i>
                    </div>
                    <span class="text-sm font-bold text-gray-600 dark:text-gray-300">Has visto todas las novedades</span>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('load-more-btn');
    const container = document.querySelector('.grid');
    const endMessage = document.getElementById('end-of-content');
    const loadMoreContainer = document.getElementById('load-more-container');
    const loadMoreIcon = document.getElementById('load-more-icon');
    const loadMoreText = document.getElementById('load-more-text');

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            const page = this.getAttribute('data-page');
            
            loadMoreIcon.classList.add('fa-spin');
            loadMoreText.textContent = 'Cargando...';
            loadMoreBtn.classList.add('opacity-75', 'cursor-not-allowed');
            loadMoreBtn.disabled = true;

            fetch(`<?= url('api/latest-software') ?>?page=${page}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        data.forEach(soft => {
                            const card = createCard(soft);
                            container.insertAdjacentHTML('beforeend', card);
                        });

                        loadMoreBtn.setAttribute('data-page', parseInt(page) + 1);
                        loadMoreIcon.classList.remove('fa-spin');
                        loadMoreText.textContent = 'Cargar más programas';
                        loadMoreBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                        loadMoreBtn.disabled = false;
                    } else {
                        loadMoreContainer.classList.add('hidden');
                        endMessage.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    loadMoreIcon.classList.remove('fa-spin');
                    loadMoreText.textContent = 'Error al cargar';
                });
        });
    }

    function createCard(soft) {
        const baseUrl = '<?= url('') ?>';
        const detailUrl = `${baseUrl}/software/${soft.slug}`;
        const iconPath = soft.icon || soft.image;
        const iconUrl = iconPath ? `${baseUrl}/${iconPath}` : '';
        const isPremium = soft.price > 0;
        
        const createdDate = new Date(soft.created_at);
        const diffDays = (new Date() - createdDate) / (1000 * 60 * 60 * 24);
        const isNew = diffDays <= 7;

        return `
        <a href="${detailUrl}" class="group block h-full fade-in-up">
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700/50 transition-all duration-500 hover:shadow-2xl h-full flex flex-col relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/0 to-blue-500/0 group-hover:from-blue-500/[0.02] group-hover:to-indigo-500/[0.02] transition-all duration-500"></div>

                ${isNew ? `
                <div class="absolute top-4 right-4 z-20">
                    <span class="flex h-3 w-3 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-600"></span>
                    </span>
                </div>` : ''}

                <div class="flex items-start gap-5 relative z-10 mb-6">
                    <div class="w-16 h-16 rounded-2xl bg-white dark:bg-gray-700 shadow-md border border-gray-100 dark:border-gray-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-500 overflow-hidden">
                        ${iconUrl ? 
                            `<img src="${iconUrl}" alt="${soft.name}" class="w-12 h-12 object-contain p-1">` : 
                            `<i class="fas fa-cube text-2xl text-blue-500"></i>`
                        }
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-lg font-black text-gray-900 dark:text-white truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors mb-0.5">
                            ${soft.name}
                        </h3>
                        <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest truncate">
                            ${soft.developer || 'Desconocido'}
                        </p>
                    </div>
                </div>

                <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3 leading-relaxed font-medium mb-8 flex-1">
                    ${soft.short_description || ''}
                </p>

                <div class="mt-auto pt-6 flex items-center justify-between relative z-10 border-t border-gray-50 dark:border-gray-700/50">
                    <div class="flex items-center gap-3">
                        ${isPremium ? 
                            `<span class="text-[10px] font-black text-purple-600 dark:text-purple-400 uppercase tracking-widest bg-purple-50 dark:bg-purple-900/30 px-2 py-0.5 rounded-full">PREMIUM</span>` : 
                            `<span class="text-[10px] font-black text-green-600 dark:text-green-400 uppercase tracking-widest bg-green-50 dark:bg-green-900/30 px-2 py-0.5 rounded-full">GRATIS</span>`
                        }
                    </div>
                    <span class="w-10 h-10 rounded-full bg-gray-900 dark:bg-gray-700 text-white flex items-center justify-center group-hover:bg-blue-600 group-hover:shadow-lg group-hover:shadow-blue-500/20 transition-all">
                        <i class="fas fa-chevron-right text-[10px]"></i>
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
    from { opacity: 0; }
    to { opacity: 1; }
}
.fade-in-up {
    animation: fadeInUp 0.6s ease-out forwards;
}
</style>

<?php 
$content = ob_get_clean();
include BASE_PATH . '/app/Views/layouts/main.php'; 
?>
