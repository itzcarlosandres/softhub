<?php

namespace App\Helpers;

use App\Models\SiteSetting;

class SeoHelper
{
    private static $settingsModel;
    private static $settings = [];

    /**
     * Inicializar el helper y cargar configuraciones
     */
    private static function init()
    {
        if (empty(self::$settings)) {
            self::$settingsModel = new SiteSetting();
            $allSettings = self::$settingsModel->getAll();
            
            foreach ($allSettings as $setting) {
                self::$settings[$setting['setting_key']] = $setting['setting_value'];
            }
        }
    }

    /**
     * Obtener el título SEO para una página de descarga
     * 
     * @param string $softwareName Nombre del software
     * @param string $version Versión del software (opcional)
     * @return string Título formateado
     */
    public static function getDownloadTitle($softwareName, $version = null)
    {
        self::init();
        
        // Obtener la plantilla de título
        $template = self::$settings['seo_download_title_template'] ?? 'Descargar {TITULO}';
        
        // Reemplazar el placeholder con el nombre del software
        $title = str_replace('{TITULO}', $softwareName, $template);
        
        // Agregar versión si está habilitado
        $showVersion = (self::$settings['seo_show_version_in_title'] ?? '0') == '1';
        
        if ($showVersion && !empty($version)) {
            $separator = self::$settings['seo_version_separator'] ?? ' v';
            
            // Si el separador es paréntesis, agregar el cierre
            if ($separator == ' (') {
                $title .= $separator . $version . ')';
            } else {
                $title .= $separator . $version;
            }
        }
        
        return $title;
    }

    /**
     * Obtener el meta título del sitio
     * 
     * @return string
     */
    public static function getSiteTitle()
    {
        self::init();
        $seoTitle = self::$settings['seo_title'] ?? '';
        if (!empty($seoTitle)) {
            return $seoTitle;
        }
        
        return self::$settings['site_name'] ?? 'SoftHub - Descarga el mejor software gratis';
    }

    /**
     * Obtener la meta descripción del sitio
     * 
     * @return string
     */
    public static function getSiteDescription()
    {
        self::init();
        $seoDescription = self::$settings['seo_description'] ?? '';
        if (!empty($seoDescription)) {
            return $seoDescription;
        }
        
        return self::$settings['site_description'] ?? 'Descarga software gratuito y de pago para Windows, Mac y Android. Miles de programas actualizados y verificados.';
    }

    /**
     * Obtener las meta keywords del sitio
     * 
     * @return string
     */
    public static function getSiteKeywords()
    {
        self::init();
        return self::$settings['seo_keywords'] ?? 'descargar software, programas gratis, aplicaciones, windows, mac, android';
    }

    /**
     * Generar meta tags completos para una página
     * 
     * @param string $title Título de la página (opcional, usa el título del sitio por defecto)
     * @param string $description Descripción de la página (opcional, usa la descripción del sitio por defecto)
     * @param string $keywords Keywords adicionales (opcional)
     * @return string HTML de meta tags
     */
    public static function generateMetaTags($title = null, $description = null, $keywords = null)
    {
        self::init();
        
        $pageTitle = $title ?? self::getSiteTitle();
        $pageDescription = $description ?? self::getSiteDescription();
        $pageKeywords = $keywords ?? self::getSiteKeywords();
        
        $html = '';
        $html .= '<title>' . htmlspecialchars($pageTitle) . '</title>' . "\n";
        $html .= '<meta name="description" content="' . htmlspecialchars($pageDescription) . '">' . "\n";
        $html .= '<meta name="keywords" content="' . htmlspecialchars($pageKeywords) . '">' . "\n";
        
        // Open Graph tags
        $html .= '<meta property="og:title" content="' . htmlspecialchars($pageTitle) . '">' . "\n";
        $html .= '<meta property="og:description" content="' . htmlspecialchars($pageDescription) . '">' . "\n";
        $html .= '<meta property="og:type" content="website">' . "\n";
        
        // Twitter Card tags
        $html .= '<meta name="twitter:card" content="summary_large_image">' . "\n";
        $html .= '<meta name="twitter:title" content="' . htmlspecialchars($pageTitle) . '">' . "\n";
        $html .= '<meta name="twitter:description" content="' . htmlspecialchars($pageDescription) . '">' . "\n";
        
        return $html;
    }

    /**
     * Generar descripción SEO para una página de software
     * 
     * @param array $software Datos del software
     * @return string
     */
    public static function getSoftwareDescription($software)
    {
        $description = 'Descarga ' . $software['name'];
        
        if (!empty($software['version'])) {
            $description .= ' v' . $software['version'];
        }
        
        $description .= ' gratis';
        
        if (!empty($software['operating_system'])) {
            $description .= ' para ' . $software['operating_system'];
        }
        
        if (!empty($software['short_description'])) {
            $description .= '. ' . $software['short_description'];
        }
        
        return $description;
    }

    /**
     * Generar keywords SEO para una página de software
     * 
     * @param array $software Datos del software
     * @param string $categoryName Nombre de la categoría (opcional)
     * @return string
     */
    public static function getSoftwareKeywords($software, $categoryName = null)
    {
        $keywords = [];
        
        // Agregar nombre del software
        $keywords[] = strtolower($software['name']);
        $keywords[] = 'descargar ' . strtolower($software['name']);
        
        // Agregar categoría si existe
        if ($categoryName) {
            $keywords[] = strtolower($categoryName);
        }
        
        // Agregar plataformas
        if (!empty($software['operating_system'])) {
            $platforms = explode(',', $software['operating_system']);
            foreach ($platforms as $platform) {
                $keywords[] = strtolower(trim($platform));
            }
        }
        
        // Agregar tipo de licencia
        if (!empty($software['license'])) {
            $keywords[] = $software['license'] == 'free' ? 'gratis' : 'software de pago';
        }
        
        // Agregar keywords generales del sitio
        $siteKeywords = self::getSiteKeywords();
        
        return implode(', ', $keywords) . ', ' . $siteKeywords;
    }
}
