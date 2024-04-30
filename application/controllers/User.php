<?php defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_not_logged_in();
        $this->load->model(['user_m', 'role_m']);
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
            'role' => $this->role_m->getRole(),
            'user' => $this->user_m->getUserActive(),
            'position' => $this->db->get('master_position')
        );
        $this->render('user/index', $data);
    }

    public function createUser()
    {
        $post = $this->input->post();
        // var_dump($post);
        // die;
        $cek = $this->user_m->getUserByUsername($post['username']);
        if ($cek->num_rows() < 1) {
            $this->user_m->createUser($post);
            if ($this->db->affected_rows() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Create new user has been successfully'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to create new user'
                );
            }
        } else {
            $response = array(
                'success' => false,
                'message' => 'This username already used'
            );
        }
        echo json_encode($response);
    }

    public function editUser()
    {
        $post = $this->input->post();
        // var_dump($post);
        // die;
        $this->user_m->editUser($post);
        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true,
                'message' => 'Edit user has been successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to edit user'
            );
        }
        echo json_encode($response);
    }

    public function deleteUser()
    {
        $post = $this->input->post();
        $this->user_m->deleteUser($post);
        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true,
                'message' => 'Delete user has been successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to delete this user'
            );
        }
        echo json_encode($response);
    }


}
