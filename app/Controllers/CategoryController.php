<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Software;

class CategoryController extends Controller
{
    private $categoryModel;
    private $softwareModel;

    public function __construct()
    {
        parent::__construct();
        $this->categoryModel = new Category();
        $this->softwareModel = new Software();
    }

    public function index()
    {
        $categories = $this->categoryModel->withSoftwareCount();

        return $this->view('pages/categories/index', [
            'title' => 'Categorías',
            'categories' => $categories
        ]);
    }

    public function show($slug)
    {
        $category = $this->categoryModel->getBySlug($slug);
        
        if (!$category) {
            http_response_code(404);
            return $this->view('errors/404');
        }

        $page = $_GET['page'] ?? 1;
        $software = $this->softwareModel->getByCategory($category['id'], $page, 24);
        $total = $this->categoryModel->getSoftwareCount($category['id']);
        $totalPages = ceil($total / 24);

        return $this->view('pages/categories/show', [
            'title' => $category['name'] . ' - Programas',
            'category' => $category,
            'software' => $software,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'db' => \App\Database::getInstance()->getConnection()
        ]);
    }
}
