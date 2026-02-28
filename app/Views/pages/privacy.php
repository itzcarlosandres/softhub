<?php
ob_start();
$title = 'Política de Privacidad - ' . seo_site_title();
$description = 'Política de privacidad y protección de datos de ' . seo_site_title();
?>

<div class="bg-gradient-to-br from-blue-50 to-cyan-50 py-16">
    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Política de Privacidad</h1>
        <p class="text-xl text-gray-600">Última actualización: <?= date('d/m/Y') ?></p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 py-12">
    
    <div class="prose prose-lg max-w-none">
        
        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Información que Recopilamos</h2>
            <p class="text-gray-700 mb-4">
                En <?= seo_site_title() ?>, recopilamos la siguiente información:
            </p>
            <ul class="list-disc pl-6 text-gray-700 space-y-2">
                <li><strong>Información de navegación:</strong> Dirección IP, tipo de navegador, páginas visitadas</li>
                <li><strong>Cookies:</strong> Utilizamos cookies para mejorar tu experiencia</li>
                <li><strong>Información voluntaria:</strong> Datos que proporcionas al contactarnos</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Cómo Usamos tu Información</h2>
            <p class="text-gray-700 mb-4">
                Utilizamos la información recopilada para:
            </p>
            <ul class="list-disc pl-6 text-gray-700 space-y-2">
                <li>Mejorar nuestro sitio web y servicios</li>
                <li>Analizar el uso del sitio</li>
                <li>Personalizar tu experiencia</li>
                <li>Responder a tus consultas</li>
                <li>Cumplir con obligaciones legales</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">3. Cookies</h2>
            <p class="text-gray-700">
                Utilizamos cookies para mejorar tu experiencia en nuestro sitio. Las cookies son pequeños 
                archivos de texto que se almacenan en tu dispositivo. Puedes configurar tu navegador para 
                rechazar cookies, pero esto puede afectar la funcionalidad del sitio.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Compartir Información</h2>
            <p class="text-gray-700 mb-4">
                No vendemos ni alquilamos tu información personal a terceros. Podemos compartir información en los siguientes casos:
            </p>
            <ul class="list-disc pl-6 text-gray-700 space-y-2">
                <li>Con proveedores de servicios que nos ayudan a operar el sitio</li>
                <li>Cuando sea requerido por ley</li>
                <li>Para proteger nuestros derechos legales</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Seguridad</h2>
            <p class="text-gray-700">
                Implementamos medidas de seguridad para proteger tu información. Sin embargo, ningún método 
                de transmisión por Internet es 100% seguro, y no podemos garantizar la seguridad absoluta.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Enlaces a Terceros</h2>
            <p class="text-gray-700">
                Nuestro sitio puede contener enlaces a sitios web de terceros. No somos responsables de 
                las prácticas de privacidad de estos sitios. Te recomendamos leer sus políticas de privacidad.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Tus Derechos</h2>
            <p class="text-gray-700 mb-4">
                Tienes derecho a:
            </p>
            <ul class="list-disc pl-6 text-gray-700 space-y-2">
                <li>Acceder a tu información personal</li>
                <li>Corregir información inexacta</li>
                <li>Solicitar la eliminación de tus datos</li>
                <li>Oponerte al procesamiento de tus datos</li>
                <li>Retirar tu consentimiento en cualquier momento</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Menores de Edad</h2>
            <p class="text-gray-700">
                Nuestro sitio no está dirigido a menores de 13 años. No recopilamos intencionalmente 
                información de menores de edad.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">9. Cambios a esta Política</h2>
            <p class="text-gray-700">
                Podemos actualizar esta política de privacidad periódicamente. Te notificaremos de cambios 
                significativos publicando la nueva política en esta página.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">10. Contacto</h2>
            <p class="text-gray-700">
                Si tienes preguntas sobre esta política de privacidad, contáctanos en: 
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
