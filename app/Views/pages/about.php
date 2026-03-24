<?php
ob_start();
$title = 'Acerca de Nosotros - ' . seo_site_title();
$description = 'Conoce más sobre ' . seo_site_title() . ', tu fuente confiable de descargas de software gratuito y seguro.';
?>

<div class="bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-gray-900 dark:to-gray-800 py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">Acerca de Nosotros</h1>
        <p class="text-xl text-gray-600 dark:text-gray-400">Tu fuente confiable de software</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 py-12">
    
    <!-- Nuestra Misión -->
    <section class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <i class="fas fa-bullseye text-blue-500"></i>
            Nuestra Misión
        </h2>
        <div class="prose prose-lg max-w-none dark:prose-invert">
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                En <strong><?= seo_site_title() ?></strong>, nos dedicamos a proporcionar a nuestros usuarios acceso a software de calidad, 
                seguro y actualizado. Creemos que todos merecen tener acceso a las mejores herramientas digitales 
                sin complicaciones.
            </p>
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                Nuestro equipo trabaja constantemente para mantener nuestra biblioteca actualizada con las últimas 
                versiones de software, asegurando que cada descarga sea segura y libre de malware.
            </p>
        </div>
    </section>

    <!-- Qué Ofrecemos -->
    <section class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <i class="fas fa-gift text-green-500"></i>
            Qué Ofrecemos
        </h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-gray-900 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Descargas Seguras</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-400">
                    Todos nuestros archivos son verificados y libres de virus, malware y software no deseado.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-green-100 dark:bg-gray-900 rounded-lg flex items-center justify-center">
                        <i class="fas fa-sync text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Siempre Actualizado</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-400">
                    Mantenemos nuestro catálogo actualizado con las últimas versiones de cada software.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-gray-900 rounded-lg flex items-center justify-center">
                        <i class="fas fa-bolt text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Descargas Rápidas</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-400">
                    Enlaces directos y servidores rápidos para que descargues sin esperas.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-orange-100 dark:bg-gray-900 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-orange-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Comunidad Activa</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-400">
                    Miles de usuarios confían en nosotros para sus necesidades de software.
                </p>
            </div>
        </div>
    </section>

    <!-- Nuestros Valores -->
    <section class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <i class="fas fa-heart text-red-500"></i>
            Nuestros Valores
        </h2>
        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-gray-900 dark:to-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl p-8">
            <ul class="space-y-4">
                <li class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-blue-600 text-xl mt-1"></i>
                    <div>
                        <strong class="text-gray-900 dark:text-white">Transparencia:</strong>
                        <span class="text-gray-700 dark:text-gray-300"> Información clara sobre cada software.</span>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-blue-600 text-xl mt-1"></i>
                    <div>
                        <strong class="text-gray-900 dark:text-white">Seguridad:</strong>
                        <span class="text-gray-700 dark:text-gray-300"> Protección de nuestros usuarios es nuestra prioridad.</span>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-blue-600 text-xl mt-1"></i>
                    <div>
                        <strong class="text-gray-900 dark:text-white">Calidad:</strong>
                        <span class="text-gray-700 dark:text-gray-300"> Solo el mejor software en nuestro catálogo.</span>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-blue-600 text-xl mt-1"></i>
                    <div>
                        <strong class="text-gray-900 dark:text-white">Innovación:</strong>
                        <span class="text-gray-700 dark:text-gray-300"> Mejoramos constantemente nuestra plataforma.</span>
                    </div>
                </li>
            </ul>
        </div>
    </section>

    <!-- Contacto -->
    <section class="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-md shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-700">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <i class="fas fa-envelope text-blue-500"></i>
            Contáctanos
        </h2>
        <p class="text-gray-700 dark:text-gray-300 mb-6">
            ¿Tienes alguna pregunta o sugerencia? Nos encantaría escucharte.
        </p>
        <div class="flex flex-col md:flex-row gap-4">
            <a href="mailto:contacto@<?= $_SERVER['HTTP_HOST'] ?>" 
               class="flex items-center justify-center gap-3 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                <i class="fas fa-envelope"></i>
                Enviar Email
            </a>
            <a href="<?= url() ?>" 
               class="flex items-center justify-center gap-3 px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition font-semibold">
                <i class="fas fa-home"></i>
                Volver al Inicio
            </a>
        </div>
    </section>

</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
