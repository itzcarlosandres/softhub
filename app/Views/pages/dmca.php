<?php
ob_start();
$title = 'Reclamaciones de Derechos de Autor (DMCA) - ' . seo_site_title();
$description = 'Política de DMCA y protección de derechos de autor de ' . seo_site_title();
?>

<div class="bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-gray-900 dark:to-gray-800 py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">Política DMCA</h1>
        <p class="text-xl text-gray-600 dark:text-gray-400">Digital Millennium Copyright Act</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 py-12">
    
    <div class="prose prose-lg max-w-none dark:prose-invert">
        
        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Derechos de Autor</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-4">
                <strong><?= seo_site_title() ?></strong> respeta la propiedad intelectual de otros, y requerimos que nuestros usuarios hagan lo mismo. De acuerdo con la <strong>Digital Millennium Copyright Act (DMCA)</strong> u otras leyes aplicables, actuaremos inmediatamente ante avisos claros de supuestas infracciones de derechos de autor que se reporten a nuestro Agente de Copyright designado.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Aviso de Infracción (Takedown Notice)</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-4">
                Si cree, de buena fe, que algún material proporcionado o a través de nuestro sitio web infringe sus derechos de autor, usted (o su agente autorizado) puede enviarnos una solicitud pidiendo que eliminemos el material proporcionando la siguiente información:
            </p>
            <ol class="list-decimal pl-6 text-gray-700 dark:text-gray-300 space-y-2 mb-4">
                <li>Una identificación de la obra protegida por derechos de autor que usted afirma ha sido infringida. Si este aviso abarca múltiples obras, proporcione una lista representativa de dichas obras.</li>
                <li>Una identificación del material o enlace sobre el cual usted afirma que es infractor para permitirnos ubicar el material en la red.</li>
                <li>Su información de contacto, incluyendo nombre, dirección y correo electrónico.</li>
                <li>Una declaración de que tiene la creencia de buena fe de que el uso del material en disputa no está autorizado por el propietario de los derechos de autor, su agente, o la ley.</li>
                <li>Una declaración de que la información proporcionada en el aviso es precisa, y bajo pena de perjurio, que usted está autorizado de actuar en nombre del titular del derecho del autor.</li>
                <li>Una firma física o electrónica del propietario de los derechos de autor o una persona autorizada.</li>
            </ol>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Información de Contacto para Avisos DMCA</h2>
            <p class="text-gray-700 dark:text-gray-300">
                Los avisos de supuestas infracciones deben enviarse vía correo electrónico a nuestro departamento encargado de propiedad intelectual a la siguiente dirección:
            </p>
            <p class="mt-4 font-bold text-lg">
                <a href="mailto:dmca@<?= $_SERVER['HTTP_HOST'] ?>" class="text-blue-600 hover:underline">
                    dmca@<?= $_SERVER['HTTP_HOST'] ?>
                </a>
            </p>
        </section>

        <section class="mb-8">
            <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <h3 class="font-bold text-gray-900 dark:text-white mb-2">Advertencia Legal</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Tenga en cuenta que bajo el estatuto de la DMCA (17 U.S.C. § 512(f)), será responsable de los daños materiales, incluyendo costos y honorarios de abogados, si falsifica material y afirma erróneamente en su notificación formal que algún contenido de nuestro sistema está infringiendo sus derechos. El contenido de esta página no debe interpretarse como asesoramiento legal formal.
                </p>
            </div>
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
