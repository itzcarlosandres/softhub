<?php

namespace App\Services;

class GeminiService
{
    private $apiKey;
    private $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';
    
    public function __construct()
    {
        // La API key se configurará en settings o .env
        $this->apiKey = $this->getApiKey();
    }
    
    /**
     * Obtener la API key de Gemini desde la configuración
     */
    private function getApiKey()
    {
        // API Key hardcoded por solicitud del usuario
        return 'AIzaSyDRNUFFwaVBL-BRyJKbFm1SVOaW1J9iUgw';
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
        $prompt .= "3. Sección de características EXACTAMENTE así:\n";
        $prompt .= "   <h2>Características Principales</h2>\n";
        $prompt .= "   <ul>\n";
        $prompt .= "   <li><strong>Nombre Característica:</strong> Explicación breve.</li>\n";
        $prompt .= "   </ul>\n";
        $prompt .= "4. CRÍTICO: Usa ENTIDADES HTML para todos los acentos y caracteres especiales (ejemplo: 'f&aacute;cil' en vez de 'fácil', 'cami&oacute;n' en vez de 'camión', '&ntilde;' en vez de 'ñ').\n";
        $prompt .= "5. El texto debe ser profesional y persuasivo.\n\n";
        
        $prompt .= "Ejemplo de salida deseada:\n";
        $prompt .= "<p><strong>Nombre</strong> es una soluci&oacute;n que permite...</p>\n";
        $prompt .= "<h2>Caracter&iacute;sticas Principales</h2>\n";
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
     * Generar ambas descripciones de una vez
     */
    public function generateBothDescriptions($softwareName, $category = '', $developer = '')
    {
        return [
            'short' => $this->generateShortDescription($softwareName, $category),
            'full' => $this->generateFullDescription($softwareName, $category, $developer)
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
     * Llamada a la API de Gemini
     */
    private function generateContent($prompt)
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
                'maxOutputTokens' => 1024,
            ]
        ];
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        // Desactivar verificación SSL solo en desarrollo local
        // IMPORTANTE: En producción, debes configurar certificados SSL válidos
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
        
        if ($httpCode !== 200) {
            $errorData = json_decode($response, true);
            $errorMessage = $errorData['error']['message'] ?? 'Error desconocido';
            
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
            $text = preg_replace('/^```html\s*/i', '', $text); // Elimina ```html al inicio
            $text = preg_replace('/^```\s*/', '', $text);      // Elimina ``` al inicio
            $text = preg_replace('/\s*```$/', '', $text);      // Elimina ``` al final
            
            return [
                'success' => true,
                'text' => trim($text)
            ];
        }
        
        return [
            'success' => false,
            'error' => 'No se pudo generar el contenido'
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
