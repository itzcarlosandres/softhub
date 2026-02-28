<?php
// UPDATED: 2025-12-28 13:32 - Fixed file_size to use download_links table

namespace App\Controllers;

use App\Models\Software;
use App\Models\Category;

class SoftwareController extends Controller
{
    private $softwareModel;
    private $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->softwareModel = new Software();
        $this->categoryModel = new Category();
    }

    public function index()
    {
        $page = $_GET['page'] ?? 1;
        $sort = $_GET['sort'] ?? 'latest';
        $categoryId = $_GET['category'] ?? null;
        
        // Obtener software con filtros
        $perPage = 24;
        
        // Obtener conexión a la base de datos
        $db = \App\Database::getInstance()->getConnection();
        $query = "SELECT * FROM software WHERE status = 'approved'";
        $params = [];
        
        // Filtro por categoría
        if ($categoryId) {
            $query .= " AND category_id = ?";
            $params[] = $categoryId;
        }
        
        // Ordenamiento
        switch ($sort) {
            case 'downloads':
                $query .= " ORDER BY downloads DESC";
                break;
            case 'rating':
                $query .= " ORDER BY rating DESC";
                break;
            case 'name':
                $query .= " ORDER BY name ASC";
                break;
            default: // latest
                $query .= " ORDER BY created_at DESC";
        }
        
        // Paginación
        $offset = ($page - 1) * $perPage;
        $query .= " LIMIT ? OFFSET ?";
        $params[] = $perPage;
        $params[] = $offset;
        
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        $software = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Total para paginación
        $countQuery = "SELECT COUNT(*) FROM software WHERE status = 'approved'";
        $countParams = [];
        if ($categoryId) {
            $countQuery .= " AND category_id = ?";
            $countParams[] = $categoryId;
        }
        $stmt = $db->prepare($countQuery);
        $stmt->execute($countParams);
        $total = $stmt->fetchColumn();
        $totalPages = ceil($total / $perPage);
        
        // Obtener categorías para el filtro
        $categoryModel = new \App\Models\Category();
        $categories = $categoryModel->withSoftwareCount();

        return $this->view('pages/software/index', [
            'title' => 'Todos los Programas',
            'software' => $software,
            'categories' => $categories,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function popular()
    {
        $db = \App\Database::getInstance()->getConnection();
        $stmt = $db->query("
            SELECT s.*, c.name as category_name 
            FROM software s 
            LEFT JOIN categories c ON s.category_id = c.id 
            WHERE s.status = 'approved' 
            ORDER BY s.downloads DESC 
            LIMIT 24
        ");
        $popular = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return $this->view('pages/software/popular', [
            'title' => 'Los Más Populares - Software Top',
            'popular' => $popular
        ]);
    }

    public function latest()
    {
        $latest = $this->softwareModel->paginate(1, 15); // Use paginate to be consistent
        
        return $this->view('pages/software/latest', [
            'title' => 'Novedades - Últimos Programas Agregados',
            'latest' => $latest
        ]);
    }

    public function apiLatest()
    {
        $page = $_GET['page'] ?? 1;
        $perPage = 15;
        
        $software = $this->softwareModel->paginate($page, $perPage);
        
        // Return JSON directly
        header('Content-Type: application/json');
        echo json_encode($software);
        exit;
    }

    public function show($slug)
    {
        $software = $this->softwareModel->getBySlug($slug);
        
        if (!$software) {
            http_response_code(404);
            return $this->view('errors/404');
        }

        // Obtener la versión más reciente para mostrar el tamaño
        $db = \App\Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT file_size FROM software_versions WHERE software_id = ? ORDER BY release_date DESC, id DESC LIMIT 1");
        $stmt->execute([$software['id']]);
        $latestVersion = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        // Prioridad: 1) Versión más reciente, 2) Tabla software, 3) Primer enlace de WINDOWS
        if ($latestVersion && !empty($latestVersion['file_size'])) {
            // Usar tamaño de la versión más reciente
            $software['file_size'] = $latestVersion['file_size'];
        } elseif (empty($software['file_size'])) {
            // Si no hay tamaño en software, buscar en download_links (PRIORIDAD: Windows primero)
            $stmt = $db->prepare("
                SELECT file_size FROM download_links 
                WHERE software_id = ? 
                AND file_size IS NOT NULL 
                AND file_size != '' 
                ORDER BY 
                    CASE 
                        WHEN platform = 'Windows' THEN 1
                        WHEN platform = 'Mac' THEN 2
                        WHEN platform = 'Linux' THEN 3
                        WHEN platform = 'Android' THEN 4
                        ELSE 5
                    END
                LIMIT 1
            ");
            $stmt->execute([$software['id']]);
            $downloadLink = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if ($downloadLink && !empty($downloadLink['file_size'])) {
                $software['file_size'] = $downloadLink['file_size'];
            }
        }
        
        // DEBUG TEMPORAL - ELIMINAR DESPUÉS
        error_log("DEBUG SHOW - Software ID: {$software['id']}, file_size final: " . ($software['file_size'] ?: 'EMPTY'));

        return $this->view('pages/software/show', [
            'title' => $software['name'] . ' - Descargar Gratis',
            'software' => $software
        ]);
    }

    public function download($id)
    {
        $software = $this->softwareModel->find($id);
        
        if (!$software) {
            http_response_code(404);
            return $this->view('errors/404');
        }

        // Increment download counter
        $this->softwareModel->incrementDownloads($id);

        // Get custom countdown from settings
        $settingsModel = new \App\Models\SiteSetting();
        $countdown = $settingsModel->get('download_countdown', 15);

        // Always show download page with countdown
        return $this->view('pages/software/download', [
            'title' => 'Descargar ' . $software['name'],
            'software' => $software,
            'countdown' => $countdown
        ]);
    }

    public function search()
    {
        $query = $_GET['q'] ?? '';
        $page = $_GET['page'] ?? 1;
        
        if (empty($query)) {
            $this->redirect('/software');
        }

        $software = $this->softwareModel->search($query, $page, 24);
        
        $db = \App\Database::getInstance()->getConnection();
        $settingsModel = new \App\Models\SiteSetting();

        return $this->view('pages/software/search', [
            'title' => 'Resultados de búsqueda: ' . $query,
            'software' => $software,
            'query' => $query,
            'currentPage' => $page,
            'db' => $db,
            'heroDotsActive' => ($settingsModel->get('home_hero_dots_active') == '1'),
            'heroSpotlightActive' => ($settingsModel->get('home_hero_spotlight_active') == '1')
        ]);
    }
}
