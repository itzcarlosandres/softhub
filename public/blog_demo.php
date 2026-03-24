<?php
session_start();
define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/app/EnvLoader.php';
EnvLoader::load(BASE_PATH);

require_once BASE_PATH . '/app/helpers.php';
require_once BASE_PATH . '/app/Database.php';

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = BASE_PATH . '/app/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) require $file;
});

$title = "Blog y Noticias - SoftHub";
$description = "Descubre los mejores tutoriales, noticias y guías sobre software en nuestro blog gratuito.";
$keywords = "blog, noticias, software, tutoriales, tech";

ob_start();
?>

<!-- Héroe del Blog -->
<section class="relative pt-24 pb-16 overflow-hidden bg-white dark:bg-gray-900 transition-colors duration-300">
    <div class="absolute inset-0 bg-blue-50/50 dark:bg-gray-800/20"></div>
    <div class="absolute top-0 right-[-10%] w-96 h-96 bg-blue-400/10 dark:bg-blue-600/10 rounded-full blur-[100px] pointer-events-none"></div>
    
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white tracking-tight mb-6 transition-colors">
                Descubre lo Mejor del Software
            </h1>
            <p class="text-lg text-gray-500 dark:text-gray-400 mb-8 font-medium">
                Tutoriales, noticias exclusivas, comparativas y los mejores trucos para llevar tu Productividad y Rendimiento al máximo nivel.
            </p>
            
            <!-- Buscador del Blog -->
            <div class="max-w-xl mx-auto relative group">
                <input type="text" placeholder="¿Qué tema estás buscando? Ej: Windows 11, Antivirus..." 
                       class="w-full bg-white dark:bg-gray-800 border-2 border-gray-100 dark:border-gray-700 rounded-full py-4 pl-6 pr-14 text-gray-700 dark:text-gray-300 focus:outline-none focus:border-blue-500 dark:focus:border-blue-500 shadow-xl shadow-black/5 transition-all outline-none">
                <button class="absolute right-2 top-2 bg-blue-600 hover:bg-blue-700 text-white w-10 h-10 rounded-full flex items-center justify-center transition-transform hover:scale-105">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Categorías -->
<section class="py-6 border-y border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50 transition-colors">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-nowrap overflow-x-auto gap-4 scrollbar-hide pb-2" style="scrollbar-width: none;">
            <a href="#" class="px-5 py-2 whitespace-nowrap bg-blue-600 text-white rounded-full font-bold text-sm shadow-lg shadow-blue-500/20"><i class="fas fa-fire mr-1"></i> Todo</a>
            <a href="#" class="px-5 py-2 whitespace-nowrap bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:border-blue-500 transition-all rounded-full font-medium text-sm">Noticias Tech</a>
            <a href="#" class="px-5 py-2 whitespace-nowrap bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:border-blue-500 transition-all rounded-full font-medium text-sm">Tutoriales</a>
            <a href="#" class="px-5 py-2 whitespace-nowrap bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:border-blue-500 transition-all rounded-full font-medium text-sm">Comparativas</a>
            <a href="#" class="px-5 py-2 whitespace-nowrap bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:border-blue-500 transition-all rounded-full font-medium text-sm">Updates & Parches</a>
            <a href="#" class="px-5 py-2 whitespace-nowrap bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:border-blue-500 transition-all rounded-full font-medium text-sm">Ciberseguridad</a>
        </div>
    </div>
</section>

