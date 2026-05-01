<?php

namespace App\Controllers;

use App\Models\Software;
use App\Models\Category;
use App\Models\DownloadLink;
use App\Services\GeminiService;
use App\Database;
use DOMDocument;
use DOMXPath;

class ImportController extends Controller
{
    private $softwareModel;
    private $categoryModel;
    private $geminiService;

    public function __construct()
    {
        parent::__construct();
        $this->requireAdmin();
        $this->softwareModel = new Software();
        $this->categoryModel = new Category();
        $this->geminiService = new GeminiService();
    }

    public function index()
    {
        return $this->view('admin/software/importer', [
            'title' => 'Importador Avanzado de Apps',
            'categories' => $this->categoryModel->all()
        ]);
    }

    /**
     * Buscar aplicaciones en Google Play
     */
    public function search()
    {
        header('Content-Type: application/json');
        $query = $_GET['q'] ?? '';
        
        if (empty($query)) {
            echo json_encode(['success' => false, 'error' => 'Consulta vacía']);
            exit;
        }

        $searchUrl = "https://play.google.com/store/search?q=" . urlencode($query) . "&c=apps&hl=es";
        
        $context = stream_context_create([
            'http' => [
                'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36\r\n" .
                            "Accept-Language: es-ES,es;q=0.9\r\n"
            ]
        ]);
        $ch = curl_init();
        // Usamos parámetros de idioma para asegurar consistencia
        $url = "https://play.google.com/store/search?q=" . urlencode($query) . "&c=apps&hl=es";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept-Language: es-ES,es;q=0.9']);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36');
        $html = curl_exec($ch);
        curl_close($ch);

        if (!$html) {
            echo json_encode(['success' => false, 'error' => 'No se pudo conectar con Google Play']);
            exit;
        }

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
        $xpath = new DOMXPath($dom);

        $results = [];
        // Buscamos cualquier enlace que apunte a una app y subimos al contenedor más cercano
        $links = $xpath->query('//a[contains(@href, "/store/apps/details?id=")]');

        foreach ($links as $linkNode) {
            $href = $linkNode->getAttribute('href');
            $url = (strpos($href, 'http') === 0) ? $href : "https://play.google.com" . $href;
            
            // Evitar duplicados (un mismo enlace puede aparecer varias veces en el card)
            $appId = explode('id=', $href)[1] ?? '';
            $appId = explode('&', $appId)[0];
            if (isset($results[$appId])) continue;

            // Buscamos el contenedor padre que tenga la información
            $parent = $linkNode->parentNode;
            for ($i = 0; $i < 10; $i++) { // Subir hasta 10 niveles buscando el card
                if (!$parent) break;
                // Si encontramos un nodo con imagen y texto, es probablemente el card
                if ($xpath->query('.//img', $parent)->length > 0 && $xpath->query('.//div', $parent)->length > 2) {
                    break;
                }
                $parent = $parent->parentNode;
            }

            if (!$parent) continue;

            // Extraer título: buscar el texto más relevante o el atributo title/alt
            $titleNode = $xpath->query('.//span[contains(@class, "Dd73n")] | .//div[contains(@class, "Dd73n")] | .//div[@title]', $parent)->item(0);
            $title = $titleNode ? ($titleNode->getAttribute('title') ?: trim($titleNode->textContent)) : '';
            
            if (empty($title)) {
                // Segundo intento: cualquier encabezado o texto largo
                $textNodes = $xpath->query('.//div[string-length(text()) > 2]', $parent);
                if ($textNodes->length > 0) $title = trim($textNodes->item(0)->textContent);
            }

            // Icono
            $imgNode = $xpath->query('.//img', $parent)->item(0);
            $icon = '';
            if ($imgNode) {
                $icon = $imgNode->getAttribute('data-src') ?: ($imgNode->getAttribute('srcset') ?: $imgNode->getAttribute('src'));
                if (strpos($icon, ' ') !== false) $icon = explode(' ', $icon)[0]; // Limpiar srcset
            }

            if (empty($title) || empty($icon)) continue;

            $results[$appId] = [
                'title' => $title,
                'url' => $url,
                'icon' => $icon,
                'developer' => 'Google Play App'
            ];

            if (count($results) >= 12) break;
        }

