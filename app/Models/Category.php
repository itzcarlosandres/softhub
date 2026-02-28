<?php

namespace App\Models;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name', 'slug', 'description', 'icon'];

    public function getBySlug($slug)
    {
        $sql = "SELECT * FROM {$this->table} WHERE slug = ? LIMIT 1";
        return $this->db->fetchOne($sql, [$slug]);
    }

    public function withSoftwareCount()
    {
        $sql = "SELECT c.*, COUNT(s.id) as software_count 
                FROM {$this->table} c 
                LEFT JOIN software s ON c.id = s.category_id AND s.status = 'approved'
                GROUP BY c.id 
                ORDER BY c.name ASC";
        return $this->db->fetchAll($sql);
    }

    public function getSoftwareCount($categoryId)
    {
        $sql = "SELECT COUNT(*) as total FROM software WHERE category_id = ? AND status = 'approved'";
        $result = $this->db->fetchOne($sql, [$categoryId]);
        return $result['total'] ?? 0;
    }

    public function popular($limit = 6)
    {
        $limit = (int) $limit;
        $sql = "SELECT c.*, COUNT(s.id) as software_count 
                FROM {$this->table} c 
                LEFT JOIN software s ON c.id = s.category_id AND s.status = 'approved'
                GROUP BY c.id 
                ORDER BY software_count DESC 
                LIMIT $limit";
        return $this->db->fetchAll($sql);
    }
}
