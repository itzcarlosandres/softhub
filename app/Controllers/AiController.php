<?php

namespace App\Controllers;

use App\Services\GeminiService;

class AiController extends Controller
{
    /**
     * Generar descripciones con IA
     */
    public function generateDescriptions()
    {
        header('Content-Type: application/json');
        
        // Verificar que sea una petición POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Método no permitido']);
            return;
        }
        
        // Obtener datos (compatibilidad con JSON y FormData)
        $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        
        $softwareName = $input['name'] ?? $input['title'] ?? '';
        $category = $input['category'] ?? '';
        $developer = $input['developer'] ?? '';
        $type = $input['type'] ?? 'both'; // 'short', 'full', 'both', 'blog_seo'
        
        if (empty($softwareName)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'El nombre es requerido'
            ]);
            return;
        }
        
        try {
            $gemini = new GeminiService();
            
            if ($type === 'blog_seo') {
                $result = $gemini->generateBlogSEO($softwareName, $category);
                
                if (!$result['short']['success'] || !$result['full']['success']) {
                    $error = !$result['short']['success'] ? $result['short']['error'] : $result['full']['error'];
                    http_response_code(500);
                    echo json_encode(['success' => false, 'error' => $error]);
                    return;
                }
                
                echo json_encode([
                    'success' => true,
                    'short' => $result['short']['text'],
                    'full' => $result['full']['text']
                ]);
                return;
            }

            if ($type === 'both') {
                $result = $gemini->generateBothDescriptions($softwareName, $category, $developer);
                
                // Verificar si ambas generaciones fueron exitosas
                if (!$result['short']['success'] || !$result['full']['success']) {
                    $error = !$result['short']['success'] ? $result['short']['error'] : $result['full']['error'];
                    http_response_code(500);
                    echo json_encode([
                        'success' => false,
                        'error' => $error
                    ]);
                    return;
                }
                
                echo json_encode([
                    'success' => true,
                    'short_description' => $result['short']['text'],
                    'full_description' => $result['full']['text']
                ]);
                
            } elseif ($type === 'short') {
                $result = $gemini->generateShortDescription($softwareName, $category);
                
                if (!$result['success']) {
                    http_response_code(500);
                    echo json_encode($result);
                    return;
                }
                
                echo json_encode([
                    'success' => true,
                    'short_description' => $result['text']
                ]);
                
            } elseif ($type === 'full') {
                $result = $gemini->generateFullDescription($softwareName, $category, $developer);
                
                if (!$result['success']) {
                    http_response_code(500);
                    echo json_encode($result);
                    return;
                }
                
                echo json_encode([
                    'success' => true,
                    'full_description' => $result['text']
                ]);
            } elseif ($type === 'site') {
                $siteName = $input['site_name'] ?? 'SoftHub';
                $result = $gemini->generateSiteDescription($siteName);
                
                if (!$result['success']) {
                    http_response_code(500);
                    echo json_encode($result);
                    return;
                }
                
                echo json_encode([
                    'success' => true,
                    'description' => $result['text']
                ]);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Error del servidor: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Generar Artículos de Blog con IA SEO optimizados
     */
    public function generateBlogPost()
    {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Método no permitido']);
            return;
        }
        
        $title = $_POST['title'] ?? '';
        $category = $_POST['category'] ?? '';
        
        if (empty($title)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'El título del artículo es requerido']);
            return;
        }
        
        try {
            $gemini = new GeminiService();
            $result = $gemini->generateBlogPost($title, $category);
            
            if (!$result['success']) {
                http_response_code(500);
                echo json_encode($result);
                return;
            }
            
            echo json_encode([
                'success' => true,
                'text' => $result['text']
            ]);
            
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Probar conexión con Gemini
     */
    public function testConnection()
    {
        header('Content-Type: application/json');
        
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $apiKey = $input['api_key'] ?? '';
            
            if (empty($apiKey)) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'error' => 'API key es requerida'
                ]);
                return;
            }
            
            // Crear instancia temporal con la API key proporcionada
            $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $apiKey;
            
            $data = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => 'Di "OK" si puedes leer esto.']
                        ]
                    ]
                ]
            ];
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            
            // Desactivar verificación SSL solo en desarrollo local
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);
            
            // Si hay error de curl
            if ($curlError) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'error' => 'Error de conexión: ' . $curlError
                ]);
                return;
            }
            
            if ($httpCode === 200) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Conexión exitosa con Google Gemini'
                ]);
            } else {
                $errorData = json_decode($response, true);
                $errorMessage = $errorData['error']['message'] ?? 'Error desconocido';
                
                // Agregar más detalles para debug
                $debugInfo = '';
                if ($httpCode === 0) {
                    $debugInfo = ' (No se pudo conectar con el servidor de Google)';
                } elseif ($httpCode === 400) {
                    $debugInfo = ' (API key inválida o request malformado)';
                } elseif ($httpCode === 403) {
                    $debugInfo = ' (API key sin permisos)';
                }
                
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'error' => $errorMessage . $debugInfo,
                    'http_code' => $httpCode,
                    'response' => $response
                ]);
            }
            
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}
