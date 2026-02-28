<?php include BASE_PATH . '/app/Views/layouts/main.php'; ?>

<style>
    .demo-section {
        scroll-margin-top: 100px;
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }
</style>

<!-- Navigation Sticky -->
<div class="sticky top-20 z-40 bg-white/95 backdrop-blur-lg border-b border-gray-200 shadow-sm">
    <div class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">5 Diseños Premium - Catálogo Software</h1>
            <div class="flex gap-2">
                <a href="#design1" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition">Opción 1</a>
                <a href="#design2" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition">Opción 2</a>
                <a href="#design3" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition">Opción 3</a>
                <a href="#design4" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition">Opción 4</a>
                <a href="#design5" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition">Opción 5</a>
            </div>
        </div>
    </div>
</div>

<!-- OPCIÓN 1: GRID MASONRY PREMIUM -->
<section id="design1" class="demo-section py-20 bg-gradient-to-br from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <div class="mb-12 text-center">
            <span class="inline-block px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-bold mb-4">OPCIÓN 1</span>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Grid Masonry Premium</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Diseño tipo Pinterest con tarjetas de altura variable, glassmorphism y animaciones suaves</p>
        </div>

        <!-- Filters -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-8 p-4 bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="flex flex-wrap gap-2">
                <button class="px-4 py-2 bg-gray-900 text-white rounded-xl text-sm font-medium">Todos</button>
                <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-200 transition">Productividad</button>
                <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-200 transition">Diseño</button>
                <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-200 transition">Desarrollo</button>
            </div>
            <div class="flex items-center gap-2">
                <i class="fas fa-search text-gray-400"></i>
                <input type="text" placeholder="Buscar software..." class="px-4 py-2 border-0 bg-gray-50 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
        </div>

        <!-- Masonry Grid -->
        <div class="columns-1 md:columns-2 lg:columns-3 xl:columns-4 gap-4 space-y-4">
            <?php 
            $colors = ['blue', 'purple', 'green', 'orange', 'red', 'indigo', 'pink', 'teal'];
            $colorIndex = 0;
            foreach ($software as $index => $soft): 
                $color = $colors[$colorIndex % count($colors)];
                $colorIndex++;
                $iconPath = !empty($soft['icon']) ? $soft['icon'] : $soft['image'];
                $isNew = strtotime($soft['created_at']) > strtotime('-7 days');
            ?>
            <div class="break-inside-avoid group">
                <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-<?= $color ?>-500/30 hover:-translate-y-2">
                    <?php if ($index % 3 == 1 && !empty($soft['image'])): ?>
                    <div class="mb-4">
                        <img src="<?= url($soft['image']) ?>" alt="<?= htmlspecialchars($soft['name']) ?>" class="w-full h-32 object-cover rounded-lg">
                    </div>
                    <?php endif; ?>
                    
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-<?= $color ?>-500 to-<?= $color ?>-600 rounded-xl flex items-center justify-center shadow-lg">
                            <?php if ($iconPath): ?>
                                <img src="<?= url($iconPath) ?>" alt="<?= htmlspecialchars($soft['name']) ?>" class="w-10 h-10 object-contain rounded">
                            <?php else: ?>
                                <i class="fas fa-cube text-white text-xl"></i>
                            <?php endif; ?>
                        </div>
                        <?php if ($isNew): ?>
                            <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-bold">NUEVO</span>
                        <?php elseif (!empty($soft['price']) && $soft['price'] > 0): ?>
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">PREMIUM</span>
                        <?php else: ?>
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">GRATIS</span>
                        <?php endif; ?>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-<?= $color ?>-600 transition"><?= htmlspecialchars($soft['name']) ?></h3>
                    <p class="text-sm text-gray-600 mb-4"><?= htmlspecialchars(substr($soft['short_description'] ?? $soft['description'] ?? '', 0, 100)) ?>...</p>
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                        <span class="flex items-center gap-1"><i class="fas fa-download"></i> <?= number_format($soft['downloads'] ?? 0) ?></span>
                        <span class="flex items-center gap-1"><i class="fas fa-star text-yellow-500"></i> <?= number_format($soft['rating'] ?? 4.5, 1) ?></span>
                    </div>
                    <a href="<?= url('software/' . $soft['slug']) ?>" class="block w-full py-3 bg-gray-900 text-white rounded-xl font-medium hover:bg-black transition text-center">Descargar</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- OPCIÓN 2: CARDS MINIMALISTAS CON HOVER EFFECTS -->
