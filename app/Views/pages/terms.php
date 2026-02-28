<?php
ob_start();
$title = 'Términos y Condiciones - ' . seo_site_title();
$description = 'Términos y condiciones de uso de ' . seo_site_title();
?>

<div class="bg-gradient-to-br from-blue-50 to-cyan-50 py-16">
    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Términos y Condiciones</h1>
        <p class="text-xl text-gray-600">Última actualización: <?= date('d/m/Y') ?></p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 py-12">
    
    <div class="prose prose-lg max-w-none">
        
        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Aceptación de los Términos</h2>
            <p class="text-gray-700">
                Al acceder y utilizar <?= seo_site_title() ?>, aceptas cumplir con estos términos y condiciones. 
                Si no estás de acuerdo con alguna parte de estos términos, no debes usar nuestro sitio web.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Uso del Servicio</h2>
            <p class="text-gray-700 mb-4">
                <?= seo_site_title() ?> proporciona enlaces y información sobre software disponible públicamente. 
                Te comprometes a:
            </p>
            <ul class="list-disc pl-6 text-gray-700 space-y-2">
                <li>Usar el sitio solo para fines legales</li>
                <li>No intentar acceder a áreas restringidas del sitio</li>
                <li>No distribuir malware o contenido dañino</li>
                <li>Respetar los derechos de propiedad intelectual</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">3. Descargas de Software</h2>
            <p class="text-gray-700">
                El software disponible en nuestro sitio es proporcionado por terceros. No somos responsables de:
            </p>
            <ul class="list-disc pl-6 text-gray-700 space-y-2 mt-4">
                <li>La funcionalidad del software descargado</li>
                <li>Daños causados por el uso del software</li>
                <li>Licencias y términos de uso del software de terceros</li>
                <li>Actualizaciones o soporte técnico del software</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Propiedad Intelectual</h2>
            <p class="text-gray-700">
                Todo el contenido de <?= seo_site_title() ?>, incluyendo texto, gráficos, logos y código, 
                está protegido por derechos de autor. No puedes reproducir, distribuir o modificar nuestro 
                contenido sin autorización expresa.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Limitación de Responsabilidad</h2>
            <p class="text-gray-700">
                <?= seo_site_title() ?> se proporciona "tal cual" sin garantías de ningún tipo. No nos hacemos 
                responsables de daños directos, indirectos, incidentales o consecuentes que resulten del uso 
                o la imposibilidad de usar nuestro servicio.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Enlaces a Terceros</h2>
            <p class="text-gray-700">
                Nuestro sitio puede contener enlaces a sitios web de terceros. No somos responsables del 
                contenido, políticas de privacidad o prácticas de estos sitios externos.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Modificaciones</h2>
            <p class="text-gray-700">
                Nos reservamos el derecho de modificar estos términos en cualquier momento. Los cambios 
                entrarán en vigor inmediatamente después de su publicación en el sitio.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Contacto</h2>
            <p class="text-gray-700">
                Si tienes preguntas sobre estos términos, contáctanos en: 
                <a href="mailto:contacto@<?= $_SERVER['HTTP_HOST'] ?>" class="text-blue-600 hover:underline">
                    contacto@<?= $_SERVER['HTTP_HOST'] ?>
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