<!-- Content Grid -->
<section class="py-16 bg-white dark:bg-gray-900 transition-colors">
    <div class="max-w-7xl mx-auto px-6">
        
        <!-- Post Destacado (Feature) -->
        <div class="mb-16">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                <i class="fas fa-star text-yellow-400"></i> Artículo Destacado
            </h2>
            <div class="group cursor-pointer rounded-3xl overflow-hidden bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 shadow-xl shadow-gray-200/50 dark:shadow-none hover:border-blue-500 dark:hover:border-blue-500 transition-all grid grid-cols-1 lg:grid-cols-2">
                <div class="relative h-64 lg:h-full overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Cybersecurity" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                    <div class="absolute top-4 left-4">
                        <span class="bg-blue-600 text-white text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-lg shadow-lg">Ciberseguridad</span>
                    </div>
                </div>
                <div class="p-8 lg:p-12 flex flex-col justify-center">
                    <div class="flex items-center gap-4 text-xs font-bold text-gray-500 mb-4 uppercase tracking-widest">
                        <span><i class="far fa-calendar mr-1"></i> Oct 24, 2025</span>
                        <span class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                        <span><i class="far fa-clock mr-1"></i> 5 min lect.</span>
                    </div>
                    <h3 class="text-2xl lg:text-4xl font-black text-gray-900 dark:text-white mb-4 leading-tight group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                        Cómo Proteger tu PC en 2025: Las Mejores Herramientas Gratuitas que Necesitas Hoy
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 text-base leading-relaxed mb-8">
                        No necesitas pagar suscripciones costosas para blindar tus datos personales. Hemos armado la lista defintiva con software gratuito open-source que protegerá tus archivos de cualquier Ransomware actual.
                    </p>
                    <div class="flex items-center justify-between mt-auto pt-6 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                AD
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Admin Carlos</h4>
                                <p class="text-xs text-gray-500">Editor en Jefe</p>
                            </div>
                        </div>
                        <a href="#" class="text-blue-600 hover:text-blue-700 font-bold text-sm flex items-center gap-2 group-hover:translate-x-1 transition-transform">
                            Leer Artículo <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Posts Grid -->
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Últimas Publicaciones</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Post Card 1 -->
            <article class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-500 shadow-xl shadow-gray-200/50 dark:shadow-none transition-all group cursor-pointer flex flex-col hover:-translate-y-1">
                <div class="relative h-48 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                    <div class="absolute top-3 left-3 bg-white/90 dark:bg-black/90 backdrop-blur-sm text-gray-900 dark:text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-md shadow-sm">
                        Tutoriales
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 leading-snug group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                        Guía Completa para Optimizar Windows 11 sin Programas Externos
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm line-clamp-2 mb-6">
                        Windows 11 puede consumir demasiados recursos en segundo plano si no sabes dónde mirar. Aquí te mostramos qué servicios desactivar.
                    </p>
                    <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between text-xs text-gray-500 font-medium">
                        <span class="flex items-center gap-1.5"><i class="far fa-calendar text-gray-400"></i> Hace 2 días</span>
                        <span class="flex items-center gap-1.5"><i class="far fa-heart text-gray-400"></i> 124 Likes</span>
                    </div>
                </div>
            </article>

            <!-- Post Card 2 -->
            <article class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-purple-500 dark:hover:border-purple-500 shadow-xl shadow-gray-200/50 dark:shadow-none transition-all group cursor-pointer flex flex-col hover:-translate-y-1">
                <div class="relative h-48 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                    <div class="absolute top-3 left-3 bg-white/90 dark:bg-black/90 backdrop-blur-sm text-gray-900 dark:text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-md shadow-sm">
                        Comparativas
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 leading-snug group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                        Adobe Premiere vs DaVinci Resolve: ¿Cuál editor elegir este año?
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm line-clamp-2 mb-6">
                        Encaramos a los dos gigantes de la edición de video. Ventajas, desventajas y por qué la versión gratuita de DaVinci podría ser tu mejor opción.
                    </p>
                    <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between text-xs text-gray-500 font-medium">
                        <span class="flex items-center gap-1.5"><i class="far fa-calendar text-gray-400"></i> Oct 21, 2025</span>
                        <span class="flex items-center gap-1.5"><i class="far fa-heart text-gray-400"></i> 89 Likes</span>
                    </div>
                </div>
            </article>

            <!-- Post Card 3 -->
            <article class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-green-500 dark:hover:border-green-500 shadow-xl shadow-gray-200/50 dark:shadow-none transition-all group cursor-pointer flex flex-col hover:-translate-y-1">
                <div class="relative h-48 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                    <div class="absolute top-3 left-3 bg-white/90 dark:bg-black/90 backdrop-blur-sm text-gray-900 dark:text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-md shadow-sm">
                        Noticias
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 leading-snug group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                        CCleaner Responde a las Acusaciones: Su última actualización incluye...
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm line-clamp-2 mb-6">
                        Tras las múltiples quejas de la comunidad respecto al telemetría, Avast libera un comunicado oficial sobre su programa de limpieza.
                    </p>
                    <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between text-xs text-gray-500 font-medium">
                        <span class="flex items-center gap-1.5"><i class="far fa-calendar text-gray-400"></i> Oct 19, 2025</span>
                        <span class="flex items-center gap-1.5"><i class="far fa-heart text-gray-400"></i> 340 Likes</span>
                    </div>
                </div>
            </article>

        </div>

        <!-- Load More -->
        <div class="text-center mt-16">
            <button class="px-8 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-bold rounded-full hover:border-blue-500 hover:text-blue-600 dark:hover:border-blue-500 transition-all shadow-sm">
                Cargar Más Entradas <i class="fas fa-redo-alt ml-2 text-xs"></i>
            </button>
        </div>
        
    </div>
</section>

<!-- Newsletter / Call to Action -->
<section class="py-20 relative overflow-hidden bg-gradient-to-br from-blue-600 to-indigo-700 text-white">
    <div class="absolute top-0 right-0 w-full h-full overflow-hidden opacity-20 pointer-events-none">
        <div class="absolute w-96 h-96 bg-white rounded-full blur-[100px] -top-20 -right-20"></div>
        <div class="absolute w-64 h-64 bg-purple-400 rounded-full blur-[80px] bottom-10 left-10"></div>
    </div>
    
    <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
        <h2 class="text-3xl md:text-5xl font-black mb-6">No te pierdas ninguna novedad</h2>
        <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
            Únete a nuestra lista de correo y recibe en tu bandeja las mejores herramientas gratuitas, alertas de actualizaciones y guías exclusivas.
        </p>
        <div class="bg-white/10 backdrop-blur-md border border-white/20 p-2 rounded-full flex mx-auto max-w-lg shadow-xl">
            <input type="email" placeholder="Tu correo electrónico..." class="flex-1 bg-transparent border-none px-6 text-white placeholder-blue-200 focus:outline-none">
            <button class="bg-white text-blue-700 font-bold px-6 py-3 rounded-full hover:bg-gray-100 hover:scale-105 transition-all">
                Suscribirme
            </button>
        </div>
        <p class="text-xs text-blue-200 mt-4 opacity-70"><i class="fas fa-lock mr-1"></i> Garantizamos 0% Spam. Date de baja cuando quieras.</p>
    </div>
</section>

<?php
$content = ob_get_clean();
// require_once normal (sin variables extra ya que en layouts/main solo pide $content)
require __DIR__ . '/../app/Views/layouts/main.php';
?>
