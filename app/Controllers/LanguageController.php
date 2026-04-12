<?php

namespace App\Controllers;

class LanguageController extends Controller
{
    public function switch($lang)
    {
        set_language($lang);
        
        // Redirect back to the previous page or home
        $referer = $_SERVER['HTTP_REFERER'] ?? url();
        header("Location: $referer");
        exit;
    }
}
