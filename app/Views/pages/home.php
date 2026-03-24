<?php 
ob_start(); 

?>

<!-- Hero Section (Glassmorphism & Blur) -->
<div class="hidden md:block container mx-auto px-4 pt-0 pb-12">
    <section class="relative rounded-3xl overflow-hidden bg-white dark:bg-gray-800 group transition-colors duration-300">
        
        <!-- Hero Background -->
        <div class="relative bg-white dark:bg-gray-800 min-h-[300px] md:min-h-[500px] lg:min-h-[550px] py-16 md:pb-24 md:pt-0 flex items-center justify-center overflow-hidden transition-colors duration-300 home-hero-main">
            <!-- Background Elements -->
            <div class="absolute inset-0 bg-white dark:bg-gray-800 z-0 transition-colors duration-300">
                <!-- Blobs (Subtle) -->
                <div class="absolute -top-[20%] -right-[10%] w-[600px] h-[600px] bg-blue-400/5 rounded-full blur-[120px]"></div>
                <div class="absolute -bottom-[20%] -left-[10%] w-[500px] h-[500px] bg-purple-400/5 rounded-full blur-[120px]"></div>
                
                <?php if ($heroDotsActive): ?>
                <!-- Dots Pattern -->
                <div class="absolute inset-0 z-0 opacity-[0.15] dark:opacity-30" 
                     style="background-image: radial-gradient(currentColor 1px, transparent 1px); background-size: 24px 24px;"></div>
                <?php endif; ?>

                <?php if ($heroSpotlightActive): ?>
                <!-- Spotlight Effect -->
                <div id="hero-spotlight" class="absolute inset-0 z-10 pointer-events-none transition-opacity duration-500 opacity-0 md:opacity-100"
                     style="background: radial-gradient(600px circle at 50% 50%, rgba(59, 130, 246, 0.08), transparent 80%);"></div>
                <?php endif; ?>
            </div>

            <!-- Content -->
            <div class="relative z-20 container mx-auto px-6 text-center max-w-4xl">
                <span class="inline-block py-1 px-3 rounded-full bg-blue-50 dark:bg-blue-900/30 border border-blue-100 dark:border-blue-800/50 text-blue-600 dark:text-blue-400 text-xs font-bold tracking-wide uppercase mb-6 shadow-sm">
                    <i class="fas fa-bolt mr-1"></i> Actualizado en tiempo real
                </span>
                <?php if ($heroDynamicActive): ?>
                    <div class="font-outfit text-4xl md:text-6xl font-extrabold text-gray-900 dark:text-white mb-4 leading-tight tracking-tight transition-colors flex flex-wrap items-center justify-center gap-x-2 md:gap-x-4">
                        <span class="whitespace-nowrap"><?= htmlspecialchars($heroDynamicPrefix) ?></span>
                        <div class="inline-flex items-center min-h-[1.2em]">
                            <span id="typewriter" class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400"></span>
                            <span class="typewriter-cursor text-blue-600 dark:text-blue-400 ml-1">|</span>
                        </div>
                        <span class="whitespace-nowrap"><?= htmlspecialchars($heroDynamicSuffix) ?></span>
                    </div>
                    <style>
                        .typewriter-cursor {
                            animation: blink 1s infinite;
                            margin-left: 2px;
                            font-weight: 300;
                        }
                        @keyframes blink {
                            0%, 100% { opacity: 1; }
                            50% { opacity: 0; }
                        }
                        @keyframes bounce-x {
                            0%, 100% { transform: translateX(0); }
                            50% { transform: translateX(5px); }
                        }
                        .animate-bounce-x {
                            animation: bounce-x 1s infinite;
                        }
                    </style>
                <?php elseif (!empty($heroTitleSetting)): 
                    // Parse **text** to gradient span
                    $safeTitle = htmlspecialchars($heroTitleSetting);
                    $parsedTitle = preg_replace(
                        '/\*\*(.*?)\*\*/', 
                        '<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">$1</span>', 
                        $safeTitle
                    );
                ?>
                    <h1 class="font-outfit text-4xl md:text-6xl font-extrabold text-gray-900 dark:text-white mb-4 leading-tight tracking-tight transition-colors">
                        <?= $parsedTitle ?>
                    </h1>
                <?php else: ?>
                    <h1 class="font-outfit text-4xl md:text-6xl font-extrabold text-gray-900 dark:text-white mb-4 leading-tight tracking-tight transition-colors">
                        Descubre Software <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400">Premium & Verificado</span>
                    </h1>
                <?php endif; ?>

                <?php if (!empty($heroSubtitleSetting)): ?>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto transition-colors"><?= htmlspecialchars($heroSubtitleSetting) ?></p>
                <?php endif; ?>
                
                <!-- Hero Search Bar - Simple Search -->
                <div class="max-w-2xl mx-auto mb-0 md:mb-12 relative z-50">
                    <form action="<?= url('search') ?>" method="GET" id="live-search-form" class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 dark:text-gray-500 text-lg group-focus-within:text-blue-600 dark:group-focus-within:text-blue-400 transition-colors"></i>
                        </div>
                        <input type="text" 
                               name="q"
                               id="search-input-live"
                               class="block w-full pl-14 pr-6 py-5 bg-white dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600/50 rounded-full shadow-md dark:shadow-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:ring-blue-500/40 dark:focus:border-blue-400 text-lg transition-all duration-300 hover:shadow-lg dark:hover:bg-gray-700"
                               placeholder="Busca tu software favorito..." 
                               autocomplete="off"
                               required>
                    <div id="search-loading" class="absolute inset-y-0 right-0 pr-6 flex items-center hidden">
                            <i class="fas fa-spinner fa-spin text-blue-500 dark:text-blue-400"></i>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Glass Stats Bar (Bottom) - Hidden on mobile -->
        <div class="hidden md:block absolute bottom-0 left-0 right-0 bg-white/60 dark:bg-gray-800/60 backdrop-blur-2xl border-t border-gray-200/50 dark:border-gray-700/50 p-4 md:p-6 shadow-[0_-5px_20px_rgba(0,0,0,0.02)] transition-colors duration-300">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto divide-x divide-gray-200/50 dark:divide-gray-700/50">
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white transition-colors"><?= number_format($totalSoftware) ?></div>
                    <div class="text-[10px] md:text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider flex items-center justify-center gap-1">
                        <i class="fas fa-cube text-blue-500 dark:text-blue-400"></i> Programas
                    </div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400 transition-colors"><?= $updatesToday > 0 ? '+' . $updatesToday : 'Diarias' ?></div>
                    <div class="text-[10px] md:text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider flex items-center justify-center gap-1">
                        <i class="fas fa-bolt text-yellow-500 dark:text-yellow-400"></i> Actualizaciones
                    </div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white transition-colors">100%</div>
                    <div class="text-[10px] md:text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider flex items-center justify-center gap-1">
                        <i class="fas fa-check-circle text-green-500 dark:text-green-400"></i> Verificado
                    </div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400 transition-colors">24/7</div>
                    <div class="text-[10px] md:text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider flex items-center justify-center gap-1">
                        <i class="fas fa-headset text-purple-500 dark:text-purple-400"></i> Soporte
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Main Content -->
<div class="container mx-auto px-4 py-12">
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Main Content Column -->
        <div class="lg:col-span-9">
            
            <!-- Software Destacado Slider -->
    <section class="mb-16">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 transition-colors">
                <i class="fas fa-star text-yellow-500"></i>
                Software Destacado
            </h2>
            <div class="flex gap-2">
                <button onclick="prevSlide()" class="p-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <i class="fas fa-chevron-left text-gray-600 dark:text-gray-300"></i>
                </button>
                <button onclick="nextSlide()" class="p-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <i class="fas fa-chevron-right text-gray-600 dark:text-gray-300"></i>
                </button>
            </div>
        </div>
        
        <div class="relative overflow-hidden">
            <!-- Slider Container with Native Scroll -->
            <div id="featuredSlider" class="flex transition-transform duration-500 ease-in-out">
                <?php
                // Usamos la variable inyectada $mostDownloaded como el carrusel de software destacado
                foreach ($mostDownloaded as $soft):
                ?>
                    <div class="flex-shrink-0 px-2" style="width: 20%">
                        <?php 
                        $originalShowDesc = $showDesc;
                        $originalShowDownloads = $showDownloads;
                        $originalShowPrice = $showPrice;
                        $originalShowButton = $showButton;
                        $originalShowBadges = $showBadges;
                        
                        $showDesc = false;
                        $showDownloads = false;
                        $showPrice = false;
                        $showButton = false;
                        // Evaluamos trending para el badge
                        $isTrending = in_array($soft['id'], $trendingIds);
                        
                        include __DIR__ . '/../partials/software_card.php';
                        
                        // Restaurar variables globales para el grid
                        $showDesc = $originalShowDesc;
                        $showDownloads = $originalShowDownloads;
                        $showPrice = $originalShowPrice;
                        $showButton = $originalShowButton;
                        $showBadges = $originalShowBadges;
                        ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Indicadores (solo desktop) -->
        <div class="hidden md:flex justify-center gap-2 mt-6" id="sliderIndicators">
            <!-- Se generan dinámicamente con JavaScript -->
        </div>
    </section>
    
    <script>
    let currentSlide = 0;
    const slider = document.getElementById('featuredSlider');
    const slides = slider.children;
    const totalSlides = slides.length;
    let slidesToShow = 5; // Desktop - 5 items
    
    // Responsive slides
    function updateSlidesToShow() {
        if (window.innerWidth < 768) {
            slidesToShow = 2; // Móvil: 2 items
        } else if (window.innerWidth < 1024) {
            slidesToShow = 3; // Tablet: 3 items
        } else {
            slidesToShow = 5; // Desktop: 5 items
        }
        // Actualizar el ancho de cada slide según columnas visibles
        const slideWidth = 100 / slidesToShow;
        Array.from(slides).forEach(slide => {
            slide.style.width = slideWidth + '%';
            slide.style.minWidth = slideWidth + '%';
            slide.style.flexShrink = '0';
        });
        updateSlider();
        createIndicators();
    }
    
    function updateSlider() {
        const slideWidth = 100 / slidesToShow;
        slider.style.transform = `translateX(-${currentSlide * slideWidth}%)`;
    }
    
    function nextSlide() {
        const maxSlide = Math.ceil(totalSlides / slidesToShow) - 1;
        currentSlide = (currentSlide + 1) > maxSlide ? 0 : currentSlide + 1;
        updateSlider();
        updateIndicators();
    }
    
    function prevSlide() {
        const maxSlide = Math.ceil(totalSlides / slidesToShow) - 1;
        currentSlide = (currentSlide - 1) < 0 ? maxSlide : currentSlide - 1;
        updateSlider();
        updateIndicators();
    }
    
    function goToSlide(index) {
        currentSlide = index;
        updateSlider();
        updateIndicators();
    }
    
    function createIndicators() {
        const indicatorsContainer = document.getElementById('sliderIndicators');
        indicatorsContainer.innerHTML = '';
        const numIndicators = Math.ceil(totalSlides / slidesToShow);
        
        for (let i = 0; i < numIndicators; i++) {
            const indicator = document.createElement('button');
            indicator.className = `w-2 h-2 rounded-full transition ${i === currentSlide ? 'bg-blue-600 w-8' : 'bg-gray-300 dark:bg-gray-700'}`;
            indicator.onclick = () => goToSlide(i);
            indicatorsContainer.appendChild(indicator);
        }
    }
    
    function updateIndicators() {
        const indicators = document.querySelectorAll('#sliderIndicators button');
        indicators.forEach((indicator, index) => {
            if (index === currentSlide) {
                indicator.className = 'w-8 h-2 rounded-full transition bg-blue-600';
            } else {
                indicator.className = 'w-2 h-2 rounded-full transition bg-gray-300 dark:bg-gray-700';
            }
        });
    }
    
    // Auto-play
    let autoplayInterval = setInterval(nextSlide, 5000);
    
    // Pausar en hover
    slider.addEventListener('mouseenter', () => {
        clearInterval(autoplayInterval);
    });
    
    slider.addEventListener('mouseleave', () => {
        autoplayInterval = setInterval(nextSlide, 5000);
    });
    
    // Soporte Táctil (Swipe)
    let touchStartX = 0;
    let touchEndX = 0;
    
    slider.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
        clearInterval(autoplayInterval); // Pausar autoplay al tocar
    }, { passive: true });
    
    slider.addEventListener('touchmove', (e) => {
        touchEndX = e.changedTouches[0].screenX;
    }, { passive: true });
    
    slider.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
        autoplayInterval = setInterval(nextSlide, 5000); // Reanudar autoplay
    });
    
    function handleSwipe() {
        if (touchStartX === 0 || touchEndX === 0) return;
        
        const swipeDistance = touchStartX - touchEndX;
        const minSwipeDistance = 50; // Umbral en píxeles
        
        if (Math.abs(swipeDistance) > minSwipeDistance) {
            if (swipeDistance > 0) {
                // Swipe Izquierda -> Siguiente
                nextSlide();
            } else {
                // Swipe Derecha -> Anterior
                prevSlide();
            }
        }
        
        // Reset valores
        touchStartX = 0;
        touchEndX = 0;
    }
    
    // Responsive
    window.addEventListener('resize', updateSlidesToShow);
    
    // Inicializar
    updateSlidesToShow();
    </script>
    
    <!-- Últimos agregados -->
    <section class="mb-16">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 transition-colors">
                <i class="fas fa-clock text-blue-500"></i>
                Últimos agregados
            </h2>
            <a href="<?= url('software') ?>" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold flex items-center gap-2 group">
                Ver todos
                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
        
        <!-- Grid de Software - Cards Minimalistas -->
        <div id="latest-software-grid" class="grid grid-cols-<?= $colsMobile ?> md:grid-cols-<?= $colsTablet ?> lg:grid-cols-<?= $colsDesktop ?> gap-6 relative transition-opacity duration-300">
            <?php 
            if (!empty($latest)): 
                $colors = ['blue', 'purple', 'green', 'orange', 'red', 'indigo', 'pink', 'teal'];
                $colorIndex = 0;
                
                foreach ($latest as $soft): 
                    $color = $colors[$colorIndex % count($colors)];
                    $colorIndex++;
                    $isTrending = in_array($soft['id'], $trendingIds);
                    
                    include __DIR__ . '/../partials/software_card.php';
                endforeach; 
            else: 
            ?>
                <div class="col-span-full text-center py-20">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-inbox text-gray-300 text-5xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No hay software disponible</h3>
                    <p class="text-gray-500 text-lg">Vuelve pronto para ver nuevos programas</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
        </div>
        <!-- End Main Content Column -->
        
        <!-- Sidebar - Clean Minimal White Design -->
        <aside class="lg:col-span-3">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-lg dark:shadow-gray-900/50 sticky top-24 transition-colors">
                <!-- Header -->
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2 transition-colors">
                        <i class="fas fa-chart-line text-blue-500"></i>
                        TOP 10
                    </h2>
                    <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-md font-bold">LIVE</span>
                </div>
                
                <!-- List -->
                <div class="space-y-2">
                    <?php 
                    // Ordenar por descargas (mayor a menor)
                    $topDownloads = !empty($mostDownloaded) ? $mostDownloaded : [];
                    usort($topDownloads, function($a, $b) {
                        return ($b['downloads'] ?? 0) - ($a['downloads'] ?? 0);
                    });
                    $topDownloads = array_slice($topDownloads, 0, 10);
                    
                    $position = 1;
                    foreach ($topDownloads as $soft): 
                        // Colores del badge de posición
                        if ($position == 1) {
                            $badgeBg = 'bg-yellow-400';
                            $badgeText = 'text-gray-900';
                            $badgeShape = 'rounded-md';
                        } elseif ($position == 2) {
                            $badgeBg = 'bg-gray-200';
                            $badgeText = 'text-gray-700';
                            $badgeShape = 'rounded-md';
                        } elseif ($position == 3) {
                            $badgeBg = 'bg-orange-100';
                            $badgeText = 'text-orange-600';
                            $badgeShape = 'rounded-md';
                        } else {
                            $badgeBg = 'bg-gray-100';
                            $badgeText = 'text-gray-600';
                            $badgeShape = 'rounded-md';
                        }
                    ?>
                    <a href="<?= url('software/' . htmlspecialchars($soft['slug'])) ?>" 
                       class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700/50 rounded-lg p-3 hover:border-blue-500 dark:hover:border-blue-500 hover:shadow-md transition-all duration-300 cursor-pointer flex items-center gap-3 group">
                        
                        <!-- Position Badge -->
                        <span class="w-6 h-6 <?= $badgeBg ?> <?= $badgeShape ?> flex items-center justify-center text-xs font-bold <?= $badgeText ?> flex-shrink-0">
                            <?= $position ?>
                        </span>
                        
                        <!-- Icon -->
                        <div class="w-10 h-10 bg-gray-50 dark:bg-gray-700 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                            <?php if (!empty($soft['icon'])): ?>
                                <img src="<?= url(htmlspecialchars($soft['icon'])) ?>" 
                                     alt="<?= htmlspecialchars($soft['name']) ?>" 
                                     loading="lazy"
                                     decoding="async"
                                     class="w-full h-full object-contain p-1">
                            <?php else: ?>
                                <i class="fas fa-download text-gray-300 dark:text-gray-500 text-xl"></i>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Info -->
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white truncate transition">
                                <?= htmlspecialchars($soft['name']) ?>
                            </h3>
                            <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-download text-green-500"></i> 
                                    <span class="text-gray-700 dark:text-gray-300"><?= number_format($soft['downloads']) ?></span>
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <span class="text-gray-700 dark:text-gray-300"><?= number_format($soft['rating'] ?? 4.5, 1) ?></span>
                                </span>
                            </div>
                        </div>
                    </a>
                    <?php 
                    $position++;
                    endforeach; 
                    ?>
                </div>
                
                <!-- Footer -->
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700/50">
                    <p class="text-xs text-center text-gray-400 dark:text-gray-500 font-semibold">Actualizado en tiempo real</p>
                </div>
            </div>
        </aside>
        <!-- End Sidebar -->
        
    </div>
    <!-- End Grid -->
    
    <!-- Trust Section Removed -->
    
