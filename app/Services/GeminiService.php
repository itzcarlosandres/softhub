<?php

namespace App\Services;

use App\Models\SiteSetting;

class GeminiService
{
    private $apiKey;
    private $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';
    
    public function __construct()
    {
        // La API key se obtendrá de la base de datos o .env
        $this->apiKey = $this->getApiKey();
    }
    
    /**
     * Obtener la API key de Gemini (Preferencia: Base de datos > .env)
     */
    private function getApiKey()
    {
        // 1. Intentar desde la base de datos
        $settings = new SiteSetting();
        $dbKey = $settings->get('gemini_api_key');
        
        if (!empty($dbKey)) {
            return $dbKey;
        }

        // 2. Fallback al archivo .env o variable de entorno
        return getenv('GEMINI_API_KEY') ?: $_ENV['GEMINI_API_KEY'] ?? '';
    }
    
    /**
     * Generar descripción corta del software
     */
    public function generateShortDescription($softwareName, $category = '')
    {
        $prompt = "Genera una descripción corta (máximo 2 líneas, 150 caracteres) para el software '{$softwareName}'";
        
        if (!empty($category)) {
            $prompt .= " de la categoría '{$category}'";
        }
        
        $prompt .= ". La descripción debe ser profesional, concisa y atractiva. Solo devuelve la descripción sin comillas ni texto adicional.";
        
        return $this->generateContent($prompt);
    }
    
    /**
     * Generar descripción completa del software con formato HTML SEO
     */
    public function generateFullDescription($softwareName, $category = '', $developer = '')
    {
        $prompt = "Genera una descripción completa y profesional en HTML para el software '{$softwareName}'";
        
        if (!empty($category)) {
            $prompt .= " de la categoría '{$category}'";
        }
        
        if (!empty($developer)) {
            $prompt .= " desarrollado por {$developer}";
        }
        
        $prompt .= ".\n\n";
        $prompt .= "IMPORTANTE: Usa el siguiente formato HTML estricto y optimizado:\n\n";
        $prompt .= "1. Usa etiquetas <p> para párrafos.\n";
        $prompt .= "2. Usa <strong> para resaltar el nombre del software y 3-4 frases clave.\n";
        $prompt .= "3. Sección de características EXACTAMENTE así (usa el idioma solicitado):\n";
        $prompt .= "   <h2>Características Principales</h2> (o 'Main Features' en inglés)\n";
        $prompt .= "   <ul>\n";
        $prompt .= "   <li><strong>Nombre Característica:</strong> Explicación breve.</li>\n";
        $prompt .= "   </ul>\n";
        $prompt .= "4. CRÍTICO: Usa ENTIDADES HTML para todos los acentos y caracteres especiales (ejemplo: 'f&aacute;cil' en vez de 'fácil', 'cami&oacute;n' en vez de 'camión', '&ntilde;' en vez de 'ñ').\n";
        $prompt .= "5. El texto debe ser profesional y persuasivo.\n\n";
        
        $prompt .= "Ejemplo de salida deseada:\n";
        $prompt .= "<p><strong>Nombre</strong> es una soluci&oacute;n que permite...</p>\n";
        $prompt .= "<h2>Características Principales</h2>\n";
        $prompt .= "<ul>\n";
        $prompt .= "<li><strong>Funci&oacute;n 1:</strong> Detalle.</li>\n";
        $prompt .= "</ul>\n\n";
 
        $prompt .= "REGLAS:\n";
        $prompt .= "- NO uses bloques de código markdown (```html).\n";
        $prompt .= "- NO incluyas explicaciones extra, solo el código HTML.\n";
        $prompt .= "- Asegúrate de convertir TODOS los acentos a entidades HTML.\n";
        
        return $this->generateContent($prompt);
    }
    
