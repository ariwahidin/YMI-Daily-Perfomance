<?php

class Plp_m extends CI_Model
{
    public function insert($params)
    {
        $query = $this->db->insert('pl_p', $params);
        return $query;
    }
}
