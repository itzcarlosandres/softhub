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
        return $this->view('pages/privacy', [
            'title' => 'Política de Privacidad'
        ]);
    }
    
    public function cookies()
    {
        return $this->view('pages/cookies', [
            'title' => 'Política de Cookies'
        ]);
    }

    public function dmca()
    {
        return $this->view('pages/dmca', [
            'title' => 'Política DMCA'
        ]);
    }

    public function contact()
    {
        return $this->view('pages/contact', [
            'title' => 'Contacto'
        ]);
    }
}
