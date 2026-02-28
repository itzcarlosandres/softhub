<?php

namespace App\Controllers;

class PageController extends Controller
{
    public function about()
    {
        return $this->view('pages/about');
    }
    
    public function terms()
    {
        return $this->view('pages/terms');
    }
    
    public function privacy()
    {
        return $this->view('pages/privacy');
    }

    public function demoHeroes()
    {
        return $this->view('pages/demo_heroes', [
            'title' => 'Diseños de Hero Premium'
        ]);
    }

    public function demoSoftware()
    {
        $db = \App\Database::getInstance()->getConnection();
        
        // Get featured/approved software (limit to 12 for demo)
        $stmt = $db->prepare("
            SELECT * FROM software 
            WHERE status = 'approved' 
            ORDER BY downloads DESC, created_at DESC 
            LIMIT 12
        ");
        $stmt->execute();
        $software = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return $this->view('pages/demo_software', [
            'title' => 'Diseños de Catálogo de Software Premium',
            'software' => $software
        ]);
    }

    public function demoFooters()
    {
        return $this->view('pages/demo_footers', [
            'title' => 'Diseños de Footer Premium'
        ]);
    }

    public function demoAdmin()
    {
        return $this->view('pages/demo_admin', [
            'title' => 'Diseños de Admin Panel Premium'
        ]);
    }

    public function demoTitles()
    {
        return $this->view('pages/demo_titles', [
            'title' => 'Demos de Títulos Dinámicos'
        ]);
    }
}
