<?php
ob_start();
$title = 'Política de Cookies - ' . seo_site_title();
$description = 'Política de uso de cookies en ' . seo_site_title();
?>

<div class="bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-gray-900 dark:to-gray-800 py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">Política de Cookies</h1>
        <p class="text-xl text-gray-600 dark:text-gray-400">Última actualización: <?= date('d/m/Y') ?></p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 py-12">
    
    <div class="prose prose-lg max-w-none dark:prose-invert">
        
        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">1. ¿Qué son las Cookies?</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-4">
                Una cookie es un pequeño archivo de texto que un sitio web guarda en tu ordenador o dispositivo móvil cuando visitas el sitio. Las cookies se utilizan ampliamente con el fin de hacer que los sitios web funcionen, o funcionen de manera más eficiente, así como para proporcionar información a los propietarios del sitio.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">2. ¿Cómo utilizamos las cookies?</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-4">
                En <strong><?= seo_site_title() ?></strong> utilizamos cookies propias y de terceros para diversos fines, incluyendo:
            </p>
            <ul class="list-disc pl-6 text-gray-700 dark:text-gray-300 space-y-2">
                <li>Mantener tu sesión activa y mejorar la seguridad.</li>
                <li>Recordar tus preferencias (por ejemplo, el modo oscuro o el idioma).</li>
                <li>Analizar cómo interactúas con nuestra web para mejorar el rendimiento y los servicios.</li>
                <li>Proporcionar contenido o anuncios más relevantes, de ser el caso.</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">3. Tipos de Cookies que empleamos</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-4">
                Dependiendo de su propósito, utilizamos los siguientes tipos:
            </p>
            <ul class="list-disc pl-6 text-gray-700 dark:text-gray-300 space-y-2">
                <li><strong>Cookies Estrictamente Necesarias:</strong> Esenciales para proveer los servicios que has solicitado en la plataforma.</li>
                <li><strong>Cookies de Rendimiento y Análisis:</strong> Nos permiten contabilizar visitas y fuentes de tráfico para poder evaluar el rendimiento del sitio.</li>
                <li><strong>Cookies Funcionales:</strong> Ayudan a recordar la configuración de tu interfaz.</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">4. Controlar y Eliminar Cookies</h2>
            <p class="text-gray-700 dark:text-gray-300">
                Puedes controlar o eliminar las cookies siempre que lo desees. Las puedes eliminar todas en tu equipo y puedes configurar la mayoría de navegadores para que no se instalen. Si lo haces, sin embargo, tendrás que ajustar manualmente algunas preferencias cada vez que visites un sitio web, y algunos servicios pueden dejar de funcionar correctamente.
            </p>
            <p class="text-gray-700 dark:text-gray-300 mt-2">
                Para obtener más información sobre cómo gestionar y eliminar cookies en los diferentes navegadores, puedes visitar el menú de "Ayuda" del navegador correspondiente.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">5. Enlaces Externos</h2>
            <p class="text-gray-700 dark:text-gray-300">
                Nuestra web puede contener hipervínculos a otros sitios de terceros con sus propias políticas de privacidad y de uso de cookies. No asumimos responsabilidad alguna sobre el contenido o las políticas de otros sitios.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">6. Datos de Contacto</h2>
            <p class="text-gray-700 dark:text-gray-300">
                Si tienes alguna pregunta acerca de nuestra Política de Cookies, por favor contáctanos enviando un correo a:
                <a href="mailto:privacidad@<?= $_SERVER['HTTP_HOST'] ?>" class="text-blue-600 hover:underline">
                    privacidad@<?= $_SERVER['HTTP_HOST'] ?>
                </a>
            </p>
        </section>

    </div>

    <div class="mt-12 text-center">
        <a href="<?= url() ?>" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver al Inicio
        </a>
    </div>

</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
