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

    public function formExample()
    {
        $file_path = 'file/form_example.xlsx'; // Ganti dengan path file Excel Anda
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="YMI_schedule_example.xlsx"'); // Nama file yang akan didownload
        readfile($file_path);
    }

    public function getDataExcelForm()
    {
        $header = array(
            'user_id' => 'kolom1',
            'fullname' => 'kolom2',
            'position_id' => 'kolom3',
            'position_name' => 'kolom4',
            'start_date' => 'kolom5',
            'start_time' => 'kolom6',
            'end_date' => 'kolom7',
            'end_time' => 'kolom8',
        );

        $data = array(
            'success' => true,
            'example' => json_decode(file_get_contents('file/schedule_example.json'), true),
            'header' => json_decode(json_encode($header)),
            'users' => $this->work_schedule_m->getMasterUser()->result(),
            'file_name' => 'YMI_schedule_form_' . date('YmdHis', strtotime(currentDateTime())) . '.xlsx'
        );
        echo json_encode($data);
    }

    public function createSchedule()
    {
        $post = $this->input->post();

        // var_dump($post);
        // die;

        $cek = $this->db->get_where('work_schedule', ['user_id' => $post['user_id'], 'date' => $post['start_date'], 'is_deleted' => 'N']);

        if ($cek->num_rows() < 1) {

            $params = array(
                'user_id' => $post['user_id'],
                'position_id' => $post['position_id'],
                'date' => $post['start_date'],
                'start_time' => date('Y-m-d H:i:s', strtotime($post['start_date'] . $post['start_time'])),
                'end_time' => date('Y-m-d H:i:s', strtotime($post['end_date'] . $post['end_time'])),
                'is_active' => 'Y',
                'remarks' => $post['remarks'],
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

    public function createWithExcel()
    {
        $post = $this->input->post();
        $schedule = json_decode($post['schedule'])->rows;
        $params = array();

        foreach ($schedule as $data) {
            $param = array();
            $param['user_id'] = $data->user_id;
            $param['position_id'] = $data->position_id;
            $param['date'] = date('Y-m-d', strtotime($data->start_time));
            $param['start_time'] = date('Y-m-d H:i:s', strtotime($data->start_date . $data->start_time));
            $param['end_time'] = date('Y-m-d H:i:s', strtotime($data->end_date . $data->end_time));
            $param['is_active'] = 'Y';
            $param['created_at'] = currentDateTime();
            $param['created_by'] = userId();
            $param['is_deleted'] = 'N';
            array_push($params, $param);
        }

        $this->db->insert_batch('work_schedule', $params);

        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true,
                'message' => 'upload schedule successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'failed to ulpload schedule'
            );
        }

        echo json_encode($response);
    }

    public function editSchedule()
    {
        $post = $this->input->post();


        $cek = $this->db->get_where('work_schedule', ['user_id' => $post['user_id'], 'date' => $post['start_date'], 'is_deleted' => 'N', 'id !=' => $post['eks_id']]);

        // var_dump($this->db->last_query());
        // die;

        if ($cek->num_rows() < 1) {

            $params = array(
                'user_id' => $post['user_id'],
                'position_id' => $post['position_id'],
                'date' => $post['start_date'],
                'start_time' => date('Y-m-d H:i:s', strtotime($post['start_date'] . $post['start_time'])),
                'end_time' => date('Y-m-d H:i:s', strtotime($post['end_date'] . $post['end_time'])),
                'is_active' => $post['in_status'],
                'remarks' => $post['remarks'],
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