    /**
     * Generar ambas descripciones de una vez optimizado en una sola llamada
     */
    public function generateBothDescriptions($softwareName, $category = '', $developer = '')
    {
        $prompt = "Genera una descripción corta y una descripción completa en HTML para el software '{$softwareName}'";
        
        if (!empty($category)) {
            $prompt .= " de la categoría '{$category}'";
        }
        
        if (!empty($developer)) {
            $prompt .= " desarrollado por {$developer}";
        }
        
        $prompt .= ".\n\n";
        $prompt .= "IMPORTANTE: Divide la respuesta en dos secciones EXACTAMENTE con estos encabezados:\n";
        $prompt .= "---SHORT_DESCRIPTION---\n";
        $prompt .= "[Aquí la descripción corta de máximo 150 caracteres, sin HTML]\n";
        $prompt .= "---FULL_DESCRIPTION---\n";
        $prompt .= "[Aquí el código HTML profesional según las reglas de formato]\n\n";
        
        $prompt .= "REGLAS PARA EL HTML:\n";
        $prompt .= "1. Usa etiquetas <p>, <ul>, <li> y <strong>.\n";
        $prompt .= "2. CRÍTICO: Usa ENTIDADES HTML para todos los acentos y caracteres especiales (ej: 'f&aacute;cil').\n";
        $prompt .= "3. Solo devuelve el texto solicitado bajo los encabezados.\n";
        
        $result = $this->generateContent($prompt);
        
        if (!$result['success']) {
            return [
                'short' => $result,
                'full' => $result
            ];
        }
        
        $text = $result['text'];
        $short = ''; 
        $full = '';
        
        if (preg_match('/---SHORT_DESCRIPTION---(.*?)(---FULL_DESCRIPTION---|$)/s', $text, $matches)) {
            $short = trim($matches[1]);
            // Limpiar posibles bloques markdown en la corta
            $short = preg_replace('/^```(?:text|markdown)?\s+/i', '', $short);
            $short = preg_replace('/\s*```$/', '', $short);
            $short = trim($short, '"\' ');
        }
        
        if (preg_match('/---FULL_DESCRIPTION---(.*?)$/s', $text, $matches)) {
            $full = trim($matches[1]);
            // Limpiar posibles bloques markdown en la larga (Muy común)
            if (preg_match('/```(?:html|markdown)?\s*(.*?)\s*```/si', $full, $subMatches)) {
                $full = $subMatches[1];
            } else {
                $full = preg_replace('/^```(?:html|markdown)?\s+/i', '', $full);
                $full = preg_replace('/\s*```$/', '', $full);
            }
        }
        
        // Si no se pudo parsear correctamente, intentamos fallback
        if (empty($short) || empty($full)) {
            // Fallback manual por si falla el regex (aunque no debería)
            return [
                'short' => ['success' => true, 'text' => substr($text, 0, 150)],
                'full' => ['success' => true, 'text' => $text]
            ];
        }
        
        return [
            'short' => ['success' => true, 'text' => $short],
            'full' => ['success' => true, 'text' => $full]
        ];
    }
    
    /**
     * Generar SEO (Título y Descripción) para artículos del blog
     */
    public function generateBlogSEO($title, $category = '')
    {
        $prompt = "Genera un Meta Título SEO y una Meta Descripción SEO para un artículo de blog titulado '{$title}'";
        if ($category) $prompt .= " de la categoría '{$category}'";
        
        $prompt .= ".\n\n";
        $prompt .= "REGLAS:\n";
        $prompt .= "1. Divide la respuesta con los encabezados: ---SHORT_DESCRIPTION--- y ---FULL_DESCRIPTION---\n";
        $prompt .= "2. En ---SHORT_DESCRIPTION--- pon el Meta Título (máximo 60 caracteres). Debe ser llamativo e incluir el título principal.\n";
        $prompt .= "3. En ---FULL_DESCRIPTION--- pon la Meta Descripción (máximo 155 caracteres). Debe ser persuasiva y resumir el valor del artículo.\n";
        $prompt .= "4. Solo devuelve el texto, sin bloques de código.\n";
        
        $result = $this->generateContent($prompt);
        
        if (!$result['success']) {
            return [
                'short' => $result,
                'full' => $result
            ];
        }
        
        $text = $result['text'];
        $seoTitle = ''; 
        $seoDesc = '';
        
        if (preg_match('/---SHORT_DESCRIPTION---(.*?)(---FULL_DESCRIPTION---|$)/s', $text, $matches)) {
            $seoTitle = trim($matches[1]);
        }
        
        if (preg_match('/---FULL_DESCRIPTION---(.*?)$/s', $text, $matches)) {
            $seoDesc = trim($matches[1]);
        }
        
        return [
            'short' => ['success' => true, 'text' => $seoTitle],
            'full' => ['success' => true, 'text' => $seoDesc]
        ];
    }
    
