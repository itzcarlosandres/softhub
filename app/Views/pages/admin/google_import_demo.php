<?php
// Habilitar errores para debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

$result = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['url'])) {
    $url = $_POST['url'];
    
    // Validar URL básica
    if (strpos($url, 'play.google.com/store/apps/details') === false) {
        $error = "Por favor ingresa una URL válida de Google Play Store.";
    } else {
        // SCRAPING LOGIC
        // Simulamos un navegador real para evitar bloqueos simples
        $context = stream_context_create([
            'http' => [
                'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36\r\n" .
                            "Accept-Language: es-ES,es;q=0.9\r\n" // Pedir contenido en español
            ]
        ]);
        
        $html = @file_get_contents($url, false, $context);
        
        if ($html) {
            // Fix encoding issues via Meta Tag Hack (Modern Way)
            $html = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">' . $html;
            
            $dom = new DOMDocument();
            @$dom->loadHTML($html);
            $xpath = new DOMXPath($dom);
            
            // Extract Title (Robust)
            $titleNode = $xpath->query('//h1');
            if ($titleNode->length > 0) {
                $title = $titleNode->item(0)->textContent;
            } else {
                $metaTitle = $xpath->query('//meta[@property="og:title"]');
                $title = $metaTitle->length > 0 ? $metaTitle->item(0)->getAttribute('content') : 'Título no encontrado';
            }
            // Limpiar "- Apps en Google Play"
            $title = str_replace(['- Apps en Google Play', '- Apps on Google Play'], '', $title);
            
            // Extract Developer (Hard because dynamic classes)
            $developer = 'Desconocido';
            $devNode = $xpath->query('//div[contains(@class, "Vbfug")]/a/span'); // Old class
            if ($devNode->length == 0) $devNode = $xpath->query('//a[contains(@href, "/store/apps/dev")]'); // Link to dev profile
            if ($devNode->length == 0) $devNode = $xpath->query('//div[contains(@class, "5Mh0k")]'); // Another common class
            
            if ($devNode->length > 0) $developer = $devNode->item(0)->textContent;
            
            // Extract Icon (Prioritize High Res)
            $iconUrl = '';
            $iconNode = $xpath->query('//img[@itemprop="image"]');
            if ($iconNode->length == 0) $iconNode = $xpath->query('//meta[@property="og:image"]');
            
            if ($iconNode->length > 0) {
                $iconUrl = $iconNode->item(0)->nodeName == 'meta' ? $iconNode->item(0)->getAttribute('content') : $iconNode->item(0)->getAttribute('src');
            }
            
            // Fix icon url formatting
            if (strpos($iconUrl, '=') !== false) {
                 // Remove size constraints to get full res (e.g. =w240-h480)
                 $iconUrl = explode('=', $iconUrl)[0] . '=w512'; 
            }

            // Extract Description
            $descNode = $xpath->query('//div[@data-g-id="description"]');
            if ($descNode->length > 0) {
                 $description = $dom->saveHTML($descNode->item(0));
            } else {
                 $metaDesc = $xpath->query('//meta[@name="description"]');
                 $description = $metaDesc->length > 0 ? $metaDesc->item(0)->getAttribute('content') : '';
            }
            
            // Extract Category (Advanced: JSON-LD)
            $category = 'General';
            
            // 1. Try JSON-LD
            $jsonScripts = $xpath->query('//script[@type="application/ld+json"]');
            if ($jsonScripts->length > 0) {
                foreach($jsonScripts as $script) {
                    $json = json_decode($script->textContent, true);
                    if (isset($json['applicationCategory'])) {
                        $category = $json['applicationCategory'];
                        break;
                    }
                }
            }
            
            // 2. Try Itemprop Genre
            if ($category === 'General') {
                $genreNode = $xpath->query('//span[@itemprop="genre"]'); // Sometimes it's a span
                if ($genreNode->length > 0) $category = $genreNode->item(0)->textContent;
            }
            
            // 3. Try Links with category slug
            if ($category === 'General') {
               $catLinks = $xpath->query('//a[contains(@href, "/store/apps/category/")]');
               if ($catLinks->length > 0) {
                   $category = $catLinks->item(0)->textContent;
               }
            }

            $result = [
                'title' => trim($title),
                'developer' => trim($developer),
                'icon' => $iconUrl,
                'description' => strip_tags($description, '<br><p>'), // Limpieza básica
                'category' => trim($category),
                'original_url' => $url
            ];
            
        } else {
            $error = "No se pudo descargar el contenido. Google podría estar bloqueando la solicitud o la URL es incorrecta.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Play Importer Demo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen py-10 font-sans">
    <div class="container mx-auto px-4 max-w-3xl">
        
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-8 text-white">
                <h1 class="text-3xl font-bold mb-2"><i class="fab fa-google-play mr-2"></i> Importador Demo</h1>
                <p class="opacity-90">Pega una URL de Google Play Store para extraer los datos.</p>
            </div>
            
            <div class="p-8">
                <form method="POST" class="mb-8">
                    <label class="block text-gray-700 font-bold mb-2">Google Play URL</label>
                    <div class="flex gap-2">
                        <input type="url" name="url" placeholder="https://play.google.com/store/apps/details?id=com.spotify.music" 
                               class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none"
                               value="<?= htmlspecialchars($_POST['url'] ?? '') ?>" required>
                        <button type="submit" class="bg-black text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-800 transition">
                            <i class="fas fa-magic mr-2"></i> Extraer
                        </button>
                    </div>
                </form>
                
                <?php if ($error): ?>
                    <div class="bg-red-50 text-red-600 p-4 rounded-lg border border-red-200 mb-6 flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-xl"></i>
                        <?= $error ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($result): ?>
                    <div class="border-t border-gray-100 pt-8 animate-fade-in-up">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">Datos Extraídos</h2>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Éxito</span>
                        </div>
                        
                        <div class="flex flex-col md:flex-row gap-8">
                            <!-- Icon Preview -->
                            <div class="w-full md:w-1/3 text-center">
                                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 mb-4 inline-block">
                                    <img src="<?= $result['icon'] ?>" class="w-32 h-32 object-contain rounded-xl shadow-sm mx-auto">
                                </div>
                                <div class="text-xs text-gray-400 break-all px-4">
                                    <?= substr($result['icon'], 0, 30) ?>...
                                </div>
                            </div>
                            
                            <!-- Data Fields -->
                            <div class="w-full md:w-2/3 space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nombre App</label>
                                    <input type="text" value="<?= htmlspecialchars($result['title']) ?>" class="w-full bg-gray-50 border border-gray-200 rounded px-3 py-2 font-bold text-gray-800">
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Desarrollador</label>
                                        <input type="text" value="<?= htmlspecialchars($result['developer']) ?>" class="w-full bg-gray-50 border border-gray-200 rounded px-3 py-2 text-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Categoría Detectada</label>
                                        <input type="text" value="<?= htmlspecialchars($result['category']) ?>" class="w-full bg-blue-50 border border-blue-100 text-blue-700 font-bold rounded px-3 py-2">
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Descripción (Extracto)</label>
                                    <textarea class="w-full h-32 bg-gray-50 border border-gray-200 rounded px-3 py-2 text-sm text-gray-600 leading-relaxed"><?= htmlspecialchars(substr(strip_tags($result['description']), 0, 500)) ?>...</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
                            <button onclick="alert('En el sistema real, esto guardará los datos en la BD.')" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 shadow-lg hover:shadow-blue-500/30 transition transform hover:-translate-y-1">
                                <i class="fas fa-save mr-2"></i> Guardar en Base de Datos
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
                                <i class="fas fa-plus-circle"></i> Abrir en Creador de Software
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
