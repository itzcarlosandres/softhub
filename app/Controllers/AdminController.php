<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Software;
use App\Models\Category;
use App\Models\License;

class AdminController extends Controller
{
    private $userModel;
    private $softwareModel;
    private $categoryModel;
    private $licenseModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
        $this->softwareModel = new Software();
        $this->categoryModel = new Category();
        $this->licenseModel = new License();
    }

    // Dashboard
    public function dashboard()
    {
        $this->requireAdmin();
        
        // Basic Counts
        $totalSoftware = $this->softwareModel->count();
        $totalCategories = $this->categoryModel->count();
        $totalUsers = $this->userModel->count();

        // Advanced Stats (Direct DB for Sums/Joins)
        $db = \App\Database::getInstance();
        
        $totalDownloads = $db->fetchOne("SELECT SUM(downloads) as total FROM software")['total'] ?? 0;
        
        // Top Software
        $topSoftware = $db->fetchAll("
            SELECT name, downloads, icon 
            FROM software 
            WHERE status = 'published' OR status = 'approved'
            ORDER BY downloads DESC 
            LIMIT 5
        ");

        // Recent Activity
        $recentActivity = $db->fetchAll("
            SELECT name, created_at, downloads, icon
            FROM software 
            ORDER BY created_at DESC
            LIMIT 5
        ");

        return $this->view('admin/dashboard', [
            'title' => 'Panel de Administración',
            'stats' => [
                'total_software' => $totalSoftware,
                'total_downloads' => $totalDownloads,
                'total_users' => $totalUsers,
                'total_categories' => $totalCategories,
            ],
            'topSoftware' => $topSoftware,
            'recentActivity' => $recentActivity
        ]);
    }

    // Login
    public function showLogin()
    {
        if ($this->isAuthenticated()) {
            $this->redirect('/admin');
        }
        
        return $this->view('admin/login', [
            'title' => 'Iniciar Sesión - Admin'
        ]);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/login');
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->findByEmail($email);

        if ($user && $this->userModel->verifyPassword($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            
            $this->redirect('/admin');
        } else {
            $_SESSION['error'] = 'Credenciales incorrectas';
            $this->redirect('/admin/login');
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/admin/login');
    }

    // Software Management
    public function softwareList()
    {
        $this->requireAdmin();
        
        $page = $_GET['page'] ?? 1;
        $software = $this->softwareModel->paginate($page, 20);
        $total = $this->softwareModel->count();
        $totalPages = ceil($total / 20);

        return $this->view('admin/software/index', [
            'title' => 'Gestión de Software',
            'software' => $software,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function softwareCreate()
    {
        $this->requireAdmin();
        
        $categories = $this->categoryModel->all();

        return $this->view('admin/software/create', [
            'title' => 'Agregar Nuevo Software',
            'categories' => $categories
        ]);
    }

    public function softwareStore()
    {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/software');
        }

        // Combinar plataformas seleccionadas en un string
        $platforms = isset($_POST['platforms']) ? implode(', ', $_POST['platforms']) : '';

        $slug = $this->generateSlug($_POST['name'] ?? '');
        $originalSlug = $slug;
        $counter = 1;

        // Verificar si el slug ya existe y generar uno único
        while (!empty($this->softwareModel->where('slug', $slug))) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $data = [
            'name' => $_POST['name'] ?? '',
            'slug' => $slug,
            'description' => $_POST['description'] ?? '',
            'short_description' => $_POST['short_description'] ?? '',
            'version' => $_POST['version'] ?? '',
            'developer' => $_POST['developer'] ?? '',
            'category_id' => $_POST['category_id'] ?? null,
            'license' => $_POST['license'] ?? 'free',
            'operating_system' => $platforms,
            'file_size' => $_POST['file_size'] ?? '',
            'price' => isset($_POST['price']) && $_POST['price'] !== '' ? (float)$_POST['price'] : 0.00,
            'buy_url' => $_POST['buy_url'] ?? '',
            'download_url' => '', // Ya no se usa, se guardan en download_links
            'requirements' => $_POST['requirements'] ?? '',
            'status' => 'approved', // Publicación directa
            'featured' => isset($_POST['featured']) ? 1 : 0,
            'downloads' => 0,
            'rating' => 0
        ];

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $data['image'] = $this->uploadFile($_FILES['image'], 'images');
        }

        // Handle icon upload
        if (isset($_FILES['icon']) && $_FILES['icon']['error'] === 0) {
            $data['icon'] = $this->uploadFile($_FILES['icon'], 'icons');
        }

        $softwareId = $this->softwareModel->create($data);
        
        // Guardar enlaces de descarga múltiples
        if (isset($_POST['download_links']) && is_array($_POST['download_links'])) {
            $downloadLinkModel = new \App\Models\DownloadLink();
            
            foreach ($_POST['download_links'] as $platform => $links) {
                // Verificar si es un array de enlaces múltiples o un solo enlace
                if (isset($links['url'])) {
                    // Formato antiguo: un solo enlace por plataforma
                    if (!empty($links['url'])) {
                        $downloadLinkModel->create([
                            'software_id' => $softwareId,
                            'platform' => $platform,
                            'download_url' => $links['url'],
                            'file_size' => $links['size'] ?? null,
                            'version' => $links['version'] ?? null
                        ]);
                    }
                } else {
                    // Formato nuevo: múltiples enlaces por plataforma
                    foreach ($links as $linkData) {
                        if (!empty($linkData['url'])) {
                            $downloadLinkModel->create([
                                'software_id' => $softwareId,
                                'platform' => $platform,
                                'download_url' => $linkData['url'],
                                'file_size' => $linkData['size'] ?? null,
                                'version' => $linkData['version'] ?? null
                            ]);
                        }
                    }
                }
            }
        }

        $_SESSION['success'] = 'Software agregado exitosamente';
        $this->redirect('/admin/software');
    }

    public function softwareEdit($id)
    {
        $this->requireAdmin();
        
        $software = $this->softwareModel->find($id);
        if (!$software) {
            $_SESSION['error'] = 'Software no encontrado';
            $this->redirect('/admin/software');
        }

        $categories = $this->categoryModel->all();

        return $this->view('admin/software/edit', [
            'title' => 'Editar Software',
            'software' => $software,
            'categories' => $categories
        ]);
    }

    public function softwareUpdate($id)
    {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/software');
        }

        $data = [
            'name' => $_POST['name'] ?? '',
            'slug' => $this->generateSlug($_POST['name'] ?? ''),
            'description' => $_POST['description'] ?? '',
            'short_description' => $_POST['short_description'] ?? '',
            'version' => $_POST['version'] ?? '',
            'developer' => $_POST['developer'] ?? '',
            'category_id' => $_POST['category_id'] ?? null,
            'license' => $_POST['license'] ?? 'free',
            'operating_system' => $_POST['operating_system'] ?? '',
            'file_size' => $_POST['file_size'] ?? '',
            'price' => isset($_POST['price']) && $_POST['price'] !== '' ? (float)$_POST['price'] : 0.00,
            'buy_url' => $_POST['buy_url'] ?? '',
            'download_url' => $_POST['download_url'] ?? '',
            'requirements' => $_POST['requirements'] ?? '',
            'status' => 'approved', // Siempre publicado
            'featured' => isset($_POST['featured']) ? 1 : 0,
            'badge_editors_choice' => isset($_POST['badge_editors_choice']) ? 1 : 0
        ];

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $data['image'] = $this->uploadFile($_FILES['image'], 'images');
        }

        // Handle icon upload
        if (isset($_FILES['icon']) && $_FILES['icon']['error'] === 0) {
            $data['icon'] = $this->uploadFile($_FILES['icon'], 'icons');
        }

        // DEBUG: Guardar datos en log
        $logFile = __DIR__ . '/../../storage/logs/debug.log';
        $logDir = dirname($logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - UPDATE ID: $id\n" . print_r($data, true) . "\n\n", FILE_APPEND);

        // Ejecutar update y verificar resultado
        $result = $this->softwareModel->update($id, $data);
        
        // DEBUG: Verificar resultado del update
        file_put_contents($logFile, "UPDATE RESULT: " . ($result ? 'SUCCESS' : 'FAILED') . "\n", FILE_APPEND);
        
        // DEBUG: Verificar datos después del update
        $updated = $this->softwareModel->find($id);
        file_put_contents($logFile, "DATOS DESPUÉS DEL UPDATE:\n" . print_r($updated, true) . "\n\n", FILE_APPEND);

        $_SESSION['success'] = 'Software actualizado exitosamente';
        $this->redirect('/admin/software');
    }

    public function softwareDelete($id)
    {
        $this->requireAdmin();
        
        $this->softwareModel->delete($id);
        
        $_SESSION['success'] = 'Software eliminado exitosamente';
        $this->redirect('/admin/software');
    }

    public function toggleFeatured($id)
    {
        $this->requireAdmin();
        
        // Obtener el software actual
        $software = $this->softwareModel->find($id);
        
        if (!$software) {
            $_SESSION['error'] = 'Software no encontrado';
            $this->redirect('/admin/software');
        }
        
        // Cambiar el estado de featured
        $newFeaturedStatus = $software['featured'] ? 0 : 1;
        
        $this->softwareModel->update($id, [
            'featured' => $newFeaturedStatus
        ]);
        
        $message = $newFeaturedStatus ? 'Software marcado como destacado' : 'Software removido de destacados';
        $_SESSION['success'] = $message;
        
        $this->redirect('/admin/software');
    }

    public function toggleTrending($id)
    {
        $this->requireAdmin();
        
        // Obtener el software actual
        $software = $this->softwareModel->find($id);
        
        if (!$software) {
            $_SESSION['error'] = 'Software no encontrado';
            $this->redirect('/admin/software');
        }
        
        // Cambiar el estado de trending
        $newTrendingStatus = $software['trending'] ? 0 : 1;
        
        $this->softwareModel->update($id, [
            'trending' => $newTrendingStatus
        ]);
        
        $message = $newTrendingStatus ? 'Software marcado como trending' : 'Software removido de trending';
        $_SESSION['success'] = $message;
        
        $this->redirect('/admin/software');
    }

    // Category Management
    public function categoryList()
    {
        $this->requireAdmin();
        
        $categories = $this->categoryModel->withSoftwareCount();

        return $this->view('admin/categories/index', [
            'title' => 'Gestión de Categorías',
            'categories' => $categories
        ]);
    }

    public function categoryCreate()
    {
        $this->requireAdmin();

        return $this->view('admin/categories/create', [
            'title' => 'Agregar Nueva Categoría'
        ]);
    }

    public function categoryStore()
    {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/categories');
        }

        $data = [
            'name' => $_POST['name'] ?? '',
            'slug' => $this->generateSlug($_POST['name'] ?? ''),
            'description' => $_POST['description'] ?? '',
            'icon' => $_POST['icon'] ?? ''
        ];

        $this->categoryModel->create($data);

        $_SESSION['success'] = 'Categoría agregada exitosamente';
        $this->redirect('/admin/categories');
    }

    public function categoryEdit($id)
    {
        $this->requireAdmin();
        
        $category = $this->categoryModel->find($id);
        if (!$category) {
            $_SESSION['error'] = 'Categoría no encontrada';
            $this->redirect('/admin/categories');
        }

        return $this->view('admin/categories/edit', [
            'title' => 'Editar Categoría',
            'category' => $category
        ]);
    }

    public function categoryUpdate($id)
    {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/categories');
        }

        $data = [
            'name' => $_POST['name'] ?? '',
            'slug' => $this->generateSlug($_POST['name'] ?? ''),
            'description' => $_POST['description'] ?? '',
            'icon' => $_POST['icon'] ?? ''
        ];

        $this->categoryModel->update($id, $data);

        $_SESSION['success'] = 'Categoría actualizada exitosamente';
        $this->redirect('/admin/categories');
    }

    public function categoryDelete($id)
    {
        $this->requireAdmin();
        
        // Primero, actualizar todos los software que usan esta categoría
        // Establecer category_id a NULL para evitar referencias huérfanas
        $db = \App\Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE software SET category_id = NULL WHERE category_id = ?");
        $stmt->execute([$id]);
        
        // Ahora eliminar la categoría
        $this->categoryModel->delete($id);
        
        $_SESSION['success'] = 'Categoría eliminada exitosamente';
        $this->redirect('/admin/categories');
    }

    // License Management
    public function licenseList()
    {
        $this->requireAdmin();
        $licenses = $this->licenseModel->withSoftwareCount();
        
        return $this->view('admin/licenses/index', [
            'title' => 'Gestión de Licencias',
            'licenses' => $licenses
        ]);
    }

    public function licenseStore()
    {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/licenses');
        }

        $data = [
            'name' => $_POST['name'] ?? '',
            'slug' => $this->generateSlug($_POST['name'] ?? '')
        ];

        $this->licenseModel->create($data);

        $_SESSION['success'] = 'Tipo de Licencia agregada exitosamente';
        $this->redirect('/admin/licenses');
    }

    public function licenseDelete($id)
    {
        $this->requireAdmin();
        
        // Al eliminar licencia, los software no se cambian automáticamente salvo que se decida.
        // Pero para ser limpios, ponemos el slug en 'free' o lo dejamos huérfano (la DB tiene license como texto)
        // Obtener la licencia para saber su slug
        $license = $this->licenseModel->find($id);
        if ($license) {
            $db = \App\Database::getInstance()->getConnection();
            $stmt = $db->prepare("UPDATE software SET license = 'free' WHERE license = ?");
            $stmt->execute([$license['slug']]);
            $this->licenseModel->delete($id);
            $_SESSION['success'] = 'Licencia eliminada exitosamente';
        }
        
        $this->redirect('/admin/licenses');
    }

    // Settings
    public function settings()
    {
        $this->requireAdmin();
        
        $settingsModel = new \App\Models\SiteSetting();
        $allSettings = $settingsModel->getAll();
        
        // Organizar configuraciones por key
        $settings = [];
        foreach ($allSettings as $setting) {
            $settings[$setting['setting_key']] = [
                'setting_key' => $setting['setting_key'],
                'setting_value' => $setting['setting_value']
            ];
        }
        
        return $this->view('admin/settings', [
            'title' => 'Configuración del Sitio',
            'settings' => $settings
        ]);
    }

    public function settingsSave()
    {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/settings');
        }

        $settingsModel = new \App\Models\SiteSetting();
        
        // Procesar logo
        if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === 0) {
            // Validar tamaño (máximo 2MB)
            if ($_FILES['site_logo']['size'] > 2 * 1024 * 1024) {
                $_SESSION['error'] = 'El logo no debe superar los 2MB';
                $this->redirect('/admin/settings');
            }
            
            // Validar tipo de archivo
            $allowedTypes = ['image/png', 'image/jpeg', 'image/svg+xml', 'image/webp'];
            if (!in_array($_FILES['site_logo']['type'], $allowedTypes)) {
                $_SESSION['error'] = 'Formato de logo no válido. Use PNG, JPG, SVG o WebP';
                $this->redirect('/admin/settings');
            }
            
            // Eliminar logo anterior si existe
            $oldLogo = $settingsModel->get('site_logo');
            if ($oldLogo && file_exists(__DIR__ . '/../../public/' . $oldLogo)) {
                unlink(__DIR__ . '/../../public/' . $oldLogo);
            }
            
            // Subir nuevo logo
            $logoPath = $this->uploadFile($_FILES['site_logo'], 'branding');
            if ($logoPath) {
                $settingsModel->set('site_logo', $logoPath);
            }
        }
        
        // Eliminar logo si se marcó la opción
        if (isset($_POST['remove_logo']) && $_POST['remove_logo'] == '1') {
            $oldLogo = $settingsModel->get('site_logo');
            if ($oldLogo && file_exists(__DIR__ . '/../../public/' . $oldLogo)) {
                unlink(__DIR__ . '/../../public/' . $oldLogo);
            }
            $settingsModel->set('site_logo', '');
        }
        
        // Procesar favicon
        if (isset($_FILES['site_favicon']) && $_FILES['site_favicon']['error'] === 0) {
            // Validar tamaño (máximo 1MB)
            if ($_FILES['site_favicon']['size'] > 1024 * 1024) {
                $_SESSION['error'] = 'El favicon no debe superar 1MB';
                $this->redirect('/admin/settings');
            }
            
            // Validar tipo de archivo
            $allowedTypes = [
                'image/x-icon', 
                'image/vnd.microsoft.icon', 
                'image/png', 
                'image/svg+xml', 
                'image/ico', 
                'image/icon'
            ];
            $extension = strtolower(pathinfo($_FILES['site_favicon']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['ico', 'png', 'svg'];

            if (!in_array($_FILES['site_favicon']['type'], $allowedTypes) && !in_array($extension, $allowedExtensions)) {
                $_SESSION['error'] = 'Formato de favicon no válido. Use ICO, PNG o SVG (Detectado: ' . $_FILES['site_favicon']['type'] . ')';
                $this->redirect('/admin/settings');
            }
            
            // Eliminar favicon anterior si existe
            $oldFavicon = $settingsModel->get('site_favicon');
            if ($oldFavicon && file_exists(__DIR__ . '/../../public/' . $oldFavicon)) {
                unlink(__DIR__ . '/../../public/' . $oldFavicon);
            }
            
            // Subir nuevo favicon
            $faviconPath = $this->uploadFile($_FILES['site_favicon'], 'branding');
            if ($faviconPath) {
                $settingsModel->set('site_favicon', $faviconPath);
            }
        }
        
        // Eliminar favicon si se marcó la opción
        if (isset($_POST['remove_favicon']) && $_POST['remove_favicon'] == '1') {
            $oldFavicon = $settingsModel->get('site_favicon');
            if ($oldFavicon && file_exists(__DIR__ . '/../../public/' . $oldFavicon)) {
                unlink(__DIR__ . '/../../public/' . $oldFavicon);
            }
            $settingsModel->set('site_favicon', '');
        }
        
        // Procesar otras configuraciones (incluyendo gemini_api_key)
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'setting_') === 0) {
                $settingKey = str_replace('setting_', '', $key);
                $settingsModel->set($settingKey, trim($value));
            }
        }
        
        // Guardar explícitamente gemini_api_key si se envió
        if (isset($_POST['setting_gemini_api_key'])) {
            $settingsModel->set('gemini_api_key', trim($_POST['setting_gemini_api_key']));
        }
        
        // Configuraciones de tipo checkbox (si no están en POST, se guardan como 0)
        $aiEnabled = isset($_POST['setting_ai_enabled']) ? '1' : '0';
        $settingsModel->set('ai_enabled', $aiEnabled);
        
        $dynamicActive = isset($_POST['setting_home_hero_dynamic_active']) ? '1' : '0';
        $settingsModel->set('home_hero_dynamic_active', $dynamicActive);
        
        $dotsActive = isset($_POST['setting_home_hero_dots_active']) ? '1' : '0';
        $settingsModel->set('home_hero_dots_active', $dotsActive);
        
        $spotlightActive = isset($_POST['setting_home_hero_spotlight_active']) ? '1' : '0';
        $settingsModel->set('home_hero_spotlight_active', $spotlightActive);
        
        $_SESSION['success'] = 'Configuraciones guardadas exitosamente';
        $this->redirect('/admin/settings');
    }

    // Helper Methods
    private function generateSlug($string)
    {
        $string = strtolower(trim($string));
        $string = preg_replace('/[^a-z0-9-]/', '-', $string);
        $string = preg_replace('/-+/', '-', $string);
        return trim($string, '-');
    }

    private function uploadFile($file, $folder = 'uploads')
    {
        $uploadDir = __DIR__ . '/../../public/uploads/' . $folder . '/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = uniqid() . '.' . $extension;
        $destination = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            
            // 🖼️ OPTIMIZACIÓN AUTOMÁTICA DE IMÁGENES (Saltar para branding - Logo/Favicon)
            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array($extension, $imageExtensions) && $folder !== 'branding') {
                try {
                    // Importar ImageOptimizer
                    require_once __DIR__ . '/../Helpers/ImageOptimizer.php';
                    
                    // 1. Optimizar y convertir a WebP
                    $webpPath = \App\Helpers\ImageOptimizer::optimizeImage(
                        $destination,
                        1200,  // Max width
                        85     // Quality
                    );
                    
                    // 2. Crear thumbnail
                    $thumbPath = \App\Helpers\ImageOptimizer::createThumbnail(
                        $destination,
                        300,   // Width
                        300    // Height
                    );
                    
                    // Si la conversión fue exitosa, usar la versión WebP
                    if ($webpPath && file_exists($webpPath)) {
                        // Eliminar imagen original para ahorrar espacio
                        if ($extension !== 'webp') {
                            @unlink($destination);
                        }
                        
                        // Actualizar filename a WebP
                        $filename = basename($webpPath);
                        
                        // Log de optimización
                        error_log("✅ Imagen optimizada: " . $filename);
                        if ($thumbPath) {
                            error_log("✅ Thumbnail creado: " . basename($thumbPath));
                        }
                    }
                    
                } catch (\Exception $e) {
                    // Si falla la optimización, continuar con la imagen original
                    error_log("⚠️ Error al optimizar imagen: " . $e->getMessage());
                }
            }
            
            // Devolver la ruta relativa para que funcione con url()
            return 'uploads/' . $folder . '/' . $filename;
        }

        return null;
    }
    
    // ========================================
    // GESTIÓN DE PERFIL
    // ========================================
    
    public function profile()
    {
        $this->requireAdmin();
        return $this->view('admin/profile');
    }
    
    public function updateInfo()
    {
        $this->requireAdmin();
        
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $userId = $_SESSION['user_id'];
        
        if (empty($name) || empty($email)) {
            $_SESSION['error'] = 'Todos los campos son requeridos';
            $this->redirect('/admin/profile');
            return;
        }
        
        // Validar email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email inválido';
            $this->redirect('/admin/profile');
            return;
        }
        
        try {
            $db = \App\Database::getInstance()->getConnection();
            
            // Verificar si el email ya existe (excepto el usuario actual)
            $stmt = $db->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $stmt->execute([$email, $userId]);
            if ($stmt->fetch()) {
                $_SESSION['error'] = 'Este email ya está en uso';
                $this->redirect('/admin/profile');
                return;
            }
            
            // Actualizar información (solo name y email, no username)
            $stmt = $db->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
            $stmt->execute([$name, $email, $userId]);
            
            // Actualizar sesión
            $_SESSION['user_name'] = $name;
            
            $_SESSION['success'] = 'Información actualizada correctamente';
            $this->redirect('/admin/profile');
            
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error al actualizar: ' . $e->getMessage();
            $this->redirect('/admin/profile');
        }
    }
    
    public function updatePassword()
    {
        $this->requireAdmin();
        
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $userId = $_SESSION['user_id'];
        
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['error'] = 'Todos los campos son requeridos';
            $this->redirect('/admin/profile');
            return;
        }
        
        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = 'Las contraseñas no coinciden';
            $this->redirect('/admin/profile');
            return;
        }
        
        if (strlen($newPassword) < 6) {
            $_SESSION['error'] = 'La contraseña debe tener al menos 6 caracteres';
            $this->redirect('/admin/profile');
            return;
        }
        
        try {
            $db = \App\Database::getInstance()->getConnection();
            
            // Verificar contraseña actual
            $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch();
            
            if (!$user || !password_verify($currentPassword, $user['password'])) {
                $_SESSION['error'] = 'La contraseña actual es incorrecta';
                $this->redirect('/admin/profile');
                return;
            }
            
            // Actualizar contraseña
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$hashedPassword, $userId]);
            
            $_SESSION['success'] = 'Contraseña actualizada correctamente';
            $this->redirect('/admin/profile');
            
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error al actualizar contraseña: ' . $e->getMessage();
            $this->redirect('/admin/profile');
        }
    }

    // ========================================
    // BLOG CATEGORIES
    // ========================================
    
    public function blogCategoryList()
    {
        $this->requireAdmin();
        $db = \App\Database::getInstance()->getConnection();
        $stmt = $db->query("
            SELECT c.*, COUNT(p.id) as posts_count 
            FROM blog_categories c 
            LEFT JOIN blog_posts p ON c.id = p.blog_category_id 
            GROUP BY c.id 
            ORDER BY c.name ASC
        ");
        $categories = $stmt->fetchAll();
        
        return $this->view('admin/blog_categories/index', [
            'title' => 'Categorías del Blog',
            'categories' => $categories
        ]);
    }

    public function blogCategoryStore()
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/blog-categories');
        }

        $name = trim($_POST['name'] ?? '');
        if (empty($name)) {
            $_SESSION['error'] = 'El nombre de la categoría es requerido';
            $this->redirect('/admin/blog-categories');
            return;
        }

        $slug = $this->generateSlug($name);
        
        $db = \App\Database::getInstance()->getConnection();
        
        // Ensure slug is unique
        $stmt = $db->prepare("SELECT id FROM blog_categories WHERE slug = ?");
        $stmt->execute([$slug]);
        if ($stmt->fetch()) {
            $slug .= '-' . time();
        }

        $stmt = $db->prepare("INSERT INTO blog_categories (name, slug) VALUES (?, ?)");
        if ($stmt->execute([$name, $slug])) {
            $_SESSION['success'] = 'Categoría creada exitosamente';
        } else {
            $_SESSION['error'] = 'Error al crear la categoría';
        }

        $this->redirect('/admin/blog-categories');
    }

    public function blogCategoryUpdate($id)
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/blog-categories');
        }

        $name = trim($_POST['name'] ?? '');
        if (empty($name)) {
            $_SESSION['error'] = 'El nombre es requerido';
            $this->redirect('/admin/blog-categories');
            return;
        }

        $slug = $this->generateSlug($name);
        $db = \App\Database::getInstance()->getConnection();

        // Ensure slug uniqueness ignoring current
        $stmt = $db->prepare("SELECT id FROM blog_categories WHERE slug = ? AND id != ?");
        $stmt->execute([$slug, $id]);
        if ($stmt->fetch()) {
            $slug .= '-' . time();
        }

        $stmt = $db->prepare("UPDATE blog_categories SET name = ?, slug = ? WHERE id = ?");
        if ($stmt->execute([$name, $slug, $id])) {
            $_SESSION['success'] = 'Categoría actualizada exitosamente';
        } else {
            $_SESSION['error'] = 'Error al actualizar categoría';
        }

        $this->redirect('/admin/blog-categories');
    }

    public function blogCategoryDelete($id)
    {
        $this->requireAdmin();
        $db = \App\Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM blog_categories WHERE id = ?");
        if ($stmt->execute([$id])) {
            $_SESSION['success'] = 'Categoría eliminada exitosamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar categoría';
        }
        $this->redirect('/admin/blog-categories');
    }

    // ========================================
    // BLOG POSTS
    // ========================================

    public function blogPostList()
    {
        $this->requireAdmin();
        $db = \App\Database::getInstance()->getConnection();
        
        $stmt = $db->query("
            SELECT p.*, c.name as category_name, u.name as author_name 
            FROM blog_posts p 
            LEFT JOIN blog_categories c ON p.blog_category_id = c.id
            LEFT JOIN users u ON p.author_id = u.id
            ORDER BY p.created_at DESC
        ");
        $posts = $stmt->fetchAll();

        return $this->view('admin/blog_posts/index', [
            'title' => 'Artículos del Blog',
            'posts' => $posts
        ]);
    }

    public function blogPostCreate()
    {
        $this->requireAdmin();
        $db = \App\Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM blog_categories ORDER BY name ASC");
        $categories = $stmt->fetchAll();

        return $this->view('admin/blog_posts/create', [
            'title' => 'Crear Artículo',
            'categories' => $categories
        ]);
    }

    public function blogPostStore()
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/blog-posts');
        }

        $title = trim($_POST['title'] ?? '');
        $categoryId = $_POST['blog_category_id'] ?? null;
        $extract = trim($_POST['extract'] ?? '');
        $content = $_POST['content'] ?? '';
        $isFeatured = isset($_POST['is_featured']) ? 1 : 0;
        $authorId = $_SESSION['user_id'] ?? 1; // Fallback to 1 if not set
        
        $slug = $this->generateSlug($title);
        $db = \App\Database::getInstance()->getConnection();
        
        // Ensure slug is unique
        $stmt = $db->prepare("SELECT id FROM blog_posts WHERE slug = ?");
        $stmt->execute([$slug]);
        if ($stmt->fetch()) {
            $slug .= '-' . time();
        }

        $imgPath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $imgPath = $this->uploadFile($_FILES['image'], 'blog');
        }

        $stmt = $db->prepare("
            INSERT INTO blog_posts 
            (blog_category_id, title, slug, extract, content, image, is_featured, author_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        if ($stmt->execute([$categoryId, $title, $slug, $extract, $content, $imgPath, $isFeatured, $authorId])) {
            $_SESSION['success'] = 'Artículo creado exitosamente';
        } else {
            $_SESSION['error'] = 'Error al crear el artículo';
        }

        $this->redirect('/admin/blog-posts');
    }

    public function blogPostEdit($id)
    {
        $this->requireAdmin();
        $db = \App\Database::getInstance()->getConnection();
        
        $stmt = $db->prepare("SELECT * FROM blog_posts WHERE id = ?");
        $stmt->execute([$id]);
        $post = $stmt->fetch();

        if (!$post) {
            $_SESSION['error'] = 'Artículo no encontrado';
            $this->redirect('/admin/blog-posts');
        }

        $catStmt = $db->query("SELECT * FROM blog_categories ORDER BY name ASC");
        $categories = $catStmt->fetchAll();

        return $this->view('admin/blog_posts/edit', [
            'title' => 'Editar Artículo',
            'post' => $post,
            'categories' => $categories
        ]);
    }

    public function blogPostUpdate($id)
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/blog-posts');
        }

        $title = trim($_POST['title'] ?? '');
        $categoryId = $_POST['blog_category_id'] ?? null;
        $extract = trim($_POST['extract'] ?? '');
        $content = $_POST['content'] ?? '';
        $isFeatured = isset($_POST['is_featured']) ? 1 : 0;
        
        $slug = $this->generateSlug($title);
        $db = \App\Database::getInstance()->getConnection();

        // Ensure slug is unique ignoring current post
        $stmt = $db->prepare("SELECT id FROM blog_posts WHERE slug = ? AND id != ?");
        $stmt->execute([$slug, $id]);
        if ($stmt->fetch()) {
            $slug .= '-' . time();
        }

        // Get current image to preserve if no new one
        $stmt = $db->prepare("SELECT image FROM blog_posts WHERE id = ?");
        $stmt->execute([$id]);
        $post = $stmt->fetch();
        $imgPath = $post['image'] ?? null;

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $newImgPath = $this->uploadFile($_FILES['image'], 'blog');
            if ($newImgPath) {
                $imgPath = $newImgPath;
            }
        }

        $stmt = $db->prepare("
            UPDATE blog_posts SET 
            blog_category_id = ?, 
            title = ?, 
            slug = ?, 
            extract = ?, 
            content = ?, 
            image = ?, 
            is_featured = ?
            WHERE id = ?
        ");

        if ($stmt->execute([$categoryId, $title, $slug, $extract, $content, $imgPath, $isFeatured, $id])) {
            $_SESSION['success'] = 'Artículo actualizado exitosamente';
        } else {
            $_SESSION['error'] = 'Error al actualizar el artículo';
        }

        $this->redirect('/admin/blog-posts');
    }

    public function blogPostDelete($id)
    {
        $this->requireAdmin();
        $db = \App\Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM blog_posts WHERE id = ?");
        if ($stmt->execute([$id])) {
            $_SESSION['success'] = 'Artículo eliminado exitosamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar el artículo';
        }
        $this->redirect('/admin/blog-posts');
    }

    public function blogPostToggleFeatured($id)
    {
        $this->requireAdmin();
        $db = \App\Database::getInstance()->getConnection();
        
        $stmt = $db->prepare("SELECT is_featured FROM blog_posts WHERE id = ?");
        $stmt->execute([$id]);
        $post = $stmt->fetch();
        
        if ($post) {
            $newStatus = $post['is_featured'] ? 0 : 1;
            $update = $db->prepare("UPDATE blog_posts SET is_featured = ? WHERE id = ?");
            if ($update->execute([$newStatus, $id])) {
                $_SESSION['success'] = $newStatus ? 'Artículo destacado' : 'Destacado quitado';
            } else {
                $_SESSION['error'] = 'Error al cambiar estado';
            }
        }
        
        $this->redirect('/admin/blog-posts');
    }
}
