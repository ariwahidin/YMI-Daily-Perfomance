<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ekspedisi_model extends CI_Model
{

    var $table = 'master_ekspedisi a';
    var $column_order = array(null, 'a.name', 'b.name', 'a.no_truck', 'a.id'); //set column field database for datatable orderable
    var $column_search = array('a.id', 'a.name', 'b.name', 'a.no_truck'); //set column field database for datatable searchable 
    var $order = array('a.id' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->db->select('a.id, a.name, a.position_id, b.name as position, a.no_truck, a.is_active');
        $this->db->from($this->table);
        $this->db->join('master_position b', 'a.position_id = b.id');
        $this->db->where('a.is_active', 'Y');

        $i = 0;

        // var_dump($_POST);   

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
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

        // // Pencarian global
        // if ($_POST['search']['value']) {
        //     $this->db->group_start(); // Mulai grup pencarian
        //     foreach ($this->column_search as $item) {
        //         $this->db->or_like($item, $_POST['search']['value']);
        //     }
        //     $this->db->group_end(); // Akhiri grup pencarian
        // }

        // Individual column search

        // var_dump($_POST['columns']);
        foreach ($_POST['columns'] as $col => $data) {
            if (!empty($data['search']['value'])) {
                $this->db->like($this->column_search[$col], $data['search']['value']);
            }
        }

        if (isset($_POST['order'])) {

            if ($_POST['order']['0']['column'] == '0') {
                $this->db->order_by('a.id', 'desc');
            } else {
                $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            }
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
}