    /**
     * Generar descripción SEO para el sitio web
     */
    public function generateSiteDescription($siteName)
    {
        $prompt = "Genera una descripción SEO profesional para un sitio web llamado '{$siteName}' que se dedica a la descarga de software. La descripción debe tener un máximo de 160 caracteres, ser atractiva para buscadores y usuarios, e incluir palabras clave relevantes como 'software', 'descargar' y 'gratis'. Solo devuelve el texto de la descripción.";
        
        return $this->generateContent($prompt);
    }
    
    /**
     * Llamada a la API de Gemini con manejo de reintentos para errores de Rate Limit (429)
     */
    private function generateContent($prompt, $maxRetries = 8)
    {
        if (empty($this->apiKey)) {
            return [
                'success' => false,
                'error' => 'API key de Gemini no configurada. Ve a Configuración > IA para agregarla.'
            ];
        }
        
        $url = $this->apiUrl . '?key=' . $this->apiKey;
        
        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'topK' => 40,
                'topP' => 0.95,
                'maxOutputTokens' => 2048, // Aumentado un poco para artículos largos
            ]
        ];
        
        $attempt = 0;
        $response = null;
        $httpCode = 0;
        
        while ($attempt <= $maxRetries) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_TIMEOUT, 60); // Aumentado a 60 segundos
            
            // Desactivar verificación SSL solo en desarrollo local
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);
            
            if ($error) {
                return [
                    'success' => false,
                    'error' => 'Error de conexión: ' . $error
                ];
            }
            
            // Si el código es 200, salimos del bucle
            if ($httpCode === 200) {
                break;
            }
            
            // Si es error 429 (Too Many Requests), esperamos y reintentamos
            if ($httpCode === 429 && $attempt < $maxRetries) {
                $attempt++;
                // Espera optimizada: 1s, 2s, 4s, 8s, 16s... (más rápido al inicio)
                sleep(pow(2, $attempt - 1)); 
                continue;
            }
            
            // Para otros errores o si excedimos reintentos, salimos
            break;
        }
        
        if ($httpCode !== 200) {
            $errorData = json_decode($response, true);
            $errorMessage = $errorData['error']['message'] ?? 'Error desconocido';
            
            if ($httpCode === 429) {
                return [
                    'success' => false,
                    'error' => 'Límite de cuota excedido (429) tras ' . $maxRetries . ' reintentos. Google dice: "' . $errorMessage . '". Verifica en Google Cloud Console que tu cuota sea suficiente.'
                ];
            }
            
            return [
                'success' => false,
                'error' => 'Error de API (código ' . $httpCode . '): ' . $errorMessage
            ];
        }
        
        $result = json_decode($response, true);
        
        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $text = trim($result['candidates'][0]['content']['parts'][0]['text']);
            // Limpiar comillas si las hay
            $text = trim($text, '"\'');
            
            // Limpiar bloques de código markdown que la IA suele añadir
            // Evitamos limpiar si detectamos separadores de secciones propias para no romper el parseo posterior
            if (strpos($text, '---SHORT_DESCRIPTION---') === false) {
                // Caso 1: Todo el contenido (o casi todo) está envuelto en ```html ... ```
                if (preg_match('/^\s*```(?:html|markdown|json|text)?\s*(.*?)\s*```\s*$/si', $text, $matches)) {
                    $text = $matches[1];
                } else {
                    // Caso 2: Solo hay marcadores sueltos al inicio o final (más conservador)
                    $text = preg_replace('/^```(?:html|markdown|json|text)?\s+/i', '', $text);
                    $text = preg_replace('/\s*```$/', '', $text);
                }
            }
            
            return [
                'success' => true,
                'text' => trim($text)
            ];
        }
        
        return [
            'success' => false,
            'error' => 'No se pudo generar el contenido. La respuesta de la IA fue inesperada.'
        ];
    }
    
    /**
     * Generar requisitos del sistema del software
     */
    public function generateRequirements($softwareName, $category = '')
    {
        $prompt = "Genera una lista de requisitos del sistema (mínimos y recomendados) para el software '{$softwareName}'";
        
        if (!empty($category)) {
            $prompt .= " de la categoría '{$category}'";
        }
        
        $prompt .= ".\n\n";
        $prompt .= "Usa el siguiente formato HTML:\n";
        $prompt .= "1. Usa etiquetas <strong> para los títulos.\n";
        $prompt .= "2. Usa <ul> y <li> para las listas.\n";
        $prompt .= "3. Separa por 'Requisitos Mínimos' y 'Requisitos Recomendados'.\n";
        $prompt .= "4. Usa ENTIDADES HTML para caracteres especiales.\n";
        
        return $this->generateContent($prompt);
    }
    
    /**
     * Generar artículo de blog optimizado para SEO
     */
    public function generateBlogPost($title, $category = '')
    {
        $prompt = "Escribe un artículo de blog completo, detallado y altamente optimizado para SEO sobre el siguiente tema: '{$title}'.\n";
        
        if (!empty($category)) {
            $prompt .= "El artículo pertenece a la categoría: '{$category}'.\n";
        }
        
        $prompt .= "\nREGLAS ESTRICTAS PARA EL FORMATo HTML:\n";
        $prompt .= "1. El artículo entero debe estar formateado en HTML limpio y debe tener una longitud aproximada de 500 a 600 palabras.\n";
        $prompt .= "2. Utiliza etiquetas <h2> para los subtítulos principales y <h3> para secciones secundarias si son necesarias. (NO uses <h1>, ya que el título de la página lo proporciona el sistema).\n";
        $prompt .= "3. Utiliza párrafos con <p>, listas con <ul> y <li>, y resalta (negrita) términos importantes o palabras clave relacionadas al tema usando <strong>.\n";
        $prompt .= "4. Estructura el artículo así: una introducción atractiva de 1 o 2 párrafos, luego 3 o 4 secciones de desarrollo con sus respectivos <h2>, y finalmente una breve conclusión.\n";
        $prompt .= "5. Mantén un tono profesional, informativo y atractivo para mantener enganchado al lector.\n";
        $prompt .= "6. CRÍTICAMENTE IMPORTANTE: Absolutamente todos los acentos y letras especiales (como ñ) deben estar convertidos a Entidades HTML (por ejemplo: 'f&aacute;cil', 'soluci&oacute;n', 'dise&ntilde;o').\n";
        $prompt .= "7. La respuesta final solo debe contener el código HTML generado (no agregues '```html' ni texto explicativo antes ni después).\n";
        
        return $this->generateContent($prompt);
    }

    /**
     * Verificar si la API key es válida
     */
    public function testConnection()
    {
        $result = $this->generateContent('Di "OK" si puedes leer esto.');
        
        if ($result['success']) {
            return [
                'success' => true,
                'message' => 'Conexión exitosa con Google Gemini'
            ];
        }
        
        return $result;
    }
}
