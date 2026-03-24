<?php
ob_start();
$title = 'Contacto - ' . seo_site_title();
$description = 'Contáctate con el equipo de ' . seo_site_title();
?>

<div class="bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-gray-900 dark:to-gray-800 py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">Contacto</h1>
        <p class="text-xl text-gray-600 dark:text-gray-400">¿Tienes dudas o necesitas soporte? Escríbenos.</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 py-12">
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        
        <!-- Información -->
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Ponte en contacto con nosotros</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-8">
                Estamos aquí para ayudarte. Completa el formulario y nos comunicaremos contigo lo más pronto posible. Si se trata de inconvenientes técnicos, especifica detalladamente tu caso.
            </p>
            
            <div class="space-y-6">
                <div class="flex items-start">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-gray-800 rounded-full flex items-center justify-center text-blue-600 dark:text-blue-400 mr-4 flex-shrink-0">
                        <i class="fas fa-envelope text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white">Correo Electrónico</h4>
                        <p class="text-gray-600 dark:text-gray-400">Soporte general y DMCA.</p>
                        <a href="mailto:soporte@<?= $_SERVER['HTTP_HOST'] ?>" class="text-blue-600 hover:underline font-medium">soporte@<?= $_SERVER['HTTP_HOST'] ?></a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Formulario -->
        <div>
            <form action="#" method="POST" class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl dark:shadow-none border border-gray-100 dark:border-gray-700">
                
                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nombre completo</label>
                    <input type="text" id="name" name="name" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow">
                </div>
                
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Correo electrónico</label>
                    <input type="email" id="email" name="email" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow">
                </div>
                
                <div class="mb-5">
                    <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Asunto</label>
                    <input type="text" id="subject" name="subject" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow">
                </div>
                
                <div class="mb-6">
                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mensaje</label>
                    <textarea id="message" name="message" rows="4" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow"></textarea>
                </div>
                
                <button type="submit" class="w-full bg-blue-600 text-white rounded-xl px-4 py-3 font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2">
                    <i class="fas fa-paper-plane"></i> Enviar Mensaje
                </button>
            </form>
        </div>
        
    </div>

</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