<section id="design2" class="demo-section py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="mb-12 text-center">
            <span class="inline-block px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-bold mb-4">OPCIÓN 2</span>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Cards Minimalistas</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Diseño limpio y espacioso con efectos de hover sofisticados y tipografía elegante</p>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="group cursor-pointer">
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-gray-50 to-white p-8 border border-gray-100 hover:border-gray-300 transition-all duration-500 hover:shadow-2xl">
                    <!-- Icon -->
                    <div class="mb-6 relative">
                        <div class="w-20 h-20 bg-white rounded-2xl shadow-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
                            <i class="fas fa-database text-3xl text-blue-600"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition">MongoDB</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">Base de datos NoSQL escalable y flexible para aplicaciones modernas.</p>
                    
                    <!-- Stats -->
                    <div class="flex items-center gap-6 text-sm text-gray-500 mb-6">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-download text-blue-500"></i>
                            <span class="font-medium">1.2M</span>
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-star text-yellow-500"></i>
                            <span class="font-medium">4.8</span>
                        </span>
                    </div>
                    
                    <!-- Button -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-900">Gratis</span>
                        <button class="px-6 py-3 bg-gray-900 text-white rounded-full font-medium hover:bg-blue-600 transition-all transform group-hover:translate-x-2">
                            Descargar <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="group cursor-pointer">
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-purple-50 to-white p-8 border border-purple-100 hover:border-purple-300 transition-all duration-500 hover:shadow-2xl">
                    <div class="mb-6 relative">
                        <div class="w-20 h-20 bg-white rounded-2xl shadow-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
                            <i class="fas fa-palette text-3xl text-purple-600"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-crown text-white text-xs"></i>
                        </div>
                    </div>
                    
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-purple-600 transition">Figma</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">Herramienta colaborativa de diseño de interfaces y prototipos.</p>
                    
                    <div class="flex items-center gap-6 text-sm text-gray-500 mb-6">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-download text-purple-500"></i>
                            <span class="font-medium">2.8M</span>
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-star text-yellow-500"></i>
                            <span class="font-medium">4.9</span>
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-purple-600">Premium</span>
                        <button class="px-6 py-3 bg-purple-600 text-white rounded-full font-medium hover:bg-purple-700 transition-all transform group-hover:translate-x-2">
                            Descargar <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="group cursor-pointer">
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-green-50 to-white p-8 border border-green-100 hover:border-green-300 transition-all duration-500 hover:shadow-2xl">
                    <div class="mb-6 relative">
                        <div class="w-20 h-20 bg-white rounded-2xl shadow-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
                            <i class="fas fa-terminal text-3xl text-green-600"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-fire text-white text-xs"></i>
                        </div>
                    </div>
                    
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition">Git</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">Sistema de control de versiones distribuido para desarrollo ágil.</p>
                    
                    <div class="flex items-center gap-6 text-sm text-gray-500 mb-6">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-download text-green-500"></i>
                            <span class="font-medium">3.5M</span>
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-star text-yellow-500"></i>
                            <span class="font-medium">5.0</span>
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-900">Gratis</span>
                        <button class="px-6 py-3 bg-gray-900 text-white rounded-full font-medium hover:bg-green-600 transition-all transform group-hover:translate-x-2">
                            Descargar <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- OPCIÓN 3: LISTA HORIZONTAL CON DETALLES -->
