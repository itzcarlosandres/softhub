<?php
/**
 * Helper para mostrar badges de software
 */

if (!function_exists('render_badges')) {
    function render_badges($software, $position = 'top-left') {
        if (empty($software)) return '';
        
        $badges = [];
        
        // Badge: Editor's Choice
        if (!empty($software['badge_editors_choice'])) {
            $badges[] = [
                'icon' => 'fa-award',
                'text' => "Editor's Choice",
                'class' => 'bg-gradient-to-r from-purple-500 to-pink-500 text-white'
            ];
        }
        
        // Badge: Trending
        if (!empty($software['badge_trending'])) {
            $badges[] = [
                'icon' => 'fa-fire',
                'text' => 'Trending',
                'class' => 'bg-gradient-to-r from-orange-500 to-red-500 text-white'
            ];
        }
        
        // Badge: Updated
        if (!empty($software['badge_updated'])) {
            $badges[] = [
                'icon' => 'fa-sync',
                'text' => 'Actualizado',
                'class' => 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white'
            ];
        }
        
        if (empty($badges)) return '';
        
        // Determinar posición
        $positionClass = match($position) {
            'top-left' => 'top-1 left-1',
            'top-right' => 'top-1 right-1',
            'bottom-left' => 'bottom-1 left-1',
            'bottom-right' => 'bottom-1 right-1',
            'bottom-center' => 'bottom-1 left-1/2 transform -translate-x-1/2',
            default => 'bottom-1 left-1'
        };
        
        $html = '<div class="absolute ' . $positionClass . ' z-10 flex gap-1">';
        
        foreach ($badges as $badge) {
            $html .= '<span class="text-xs px-1.5 py-0.5 rounded-full font-bold shadow-md flex items-center gap-0.5 ' . $badge['class'] . '">';
            $html .= '<i class="fas ' . $badge['icon'] . ' text-xs"></i>';
            $html .= '</span>';
        }
        
        $html .= '</div>';
        
        return $html;
    }
}

/**
 * Auto-asignar badges basado en criterios
 */
if (!function_exists('auto_assign_badges')) {
    function auto_assign_badges() {
        $db = \App\Database::getInstance()->getConnection();
        
        // Reset todos los badges automáticos
        $db->exec("UPDATE software SET badge_new = 0, badge_updated = 0, badge_trending = 0");
        
        // Badge NEW: Creado hace menos de 7 días
        $db->exec("
            UPDATE software 
            SET badge_new = 1 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
            AND status = 'approved'
        ");
        
        // Badge UPDATED: Solo si está marcado manualmente o tiene una versión superior (Lógica simplificada)
        // Por ahora, evitemos que se auto-asigne a lo que es NUEVO.
        $db->exec("
            UPDATE software 
            SET badge_updated = 0 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 3 DAY)
        ");
        
        // Badge TRENDING: Top 10 más descargados del mes
        $stmt = $db->query("
            SELECT id FROM software 
            WHERE status = 'approved'
            ORDER BY downloads DESC 
            LIMIT 10
        ");
        $trending = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        if (!empty($trending)) {
            $ids = implode(',', $trending);
            $db->exec("UPDATE software SET badge_trending = 1 WHERE id IN ($ids)");
        }
        
        return true;
    }
}
