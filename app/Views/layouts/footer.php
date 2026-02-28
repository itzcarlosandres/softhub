    <!-- Footer - Bento Grid Style -->
    <footer class="bg-gray-50 dark:bg-gray-900 pt-20 pb-12 mt-auto border-t border-gray-100 dark:border-gray-800 transition-colors duration-300">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-8">
                
                <!-- Box 1: Brand & CTA (Large) -->
                <div class="md:col-span-12 lg:col-span-5 bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100 dark:border-gray-700 flex flex-col justify-between overflow-hidden relative group transition-colors">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-full blur-3xl opacity-50 -mr-16 -mt-16 pointer-events-none transition-colors"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-gray-900 dark:bg-gray-700 text-white rounded-2xl flex items-center justify-center text-xl shadow-lg shadow-gray-900/20 dark:shadow-none transition-colors">
                                <i class="fas fa-cube"></i>
                            </div>
                            <span class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white transition-colors">SoftHub<span class="text-blue-600 dark:text-blue-400">.</span></span>
                        </div>
                        <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mb-3 leading-tight transition-colors">
                            Tu centro de software premium.
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-8 leading-relaxed max-w-sm transition-colors">
                            Descarga, actualiza y gestiona tus herramientas digitales favoritas desde una sola plataforma segura y verificada.
                        </p>
                    </div>
                    
                    <div class="flex flex-wrap gap-3 relative z-10">
                        <a href="<?= url('software') ?>" class="inline-flex items-center gap-2 bg-gray-900 dark:bg-blue-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-gray-800 dark:hover:bg-blue-700 transition-all duration-300 shadow-lg shadow-gray-900/10 hover:shadow-gray-900/20 hover:-translate-y-0.5">
                            <span>Explorar Software</span>
                            <i class="fas fa-arrow-right text-sm"></i>
                        </a>
                        <a href="<?= url('about') ?>" class="inline-flex items-center gap-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 px-6 py-3 rounded-xl font-medium hover:bg-gray-50 dark:hover:bg-gray-600 hover:border-gray-300 transition-all duration-300">
                            <span>Conócenos</span>
                        </a>
                    </div>
                </div>

                <!-- Box 2: Quick Links (Medium) -->
                <div class="md:col-span-6 lg:col-span-4 bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100 dark:border-gray-700 flex flex-col transition-colors">
                    <h4 class="font-bold text-gray-900 dark:text-white mb-6 text-lg flex items-center gap-2 transition-colors">
                        <i class="fas fa-compass text-blue-500 dark:text-blue-400"></i> Navegación Rápida
                    </h4>
                    <ul class="space-y-1 flex-1">
                        <li>
                            <a href="<?= url('latest') ?>" class="flex items-center justify-between p-3 rounded-xl hover:bg-blue-50 dark:hover:bg-gray-700/50 group transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs group-hover:scale-110 transition-transform">
                                        <i class="fas fa-bolt"></i>
                                    </span>
                                    <span class="font-medium text-gray-600 dark:text-gray-300 group-hover:text-blue-700 dark:group-hover:text-blue-400 transition-colors">Novedades</span>
                                </div>
                                <i class="fas fa-chevron-right text-gray-300 dark:text-gray-600 group-hover:text-blue-400 text-xs transition-colors"></i>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('popular') ?>" class="flex items-center justify-between p-3 rounded-xl hover:bg-purple-50 dark:hover:bg-gray-700/50 group transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xs group-hover:scale-110 transition-transform">
                                        <i class="fas fa-fire"></i>
                                    </span>
                                    <span class="font-medium text-gray-600 dark:text-gray-300 group-hover:text-purple-700 dark:group-hover:text-purple-400 transition-colors">Más Populares</span>
                                </div>
                                <i class="fas fa-chevron-right text-gray-300 dark:text-gray-600 group-hover:text-purple-400 text-xs transition-colors"></i>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('categories') ?>" class="flex items-center justify-between p-3 rounded-xl hover:bg-green-50 dark:hover:bg-gray-700/50 group transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 flex items-center justify-center text-xs group-hover:scale-110 transition-transform">
                                        <i class="fas fa-th-large"></i>
                                    </span>
                                    <span class="font-medium text-gray-600 dark:text-gray-300 group-hover:text-green-700 dark:group-hover:text-green-400 transition-colors">Categorías</span>
                                </div>
                                <i class="fas fa-chevron-right text-gray-300 dark:text-gray-600 group-hover:text-green-400 text-xs transition-colors"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Box 3: Social & Community (Medium Vertical) -->
                <div class="md:col-span-6 lg:col-span-3 bg-gray-900 backdrop-blur-xl border border-gray-800 p-8 rounded-3xl shadow-2xl text-white flex flex-col justify-between relative overflow-hidden group">
                    <!-- Blur Effects & Gradients -->
                    <div class="absolute top-0 right-0 w-40 h-40 bg-blue-600 rounded-full blur-[60px] opacity-30 -mr-10 -mt-10 transition-all duration-700 group-hover:opacity-50"></div>
                    <div class="absolute bottom-0 left-0 w-40 h-40 bg-purple-600 rounded-full blur-[60px] opacity-20 -ml-10 -mb-10 transition-all duration-700 group-hover:opacity-40"></div>
                    
                    <div class="relative z-10">
                        <h4 class="font-bold text-xl mb-2">Comunidad</h4>
                        <p class="text-gray-400 text-sm mb-6">Únete a más de 50k usuarios.</p>
                        
                        <div class="flex flex-col gap-3">
                            <?php 
                            $settingsModel = new \App\Models\SiteSetting();
                            $discord = $settingsModel->get('social_discord', '#');
                            $twitter = $settingsModel->get('social_twitter', '#');
                            $instagram = $settingsModel->get('social_instagram', '#');
                            $facebook = $settingsModel->get('social_facebook', '#');
                            ?>
                            
                            <?php if($discord !== '#'): ?>
                            <a href="<?= htmlspecialchars($discord) ?>" target="_blank" class="flex items-center gap-3 bg-white/5 hover:bg-white/10 p-3 rounded-xl backdrop-blur-md transition-all border border-white/5 hover:border-white/20 group/item">
                                <span class="w-8 h-8 rounded-lg bg-[#5865F2]/20 flex items-center justify-center text-[#5865F2] group-hover/item:bg-[#5865F2] group-hover/item:text-white transition-all">
                                    <i class="fab fa-discord text-sm"></i>
                                </span>
                                <span class="font-medium text-sm text-gray-300 group-hover/item:text-white">Discord Server</span>
                            </a>
                            <?php endif; ?>

                            <?php if($twitter !== '#'): ?>
                            <a href="<?= htmlspecialchars($twitter) ?>" target="_blank" class="flex items-center gap-3 bg-white/5 hover:bg-white/10 p-3 rounded-xl backdrop-blur-md transition-all border border-white/5 hover:border-white/20 group/item">
                                <span class="w-8 h-8 rounded-lg bg-sky-500/20 flex items-center justify-center text-sky-500 group-hover/item:bg-sky-500 group-hover/item:text-white transition-all">
                                    <i class="fab fa-twitter text-sm"></i>
                                </span>
                                <span class="font-medium text-sm text-gray-300 group-hover/item:text-white">Twitter / X</span>
                            </a>
                            <?php endif; ?>

                            <?php if($instagram !== '#'): ?>
                            <a href="<?= htmlspecialchars($instagram) ?>" target="_blank" class="flex items-center gap-3 bg-white/5 hover:bg-white/10 p-3 rounded-xl backdrop-blur-md transition-all border border-white/5 hover:border-white/20 group/item">
                                <span class="w-8 h-8 rounded-lg bg-pink-500/20 flex items-center justify-center text-pink-500 group-hover/item:bg-pink-500 group-hover/item:text-white transition-all">
                                    <i class="fab fa-instagram text-sm"></i>
                                </span>
                                <span class="font-medium text-sm text-gray-300 group-hover/item:text-white">Instagram</span>
                            </a>
                            <?php endif; ?>

                            <?php if($facebook !== '#'): ?>
                            <a href="<?= htmlspecialchars($facebook) ?>" target="_blank" class="flex items-center gap-3 bg-white/5 hover:bg-white/10 p-3 rounded-xl backdrop-blur-md transition-all border border-white/5 hover:border-white/20 group/item">
                                <span class="w-8 h-8 rounded-lg bg-blue-600/20 flex items-center justify-center text-blue-600 group-hover/item:bg-blue-600 group-hover/item:text-white transition-all">
                                    <i class="fab fa-facebook-f text-sm"></i>
                                </span>
                                <span class="font-medium text-sm text-gray-300 group-hover/item:text-white">Facebook</span>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Box 4: Legal & Info (Full Width Strip) -->
                <div class="md:col-span-12 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-4 text-sm transition-colors">
                    <div class="flex items-center gap-6 text-gray-500 dark:text-gray-400 transition-colors">
                        <a href="<?= url('privacy') ?>" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Privacidad</a>
                        <a href="<?= url('terms') ?>" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Términos</a>
                        <a href="<?= url('cookies') ?>" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Cookies</a>
                        <a href="<?= url('contact') ?>" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Contacto</a>
                    </div>
                    <div class="text-gray-400 dark:text-gray-500 transition-colors">
                        &copy; <?= date('Y') ?> SoftHub Inc. Diseñado con <i class="fas fa-heart text-red-400 dark:text-red-500 mx-1 animate-pulse"></i> por el equipo.
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- PWA Install Button (Hidden by default) -->
    <button id="install-pwa-button" 
            style="display: none;"
            class="fixed bottom-6 right-6 bg-gray-900 text-white px-6 py-3 rounded-full shadow-2xl hover:shadow-3xl transition-all duration-300 flex items-center gap-3 z-50 hover:-translate-y-1 hover:bg-black border border-gray-800">
        <i class="fas fa-download text-lg"></i>
        <span class="font-semibold">Instalar App</span>
    </button>
    
    <!-- PWA Script -->
    <script src="<?= url('assets/js/pwa.js') ?>"></script>
    
    <!-- Lazy Loading Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lazy loading para todas las imágenes con data-src
        const images = document.querySelectorAll('img[data-src]');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.add('loaded');
                        img.removeAttribute('data-src');
                        observer.unobserve(img);
                    }
                });
            }, {
                rootMargin: '50px'
            });
            
            images.forEach(img => imageObserver.observe(img));
        } else {
            // Fallback para navegadores antiguos
            images.forEach(img => {
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
            });
        }
    });
    </script>
    
    <style>
    img[data-src] {
        opacity: 0;
        transition: opacity 0.3s ease;
        background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }

    img[data-src].loaded {
        opacity: 1;
        animation: none;
    }
    
    @keyframes shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
    </style>
</body>
</html>
