<?php defined('BASEPATH') or exit('No direct script access allowed');

class WorkSchedule extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_not_logged_in();
        $this->load->model(['user_m', 'role_m', 'work_schedule_m']);
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
            'users' => $this->user_m->getUserActive(),
            'position' => $this->db->get('master_position'),

        );
        $this->render('work_schedule/index', $data);
    }

    public function getTableSchedule()
    {
        $data = array(
            'work_schedule' => $this->work_schedule_m->getWorkSchedule(),
        );
        $this->load->view('work_schedule/table_schedule', $data);
    }

    public function createSchedule()
    {
        $post = $this->input->post();

        $cek = $this->db->get_where('work_schedule', ['user_id' => $post['user_id'], 'date' => $post['date'], 'is_deleted' => 'N']);

        if ($cek->num_rows() < 1) {

            $params = array(
                'user_id' => $post['user_id'],
                'position_id' => $post['position_id'],
                'date' => $post['date'],
                'start_time' => date('Y-m-d H:i:s', strtotime($post['date'] . $post['start_time'])),
                'end_time' => date('Y-m-d H:i:s', strtotime($post['date'] . $post['end_time'])),
                'created_at' => currentDateTime(),
                'created_by' => userId(),
                'is_deleted' => 'N'
            );

            $this->db->insert('work_schedule', $params);

            if ($this->db->affected_rows() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Schedule has been created successfully'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to created schedule' . $this->db->error()
                );
            }
        } else {
            $response = array(
                'success' => false,
                'message' => 'This schedule already exists'
            );
        }

        echo json_encode($response);
    }

    public function editSchedule()
    {
        $post = $this->input->post();


        $cek = $this->db->get_where('work_schedule', ['user_id' => $post['user_id'], 'date' => $post['date'], 'is_deleted' => 'N', 'id !=' => $post['eks_id']]);

        // var_dump($this->db->last_query());
        // die;

        if ($cek->num_rows() < 1) {

            $params = array(
                'user_id' => $post['user_id'],
                'position_id' => $post['position_id'],
                'date' => $post['date'],
                'start_time' => date('Y-m-d H:i:s', strtotime($post['date'] . $post['start_time'])),
                'end_time' => date('Y-m-d H:i:s', strtotime($post['date'] . $post['end_time'])),
                'created_at' => currentDateTime(),
                'created_by' => userId()
            );

            $this->db->where(['id' => $post['eks_id']]);
            $this->db->update('work_schedule', $params);

            if ($this->db->affected_rows() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Schedule has been update successfully'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to updating schedule' . $this->db->error()
                );
            }
        } else {
            $response = array(
                'success' => false,
                'message' => 'This schedule already exists'
            );
        }


        echo json_encode($response);
    }

    public function deleteSchedule()
    {
        $post = $this->input->post();
        // var_dump($post);

        $params = array(
            'is_deleted' => 'Y',
            'deleted_at' => currentDateTime(),
            'deleted_by' => userId()
        );

        $this->db->where(['id' => $post['id']]);
        $this->db->update('work_schedule', $params);

        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true,
                'message' => 'Deleting work schedule has been successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to deleting work schedule'
            );
        }
        echo json_encode($response);
    }
}
