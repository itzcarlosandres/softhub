<?php 
ob_start(); 

?>

<!-- Premium Custom Hero Section -->
<style>
  .hero-section-custom {
    position: relative;
    width: 100%;
    height: 480px;
    background-color: #1e3a8a; /* Blue 900 */
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* Vector Shapes with CSS */
  .shape-green {
    position: absolute; top: -50%; left: -20%; width: 60%; height: 200%;
    background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%); /* Blue 700 to 500 */
    transform: rotate(20deg); box-shadow: 10px 0 50px rgba(0,0,0,0.3);
    z-index: 1; transition: transform 0.1s ease-out;
  }

  .shape-dark-blue {
    position: absolute; bottom: -40%; left: -10%; width: 50%; height: 80%;
    background: #172554; /* Blue 950 */
    transform: rotate(-12deg); border-radius: 60px;
    box-shadow: 0 -10px 30px rgba(0,0,0,0.2); z-index: 2; transition: transform 0.1s ease-out;
  }

  .shape-wave-right {
    position: absolute; bottom: -60%; right: -20%; width: 70%; height: 150%;
    background: #2563eb; /* Blue 600 */
    border-radius: 50%; transform: rotate(-35deg); z-index: 1;
    transition: transform 0.1s ease-out;
  }

  .shape-gradient-right {
    position: absolute; top: 0; right: 0; width: 40%; height: 100%;
    background: linear-gradient(90deg, transparent 0%, #1e3a8a 100%); z-index: 2;
  }

  /* Content Overlay */
  .content-wrapper-custom {
    position: relative; z-index: 10; width: 100%; max-width: 900px; padding: 0 40px;
    display: flex; flex-direction: column; align-items: flex-start;
  }

  .hero-title-custom {
    color: #ffffff !important; font-size: 3.2rem; font-weight: 700; line-height: 1.25;
    letter-spacing: -0.5px; margin-bottom: 40px; text-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    font-family: 'Montserrat', sans-serif;
  }
  
  .typewriter-cursor {
    animation: blink 1s infinite;
    margin-left: 2px;
    font-weight: 300;
  }
  @keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0; }
  }

  /* Search Bar */
  .search-wrapper-custom { width: 100%; max-width: 820px; }
  .search-box-custom {
    display: flex; align-items: center; background-color: #ffffff;
    padding: 12px 20px 12px 24px; border-radius: 6px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
  }
  .search-input-custom {
    flex: 1; border: none; outline: none; font-size: 1.1rem; font-family: inherit;
    color: #333; background: transparent; width: 100%;
  }
  .search-input-custom::placeholder { color: #929ba3; font-weight: 500; }
  .search-button-custom {
    background: transparent; border: none; cursor: pointer; color: #55626a;
    display: flex; align-items: center; justify-content: center; padding: 4px;
    transition: color 0.2s ease, transform 0.2s ease;
  }
  .search-button-custom:hover { color: #1a567c; transform: scale(1.1); }

  .dark .search-box-custom { background-color: #1f2937; box-shadow: 0 10px 30px rgba(0,0,0,0.4); }
  .dark .search-input-custom { color: #ffffff; }
  .dark .search-input-custom::placeholder { color: #9ca3af; }
  .dark .search-button-custom { color: #9ca3af; }
  .dark .search-button-custom:hover { color: #60a5fa; }

  @media (max-width: 768px) {
    .hero-title-custom { font-size: 2.2rem; margin-bottom: 30px; }
    .shape-green { width: 80%; left: -30%; }
    .content-wrapper-custom { padding: 0 20px; }
    .search-box-custom { padding: 8px 16px 8px 20px; }
    .hero-section-custom { height: 400px; }
  }
</style>

<div class="hidden md:block w-full pt-0 pb-12">
    <section class="hero-section-custom shadow-xl">
        <!-- Background Shapes -->
        <div class="shape-green"></div>
        <div class="shape-dark-blue"></div>
        <div class="shape-wave-right"></div>
        <div class="shape-gradient-right"></div>

        <!-- Content -->
        <div class="content-wrapper-custom">
            
            <?php if (!empty($heroSubtitleSetting)): ?>
                <span class="inline-block py-1 px-3 rounded-full bg-white/10 border border-white/20 text-white text-xs font-bold tracking-wide uppercase mb-6 shadow-sm">
                    <i class="fas fa-bolt mr-1"></i> <?= htmlspecialchars($heroSubtitleSetting) ?>
                </span>
            <?php else: ?>
                <span class="inline-block py-1 px-3 rounded-full bg-white/10 border border-white/20 text-white text-xs font-bold tracking-wide uppercase mb-6 shadow-sm">
                    <i class="fas fa-bolt mr-1"></i> <?= __('updated_real_time', 'Actualizado en tiempo real') ?>
                </span>
            <?php endif; ?>

            <?php if ($heroDynamicActive): ?>
                <h1 class="hero-title-custom flex flex-wrap items-center gap-2">
                    <span class="whitespace-nowrap"><?= htmlspecialchars($heroDynamicPrefix) ?></span>
                    <span class="inline-flex items-center">
                        <span id="typewriter" class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400"></span><span class="typewriter-cursor text-white">|</span>
                    </span>
                    <span class="whitespace-nowrap"><?= htmlspecialchars($heroDynamicSuffix) ?></span>
                </h1>
            <?php elseif (!empty($heroTitleSetting)): 
                $safeTitle = htmlspecialchars($heroTitleSetting);
                $parsedTitle = preg_replace(
                    '/\*\*(.*?)\*\*/', 
                    '<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">$1</span>', 
                    $safeTitle
                );
            ?>
                <h1 class="hero-title-custom"><?= $parsedTitle ?></h1>
            <?php else: ?>
                <h1 class="hero-title-custom">
                    <?= __('hero_default_title', 'Tus mejores Aplicaciones<br>en un solo lugar') ?><span class="typewriter-cursor text-white">|</span>
                </h1>
            <?php endif; ?>
            
            <!-- Search Bar -->
            <div class="search-wrapper-custom relative z-50">
                <form action="<?= url('search') ?>" method="GET" id="live-search-form" class="relative group">
                    <div class="search-box-custom relative">
                        <input type="text" 
                               name="q"
                               id="search-input-live"
                               class="search-input-custom"
                               placeholder="<?= __('search_placeholder', '¿Qué quieres buscar?') ?>" 
                               autocomplete="off"
                               required>
                        <button type="submit" class="search-button-custom" aria-label="<?= __('search_button', 'Buscar') ?>">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                        <div id="search-loading" class="absolute inset-y-0 right-14 pr-2 flex items-center hidden">
                            <i class="fas fa-spinner fa-spin text-blue-500"></i>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Glass Stats Bar (Bottom) - Retained -->
        <div class="absolute bottom-0 left-0 right-0 bg-white/10 dark:bg-gray-900/40 backdrop-blur-xl border-t border-white/10 p-4 md:p-6 shadow-lg transition-colors duration-300 z-20">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto divide-x divide-white/20">
                <div class="text-center">
                    <div class="text-2xl font-bold text-white"><?= number_format($totalSoftware) ?></div>
                    <div class="text-[10px] md:text-xs text-white/80 font-bold uppercase tracking-wider flex items-center justify-center gap-1">
                        <i class="fas fa-cube text-blue-400"></i> <?= __('programs', 'Programas') ?>
                    </div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-400"><?= $updatesToday > 0 ? '+' . $updatesToday : __('diarias', 'Diarias') ?></div>
                    <div class="text-[10px] md:text-xs text-white/80 font-bold uppercase tracking-wider flex items-center justify-center gap-1">
                        <i class="fas fa-bolt text-purple-400"></i> <?= __('updates', 'Actualizaciones') ?>
                    </div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">100%</div>
                    <div class="text-[10px] md:text-xs text-white/80 font-bold uppercase tracking-wider flex items-center justify-center gap-1">
                        <i class="fas fa-check-circle text-blue-300"></i> <?= __('verified', 'Verificado') ?>
                    </div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-400">24/7</div>
                    <div class="text-[10px] md:text-xs text-white/80 font-bold uppercase tracking-wider flex items-center justify-center gap-1">
                        <i class="fas fa-headset text-blue-400"></i> <?= __('support', 'Soporte') ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const heroSection = document.querySelector('.hero-section-custom');
  if (heroSection) {
    const greenShape = document.querySelector('.shape-green');
    const darkBlueShape = document.querySelector('.shape-dark-blue');
    const rightWave = document.querySelector('.shape-wave-right');

    let mouseX = 0;
    let mouseY = 0;
    let rafId = null;

    heroSection.addEventListener('mousemove', (e) => {
      const rect = heroSection.getBoundingClientRect();
      mouseX = (e.clientX - rect.left) / rect.width - 0.5;
      mouseY = (e.clientY - rect.top) / rect.height - 0.5;

      if (!rafId) {
        rafId = requestAnimationFrame(() => {
          if(greenShape) greenShape.style.transform = `rotate(20deg) translate(${mouseX * -40}px, ${mouseY * -40}px)`;
          if(darkBlueShape) darkBlueShape.style.transform = `rotate(-12deg) translate(${mouseX * 25}px, ${mouseY * 25}px)`;
          if(rightWave) rightWave.style.transform = `rotate(-35deg) translate(${mouseX * -20}px, ${mouseY * -20}px)`;
          rafId = null;
        });
      }
    });
  }
});
</script>

<!-- Main Content -->
<div class="container mx-auto px-4 py-12">
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Main Content Column -->
        <div class="lg:col-span-9">
            
            <!-- Software Destacado Slider -->
    <!-- Software Destacado Slider (Option 3 Design) -->
    <section class="mb-16">
        <div class="mb-8 relative z-10">
            <div class="flex items-center gap-6">
                <h2 class="text-xl font-extrabold text-gray-900 dark:text-white whitespace-nowrap flex items-center gap-2">
                    <i class="fas fa-star text-pink-500 text-lg"></i>
                    <?= __('featured_software', 'Software Destacado') ?>
                </h2>
                <div class="h-px w-full bg-gradient-to-r from-pink-500/50 to-transparent"></div>
            </div>
        </div>
        
        <!-- Swiper Container -->
        <div class="swiper featured-swiper w-full px-1 py-4">
            <div class="swiper-wrapper">
                <?php
                $neonClasses = [
                    ['border' => 'hover:border-pink-500/50 hover:shadow-[0_0_15px_rgba(236,72,153,0.15)]', 'iconBg' => 'group-hover:bg-pink-500'],
                    ['border' => 'hover:border-cyan-500/50 hover:shadow-[0_0_15px_rgba(6,182,212,0.15)]', 'iconBg' => 'group-hover:bg-cyan-500'],
                    ['border' => 'hover:border-yellow-500/50 hover:shadow-[0_0_15px_rgba(234,179,8,0.15)]', 'iconBg' => 'group-hover:bg-yellow-500'],
                    ['border' => 'hover:border-purple-500/50 hover:shadow-[0_0_15px_rgba(168,85,247,0.15)]', 'iconBg' => 'group-hover:bg-purple-500'],
                    ['border' => 'hover:border-emerald-500/50 hover:shadow-[0_0_15px_rgba(16,185,129,0.15)]', 'iconBg' => 'group-hover:bg-emerald-500']
                ];
                $neonIndex = 0;
                
                foreach ($featured as $soft): 
                    $neonClass = $neonClasses[$neonIndex % count($neonClasses)];
                    $neonIndex++;
                ?>
                <!-- Slide Item -->
                <div class="swiper-slide cursor-pointer h-auto">
                    <a href="<?= url('software/' . htmlspecialchars($soft['slug'])) ?>" class="flex h-full items-center gap-4 bg-white dark:bg-[#14161b] border border-gray-200 dark:border-gray-800 p-3 rounded-2xl <?= $neonClass['border'] ?> transition-all duration-300 group">
                        
                        <?php if (!empty($soft['icon'])): ?>
                            <img src="<?= url(htmlspecialchars($soft['icon'])) ?>" class="w-14 h-14 rounded-xl object-contain bg-gray-50 dark:bg-black/50 p-1 shrink-0 shadow-sm" alt="<?= htmlspecialchars($soft['name']) ?>">
                        <?php else: ?>
                            <div class="w-14 h-14 rounded-xl bg-gray-50 dark:bg-gray-800 flex items-center justify-center shrink-0">
                                <i class="fas fa-cube text-gray-400 text-xl"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="flex-1 min-w-0 pr-2">
                            <h3 class="font-bold text-gray-900 dark:text-white text-sm truncate"><?= htmlspecialchars($soft['name']) ?></h3>
                            <p class="text-gray-500 text-[11px] truncate flex items-center gap-1 mt-0.5">
                                <?php if (!empty($soft['category_name'])): ?>
                                    <i class="fas fa-folder text-gray-400"></i> <?= htmlspecialchars(__($soft['category_name'], $soft['category_name'])) ?>
                                <?php endif; ?>
                                <?php if (!empty($soft['version'])): ?>
                                    • v<?= htmlspecialchars($soft['version']) ?>
                                <?php endif; ?>
                            </p>
                        </div>
                        
                        <div class="shrink-0 w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center <?= $neonClass['iconBg'] ?> group-hover:text-white transition-colors">
                            <i class="fas fa-arrow-right text-xs text-gray-400 group-hover:text-white transition-colors"></i>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Swiper CSS/JS Inclusions -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const swiper = new Swiper('.featured-swiper', {
            slidesPerView: 1.15, // Mobile: shows 1 card and a bit of the next
            spaceBetween: 12,
            grabCursor: true,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },
            breakpoints: {
                480: { slidesPerView: 1.3, spaceBetween: 12 },
                640: { slidesPerView: 2.1, spaceBetween: 16 },
                768: { slidesPerView: 2.5, spaceBetween: 16 },
                1024: { slidesPerView: 3, spaceBetween: 16 }
            }
        });
    });
    </script>

    
    <!-- Últimos agregados -->
    <section class="mb-16">
        <div class="mb-10 relative z-10">
            <div class="flex items-center gap-6">
                <h2 class="text-xl font-extrabold text-gray-900 dark:text-white whitespace-nowrap flex items-center gap-2">
                    <i class="fas fa-clock text-blue-500 text-lg"></i>
                    <?= __('latest_added', 'Últimos agregados') ?>
                </h2>
                <div class="h-px w-full bg-gradient-to-r from-blue-500/50 to-transparent"></div>
                <a href="<?= url('software') ?>" class="w-10 h-10 rounded-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:border-blue-500 transition flex items-center justify-center shadow-sm flex-shrink-0 group" title="<?= __('view_all', 'Ver todos') ?>">
                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-blue-500 transition-colors text-xs"></i>
                </a>
            </div>
        </div>
        
        <!-- Dynamic View of Software - Grid or List -->
        <div id="latest-software-grid" class="<?= $latestLayout == 'list' ? 'flex flex-col gap-4' : 'grid grid-cols-' . $colsMobile . ' md:grid-cols-' . $colsTablet . ' lg:grid-cols-' . $colsDesktop . ' gap-6' ?> relative transition-opacity duration-300">
            <?php 
            if (!empty($latest)): 
                $colors = ['blue', 'purple', 'green', 'orange', 'red', 'indigo', 'pink', 'teal'];
                $colorIndex = 0;
                
                foreach ($latest as $soft): 
                    $color = $colors[$colorIndex % count($colors)];
                    $colorIndex++;
                    $isTrending = in_array($soft['id'], $trendingIds);
                    
                    if ($latestLayout == 'list') {
                        include __DIR__ . '/../partials/software_list_item.php';
                    } else {
                        include __DIR__ . '/../partials/software_card.php';
                    }
                endforeach; 
            else: 
            ?>
                <div class="col-span-full text-center py-20">
                    <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-inbox text-gray-300 text-5xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2"><?= __('no_software_available', 'No hay software disponible') ?></h3>
                    <p class="text-gray-500 text-lg"><?= __('come_back_soon', 'Vuelve pronto para ver nuevos programas') ?></p>
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
                        <?= __('top_10', 'TOP 10') ?>
                    </h2>
                    <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-md font-bold"><?= __('live', 'LIVE') ?></span>
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
                    <p class="text-xs text-center text-gray-400 dark:text-gray-500 font-semibold"><?= __('updated_real_time', 'Actualizado en tiempo real') ?></p>
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