</div>


    
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Grid filtering removed
    
<?php if ($heroDynamicActive): ?>
    // Typewriter Effect
    const typewriterElement = document.getElementById('typewriter');
    if (typewriterElement) {
        const words = "<?= addslashes($heroDynamicText) ?>".split(',').map(w => w.trim());
        let wordIndex = 0;
        let charIndex = 0;
        let isDeleting = false;
        let typeSpeed = 100;

        function type() {
            const currentWord = words[wordIndex % words.length];
            
            if (isDeleting) {
                typewriterElement.textContent = currentWord.substring(0, charIndex - 1);
                charIndex--;
                typeSpeed = 50;
            } else {
                typewriterElement.textContent = currentWord.substring(0, charIndex + 1);
                charIndex++;
                typeSpeed = 150;
            }

            if (!isDeleting && charIndex === currentWord.length) {
                isDeleting = true;
                typeSpeed = 2000; // Pause at end
            } else if (isDeleting && charIndex === 0) {
                isDeleting = false;
                wordIndex++;
                typeSpeed = 500; // Pause before next word
            }

            setTimeout(type, typeSpeed);
        }

        if (words.length > 0) {
            type();
        }
    }
<?php endif; ?>

<?php if ($heroSpotlightActive): ?>
    // Spotlight Effect Tracking
    const heroMain = document.querySelector('.home-hero-main');
    const spotlight = document.getElementById('hero-spotlight');
    
    if (heroMain && spotlight) {
        heroMain.addEventListener('mousemove', (e) => {
            const rect = heroMain.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            spotlight.style.background = `radial-gradient(600px circle at ${x}px ${y}px, rgba(59, 130, 246, 0.12), transparent 80%)`;
        });
        
        heroMain.addEventListener('mouseleave', () => {
            spotlight.style.background = `radial-gradient(600px circle at 50% 50%, rgba(59, 130, 246, 0.08), transparent 80%)`;
        });
    }
<?php endif; ?>
});
</script>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>