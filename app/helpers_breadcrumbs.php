<?php
/**
 * Helper para generar breadcrumbs con schema markup
 */

if (!function_exists('breadcrumbs')) {
    function breadcrumbs($items) {
        if (empty($items)) return '';
        
        $html = '<nav aria-label="breadcrumb" class="mb-6">';
        $html .= '<ol class="flex items-center space-x-2 text-sm" itemscope itemtype="https://schema.org/BreadcrumbList">';
        
        $position = 1;
        $totalItems = count($items);
        
        foreach ($items as $label => $url) {
            $isLast = ($position === $totalItems);
            
            $html .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="flex items-center">';
            
            if (!$isLast && $url) {
                $html .= '<a href="' . htmlspecialchars($url) . '" itemprop="item" class="text-blue-600 hover:text-blue-800 hover:underline transition">';
                $html .= '<span itemprop="name">' . htmlspecialchars($label) . '</span>';
                $html .= '</a>';
                $html .= '<meta itemprop="position" content="' . $position . '">';
                $html .= '<i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>';
            } else {
                $html .= '<span itemprop="name" class="text-gray-700 font-medium">' . htmlspecialchars($label) . '</span>';
                $html .= '<meta itemprop="position" content="' . $position . '">';
            }
            
            $html .= '</li>';
            $position++;
        }
        
        $html .= '</ol>';
        $html .= '</nav>';
        
        return $html;
    }
}
?>
