<?php
// Debug File
$pageTitle = 'Debug Page';
ob_start();
?>
<div class="p-10">
    <h1 class="text-3xl font-bold text-white">¡El Layout Funciona!</h1>
    <p class="text-gray-400">Si ves esto, el problema está en el contenido del dashboard.php original.</p>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';
?>
