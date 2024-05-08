<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ekspedisi extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_not_logged_in();
        $this->load->model(['user_m', 'role_m', 'ekspedisi_m']);
    }

    public function render($view, array $data = null)
    {
        $this->load->view('template/header');
        $this->load->view($view, $data);
        $this->load->view('template/footer');
    }

    public function index()
    {
        $data = array(
            'ekspedisi' => $this->ekspedisi_m->getEkspedisi(),
            'position' => $this->db->get('master_position')
        );
        $this->render('ekspedisi/index', $data);
    }

    public function createEkspedisi()
    {
        $post = $this->input->post();
        // var_dump($post);
        // die;
        $params = array(
            'name' => $post['name'],
            'no_truck' => $post['no_truck'],
            'position_id' => $post['position'],
            'is_active' => 'Y',
            'is_deleted' => 'N',
            'created_by' => userId(),
            'created_at' => currentDateTime()
        );

        // var_dump($params);

        $this->ekspedisi_m->createEkspedisi($params);
        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true,
                'message' => 'Create new ekspedisi has been successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to create new ekspedisi'
            );
        }
        echo json_encode($response);
    }

    public function editEkspedisi()
    {
        $post = $this->input->post();
        // var_dump($post);
        // die;

        $id = $post['eks_id'];
        $params = array(
            'name' => $post['name'],
            'position_id' => $post['position'],
            'no_truck' => $post['no_truck'],
            'updated_at' => currentDateTime(),
            'updated_by' => userId()
        );
        $this->ekspedisi_m->editEkspedisi($id, $params);
        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true,
                'message' => 'Edit ekspedisi has been successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to edit ekspedisi'
            );
        }
        echo json_encode($response);
    }

    public function deleteEkspedisi()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $params = array(
            'is_active' => 'N',
            'is_deleted' => 'Y',
            'deleted_at' => currentDateTime(),
            'deleted_by' => userId()
        );
        $this->ekspedisi_m->deleteFactory($id, $params);
        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true,
                'message' => 'Delete ekspedisi has been successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to delete ekspedisi'
            );
        }
        echo json_encode($response);
    }
}
