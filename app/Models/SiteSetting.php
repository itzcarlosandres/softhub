<?php

namespace App\Models;

class SiteSetting extends Model
{
    protected $table = 'site_settings';
    protected $fillable = [
        'setting_key',
        'setting_value',
        'setting_type',
        'description'
    ];

    public function get($key, $default = null)
    {
        try {
            $stmt = $this->db->getConnection()->prepare("SELECT setting_value FROM {$this->table} WHERE setting_key = ?");
            $stmt->execute([$key]);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            return $result ? $result['setting_value'] : $default;
        } catch (\PDOException $e) {
            // Si la tabla no existe, devolver valor por defecto
            return $default;
        }
    }

    public function set($key, $value)
    {
        try {
            $stmt = $this->db->getConnection()->prepare("
                INSERT INTO {$this->table} (setting_key, setting_value) 
                VALUES (?, ?) 
                ON DUPLICATE KEY UPDATE setting_value = ?
            ");
            return $stmt->execute([$key, $value, $value]);
        } catch (\PDOException $e) {
            // Si la tabla no existe, no hacer nada
            return false;
        }
    }

    public function getAll()
    {
        try {
            $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->table} ORDER BY setting_key");
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Si la tabla no existe, devolver array vacío
            return [];
        }
    }
}
?>
