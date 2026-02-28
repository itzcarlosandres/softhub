<?php

namespace App\Controllers;

use App\Database;
use App\Traits\JsonResponder;
use App\Services\GeminiService;
use PDO;

class ApiController
{
    use JsonResponder;

    private $db;
    
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Live search endpoint
     * Returns software and categories matching the query
     */
    public function search()
    {
        try {
            $query = $_GET['q'] ?? '';
            $filter = $_GET['filter'] ?? 'all';
            
            if (strlen($query) < 2) {
                return $this->success(['software' => [], 'categories' => []]);
            }
            
            $results = [
                'software' => [],
                'categories' => []
            ];
            
            // Search software
            if ($filter === 'all' || $filter === 'software') {
                $stmt = $this->db->prepare("
                    SELECT 
                        id,
                        name,
                        slug,
                        icon,
                        downloads,
                        rating
                    FROM software 
                    WHERE status = 'approved' 
                    AND (
                        name LIKE ? 
                        OR description LIKE ?
                        OR short_description LIKE ?
                    )
                    ORDER BY downloads DESC
                    LIMIT 8
                ");
                
                $searchTerm = '%' . $query . '%';
                $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
                $results['software'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            
            // Search categories
            if ($filter === 'all' || $filter === 'categories') {
                $stmt = $this->db->prepare("
                    SELECT 
                        c.id,
                        c.name,
                        c.slug,
                        COUNT(s.id) as software_count
                    FROM categories c
                    LEFT JOIN software s ON c.id = s.category_id AND s.status = 'approved'
                    WHERE c.name LIKE ?
                    GROUP BY c.id, c.name, c.slug
                    ORDER BY software_count DESC
                    LIMIT 5
                ");
                
                $searchTerm = '%' . $query . '%';
                $stmt->execute([$searchTerm]);
                $results['categories'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            
            return $this->success($results);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function filterCategory()
    {
        try {
            $categoryId = $_GET['category'] ?? 'all';
            $limit = 12;
            
            $results = [];
            
            $query = "
                SELECT 
                    s.id, s.name, s.slug, s.icon, s.image, s.short_description, s.description, s.downloads, s.rating, s.price, s.created_at, s.trending
                FROM software s
                WHERE s.status = 'approved'
            ";
            
            $params = [];
            
            if ($categoryId !== 'all' && is_numeric($categoryId)) {
                $query .= " AND s.category_id = ?";
                $params[] = $categoryId;
            }
            
            $query .= " ORDER BY s.created_at DESC LIMIT ?";
            $params[] = $limit;
            
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Also fetch trending IDs
            $stmtTrending = $this->db->query("SELECT id FROM software WHERE status = 'approved' AND trending = 1 ORDER BY downloads DESC LIMIT 10");
            $trendingIds = array_column($stmtTrending->fetchAll(PDO::FETCH_ASSOC), 'id');
            
            return $this->success(['software' => $results, 'trendingIds' => $trendingIds]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Rate software and update average rating
     */
    public function rateSoftware()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return $this->error('Method not allowed', 405);
            }

            $input = json_decode(file_get_contents('php://input'), true);
            $softwareId = $input['software_id'] ?? null;
            $rating = $input['rating'] ?? null;
            $comment = $input['comment'] ?? '';

            if (!$softwareId || !$rating || !is_numeric($rating) || $rating < 1 || $rating > 5) {
                return $this->error('Invalid software ID or rating (must be 1-5)');
            }

            // Insert review
            $stmt = $this->db->prepare("INSERT INTO reviews (software_id, rating, comment) VALUES (?, ?, ?)");
            $stmt->execute([$softwareId, $rating, $comment]);

            // Update software rating average
            $stmtAvg = $this->db->prepare("
                UPDATE software s
                SET 
                    s.rating = (SELECT AVG(rating) FROM reviews WHERE software_id = ?),
                    s.rating_count = (SELECT COUNT(*) FROM reviews WHERE software_id = ?)
                WHERE s.id = ?
            ");
            $stmtAvg->execute([$softwareId, $softwareId, $softwareId]);

            return $this->success([], 'Rating submitted successfully');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Generate system requirements using IA
     */
    public function generateRequirements()
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $name = $input['name'] ?? '';
            $category = $input['category'] ?? '';

            if (empty($name)) {
                return $this->error('Software name is required');
            }

            $gemini = new GeminiService();
            $result = $gemini->generateRequirements($name, $category);

            if (!$result['success']) {
                return $this->error($result['error'], 500);
            }

            return $this->success(['requirements' => $result['text']]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Generate software description using IA
     */
    public function generateDescription()
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $name = $input['name'] ?? '';
            $category = $input['category'] ?? '';
            $developer = $input['developer'] ?? '';
            $type = $input['type'] ?? 'short';

            if (empty($name)) {
                return $this->error('Software name is required');
            }

            $gemini = new GeminiService();
            
            if ($type === 'full') {
                $result = $gemini->generateFullDescription($name, $category, $developer);
            } else {
                $result = $gemini->generateShortDescription($name, $category);
            }

            if (!$result['success']) {
                return $this->error($result['error'], 500);
            }

            return $this->success(['description' => $result['text']]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
