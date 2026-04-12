<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 Diagnóstico Profundo de Subidas</h1>";

echo "<ul>";
echo "<li><b>Versión de PHP:</b> " . phpversion() . "</li>";
echo "<li><b>upload_max_filesize (ini):</b> " . ini_get('upload_max_filesize') . "</li>";
echo "<li><b>post_max_size (ini):</b> " . ini_get('post_max_size') . "</li>";
echo "<li><b>file_uploads (activado?):</b> " . (ini_get('file_uploads') ? 'SÍ ✅' : 'NO ❌') . "</li>";
echo "<li><b>upload_tmp_dir:</b> " . (ini_get('upload_tmp_dir') ?: 'Usando temporal del sistema') . "</li>";

$tmpDir = ini_get('upload_tmp_dir') ?: sys_get_temp_dir();
echo "<li><b>Carpeta temporal utilizable:</b> $tmpDir</li>";

if (is_writable($tmpDir)) {
    echo "<li>✅ Carpeta temporal es ESCRIBIBLE por PHP.</li>";
} else {
    echo "<li>❌ <b>ERROR:</b> PHP NO puede escribir en la carpeta temporal. ¡Este es el problema! Tienes que hablar con tu hosting o cambiarla en php.ini.</li>";
}

echo "</ul>";

echo "<h2>📤 Prueba de Subida Real</h2>";
echo '<form method="POST" enctype="multipart/form-data">
    <input type="file" name="test_file">
    <input type="submit" value="Probar Subida">
</form>';

if (isset($_FILES['test_file'])) {
    echo "<h3>Resultados de la prueba:</h3><pre>";
    print_r($_FILES['test_file']);
    echo "</pre>";
    
    if ($_FILES['test_file']['error'] === 0) {
        echo "<h4 style='color:green'>✅ ¡ÉXITO! PHP aceptó el archivo correctamente. El problema estaba en el código del controlador.</h4>";
    } else {
         echo "<h4 style='color:red'>❌ FALLO. Código de error: " . $_FILES['test_file']['error'] . ". Revisar php.ini.</h4>";
    }
}
?>
