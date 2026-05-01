<?php

namespace App\Controllers;

use App\Database;

class BlogController extends Controller
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function index()
    {
        // Get all categories
        $stmt = $this->db->query("SELECT * FROM blog_categories ORDER BY name ASC");
        $categories = $stmt->fetchAll();

        // Get latest posts
        $stmt = $this->db->query("
            SELECT p.*, c.name as category_name, c.slug as category_slug, u.username as author_name 
            FROM blog_posts p 
            LEFT JOIN blog_categories c ON p.blog_category_id = c.id
            LEFT JOIN users u ON p.author_id = u.id
            ORDER BY p.created_at DESC 
            LIMIT 12
        ");
        $posts = $stmt->fetchAll();

        // Get featured post (the most recent one marked as featured, or just the most recent if none is featured)
        $stmt = $this->db->query("
            SELECT p.*, c.name as category_name, c.slug as category_slug, u.username as author_name 
            FROM blog_posts p 
            LEFT JOIN blog_categories c ON p.blog_category_id = c.id
            LEFT JOIN users u ON p.author_id = u.id
            WHERE p.is_featured = 1 
            ORDER BY p.created_at DESC 
            LIMIT 1
        ");
        $featuredPost = $stmt->fetch();
        
        if (!$featuredPost && count($posts) > 0) {
            $featuredPost = $posts[0];
            // Remove the first post from the posts list so it doesn't duplicate
            array_shift($posts);
        }

        $settings = new \App\Models\SiteSetting();
        $title = $settings->get('seo_blog_title', 'Blog y Noticias - SoftHub');
        $description = $settings->get('seo_blog_description', 'Descubre los mejores tutoriales, noticias y guías sobre software en nuestro blog gratuito.');

        return $this->view('blog/index', [
            'title' => $title,
            'description' => $description,
            'categories' => $categories,
            'posts' => $posts,
            'featuredPost' => $featuredPost
        ]);
    }

    public function search()
    {
        $query = $_GET['q'] ?? '';
        $query = trim($query);

        if (empty($query)) {
            header("Location: " . url('blog'));
            exit;
        }

        // Search logic
        $stmt = $this->db->prepare("
            SELECT p.*, c.name as category_name, c.slug as category_slug, u.username as author_name 
            FROM blog_posts p 
            LEFT JOIN blog_categories c ON p.blog_category_id = c.id
            LEFT JOIN users u ON p.author_id = u.id
            WHERE p.title LIKE ? OR p.extract LIKE ? OR p.content LIKE ?
            ORDER BY p.created_at DESC
        ");
        
        $searchTerm = "%{$query}%";
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        $posts = $stmt->fetchAll();

        // Get categories for the filter bar
        $stmt = $this->db->query("SELECT * FROM blog_categories ORDER BY name ASC");
        $categories = $stmt->fetchAll();

        return $this->view('blog/search', [
            'title' => 'Resultados de búsqueda: ' . htmlspecialchars($query) . ' - Blog SoftHub',
            'description' => 'Resultados de búsqueda en nuestro blog.',
            'query' => $query,
            'posts' => $posts,
            'categories' => $categories
        ]);
    }

    public function category($slug)
    {
        // Get category
        $stmt = $this->db->prepare("SELECT * FROM blog_categories WHERE slug = ?");
        $stmt->execute([$slug]);
        $category = $stmt->fetch();

        if (!$category) {
            header("HTTP/1.0 404 Not Found");
            return $this->view('errors/404');
        }

        // Get all categories for filter
        $stmt = $this->db->query("SELECT * FROM blog_categories ORDER BY name ASC");
        $categories = $stmt->fetchAll();

        // Get posts by category
        $stmt = $this->db->prepare("
            SELECT p.*, c.name as category_name, c.slug as category_slug, u.username as author_name 
            FROM blog_posts p 
            LEFT JOIN blog_categories c ON p.blog_category_id = c.id
            LEFT JOIN users u ON p.author_id = u.id
            WHERE p.blog_category_id = ?
            ORDER BY p.created_at DESC
        ");
        $stmt->execute([$category['id']]);
        $posts = $stmt->fetchAll();

        return $this->view('blog/category', [
            'title' => $category['name'] . ' - Blog SoftHub',
            'description' => 'Artículos de ' . $category['name'] . ' en el blog.',
            'category' => $category,
            'categories' => $categories,
            'posts' => $posts
        ]);
    }

    public function show($slug)
    {
        // Get post
        $stmt = $this->db->prepare("
            SELECT p.*, c.name as category_name, c.slug as category_slug, u.username as author_name 
            FROM blog_posts p 
            LEFT JOIN blog_categories c ON p.blog_category_id = c.id
            LEFT JOIN users u ON p.author_id = u.id
            WHERE p.slug = ?
        ");
        $stmt->execute([$slug]);
        $post = $stmt->fetch();

        if (!$post) {
            header("HTTP/1.0 404 Not Found");
            return $this->view('errors/404');
        }

        // Update views
        $updateStmt = $this->db->prepare("UPDATE blog_posts SET views = views + 1 WHERE id = ?");
        $updateStmt->execute([$post['id']]);

        // Get related posts
        $stmt = $this->db->prepare("
            SELECT p.*, c.name as category_name, c.slug as category_slug 
            FROM blog_posts p 
            LEFT JOIN blog_categories c ON p.blog_category_id = c.id
            WHERE p.blog_category_id = ? AND p.id != ? 
            ORDER BY p.created_at DESC 
            LIMIT 3
        ");
        $stmt->execute([$post['blog_category_id'], $post['id']]);
        $relatedPosts = $stmt->fetchAll();

        return $this->view('blog/show', [
            'title' => $post['title'] . ' - Blog SoftHub',
            'description' => $post['extract'] ?? $post['title'],
            'image' => $post['image'] ? url($post['image']) : null,
            'post' => $post,
            'relatedPosts' => $relatedPosts
        ]);
    }
}
