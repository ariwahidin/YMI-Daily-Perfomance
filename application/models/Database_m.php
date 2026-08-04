<?php defined('BASEPATH') or exit('No direct script access allowed');

class Database_m extends CI_Model
{
    public function master_top()
    {
        // table term of payment
        $result = 0;
        $sql1 = "CREATE TABLE IF NOT EXISTS master_top (
            GroupNum INT AUTO_INCREMENT PRIMARY KEY,
            Descript VARCHAR(255),
            ExtraDays INT,
            ExtraMonth INT,
            CreatedBy INT,
            CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
            UpdatedBy INT,
            UpdatedAt DATETIME
        )";
        $query = $this->db->query($sql1);
        if ($query) {
            $result = $result + 1;
        }
        return $result;
    }
}
