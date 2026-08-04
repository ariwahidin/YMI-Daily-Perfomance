<?php
class Customer_m extends CI_Model
{

    var $table = 'master_customer';
    var $column_order = array(null, 'CardName', 'Address', 'City', 'Phone'); //field yang ada di table cuatomer
    var $column_search = array('CardName', 'Address', 'City'); //field yang diizin untuk pencarian 
    var $order = array('CardName' => 'asc'); // default order 

    private function _get_datatables_query()
    {

        $this->db->from($this->table);
        $i = 0;

        foreach ($this->column_search as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }


    public function simpanCustomer($data)
    {
        // Mendapatkan waktu sekarang
        date_default_timezone_set('Asia/Jakarta');
        $created_at = date('Y-m-d H:i:s');

        // Menambahkan kolom 'created_by' dan 'created_at' ke setiap elemen data
        foreach ($data as &$row) {
            $row['created_by'] = $this->session->userdata('user_data')['user_id'];
            $row['created_at'] = $created_at;
        }
        return $this->db->insert_batch('master_customer', $data);
    }
}
