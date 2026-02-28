<?php

namespace App\Controllers;

class Controller
{
    public function __construct()
    {
        // Base constructor
    }

    protected function view($view, $data = [])
    {
        // Agregar $db automáticamente a todas las vistas
        if (!isset($data['db'])) {
            $data['db'] = \App\Database::getInstance()->getConnection();
        }
        
        // Agregar parámetros de ruta si existen
        if (!isset($data['params']) && isset($GLOBALS['route_params'])) {
            $data['params'] = $GLOBALS['route_params'];
        }
        
        extract($data);
        $viewPath = __DIR__ . "/../Views/{$view}.php";
        
        if (file_exists($viewPath)) {
            ob_start();
            include $viewPath;
            $content = ob_get_clean();
            echo $content;
        } else {
            throw new \Exception("View not found: {$view}");
        }
    }

    protected function redirect($url)
    {
        // Si la URL no empieza con http, usar la función url()
        if (!str_starts_with($url, 'http')) {
            $url = url($url);
        }
        header("Location: {$url}");
        exit;
    }

    protected function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function isAuthenticated()
    {
        return isset($_SESSION['user_id']);
    }

    protected function requireAuth()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('/admin/login');
        }
    }

    protected function requireAdmin()
    {
        $this->requireAuth();
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $this->redirect('/');
        }
    }
}