<section id="design3" class="demo-section py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="mb-12 text-center">
            <span class="inline-block px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-bold mb-4">OPCIÓN 3</span>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Vista de Lista Premium</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Diseño tipo tabla con información detallada y acciones rápidas</p>
        </div>

        <div class="space-y-4">
            <!-- Item 1 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-blue-500/50 group">
                <div class="flex items-center gap-6">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-chrome text-white text-2xl"></i>
                        </div>
                    </div>
                    
                    <!-- Info -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition">Google Chrome</h3>
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">GRATIS</span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">POPULAR</span>
                        </div>
                        <p class="text-gray-600 mb-3">Navegador web rápido, seguro y personalizable con sincronización en la nube.</p>
                        <div class="flex items-center gap-6 text-sm text-gray-500">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-download text-blue-500"></i>
                                <span class="font-medium">5.2M descargas</span>
                            </span>
                            <span class="flex items-center gap-2">
                                <i class="fas fa-star text-yellow-500"></i>
                                <span class="font-medium">4.8 (12.5K reseñas)</span>
                            </span>
                            <span class="flex items-center gap-2">
                                <i class="fas fa-hdd text-gray-400"></i>
                                <span class="font-medium">125 MB</span>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex-shrink-0 flex items-center gap-3">
                        <button class="w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition">
                            <i class="fas fa-heart text-gray-600"></i>
                        </button>
                        <button class="px-8 py-3 bg-gray-900 text-white rounded-xl font-medium hover:bg-blue-600 transition-all shadow-lg hover:shadow-xl">
                            Descargar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-purple-500/50 group">
                <div class="flex items-center gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-slack text-white text-2xl"></i>
                        </div>
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-purple-600 transition">Slack</h3>
                            <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold">PREMIUM</span>
                        </div>
                        <p class="text-gray-600 mb-3">Plataforma de comunicación empresarial para equipos modernos y colaborativos.</p>
                        <div class="flex items-center gap-6 text-sm text-gray-500">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-download text-purple-500"></i>
                                <span class="font-medium">1.8M descargas</span>
                            </span>
                            <span class="flex items-center gap-2">
                                <i class="fas fa-star text-yellow-500"></i>
                                <span class="font-medium">4.7 (8.2K reseñas)</span>
                            </span>
                            <span class="flex items-center gap-2">
                                <i class="fas fa-hdd text-gray-400"></i>
                                <span class="font-medium">98 MB</span>
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex-shrink-0 flex items-center gap-3">
                        <button class="w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition">
                            <i class="fas fa-heart text-gray-600"></i>
                        </button>
                        <button class="px-8 py-3 bg-purple-600 text-white rounded-xl font-medium hover:bg-purple-700 transition-all shadow-lg hover:shadow-xl">
                            Descargar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-orange-500/50 group">
                <div class="flex items-center gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-spotify text-white text-2xl"></i>
                        </div>
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-orange-600 transition">Spotify</h3>
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">GRATIS</span>
                            <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-bold">NUEVO</span>
                        </div>
                        <p class="text-gray-600 mb-3">Servicio de streaming de música con millones de canciones y podcasts.</p>
                        <div class="flex items-center gap-6 text-sm text-gray-500">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-download text-orange-500"></i>
                                <span class="font-medium">3.2M descargas</span>
                            </span>
                            <span class="flex items-center gap-2">
                                <i class="fas fa-star text-yellow-500"></i>
                                <span class="font-medium">4.9 (15.8K reseñas)</span>
                            </span>
                            <span class="flex items-center gap-2">
                                <i class="fas fa-hdd text-gray-400"></i>
                                <span class="font-medium">156 MB</span>
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex-shrink-0 flex items-center gap-3">
                        <button class="w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition">
                            <i class="fas fa-heart text-gray-600"></i>
                        </button>
                        <button class="px-8 py-3 bg-gray-900 text-white rounded-xl font-medium hover:bg-orange-600 transition-all shadow-lg hover:shadow-xl">
                            Descargar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- OPCIÓN 4: MAGAZINE STYLE -->
