<?php
/**
 * Helper Functions
 */

if (!function_exists('url')) {
    function url($path = '') {
        $appUrl = env('APP_URL', '');
        
        if ($appUrl) {
            // Si ya es una URL absoluta, la devolvemos tal cual
            if (preg_match('/^https?:\/\//', $path)) {
                return $path;
            }

            $baseUrl = rtrim($appUrl, '/');
            $cleanPath = ltrim($path, '/');
            
            // Si el path ya empieza con public/, lo limpiamos porque ya estamos dentro en CyberPanel
            if (strpos($cleanPath, 'public/') === 0) {
                $cleanPath = substr($cleanPath, 7);
            }
            
            return $baseUrl . ($cleanPath ? '/' . $cleanPath : '');
        }
        
        // Si ya es una URL absoluta, la devolvemos tal cual (fallback)
        if (preg_match('/^https?:\/\//', $path)) {
            return $path;
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

/**
 * Obtener el icono de una categoría (prioriza DB, fallback a mapeo por slug)
 */
if (!function_exists('get_category_icon')) {
    function get_category_icon($category) {
        if (empty($category)) return 'fas fa-folder';
        
        // Si se pasa solo el slug por compatibilidad (legacy)
        if (is_string($category)) {
            $category = ['slug' => $category];
        }

        // Si ya tiene un icono definido en la base de datos, lo usamos
        if (!empty($category['icon'])) {
            $icon = $category['icon'];
            // Asegurar prefijo FontAwesome si no lo tiene y no empieza por 'fa-'
            if (!preg_match('/^(fas|far|fab|fal|fad|fat|fa-)/', $icon) && !preg_match('/^fa-/', $icon)) {
                $icon = 'fas ' . $icon;
            }
            // Si empieza por fa- pero no tiene el prefijo de peso (como 'fas')
            if (preg_match('/^fa-/', $icon) && !preg_match('/^(fas|far|fab|fal|fad|fat)\s/', $icon)) {
                $icon = 'fas ' . $icon;
            }
            return $icon;
        }

        // Mapeo legacy por slug como fallback
        $slug = $category['slug'] ?? '';
        $icons = [
            'antivirus' => 'fa-shield-alt',
            'navegadores' => 'fa-globe',
            'multimedia' => 'fa-play-circle',
            'utilidades' => 'fa-cog',
            'productividad' => 'fa-briefcase',
            'juegos' => 'fa-gamepad',
            'desarrollo' => 'fa-code',
            'educacion' => 'fa-graduation-cap',
            'comunicacion' => 'fa-comments',
            'diseno' => 'fa-palette',
            'seguridad' => 'fa-lock',
            'sistema' => 'fa-desktop'
        ];
        
        $slug = strtolower($slug);
        foreach($icons as $key => $val) {
            if(strpos($slug, $key) !== false) return 'fas ' . $val;
        }
        
        return 'fas fa-folder';
    }
}

if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        // Calcular semanas sin usar propiedad dinámica en DateInterval (Deprecado en PHP 8.2+)
        $weeks = floor($diff->d / 7);
        $days = $diff->d - ($weeks * 7);

        $string = array(
            'y' => 'año',
            'm' => 'mes',
            'w' => 'semana',
            'd' => 'día',
            'h' => 'hora',
            'i' => 'minuto',
            's' => 'segundo',
        );

        foreach ($string as $k => &$v) {
            $value = ($k == 'w') ? $weeks : (($k == 'd') ? $days : $diff->$k);
            
            if ($value) {
                $v = $value . ' ' . $v . ($value > 1 ? ($k == 'm' ? 'es' : 's') : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? 'Hace ' . implode(', ', $string) : 'Justo ahora';
    }
}
