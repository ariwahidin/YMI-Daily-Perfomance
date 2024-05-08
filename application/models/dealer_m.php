<?php
class Dealer_m extends CI_Model
{
    public function getDealer()
    {
        $where = array(
            'is_active != ' => 'N'
        );
        return $this->db->get_where('master_dealer', $where);
    }

    public function createDealer($params)
    {
        $this->db->insert('master_dealer', $params);
    }

    public function editDealer($id, $params)
    {
        $where = ['id' => $id];
        $this->db->where($where);
        $this->db->update('master_dealer', $params);
    }

    public function deleteDealer($id, $params)
    {
        $where = ['id' => $id];
        $this->db->where($where);
        $this->db->update('master_dealer', $params);
    }
}
