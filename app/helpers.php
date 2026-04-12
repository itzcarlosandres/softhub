<?php
/**
 * Helper Functions
 */

if (!function_exists('url')) {
    function url($path = '') {
        $appUrl = env('APP_URL', '');
        
        if ($appUrl) {
            $baseUrl = rtrim($appUrl, '/');
            $cleanPath = ltrim($path, '/');
            
            // Si el path ya empieza con public/, lo limpiamos porque ya estamos dentro en CyberPanel
            if (strpos($cleanPath, 'public/') === 0) {
                $cleanPath = substr($cleanPath, 7);
            }
            
            return $baseUrl . ($cleanPath ? '/' . $cleanPath : '');
        }
        
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        return $protocol . $host . ($path ? '/' . ltrim($path, '/') : '');
    }
}

if (!function_exists('asset')) {
    function asset($path) {
        return url($path);
    }
}

/**
 * Generar título SEO para página de descarga
 */
if (!function_exists('seo_download_title')) {
    function seo_download_title($softwareName, $version = null) {
        return \App\Helpers\SeoHelper::getDownloadTitle($softwareName, $version);
    }
}

/**
 * Generar meta tags SEO
 */
if (!function_exists('seo_meta_tags')) {
    function seo_meta_tags($title = null, $description = null, $keywords = null) {
        return \App\Helpers\SeoHelper::generateMetaTags($title, $description, $keywords);
    }
}

/**
 * Obtener título del sitio
 */
if (!function_exists('seo_site_title')) {
    function seo_site_title() {
        return \App\Helpers\SeoHelper::getSiteTitle();
    }
}

/**
 * Obtener descripción del sitio
 */
if (!function_exists('seo_site_description')) {
    function seo_site_description() {
        return \App\Helpers\SeoHelper::getSiteDescription();
    }
}

/**
 * Obtener keywords del sitio
 */
if (!function_exists('seo_site_keywords')) {
    function seo_site_keywords() {
        return \App\Helpers\SeoHelper::getSiteKeywords();
    }
}

/**
 * Generar descripción SEO para software
 */
if (!function_exists('seo_software_description')) {
    function seo_software_description($software) {
        return \App\Helpers\SeoHelper::getSoftwareDescription($software);
    }
}

/**
 * Generar keywords SEO para software
 */
if (!function_exists('seo_software_keywords')) {
    function seo_software_keywords($software, $categoryName = null) {
        return \App\Helpers\SeoHelper::getSoftwareKeywords($software, $categoryName);
    }
}

/**
 * Encriptar ID para ofuscación de URLs (Seguro para URL)
 */
if (!function_exists('encrypt_id')) {
    function encrypt_id($id) {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($id));
    }
}

/**
 * Localización / Traducción
 */
if (!function_exists('__')) {
    function __($key, $default = null) {
        static $translations = [];
        $lang = get_language();
        
        if (!isset($translations[$lang])) {
            $path = BASE_PATH . "/app/Languages/{$lang}.php";
            if (file_exists($path)) {
                $translations[$lang] = include $path;
            } else {
                $translations[$lang] = [];
            }
        }
        
        return $translations[$lang][$key] ?? ($default ?? $key);
    }
}

if (!function_exists('get_language')) {
    function get_language() {
        if (isset($_SESSION['lang'])) {
            return $_SESSION['lang'];
        }
        
        static $defaultLang = null;
        if ($defaultLang === null) {
            $settingsModel = new \App\Models\SiteSetting();
            $defaultLang = $settingsModel->get('default_language', 'es');
        }
        
        return $defaultLang;
    }
}

if (!function_exists('set_language')) {
    function set_language($lang) {
        $supported = ['es', 'en'];
        if (in_array($lang, $supported)) {
            $_SESSION['lang'] = $lang;
            return true;
        }
        return false;
    }
}

/**
 * Decriptar ID
 */
if (!function_exists('decrypt_id')) {
    function decrypt_id($hash) {
        $decoded = base64_decode(str_replace(['-', '_'], ['+', '/'], $hash));
        return is_numeric($decoded) ? intval($decoded) : null;
    }
}
