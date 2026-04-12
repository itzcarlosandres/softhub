<?php

namespace App\Models;

class Software extends Model
{
    protected $table = 'software';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'version',
        'developer',
        'category_id',
        'license',
        'operating_system',
        'file_size',
        'download_url',
        'image',
        'icon',
        'screenshots',
        'requirements',
        'downloads',
        'rating',
        'status',
        'featured',
        'trending',
        'badge_editors_choice',
        'custom_badge',
        'badge_id',
        'price',
        'buy_url',
        'updated_at'
    ];

    public function getBySlug($slug)
    {
        $sql = "SELECT s.*, c.name as category_name, l.name as license_name, b.name as badge_name, b.color as badge_color 
                FROM {$this->table} s 
                LEFT JOIN categories c ON s.category_id = c.id 
                LEFT JOIN licenses l ON s.license = l.slug 
                LEFT JOIN badges b ON s.badge_id = b.id
                WHERE s.slug = ? AND s.status = 'approved' 
                LIMIT 1";
        return $this->db->fetchOne($sql, [$slug]);
    }

    public function find($id)
    {
        $stmt = $this->db->getConnection()->prepare("
            SELECT s.*, c.name as category_name, c.slug as category_slug, l.name as license_name, b.name as badge_name, b.color as badge_color
            FROM {$this->table} s 
            LEFT JOIN categories c ON s.category_id = c.id 
            LEFT JOIN licenses l ON s.license = l.slug 
            LEFT JOIN badges b ON s.badge_id = b.id
            WHERE s.id = ? 
            LIMIT 1
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getFeatured($limit = 6)
    {
        $sql = "SELECT s.*, c.name as category_name, l.name as license_name, b.name as badge_name, b.color as badge_color 
                FROM {$this->table} s 
                LEFT JOIN categories c ON s.category_id = c.id 
                LEFT JOIN licenses l ON s.license = l.slug 
                LEFT JOIN badges b ON s.badge_id = b.id
                WHERE s.featured = 1 AND s.status = 'approved' 
                ORDER BY s.updated_at DESC 
                LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }

    public function getLatest($limit = 12)
    {
        $sql = "SELECT s.*, c.name as category_name, l.name as license_name, b.name as badge_name, b.color as badge_color 
                FROM {$this->table} s 
                LEFT JOIN categories c ON s.category_id = c.id 
                LEFT JOIN licenses l ON s.license = l.slug 
                LEFT JOIN badges b ON s.badge_id = b.id
                WHERE s.status = 'approved' 
                ORDER BY s.updated_at DESC 
                LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }

    public function getMostDownloaded($limit = 10)
    {
        $sql = "SELECT s.*, c.name as category_name, l.name as license_name 
                FROM {$this->table} s 
                LEFT JOIN categories c ON s.category_id = c.id 
                LEFT JOIN licenses l ON s.license = l.slug 
                WHERE s.status = 'approved' 
                ORDER BY s.downloads DESC 
                LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }

    public function getByCategory($categoryId, $page = 1, $perPage = 12)
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT s.*, c.name as category_name, l.name as license_name 
                FROM {$this->table} s 
                LEFT JOIN categories c ON s.category_id = c.id 
                LEFT JOIN licenses l ON s.license = l.slug 
                WHERE s.category_id = ? AND s.status = 'approved' 
                ORDER BY s.updated_at DESC 
                LIMIT ? OFFSET ?";
        return $this->db->fetchAll($sql, [$categoryId, $perPage, $offset]);
    }

    public function search($query, $page = 1, $perPage = 12)
    {
        $offset = ($page - 1) * $perPage;
        $searchTerm = "%{$query}%";
        $sql = "SELECT s.*, c.name as category_name, l.name as license_name 
                FROM {$this->table} s 
                LEFT JOIN categories c ON s.category_id = c.id 
                LEFT JOIN licenses l ON s.license = l.slug 
                WHERE (s.name LIKE ? OR s.description LIKE ? OR s.developer LIKE ?) 
                AND s.status = 'approved' 
                ORDER BY s.downloads DESC 
                LIMIT ? OFFSET ?";
        return $this->db->fetchAll($sql, [$searchTerm, $searchTerm, $searchTerm, $perPage, $offset]);
    }

    public function paginate($page = 1, $perPage = 24)
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT s.*, c.name as category_name, l.name as license_name 
                FROM {$this->table} s 
                LEFT JOIN categories c ON s.category_id = c.id 
                LEFT JOIN licenses l ON s.license = l.slug 
                WHERE s.status = 'approved' 
                ORDER BY s.updated_at DESC 
                LIMIT ? OFFSET ?";
        return $this->db->fetchAll($sql, [$perPage, $offset]);
    }

    public function count()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE status = 'approved'";
        $result = $this->db->fetchOne($sql);
        return $result['total'] ?? 0;
    }

    public function incrementDownloads($id)
    {
        $sql = "UPDATE {$this->table} SET downloads = downloads + 1 WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }

    public function updateRating($id, $rating)
    {
        $sql = "UPDATE {$this->table} SET rating = ? WHERE id = ?";
        return $this->db->query($sql, [$rating, $id]);
    }
}
