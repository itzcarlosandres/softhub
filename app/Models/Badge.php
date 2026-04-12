<?php

namespace App\Models;

class Badge extends Model
{
    protected $table = 'badges';
    protected $fillable = ['name', 'slug', 'color'];

    public function all()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY name ASC";
        return $this->db->fetchAll($sql);
    }
}
