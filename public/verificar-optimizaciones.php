<?php
/**
 * Script de Verificación de Optimizaciones
 * Verifica que las optimizaciones de rendimiento estén activas
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Optimizaciones</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 32px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 16px;
        }
        .section {
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }
        .section h2 {
            color: #333;
            margin-bottom: 15px;
            font-size: 20px;
        }
        .check-item {
            display: flex;
            align-items: center;
            padding: 12px;
            margin-bottom: 10px;
            background: white;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        .status {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            font-size: 14px;
        }
        .status.ok { background: #10b981; }
        .status.warning { background: #f59e0b; }
        .status.error { background: #ef4444; }
        .label {
            flex: 1;
            font-weight: 500;
            color: #333;
        }
        .value {
            color: #666;
            font-family: 'Courier New', monospace;
            font-size: 13px;
        }
        .summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .stat-card .number {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .stat-card .label {
            font-size: 14px;
            opacity: 0.9;
            color: white;
        }
        .code {
            background: #1e293b;
            color: #10b981;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            overflow-x: auto;
            margin-top: 10px;
        }
        .recommendation {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }
        .recommendation strong {
            color: #92400e;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Verificación de Optimizaciones</h1>
        <p class="subtitle">Comprobando configuraciones de rendimiento del servidor</p>

        <?php
        // Contadores
        $total_checks = 0;
        $passed_checks = 0;
        $warnings = 0;
        $errors = 0;

        // Función helper para mostrar checks
        function check_item($label, $status, $value = '', $is_critical = false) {
            global $total_checks, $passed_checks, $warnings, $errors;
            $total_checks++;
            
            $icon = '✓';
            $class = 'ok';
            
            if ($status === 'warning') {
                $icon = '!';
                $class = 'warning';
                $warnings++;
            } elseif ($status === 'error') {
                $icon = '✗';
                $class = 'error';
                $errors++;
            } else {
                $passed_checks++;
            }
            
            echo "<div class='check-item'>";
            echo "<div class='status $class'>$icon</div>";
            echo "<div class='label'>$label</div>";
            if ($value) echo "<div class='value'>$value</div>";
            echo "</div>";
        }
        ?>

        <!-- Resumen -->
        <div class="summary">
            <div class="stat-card">
                <div class="number" id="total-checks">-</div>
                <div class="label">Total Checks</div>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <div class="number" id="passed-checks">-</div>
                <div class="label">Pasados ✓</div>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <div class="number" id="warnings">-</div>
                <div class="label">Advertencias !</div>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                <div class="number" id="errors">-</div>
                <div class="label">Errores ✗</div>
            </div>
        </div>

        <!-- 1. Módulos de Apache/LiteSpeed -->
        <div class="section">
            <h2>📦 Módulos del Servidor</h2>
            <?php
            $modules_to_check = ['mod_deflate', 'mod_expires', 'mod_headers', 'mod_rewrite'];
            
            if (function_exists('apache_get_modules')) {
                $loaded_modules = apache_get_modules();
                foreach ($modules_to_check as $module) {
                    $status = in_array($module, $loaded_modules) ? 'ok' : 'warning';
                    $value = in_array($module, $loaded_modules) ? 'Activo' : 'No detectado';
                    check_item($module, $status, $value);
                }
            } else {
                check_item('apache_get_modules()', 'warning', 'No disponible (LiteSpeed o CGI)');
                echo "<div class='recommendation'><strong>Nota:</strong> En LiteSpeed/OpenLiteSpeed, los módulos equivalentes suelen estar activos por defecto.</div>";
            }
            ?>
        </div>

        <!-- 2. Compresión -->
        <div class="section">
            <h2>🗜️ Compresión</h2>
            <?php
            // Verificar si la compresión está activa
            $compression_active = false;
            
            if (function_exists('ob_gzhandler') || ini_get('zlib.output_compression')) {
                $compression_active = true;
            }
            
            check_item(
                'Compresión Gzip/Zlib', 
                $compression_active ? 'ok' : 'warning',
                $compression_active ? 'Disponible' : 'No detectado en PHP'
            );
            
            // Verificar headers de salida
            if (function_exists('headers_list')) {
                $headers = headers_list();
                $has_encoding = false;
                foreach ($headers as $header) {
                    if (stripos($header, 'Content-Encoding') !== false) {
                        $has_encoding = true;
                        check_item('Content-Encoding Header', 'ok', $header);
                    }
                }
                if (!$has_encoding) {
                    check_item('Content-Encoding Header', 'warning', 'No presente en esta respuesta');
                }
            }
            ?>
            
            <div class="recommendation">
                <strong>💡 Cómo verificar compresión:</strong>
                <div class="code">curl -H "Accept-Encoding: gzip" -I https://tudominio.com</div>
                Buscar: <code>Content-Encoding: gzip</code>
            </div>
        </div>

        <!-- 3. Cache -->
        <div class="section">
            <h2>💾 Cache del Navegador</h2>
            <?php
            // Verificar headers de cache
            $cache_headers = ['Cache-Control', 'Expires', 'ETag', 'Last-Modified'];
            
            if (function_exists('headers_list')) {
                $headers = headers_list();
                $found_cache = false;
                
                foreach ($cache_headers as $cache_header) {
                    $found = false;
                    foreach ($headers as $header) {
                        if (stripos($header, $cache_header) !== false) {
                            $found = true;
                            $found_cache = true;
                            check_item($cache_header, 'ok', $header);
                            break;
                        }
                    }
                    if (!$found) {
                        check_item($cache_header, 'warning', 'No presente');
                    }
                }
                
                if (!$found_cache) {
                    echo "<div class='recommendation'><strong>⚠️ Advertencia:</strong> No se detectaron headers de cache. Verifica que el .htaccess esté funcionando.</div>";
                }
            }
            ?>
        </div>

        <!-- 4. PHP Info -->
        <div class="section">
            <h2>🐘 Información de PHP</h2>
            <?php
            check_item('Versión de PHP', 'ok', phpversion());
            check_item('Servidor Web', 'ok', $_SERVER['SERVER_SOFTWARE'] ?? 'Desconocido');
            check_item('Límite de Memoria', 'ok', ini_get('memory_limit'));
            check_item('Tiempo Máx. Ejecución', 'ok', ini_get('max_execution_time') . 's');
            check_item('Upload Max Filesize', 'ok', ini_get('upload_max_filesize'));
            check_item('Post Max Size', 'ok', ini_get('post_max_size'));
            ?>
        </div>

        <!-- 5. Archivos Críticos -->
        <div class="section">
            <h2>📄 Archivos de Configuración</h2>
            <?php
            $critical_files = [
                '.htaccess' => '../.htaccess',
                '.env' => '../.env',
                'index.php' => '../index.php'
            ];
            
            foreach ($critical_files as $name => $path) {
                $exists = file_exists($path);
                $readable = $exists && is_readable($path);
                
                if ($exists && $readable) {
                    $size = filesize($path);
                    check_item($name, 'ok', number_format($size) . ' bytes');
                } elseif ($exists) {
                    check_item($name, 'warning', 'Existe pero no es legible');
                } else {
                    check_item($name, 'error', 'No encontrado');
                }
            }
            ?>
        </div>

        <!-- 6. Extensiones PHP -->
        <div class="section">
            <h2>🔌 Extensiones PHP Requeridas</h2>
            <?php
            $required_extensions = [
                'pdo' => 'PDO (Base de datos)',
                'pdo_mysql' => 'PDO MySQL',
                'mbstring' => 'Multibyte String',
                'json' => 'JSON',
                'curl' => 'cURL',
                'gd' => 'GD (Imágenes)',
                'fileinfo' => 'File Info',
                'openssl' => 'OpenSSL'
            ];
            
            foreach ($required_extensions as $ext => $label) {
                $loaded = extension_loaded($ext);
                check_item($label, $loaded ? 'ok' : 'error', $loaded ? 'Instalado' : 'NO instalado');
            }
            ?>
        </div>

        <!-- Actualizar contadores -->
        <script>
            document.getElementById('total-checks').textContent = <?= $total_checks ?>;
            document.getElementById('passed-checks').textContent = <?= $passed_checks ?>;
            document.getElementById('warnings').textContent = <?= $warnings ?>;
            document.getElementById('errors').textContent = <?= $errors ?>;
        </script>

        <!-- Recomendaciones finales -->
        <div class="section" style="border-left-color: #10b981; background: #f0fdf4;">
            <h2>✅ Próximos Pasos</h2>
            <div style="line-height: 1.8;">
                <p><strong>1. Verificar compresión en producción:</strong></p>
                <div class="code">curl -H "Accept-Encoding: gzip" -I https://tudominio.com</div>
                
                <p style="margin-top: 15px;"><strong>2. Probar PageSpeed Insights:</strong></p>
                <div class="code">https://pagespeed.web.dev/</div>
                
                <p style="margin-top: 15px;"><strong>3. Limpiar cache del navegador:</strong></p>
                <div class="code">Ctrl + Shift + R (Windows/Linux) o Cmd + Shift + R (Mac)</div>
            </div>
        </div>
    </div>
</body>
</html>
