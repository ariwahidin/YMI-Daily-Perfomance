<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dealer extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_not_logged_in();
        $this->load->model(['user_m', 'role_m', 'dealer_m']);
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
            'dealer' => $this->dealer_m->getdealer()
        );
        $this->render('dealer/index', $data);
    }

    public function createdealer()
    {
        $post = $this->input->post();

        $cek = $this->db->get_where('master_dealer', ['code' => $post['code']]);

        if ($cek->num_rows() < 1) {

            $params = array(
                'code' => $post['code'],
                'name' => $post['name'],
                'is_active' => 'Y',
                'is_deleted' => 'N',
                'created_by' => userId(),
                'created_at' => currentDateTime()
            );

            $this->dealer_m->createdealer($params);
            if ($this->db->affected_rows() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Create new dealer has been successfully'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to create new dealer'
                );
            }
        } else {
            $response = array(
                'success' => false,
                'message' => 'Dealer code already exists'
            );
        }
        echo json_encode($response);
    }

    public function editdealer()
    {
        $post = $this->input->post();

        $id = $post['eks_id'];
        $cek = $this->db->get_where('master_dealer', ['code' => $post['code'], 'id !=' => $id]);

        // var_dump($this->db->last_query());
        // die;

        if ($cek->num_rows() < 1) {

            $params = array(
                'code' => $post['code'],
                'name' => $post['name'],
                'updated_at' => currentDateTime(),
                'updated_by' => userId()
            );
            $this->dealer_m->editdealer($id, $params);
            if ($this->db->affected_rows() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Edit dealer has been successfully'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to edit dealer'
                );
            }
        } else {
            $response = array(
                'success' => false,
                'message' => 'Dealer code already exists'
            );
        }
        echo json_encode($response);
    }

    public function deletedealer()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $params = array(
            'is_active' => 'N',
            'is_deleted' => 'Y',
            'deleted_at' => currentDateTime(),
            'deleted_by' => userId()
        );
        $this->dealer_m->deletedealer($id, $params);
        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true,
                'message' => 'Delete dealer has been successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to delete dealer'
            );
        }
        echo json_encode($response);
    }
}
