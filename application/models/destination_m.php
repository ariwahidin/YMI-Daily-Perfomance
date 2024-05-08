<?php
class Destination_m extends CI_Model
{
    public function getdestination()
    {
        $where = array(
            'is_active != ' => 'N'
        );
        return $this->db->get_where('master_destination', $where);
    }

    public function createdestination($params)
    {
        $this->db->insert('master_destination', $params);
    }

    public function editdestination($id, $params)
    {
        $where = ['id' => $id];
        $this->db->where($where);
        $this->db->update('master_destination', $params);
    }

    public function deletedestination($id, $params)
    {
        $where = ['id' => $id];
        $this->db->where($where);
        $this->db->update('master_destination', $params);
    }
}
