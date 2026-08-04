<?php

class Role_m extends CI_Model
{
    public function getRole()
    {
        $query = $this->db->get('master_role');
        return $query;
    }
}
