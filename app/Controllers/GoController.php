<?php

namespace App\Controllers;

use App\Database;
use PDO;

class GoController extends Controller
{
    /**
     * Decode hash and show redirect page with countdown
     */
    public function index($hash)
    {
        $linkId = decrypt_id($hash);
        $type = $_GET['type'] ?? 'link';

        if (!$linkId) {
            http_response_code(404);
            return $this->view('errors/404');
        }

        $db = Database::getInstance()->getConnection();
        
        if ($type === 'soft') {
            // Handle direct software download url
            $stmt = $db->prepare("SELECT id, name, slug, icon, download_url FROM software WHERE id = ?");
            $stmt->execute([$linkId]);
            $software = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$software || empty($software['download_url'])) {
                http_response_code(404);
                return $this->view('errors/404');
            }

            $link = [
                'download_url' => $software['download_url'],
                'software_name' => $software['name'],
                'software_slug' => $software['slug'],
                'software_icon' => $software['icon'],
                'platform' => 'Directo'
            ];
        } else {
            // Get link details from download_links
            $stmt = $db->prepare("
                SELECT dl.*, s.name as software_name, s.slug as software_slug, s.icon as software_icon 
                FROM download_links dl
                JOIN software s ON dl.software_id = s.id
                WHERE dl.id = ?
            ");
            $stmt->execute([$linkId]);
            $link = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        if (!$link) {
            http_response_code(404);
            return $this->view('errors/404');
        }

        // Get custom countdown from settings
        $settingsModel = new \App\Models\SiteSetting();
        $countdown = $settingsModel->get('download_countdown', 15);

        return $this->view('pages/software/redirect', [
            'title' => 'Preparando descarga - ' . $link['software_name'],
            'link' => $link,
            'countdown' => $countdown
        ]);
    }
}
