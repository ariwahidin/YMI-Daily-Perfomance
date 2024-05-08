<?php defined('BASEPATH') or exit('No direct script access allowed');

class Destination extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_not_logged_in();
        $this->load->model(['user_m', 'role_m', 'destination_m']);
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
            'destination' => $this->destination_m->getdestination()
        );
        $this->render('destination/index', $data);
    }

    public function createdestination()
    {
        $post = $this->input->post();

        $cek = $this->db->get_where('master_destination', ['code' => $post['code']]);

        if ($cek->num_rows() < 1) {

            $params = array(
                'code' => $post['code'],
                'name' => $post['name'],
                'is_active' => 'Y',
                'is_deleted' => 'N',
                'created_by' => userId(),
                'created_at' => currentDateTime()
            );

            $this->destination_m->createdestination($params);
            if ($this->db->affected_rows() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Create new destination has been successfully'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to create new destination'
                );
            }
        } else {
            $response = array(
                'success' => false,
                'message' => 'destination code already exists'
            );
        }
        echo json_encode($response);
    }

    public function editdestination()
    {
        $post = $this->input->post();

        $id = $post['eks_id'];
        $cek = $this->db->get_where('master_destination', ['code' => $post['code'], 'id !=' => $id]);

        // var_dump($this->db->last_query());
        // die;

        if ($cek->num_rows() < 1) {

            $params = array(
                'code' => $post['code'],
                'name' => $post['name'],
                'updated_at' => currentDateTime(),
                'updated_by' => userId()
            );
            $this->destination_m->editdestination($id, $params);
            if ($this->db->affected_rows() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Edit destination has been successfully'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to edit destination'
                );
            }
        } else {
            $response = array(
                'success' => false,
                'message' => 'destination code already exists'
            );
        }
        echo json_encode($response);
    }

    public function deletedestination()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $params = array(
            'is_active' => 'N',
            'is_deleted' => 'Y',
            'deleted_at' => currentDateTime(),
            'deleted_by' => userId()
        );
        $this->destination_m->deletedestination($id, $params);
        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true,
                'message' => 'Delete destination has been successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to delete destination'
            );
        }
        echo json_encode($response);
    }
}
