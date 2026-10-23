<?php defined('BASEPATH') or exit('No direct script access allowed');

class Factory extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_not_logged_in();
        $this->load->model(['user_m', 'role_m', 'factory_m']);
    }

    public function render($view, ?array $data = null)
    {
        $this->load->view('template/header');
        $this->load->view($view, $data);
        $this->load->view('template/footer');
    }

    public function index()
    {
        $data = array(
            'factory' => $this->factory_m->getFactory()
        );
        $this->render('factory/index', $data);
    }

    public function createFactory()
    {
        $post = $this->input->post();
        $params = array(
            'name' => $post['name'],
            'is_active' => 'Y',
            'is_deleted' => 'N',
            'created_by' => userId(),
            'created_at' => currentDateTime()
        );

        // var_dump($params);

        $this->factory_m->createFactory($params);
        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true,
                'message' => 'Create new factory has been successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to create new factory'
            );
        }
        echo json_encode($response);
    }

    public function editFactory()
    {
        $post = $this->input->post();
        $id = $post['eks_id'];
        $params = array(
            'name' => $post['name'],
            'updated_at' => currentDateTime(),
            'updated_by' => userId()
        );
        $this->factory_m->editFactory($id, $params);
        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true,
                'message' => 'Edit factory has been successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to edit factory'
            );
        }
        echo json_encode($response);
    }

    public function deleteFactory()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $params = array(
            'is_active' => 'N',
            'is_deleted' => 'Y',
            'deleted_at' => currentDateTime(),
            'deleted_by' => userId()
        );
        $this->factory_m->deleteFactory($id, $params);
        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true,
                'message' => 'Delete factory has been successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to delete factory'
            );
        }
        echo json_encode($response);
    }
}
