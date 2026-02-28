<?php

namespace App\Models;

class DownloadLink extends Model
{
    protected $table = 'download_links';
    protected $fillable = [
        'software_id',
        'platform',
        'version',
        'download_url',
        'file_size'
    ];

    public function getBySoftware($softwareId)
    {
        $stmt = $this->db->getConnection()->prepare("
            SELECT * FROM {$this->table} 
            WHERE software_id = ? 
            ORDER BY 
                CASE platform
                    WHEN 'Windows' THEN 1
                    WHEN 'Mac' THEN 2
                    WHEN 'Linux' THEN 3
                    WHEN 'Android' THEN 4
                    WHEN 'iOS' THEN 5
                    ELSE 6
                END
        ");
        $stmt->execute([$softwareId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deleteBySoftware($softwareId)
    {
        $stmt = $this->db->getConnection()->prepare("DELETE FROM {$this->table} WHERE software_id = ?");
        return $stmt->execute([$softwareId]);
    }
}
?>