<section id="design4" class="demo-section py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="mb-12 text-center">
            <span class="inline-block px-4 py-2 bg-orange-100 text-orange-700 rounded-full text-sm font-bold mb-4">OPCIÓN 4</span>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Estilo Magazine</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Diseño editorial con imágenes grandes y tipografía impactante</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Featured Large Card -->
            <div class="lg:col-span-2 group cursor-pointer">
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-600 to-purple-600 h-[500px] shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    <div class="absolute inset-0 p-12 flex flex-col justify-end">
                        <span class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-bold mb-4 w-fit">DESTACADO DEL MES</span>
                        <h2 class="text-5xl font-bold text-white mb-4 group-hover:text-blue-300 transition">Adobe Creative Cloud</h2>
                        <p class="text-xl text-white/90 mb-6 max-w-2xl">Suite completa de aplicaciones creativas profesionales para diseño, video, web y fotografía.</p>
                        <div class="flex items-center gap-6 mb-6">
                            <span class="flex items-center gap-2 text-white">
                                <i class="fas fa-download"></i>
                                <span class="font-medium">2.5M descargas</span>
                            </span>
                            <span class="flex items-center gap-2 text-white">
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="font-medium">4.9 (25K reseñas)</span>
                            </span>
                        </div>
                        <button class="px-8 py-4 bg-white text-gray-900 rounded-full font-bold hover:bg-blue-500 hover:text-white transition-all w-fit shadow-2xl">
                            Explorar Suite <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Medium Card 1 -->
            <div class="group cursor-pointer">
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-green-500 to-emerald-600 h-[350px] shadow-xl">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                    <div class="absolute inset-0 p-8 flex flex-col justify-end">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center">
                                <i class="fas fa-leaf text-green-600 text-xl"></i>
                            </div>
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-white rounded-full text-xs font-bold">GRATIS</span>
                        </div>
                        <h3 class="text-3xl font-bold text-white mb-3 group-hover:text-green-300 transition">Node.js</h3>
                        <p class="text-white/90 mb-4">Entorno de ejecución JavaScript para desarrollo backend escalable.</p>
                        <button class="px-6 py-3 bg-white text-gray-900 rounded-full font-medium hover:bg-green-500 hover:text-white transition-all w-fit">
                            Descargar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Medium Card 2 -->
            <div class="group cursor-pointer">
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-red-500 to-pink-600 h-[350px] shadow-xl">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                    <div class="absolute inset-0 p-8 flex flex-col justify-end">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center">
                                <i class="fas fa-film text-red-600 text-xl"></i>
                            </div>
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-white rounded-full text-xs font-bold">PREMIUM</span>
                        </div>
                        <h3 class="text-3xl font-bold text-white mb-3 group-hover:text-pink-300 transition">Adobe Premiere Pro</h3>
                        <p class="text-white/90 mb-4">Editor de video profesional líder en la industria cinematográfica.</p>
                        <button class="px-6 py-3 bg-white text-gray-900 rounded-full font-medium hover:bg-red-500 hover:text-white transition-all w-fit">
                            Descargar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- OPCIÓN 5: DASHBOARD STYLE -->
