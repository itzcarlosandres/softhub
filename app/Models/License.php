<?php

namespace App\Models;

class License extends Model
{
    protected $table = 'licenses';
    protected $fillable = ['name', 'slug'];

    public function getBySlug($slug)
    {
        $sql = "SELECT * FROM {$this->table} WHERE slug = ? LIMIT 1";
        return $this->db->fetchOne($sql, [$slug]);
    }

    public function withSoftwareCount()
    {
        // Notice: currently licenses in software table might be stored as text (slug) instead of ID.
        // We will join by checking if software.license matches licenses.slug or licenses.name
        $sql = "SELECT l.*, COUNT(s.id) as software_count 
                FROM {$this->table} l 
                LEFT JOIN software s ON s.license = l.slug AND s.status = 'approved'
                GROUP BY l.id 
                ORDER BY l.name ASC";
        return $this->db->fetchAll($sql);
    }
}
