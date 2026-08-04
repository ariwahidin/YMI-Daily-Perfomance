<?php defined('BASEPATH') or exit('No direct script access allowed');

class Master_m extends CI_Model
{

    public function getRole()
    {
        $query = $this->db->get('master_role');
        return $query;
    }
}