<section id="design5" class="demo-section py-20 bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="mb-12 text-center">
            <span class="inline-block px-4 py-2 bg-blue-500/20 text-blue-400 rounded-full text-sm font-bold mb-4">OPCIÓN 5</span>
            <h2 class="text-4xl font-bold text-white mb-4">Dashboard Dark Mode</h2>
            <p class="text-gray-400 max-w-2xl mx-auto">Diseño tipo panel de control con modo oscuro y métricas visuales</p>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
            <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <i class="fas fa-download text-blue-500 text-2xl"></i>
                    <span class="text-green-500 text-sm font-bold">+12%</span>
                </div>
                <div class="text-3xl font-bold text-white mb-1">12.5M</div>
                <div class="text-gray-400 text-sm">Total Descargas</div>
            </div>
            <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <i class="fas fa-box text-purple-500 text-2xl"></i>
                    <span class="text-green-500 text-sm font-bold">+5</span>
                </div>
                <div class="text-3xl font-bold text-white mb-1">842</div>
                <div class="text-gray-400 text-sm">Programas</div>
            </div>
            <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <i class="fas fa-star text-yellow-500 text-2xl"></i>
                    <span class="text-green-500 text-sm font-bold">+0.2</span>
                </div>
                <div class="text-3xl font-bold text-white mb-1">4.8</div>
                <div class="text-gray-400 text-sm">Rating Promedio</div>
            </div>
            <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <i class="fas fa-users text-orange-500 text-2xl"></i>
                    <span class="text-green-500 text-sm font-bold">+8%</span>
                </div>
                <div class="text-3xl font-bold text-white mb-1">125K</div>
                <div class="text-gray-400 text-sm">Usuarios Activos</div>
            </div>
        </div>

        <!-- Software Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700 hover:border-blue-500/50 transition-all group">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-docker text-white text-xl"></i>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                        <span class="text-green-500 text-xs font-bold">ACTIVO</span>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-white mb-2 group-hover:text-blue-400 transition">Docker Desktop</h3>
                <p class="text-gray-400 text-sm mb-4">Plataforma de contenedores para desarrollo y despliegue de aplicaciones.</p>
                <div class="flex items-center gap-4 text-xs text-gray-500 mb-4">
                    <span class="flex items-center gap-1">
                        <i class="fas fa-download text-blue-400"></i>
                        <span>1.5M</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <i class="fas fa-star text-yellow-500"></i>
                        <span>4.7</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <i class="fas fa-hdd text-gray-400"></i>
                        <span>450 MB</span>
                    </span>
                </div>
                <button class="w-full py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                    Descargar
                </button>
            </div>

            <!-- Card 2 -->
            <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700 hover:border-purple-500/50 transition-all group">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-discord text-white text-xl"></i>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                        <span class="text-green-500 text-xs font-bold">ACTIVO</span>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-white mb-2 group-hover:text-purple-400 transition">Discord</h3>
                <p class="text-gray-400 text-sm mb-4">Plataforma de comunicación por voz, video y texto para comunidades.</p>
                <div class="flex items-center gap-4 text-xs text-gray-500 mb-4">
                    <span class="flex items-center gap-1">
                        <i class="fas fa-download text-purple-400"></i>
                        <span>3.8M</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <i class="fas fa-star text-yellow-500"></i>
                        <span>4.9</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <i class="fas fa-hdd text-gray-400"></i>
                        <span>85 MB</span>
                    </span>
                </div>
                <button class="w-full py-3 bg-purple-600 text-white rounded-xl font-medium hover:bg-purple-700 transition">
                    Descargar
                </button>
            </div>

            <!-- Card 3 -->
            <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700 hover:border-green-500/50 transition-all group">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-python text-white text-xl"></i>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                        <span class="text-green-500 text-xs font-bold">ACTIVO</span>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-white mb-2 group-hover:text-green-400 transition">Python 3.11</h3>
                <p class="text-gray-400 text-sm mb-4">Lenguaje de programación versátil para desarrollo web, IA y ciencia de datos.</p>
                <div class="flex items-center gap-4 text-xs text-gray-500 mb-4">
                    <span class="flex items-center gap-1">
                        <i class="fas fa-download text-green-400"></i>
                        <span>2.2M</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <i class="fas fa-star text-yellow-500"></i>
                        <span>5.0</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <i class="fas fa-hdd text-gray-400"></i>
                        <span>25 MB</span>
                    </span>
                </div>
                <button class="w-full py-3 bg-green-600 text-white rounded-xl font-medium hover:bg-green-700 transition">
                    Descargar
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Footer Note -->
<div class="bg-gray-100 py-12">
    <div class="container mx-auto px-4 text-center">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">¿Cuál diseño prefieres?</h3>
        <p class="text-gray-600 mb-6">Selecciona tu opción favorita y la implementaremos en tu catálogo de software</p>
        <div class="flex flex-wrap justify-center gap-4">
            <button class="px-6 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">Opción 1 - Grid Masonry</button>
            <button class="px-6 py-3 bg-purple-600 text-white rounded-xl font-medium hover:bg-purple-700 transition">Opción 2 - Cards Minimalistas</button>
            <button class="px-6 py-3 bg-green-600 text-white rounded-xl font-medium hover:bg-green-700 transition">Opción 3 - Lista Premium</button>
            <button class="px-6 py-3 bg-orange-600 text-white rounded-xl font-medium hover:bg-orange-700 transition">Opción 4 - Magazine</button>
            <button class="px-6 py-3 bg-gray-900 text-white rounded-xl font-medium hover:bg-black transition">Opción 5 - Dashboard Dark</button>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/app/Views/layouts/footer.php'; ?>
