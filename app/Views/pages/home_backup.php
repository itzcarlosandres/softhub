<?php 
ob_start(); 
$title = 'SoftHub - Descarga Software Gratis y Seguro';
$description = 'Descarga software gratis y seguro. Miles de programas para Windows, Mac, Linux, Android e iOS. Antivirus, navegadores, editores, juegos y más.';
?>

<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-50 to-cyan-50 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold text-gray-900 mb-4">
                Descarga software <span class="text-blue-500">seguro y actualizado</span>
            </h1>
            <p class="text-xl text-gray-600 mb-8">
                Encuentra programas, apps y herramientas verificadas.
            </p>
            
            <!-- Trust Badges -->
            <div class="flex justify-center items-center gap-8 text-gray-700">
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span>Analizado</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span>Seguro</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span>Actualizado</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="container mx-auto px-4 py-12">
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Main Content Column -->
        <div class="lg:col-span-9">
            
            <!-- Software Destacado Slider -->
    <section class="mb-16">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <i class="fas fa-star text-yellow-500"></i>
                Software Destacado
            </h2>
            <div class="flex gap-2">
                <button onclick="prevSlide()" class="p-2 rounded-lg bg-white border border-gray-200 hover:bg-gray-50 transition">
                    <i class="fas fa-chevron-left text-gray-600"></i>
                </button>
                <button onclick="nextSlide()" class="p-2 rounded-lg bg-white border border-gray-200 hover:bg-gray-50 transition">
                    <i class="fas fa-chevron-right text-gray-600"></i>
                </button>
            </div>
        </div>
        
        <div class="relative overflow-hidden">
            <div id="featuredSlider" class="flex transition-transform duration-500 ease-in-out">
                <?php
                // MODO AUTOMÁTICO: Obtener los 10 software más descargados
                $db = \App\Database::getInstance()->getConnection();
                $stmt = $db->query("
                    SELECT * FROM software 
                    WHERE status = 'approved'
                    ORDER BY downloads DESC 
                    LIMIT 10
                ");
                $featuredSoftware = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($featuredSoftware as $soft):
                ?>
                    <div class="min-w-full md:min-w-[20%] px-2">
                        <a href="<?= url('software/' . htmlspecialchars($soft['slug'])) ?>" 
                           class="block bg-white rounded-lg p-4 hover:shadow-lg transition-all duration-300 border border-gray-100 hover:border-blue-300 group">
                            
                            <!-- Icono -->
                            <div class="flex justify-center mb-3">
                                <?php if (!empty($soft['icon'])): ?>
                                    <img src="<?= url($soft['icon']) ?>" 
                                         alt="<?= htmlspecialchars($soft['name']) ?>"
                                         loading="lazy"
                                         decoding="async"
                                         width="64"
                                         height="64"
                                         class="w-16 h-16 object-contain group-hover:scale-110 transition-transform duration-300">
                                <?php else: ?>
                                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-box text-white text-2xl"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Nombre -->
                            <h3 class="font-semibold text-gray-900 text-center text-sm mb-2 line-clamp-1 group-hover:text-blue-600 transition">
                                <?= htmlspecialchars($soft['name']) ?>
                            </h3>
                            
                            <!-- Rating -->
                            <div class="flex items-center justify-center gap-1">
                                <?php
                                $rating = round($soft['rating'] ?? 0);
                                for ($i = 1; $i <= 5; $i++):
                                ?>
                                    <i class="fas fa-star <?= $i <= $rating ? 'text-yellow-400' : 'text-gray-300' ?> text-xs"></i>
                                <?php endfor; ?>
                            </div>
                        </a>
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
            indicator.className = `w-2 h-2 rounded-full transition ${i === currentSlide ? 'bg-blue-600 w-8' : 'bg-gray-300'}`;
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
                indicator.className = 'w-2 h-2 rounded-full transition bg-gray-300';
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
    
    // Responsive
    window.addEventListener('resize', updateSlidesToShow);
    
    // Inicializar
    updateSlidesToShow();
    </script>
    
    <!-- Últimos Agregados -->
    <section class="mb-16">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <i class="fas fa-clock text-blue-500"></i>
                Últimos agregados
            </h2>
        </div>
        
        <?php if (($latestLayout ?? 'grid') === 'grid'): ?>
            <!-- Grid Layout Dinámico Optimizado -->
            <div class="grid gap-3 sm:gap-4 dynamic-grid">
                <style>
                    /* Móvil (Default) */
                    .dynamic-grid {
                        grid-template-columns: repeat(<?= $gridColsSm ?? 2 ?>, minmax(0, 1fr)) !important;
                    }
                    /* Tablet */
                    @media (min-width: 768px) {
                        .dynamic-grid {
                            grid-template-columns: repeat(<?= $gridColsMd ?? 4 ?>, minmax(0, 1fr)) !important;
                        }
                    }
                    /* Escritorio */
                    @media (min-width: 1024px) {
                        .dynamic-grid {
                            grid-template-columns: repeat(<?= $gridCols ?? 8 ?>, minmax(0, 1fr)) !important;
                        }
                    }
                </style>
                <?php if (!empty($latest)): ?>
                    <?php foreach ($latest as $soft): ?>
                        <?php
                        $licenseColors = ['free' => 'bg-green-100 text-green-700', 'paid' => 'bg-orange-100 text-orange-700', 'trial' => 'bg-blue-100 text-blue-700', 'freemium' => 'bg-purple-100 text-purple-700'];
                        $licenseLabels = ['free' => 'Gratis', 'paid' => 'Pago', 'trial' => 'Prueba', 'freemium' => 'Freemium'];
                        $license = $soft['license'] ?? 'free';
                        $licenseColor = $licenseColors[$license] ?? $licenseColors['free'];
                        $licenseLabel = $licenseLabels[$license] ?? $licenseLabels['free'];
                        ?>
                        <a href="<?= url('software/' . htmlspecialchars($soft['slug'])) ?>" class="bg-white border border-gray-100 rounded-xl p-2.5 sm:p-4 hover:shadow-xl transition-all duration-300 group relative flex flex-col items-center text-center h-full">
                            <!-- Badge de Licencia -->
                            <div class="absolute top-1.5 right-1.5 z-10">
                                <span class="text-[9px] sm:text-[10px] px-1.5 py-0.5 <?= $licenseColor ?> rounded-full font-bold shadow-sm whitespace-nowrap">
                                    <?= $licenseLabel ?>
                                </span>
                            </div>
                            
                            <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gray-50 rounded-xl mb-2 sm:mb-3 overflow-hidden flex items-center justify-center group-hover:scale-110 transition-transform duration-300 relative">
                                <?php if (!empty($soft['icon'])): ?>
                                    <img src="<?= url(htmlspecialchars($soft['icon'])) ?>" 
                                         alt="<?= htmlspecialchars($soft['name']) ?>" 
                                         loading="lazy"
                                         decoding="async"
                                         class="w-full h-full object-contain p-1.5 sm:p-2">
                                <?php else: ?>
                                    <i class="fas fa-download text-gray-300 text-xl sm:text-2xl"></i>
                                <?php endif; ?>

                                <!-- Badges sobre el icono -->
                                <div class="absolute bottom-0 left-0 right-0 flex justify-center pb-0.5 sm:pb-1 transform scale-75 sm:scale-100">
                                    <?= render_badges($soft, 'static') ?>
                                </div>
                            </div>
                            
                            <h3 class="font-bold text-[11px] sm:text-sm text-gray-900 line-clamp-1 mb-1 group-hover:text-blue-600 transition">
                                <?= htmlspecialchars($soft['name']) ?>
                            </h3>
                            
                            <div class="flex items-center gap-1 text-[9px] sm:text-[10px] text-gray-500 mt-auto">
                                <div class="flex items-center gap-0.5">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <span class="font-bold text-gray-700"><?= number_format($soft['rating'] ?? 4.5, 1) ?></span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <!-- List Layout Optimizado -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                <?php if (!empty($latest)): ?>
                    <?php foreach ($latest as $soft): ?>
                        <?php
                        $licenseColors = ['free' => 'bg-green-100 text-green-700', 'paid' => 'bg-orange-100 text-orange-700', 'trial' => 'bg-blue-100 text-blue-700', 'freemium' => 'bg-purple-100 text-purple-700'];
                        $licenseLabels = ['free' => 'Gratis', 'paid' => 'Pago', 'trial' => 'Prueba', 'freemium' => 'Freemium'];
                        $license = $soft['license'] ?? 'free';
                        $licenseColor = $licenseColors[$license] ?? $licenseColors['free'];
                        $licenseLabel = $licenseLabels[$license] ?? $licenseLabels['free'];
                        ?>
                        <a href="<?= url('software/' . htmlspecialchars($soft['slug'])) ?>" class="bg-white border border-gray-100 rounded-xl p-3 sm:p-4 hover:shadow-md transition-all duration-300 group flex items-start gap-3 sm:gap-4 h-full">
                            <div class="w-14 h-14 sm:w-20 sm:h-20 flex-shrink-0 bg-gray-50 rounded-xl overflow-hidden flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                                <?php if (!empty($soft['icon'])): ?>
                                    <img src="<?= url(htmlspecialchars($soft['icon'])) ?>" 
                                         alt="<?= htmlspecialchars($soft['name']) ?>" 
                                         loading="lazy"
                                         decoding="async"
                                         class="w-full h-full object-contain p-1.5 sm:p-2">
                                <?php else: ?>
                                    <i class="fas fa-download text-gray-300 text-2xl sm:text-3xl"></i>
                                <?php endif; ?>
                            </div>
                            
                            <div class="flex-1 min-w-0 flex flex-col h-full">
                                <div class="flex justify-between items-start mb-0.5 sm:mb-1 gap-2">
                                    <h3 class="font-bold text-xs sm:text-base text-gray-900 group-hover:text-blue-600 transition truncate">
                                        <?= htmlspecialchars($soft['name']) ?>
                                    </h3>
                                    <span class="text-[8px] sm:text-[10px] px-1.5 sm:px-2 py-0.5 <?= $licenseColor ?> rounded-full font-bold shadow-sm whitespace-nowrap">
                                        <?= $licenseLabel ?>
                                    </span>
                                </div>
                                
                                <p class="text-[10px] sm:text-xs text-gray-500 line-clamp-1 mb-2 italic">
                                    <?= htmlspecialchars($soft['short_description'] ?? 'Descarga la última versión de este software.') ?>
                                </p>
                                
                                <div class="flex items-center justify-between mt-auto">
                                    <div class="flex items-center gap-2 sm:gap-3 text-[9px] sm:text-xs text-gray-400">
                                        <div class="flex items-center gap-0.5 sm:gap-1">
                                            <i class="fas fa-star text-yellow-400"></i>
                                            <span class="text-gray-600 font-semibold"><?= number_format($soft['rating'] ?? 4.5, 1) ?></span>
                                        </div>
                                        <div class="flex items-center gap-0.5 sm:gap-1">
                                            <i class="fas fa-download text-green-500"></i>
                                            <span><?= number_format($soft['downloads'] ?? 0) ?></span>
                                        </div>
                                        <div class="hidden sm:flex items-center gap-1">
                                            <i class="fas fa-tag"></i>
                                            <span><?= $soft['version'] ?? 'LATEST' ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex gap-1 transform scale-[0.7] sm:scale-90 origin-right">
                                        <?= render_badges($soft, 'static') ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </section>
    
        </div>
        <!-- End Main Content Column -->
        
        <!-- Sidebar -->
        <aside class="lg:col-span-3">
            <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden sticky top-24">
                <div class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white p-4 relative">
                    <h3 class="text-xl font-bold flex items-center">
                        <i class="fas fa-fire mr-2"></i>
                        TOP 10 Descargados
                    </h3>
                    <!-- HOT Badge -->
                    <div class="absolute top-2 right-2">
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full animate-pulse">
                            HOT
                        </span>
                    </div>
                </div>
                
                <div class="divide-y divide-gray-100">
                    <?php 
                    // Ordenar por descargas (mayor a menor)
                    $topDownloads = !empty($mostDownloaded) ? $mostDownloaded : [];
                    usort($topDownloads, function($a, $b) {
                        return ($b['downloads'] ?? 0) - ($a['downloads'] ?? 0);
                    });
                    $topDownloads = array_slice($topDownloads, 0, 10);
                    
                    $position = 1;
                    foreach ($topDownloads as $soft): 
                        // Colores especiales para top 3
                        if ($position == 1) {
                            $bgColor = 'bg-gradient-to-br from-yellow-100 to-orange-100';
                            $borderColor = 'border-l-4 border-yellow-500';
                            $badgeColor = 'bg-gradient-to-br from-yellow-400 to-orange-500 text-white';
                        } elseif ($position == 2) {
                            $bgColor = 'bg-gradient-to-br from-gray-100 to-gray-200';
                            $borderColor = 'border-l-4 border-gray-400';
                            $badgeColor = 'bg-gradient-to-br from-gray-300 to-gray-400 text-white';
                        } elseif ($position == 3) {
                            $bgColor = 'bg-gradient-to-br from-orange-100 to-red-100';
                            $borderColor = 'border-l-4 border-orange-600';
                            $badgeColor = 'bg-gradient-to-br from-orange-400 to-orange-600 text-white';
                        } else {
                            $bgColor = '';
                            $borderColor = '';
                            $badgeColor = 'bg-gray-100 text-gray-600';
                        }
                    ?>
                    <a href="<?= url('software/' . htmlspecialchars($soft['slug'])) ?>" 
                       class="flex items-center gap-3 p-3 hover:bg-blue-50 transition <?= $bgColor ?> <?= $borderColor ?>">
                        <!-- Position Badge -->
                        <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm <?= $badgeColor ?>">
                            <?= $position ?>
                        </div>
                        
                        <!-- Icon -->
                        <div class="w-10 h-10 flex-shrink-0">
                            <?php if (!empty($soft['icon'])): ?>
                                <img src="<?= url(htmlspecialchars($soft['icon'])) ?>" 
                                     alt="<?= htmlspecialchars($soft['name']) ?>" 
                                     loading="lazy"
                                     decoding="async"
                                     width="40"
                                     height="40"
                                     class="w-full h-full object-contain">
                            <?php else: ?>
                                <div class="w-full h-full bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-download text-gray-400"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Info -->
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-sm text-gray-900 truncate"><?= htmlspecialchars($soft['name']) ?></h4>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <span><i class="fas fa-download text-green-600"></i> <?= number_format($soft['downloads']) ?></span>
                                <span class="flex items-center">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <?= number_format($soft['rating'] ?? 4.5, 1) ?>
                                </span>
                            </div>
                        </div>
                    </a>
                    <?php 
                    $position++;
                    endforeach; 
                    ?>
                </div>
            </div>
        </aside>
        <!-- End Sidebar -->
        
    </div>
    <!-- End Grid -->
    
    <!-- Trust Section -->
    <section class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-2xl p-12 text-center mt-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Descarga segura y confiable</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
            <div class="flex flex-col items-center">
                <div class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-shield-alt text-white text-3xl"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">Software Analizado</h3>
                <p class="text-gray-600 text-sm">Software Probado</p>
            </div>
            
            <div class="flex flex-col items-center">
                <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-check-circle text-white text-3xl"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">Libre de Virus</h3>
                <p class="text-gray-600 text-sm">Descarga Segura</p>
            </div>
            
            <div class="flex flex-col items-center">
                <div class="w-20 h-20 bg-cyan-500 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-download text-white text-3xl"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">Descarga Segura</h3>
                <p class="text-gray-600 text-sm">Rápida y Confiable</p>
            </div>
        </div>
    </section>
    
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>