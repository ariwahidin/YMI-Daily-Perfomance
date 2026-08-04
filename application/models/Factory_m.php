<?php
class Factory_m extends CI_Model
{
    public function getFactory()
    {
        $where = array(
            'is_active != ' => 'N'
        );
        return $this->db->get_where('master_factory', $where);
    }

    public function createFactory($params)
    {
        $this->db->insert('master_factory', $params);
    }

    public function editFactory($id, $params)
    {
        $where = ['id' => $id];
        $this->db->where($where);
        $this->db->update('master_factory', $params);
    }

    public function deleteFactory($id, $params)
    {
        $where = ['id' => $id];
        $this->db->where($where);
        $this->db->update('master_factory', $params);
    }
}