        echo json_encode(['success' => true, 'results' => array_values($results)]);
        exit;
    }

    /**
     * Obtener detalles de una aplicación específica
     */
    public function getDetails()
    {
        header('Content-Type: application/json');
        $url = $_GET['url'] ?? '';

        if (empty($url) || strpos($url, 'play.google.com') === false) {
            echo json_encode(['success' => false, 'error' => 'URL inválida']);
            exit;
        }

        $ch = curl_init();
        // Forzamos idioma español mediante parámetro y cabecera
        if (strpos($url, '?') !== false) {
            $url .= '&hl=es';
        } else {
            $url .= '?hl=es';
        }
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept-Language: es-ES,es;q=0.9']);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36');
        $html = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (!$html || $httpCode !== 200) {
            echo json_encode(['success' => false, 'error' => 'No se pudo conectar con Google Play (Código: ' . $httpCode . ')']);
            exit;
        }

        $html = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">' . $html;
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        // Título robusto
        $titleNode = $xpath->query('//h1/span | //h1[@itemprop="name"] | //h1')->item(0);
        $title = $titleNode ? trim($titleNode->textContent) : 'Software Sin Nombre';

        // Icono robusto
        $icon = '';
        $iconSelectors = [
            '//img[@itemprop="image"]',
            '//img[@alt="Icono" or @alt="Icon image"]',
            '//img[contains(@src, "googleusercontent")][1]',
            '//img[contains(@class, "T7XCO")]',
            '//picture/img'
        ];

        foreach ($iconSelectors as $selector) {
            $iconNode = $xpath->query($selector)->item(0);
            if ($iconNode) {
                $icon = $iconNode->getAttribute('srcset') ?: ($iconNode->getAttribute('data-src') ?: $iconNode->getAttribute('src'));
                if (!empty($icon)) {
                    if (strpos($icon, ' ') !== false) $icon = explode(' ', $icon)[0]; // Limpiar srcset
                    if (strpos($icon, '//') === 0) $icon = 'https:' . $icon;
                    if (strpos($icon, '=') !== false) {
                        $icon = explode('=', $icon)[0] . '=w512'; // Alta resolución
                    }
                    break;
                }
            }
        }

        // Descripción original
        $description = 'Descripción no disponible directamente. Pulsa Generar con IA.';
        $descNodes = $xpath->query('//div[@data-g-id="description"] | //div[contains(@class, "b0A7u")] | //div[@itemprop="description"] | //div[contains(@class, "b056n")]');
        if ($descNodes->length > 0) {
            $description = strip_tags($dom->saveHTML($descNodes->item(0)));
        }

        // Desarrollador
        $developer = 'Desconocido';
        $devNode = $xpath->query('//div[contains(@class, "Vbfug")]//span | //a[contains(@href, "/store/apps/developer")]//span | //a[contains(@href, "/store/apps/dev")]//span')->item(0);
        if ($devNode) $developer = trim($devNode->textContent);

        // Categoría
        $category = 'Apps';
        $genreNode = $xpath->query('//span[@itemprop="genre"] | //a[contains(@href, "category/")]')->item(0);
        if ($genreNode) $category = trim($genreNode->textContent);

        // Versión (Difícil en Google Play, intentamos varios selectores y regex)
        $version = '1.0.0';
        $vSelectors = [
            '//div[contains(text(), "Versión")]/following-sibling::div',
            '//div[contains(text(), "Version")]/following-sibling::div',
            '//span[contains(text(), "Versión")]/parent::div/following-sibling::div',
            '//div[text()="Versión"]/following-sibling::span',
            '//div[text()="Version"]/following-sibling::span',
            '//div[@class="reAt0"]'
        ];

        foreach ($vSelectors as $selector) {
            $vNodes = $xpath->query($selector);
            if ($vNodes->length > 0) {
                $vText = trim($vNodes->item(0)->textContent);
                if (preg_match('/[0-9]+\.[0-9]+(\.[0-9]+)?/', $vText, $vMatches)) {
                    $version = $vMatches[0];
                    break;
                }
            }
        }

        // Si fallan los selectores, buscamos en todo el HTML por patrones comunes en scripts o texto
        if ($version === '1.0.0') {
            if (preg_match('/"([0-9]+\.[0-9]+(\.[0-9]+)?)"/', $html, $matches)) {
                // Esto puede capturar versiones de librerías, pero es mejor que nada si está cerca de la data de la app
                // Intentamos un patrón más específico de Google Play si existe
                if (preg_match('/\[\[\["([0-9]+\.[0-9]+(\.[0-9]+)?)"\]/i', $html, $m)) {
                    $version = $m[1];
                }
            }
        }

        // Imagen Destacada (Hero)
        $featuredImage = '';
        $heroSelectors = [
            '//img[@alt="Imagen de portada" or @alt="Cover art"]',
            '//img[contains(@src, "googleusercontent")][contains(@src, "fife")]',
            '//div[contains(@class, "u31Y9b")]//img',
            '//picture/source[contains(@srcset, "googleusercontent")]'
        ];

        foreach ($heroSelectors as $selector) {
            $heroNode = $xpath->query($selector)->item(0);
            if ($heroNode) {
                $featuredImage = $heroNode->getAttribute('srcset') ?: ($heroNode->getAttribute('data-src') ?: $heroNode->getAttribute('src'));
                if (!empty($featuredImage)) {
                    if (strpos($featuredImage, ' ') !== false) $featuredImage = explode(' ', $featuredImage)[0];
                    if (strpos($featuredImage, '//') === 0) $featuredImage = 'https:' . $featuredImage;
                    if (strpos($featuredImage, '=') !== false) {
                        $featuredImage = explode('=', $featuredImage)[0] . '=w1280';
                    }
                    break;
                }
            }
        }

        echo json_encode([
            'success' => true,
            'data' => [
                'title' => $title,
                'icon' => $icon,
                'developer' => $developer,
                'category' => $category,
                'version' => $version,
                'featured_image' => $featuredImage,
                'original_description' => substr($description, 0, 1500)
            ]
        ]);
        exit;
    }

    /**
     * Descubrir nuevas aplicaciones (Novedades)
     */
    public function discover()
    {
        header('Content-Type: application/json');
        
        $type = $_GET['type'] ?? 'apps';
        $ch = curl_init();
        // Usamos la página principal de apps/juegos que es más estable
        $url = ($type == 'games') 
            ? "https://play.google.com/store/games?hl=es" 
            : "https://play.google.com/store/apps?hl=es";

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36');
        $html = curl_exec($ch);
        curl_close($ch);

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
        $xpath = new DOMXPath($dom);

        $results = [];
        $links = $xpath->query('//a[contains(@href, "/store/apps/details?id=")]');

        foreach ($links as $linkNode) {
            $href = $linkNode->getAttribute('href');
            $appUrl = (strpos($href, 'http') === 0) ? $href : "https://play.google.com" . $href;
            
            $appId = explode('id=', $href)[1] ?? '';
            $appId = explode('&', $appId)[0];
            if (isset($results[$appId])) continue;

            $parent = $linkNode->parentNode;
            for ($i = 0; $i < 8; $i++) {
                if (!$parent) break;
                if ($xpath->query('.//img', $parent)->length > 0) break;
                $parent = $parent->parentNode;
            }

            if (!$parent) continue;

            $titleNode = $xpath->query('.//span[contains(@class, "Dd73n")] | .//div[contains(@class, "Dd73n")] | .//div[@title]', $parent)->item(0);
            $title = $titleNode ? ($titleNode->getAttribute('title') ?: trim($titleNode->textContent)) : '';
            
            $imgNode = $xpath->query('.//img', $parent)->item(0);
            $icon = $imgNode ? ($imgNode->getAttribute('data-src') ?: ($imgNode->getAttribute('srcset') ?: $imgNode->getAttribute('src'))) : '';
            if (strpos($icon, ' ') !== false) $icon = explode(' ', $icon)[0];

            if(!empty($title) && !empty($icon)) {
                $results[$appId] = [
                    'title' => $title,
                    'url' => $appUrl,
                    'icon' => $icon
                ];
            }
            if (count($results) >= 12) break;
        }

        echo json_encode(['success' => true, 'results' => array_values($results)]);
        exit;
    }

    /**
     * Generar descripción con IA
     */
    public function generateAi()
    {
        header('Content-Type: application/json');
        $title = $_POST['title'] ?? '';
        $category = $_POST['category'] ?? '';
        $developer = $_POST['developer'] ?? '';

        if (empty($title)) {
            echo json_encode(['success' => false, 'error' => 'Faltan datos']);
            exit;
        }

        $descriptions = $this->geminiService->generateBothDescriptions($title, $category, $developer);
        
        echo json_encode([
            'success' => true,
            'short' => $descriptions['short']['text'] ?? '',
            'full' => $descriptions['full']['text'] ?? ''
        ]);
        exit;
    }

    /**
     * Guardar el software importado
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/import');
        }

        $db = Database::getInstance();
        $conn = $db->getConnection();
        
        $name = $_POST['name'] ?? '';
        $slug = $this->generateSlug($name);
        
        // Verificar duplicado de slug
        $stmt = $conn->prepare("SELECT id FROM software WHERE slug = ?");
        $stmt->execute([$slug]);
        if ($stmt->fetch()) {
            $slug .= '-' . rand(10, 99);
        }

        $data = [
            'name' => $name,
            'slug' => $slug,
            'short_description' => $_POST['short_description'] ?? '',
            'description' => $_POST['description'] ?? '',
            'version' => $_POST['version'] ?? '',
            'developer' => $_POST['developer'] ?? '',
            'category_id' => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
            'license' => $_POST['license'] ?? 'Gratis',
            'operating_system' => 'Multiplataforma',
            'file_size' => '',
            'status' => 'published',
            'icon' => $_POST['icon'] ?? '',
            'image' => $_POST['featured_image'] ?? '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $softwareId = $this->softwareModel->create($data);

        if ($softwareId && !empty($_POST['download_links'])) {
            $downloadLinkModel = new DownloadLink();
            foreach ($_POST['download_links'] as $link) {
                if (!empty($link['url'])) {
                    $downloadLinkModel->create([
                        'software_id' => $softwareId,
                        'platform' => $link['platform'] ?? 'Directo',
                        'download_url' => $link['url'],
                        'file_size' => $link['size'] ?? '',
                        'version' => $data['version']
                    ]);
                }
            }
        }

        $_SESSION['success'] = 'Software importado exitosamente';
        $this->redirect('/admin/software');
    }

    private function generateSlug($string)
    {
        $string = strtolower(trim($string));
        $string = preg_replace('/[^a-z0-9-]/', '-', $string);
        $string = preg_replace('/-+/', '-', $string);
        return trim($string, '-');
    }
}
