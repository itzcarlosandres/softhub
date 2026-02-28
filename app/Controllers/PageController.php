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
}
