<?php
class Ekspedisi_m extends CI_Model
{
    public function getEkspedisi()
    {
        $sql = "SELECT a.id, a.name, a.position_id, b.name as position, a.no_truck, a.is_active 
        FROM master_ekspedisi a
        LEFT JOIN master_position b ON a.position_id = b.id
        WHERE a.is_active = 'Y'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getEkspedisiForInbound()
    {
        $sql = "SELECT a.id, a.name, a.position_id, b.name as position, a.no_truck, a.is_active 
        FROM master_ekspedisi a
        LEFT JOIN master_position b ON a.position_id = b.id
        WHERE a.is_active = 'Y'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function createEkspedisi($params)
    {
        $this->db->insert('master_ekspedisi', $params);
    }

    public function editEkspedisi($id, $params)
    {
        $where = ['id' => $id];
        $this->db->where($where);
        $this->db->update('master_ekspedisi', $params);
    }

    public function deleteFactory($id, $params)
    {
        $where = ['id' => $id];
        $this->db->where($where);
        $this->db->update('master_ekspedisi', $params);
    }
}
