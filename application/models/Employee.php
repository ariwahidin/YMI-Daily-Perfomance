<?php defined('BASEPATH') or exit('No direct script access allowed');

class Employee extends CI_Model
{
    public function createEmploye($params)
    {
        $this->db->insert('master_employee', $params);
    }

    public function getChecker()
    {
        $sql = "SELECT * FROM master_user WHERE role = 4 ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function deleteChecker($id, $params)
    {
        $this->db->where('id', $id);
        $this->db->update('master_employee', $params);
    }
}
