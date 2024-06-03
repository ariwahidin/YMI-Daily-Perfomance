<?php defined('BASEPATH') or exit('No direct script access allowed');

class Inbound extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(['inbound_m', 'user_m', 'ekspedisi_m', 'factory_m']);
        is_not_logged_in();
    }

    public function render($view, array $data = null)
    {
        $this->load->view('template/header');
        $this->load->view($view, $data);
        $this->load->view('template/footer');
    }

    public function index()
    {
        $checker = $this->user_m->getOperatorForInbound();
        $factory = $this->factory_m->getFactory();
        $ekspedisi = $this->ekspedisi_m->getEkspedisi();
        $data = array(
            'checker' => $checker,
            'factory' => $factory,
            'ekspedisi' => $ekspedisi,
        );
        $this->render('inbound/create_inbound', $data);
    }

    public function report()
    {
        $checker = $this->user_m->getOperator();
        $factory = $this->factory_m->getFactory();
        $ekspedisi = $this->ekspedisi_m->getEkspedisi();
        $data = array(
            'checker' => $checker,
            'factory' => $factory,
            'ekspedisi' => $ekspedisi,
        );
        $this->render('inbound/inbound_report', $data);
    }

    public function createTask()
    {
        $post = $this->input->post();

        // var_dump($post);
        // die;


        if ($post['proses'] === 'new_task') {
            $params = array(
                'unload_seq' => $post['unloading_sequence'],
                'no_sj' => $post['sj'],
                'no_truck' => $post['no_truck'],
                'qty' => $post['qty'],
                'checker_id' => $post['checker'],
                'sj_send_date' => $post['send_date'],
                'sj_date' => $post['sj_date'],
                'sj_time' => date('H:i:s', strtotime($post['sj_time'])),
                'time_arival' => date('H:i:s', strtotime($post['toa'])),
                'ekspedisi' => $post['expedisi'],
                'driver' => $post['driver'],
                'factory_code' => $post['factory'],
                'alloc_code' => $post['alocation'],
                'pintu_unloading' => $post['pintu_unloading'],
                'remarks' => $post['remarks'],
                'activity_date' =>$post['activity_date'],
                'created_date' => currentDateTime(),
                'created_by' => userId()
            );
            $this->inbound_m->createNewTask($params);

            if ($this->db->affected_rows() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'New task has been created successfully'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to create new task!'
                );
            }
        }

        echo json_encode($response);
    }

    public function editTask()
    {
        $post = $this->input->post();

        // var_dump($post);
        // die;

        if ($post['proses'] === 'edit_task') {
            $id = $post['id_task'];
            $params = array(
                'unload_seq' => $post['unloading_sequence'],
                'no_sj' => $post['sj'],
                'no_truck' => $post['no_truck'],
                'qty' => $post['qty'],
                'checker_id' => $post['checker'],
                'sj_date' => $post['sj_date'],
                'sj_time' => date('H:i:s', strtotime($post['sj_time'])),
                'ekspedisi' => $post['expedisi'],
                'driver' => $post['driver'],
                'factory_code' => $post['factory'],
                'alloc_code' => $post['alocation'],
                'pintu_unloading' => $post['pintu_unloading'],
                'sj_send_date' => $post['send_date'],
                'time_arival' => $post['toa'],
                'remarks' => $post['remarks'],
                'activity_date' => $post['activity_date'],
            );
            $this->inbound_m->editTask($id, $params);

            if ($this->db->affected_rows() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Edit task successfully'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to edit task!'
                );
            }
        }

        echo json_encode($response);
    }

    public function task()
    {
        $checker = $this->user_m->getOperatorForInbound();
        $factory = $this->factory_m->getFactory();
        $ekspedisi = $this->ekspedisi_m->getEkspedisiForInbound();
        $data = array(
            'checker' => $checker,
            'factory' => $factory,
            'ekspedisi' => $ekspedisi,
        );
        $this->render('inbound/inbound_task/inbound_task', $data);
    }

    public function getAllRowTask()
    {
        $post = $this->input->post();
        $task = $this->inbound_m->getTaskByUser($post);
        $data = array(
            'task' => $task
        );
        $this->load->view('inbound/inbound_task/row_task', $data);
    }

    public function getTaskById()
    {
        $post = $this->input->post();
        $task = $this->inbound_m->getTaskByUser($post);
        $response = array(
            'success' => true,
            'task' => $task->row()
        );
        echo json_encode($response);
    }

    public function getTaskCompleteById()
    {
        $post = $this->input->post();
        $task = $this->inbound_m->getTaskCompleteById($post);
        $response = array(
            'success' => true,
            'task' => $task->row()
        );
        echo json_encode($response);
    }

    public function keepAlive()
    {
        $response = array(
            'success' => true,
            'message' => 'keep a live'
        );
        echo json_encode($response);
    }

    public function getRow()
    {

        $post = $this->input->post();
        $this->inbound_m->createTempActivity($post);
        $id = $this->db->insert_id();
        $row = $this->inbound_m->getTempActivity($id);
        $data = array(
            'activity' => $row
        );
        $this->load->view('inbound/row', $data);
    }

    public function deleteTransTemp()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $this->inbound_m->deleteRowTrans($id);
        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true,
                'message' => 'Delete data successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed deleting data'
            );
        }
        echo json_encode($response);
    }

    public function getAllRowTemp()
    {
        $rows = $this->inbound_m->getTempActivity();

        foreach ($rows->result() as $data) {
            $data->duration_unloading = countDuration($data->start_unloading, $data->stop_unloading);
            $data->duration_checking = countDuration($data->start_checking, $data->stop_checking);
            $data->duration_putaway = countDuration($data->start_putaway, $data->stop_putaway);
        }

        $data = array(
            'activity' => $rows
        );

        $this->load->view('inbound/row', $data);
    }



    public function getDataCompleteById()
    {
        $data = array(
            'success' => true,
            'data' => $this->inbound_m->getActCompleteById()->row()
        );
        echo json_encode($data);
    }

    public function getRowCompleteAct()
    {
        $rows = $this->inbound_m->getCompletedActivity($_POST);

        foreach ($rows->result() as $data) {
            $data->duration_unloading = countDuration($data->start_unload, $data->stop_unload);
            $data->duration_checking = countDuration($data->start_checking, $data->stop_checking);
            $data->duration_putaway = countDuration($data->start_putaway, $data->stop_putaway);
        }

        $data = array(
            'completed' => $rows
        );
        $this->load->view('inbound/row_complete_ctivity', $data);
    }

    public function tableReport()
    {
        $post = $this->input->post();
        $rows = $this->inbound_m->getCompletedActivity($post);

        foreach ($rows->result() as $data) {
            $data->duration_unloading = countDuration($data->start_unload, $data->stop_unload);
            $data->duration_checking = countDuration($data->start_checking, $data->stop_checking);
            $data->duration_putaway = countDuration($data->start_putaway, $data->stop_putaway);
        }

        $data = array(
            'completed' => $rows
        );
        $this->load->view('inbound/table_report', $data);
    }

    public function getDataExcel()
    {
        $rows = $this->inbound_m->getCompletedActivity($_POST)->result();
        // var_dump($rows);
        // die;
        $dataExcel = array();
        $no = 1;
        foreach ($rows as $val) {
            $row = array();
            $row['NO UNLOAD'] = $val->unload_seq;
            $row['TANGGAL AKTIVITAS'] = date('Y-m-d', strtotime($val->activity_date));
            $row['TANGGAL KIRIM'] = date('Y-m-d', strtotime($val->sj_send_date));
            $row['TANGGAL UNLOAD'] = date('Y-m-d', strtotime($val->sj_send_date));
            $row['FACTORY'] = $val->factory_name;
            $row['SURAT JALAN'] = $val->no_sj;
            $row['NO TRUCK'] = $val->no_truck;
            $row['EXPEDISI'] = $val->ekspedisi_name;
            $row['ORIGIN TIME ARIVAL'] = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($val->sj_created_at)) . $val->time_arival));
            $row['TIME ARIVAL'] = $val->time_arival;
            $row['NAMA SUPIR'] = $val->driver;
            $row['ALOCATION'] = $val->alloc_code;
            $row['PINTU UNLOADING'] = $val->pintu_unloading;
            $row['QTY'] = $val->qty;
            $row['CHECKER'] = $val->checker_name;
            $row['ORIGIN START UNLOAD'] = $val->start_unload == null ? '' :  date('Y-m-d H:i:s', strtotime($val->start_unload));
            $row['START UNLOAD'] = $val->start_unload == null ? '' :  date('H:i', strtotime($val->start_unload));
            $row['ORIGIN STOP UNLOAD'] = $val->stop_unload == null ? '' :  date('Y-m-d H:i:s', strtotime($val->stop_unload));
            $row['STOP UNLOAD'] = $val->stop_unload == null ? '' :  date('H:i', strtotime($val->stop_unload));
            $row['UNLOAD DURATION'] = $val->stop_unload == null ? '' : countDuration(date('Y-m-d H:i:s', strtotime($val->start_unload)), date('Y-m-d H:i:s', strtotime($val->stop_unload)));
            $row['LEAD TIME UNLOAD'] = $val->stop_unload == null ? '' :  roundMinutes($row['UNLOAD DURATION']);
            $row['ORIGIN START CHECKING'] = $val->start_checking == null ? '' : date('Y-m-d H:i:s', strtotime($val->start_checking));
            $row['START CHECKING'] = $val->start_checking == null ? '' : date('H:i', strtotime($val->start_checking));
            $row['ORIGIN STOP CHECKING'] = $val->stop_checking == null ? '' : date('Y-m-d H:i:s', strtotime($val->stop_checking));
            $row['STOP CHECKING'] = $val->stop_checking == null ? '' : date('H:i', strtotime($val->stop_checking));
            $row['CHECKING DURATION'] = $val->stop_checking == null ? '' : countDuration(date('Y-m-d H:i:s', strtotime($val->start_checking)), date('Y-m-d H:i:s', strtotime($val->stop_checking)));
            $row['LEAD TIME CHECKING'] = $val->stop_checking == null ? '' : roundMinutes($row['CHECKING DURATION']);
            $row['ORIGIN START PUTAWAY'] = $val->start_putaway == null ? '' : date('Y-m-d H:i:s', strtotime($val->start_putaway));
            $row['START PUTAWAY'] = $val->start_putaway == null ? '' : date('H:i', strtotime($val->start_putaway));
            $row['ORIGIN STOP PUTAWAY'] = $val->stop_putaway == null ? '' : date('Y-m-d H:i:s', strtotime($val->stop_putaway));
            $row['STOP PUTAWAY'] = $val->stop_putaway == null ? '' : date('H:i', strtotime($val->stop_putaway));
            $row['PUTAWAY DURATION'] = $val->stop_putaway == null ? '' : countDuration(date('Y-m-d H:i:s', strtotime($val->start_putaway)), date('Y-m-d H:i:s', strtotime($val->stop_putaway)));
            $row['LEAD TIME PUTAWAY'] = $val->stop_putaway == null ? '' : roundMinutes($row['PUTAWAY DURATION']);
            $row['REMAKRS'] = $val->remarks;
            array_push($dataExcel, $row);
        }

        $data = array(
            'success' => true,
            'data' => $dataExcel
        );
        echo json_encode($data);
    }

    public function editActivityComplete()
    {
        $post = $this->input->post();
        $this->inbound_m->updateActivityComplete($post);
        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true
            );
        } else {
            $response = array(
                'success' => false
            );
        }
        echo json_encode($response);
    }

    public function deleteCompleteActivity()
    {
        $post = $this->input->post();
        $this->inbound_m->deleteActivityComplete($post);
        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true
            );
        } else {
            $response = array(
                'success' => false
            );
        }
        echo json_encode($response);
    }

    public function editTaskCompleted()
    {
        $post = $this->input->post();
        // var_dump($post);
        // exit;
        $id = $post['id_task'];
        $params = array(
            'no_sj' => $post['sj'],
            'unload_seq' => $post['unloading_sequence'],
            'activity_date' => $post['activity_date'],
            'no_truck' => $post['no_truck'],
            'qty' => $post['qty'],
            'checker_id' => $post['checker'],
            'sj_date' => $post['sj_date'],
            'sj_time' => date('H:i:s', strtotime($post['sj_time'])),
            'ekspedisi' => $post['expedisi'],
            'driver' => $post['driver'],
            'factory_code' => $post['factory'],
            'alloc_code' => $post['alocation'],
            'pintu_unloading' => $post['pintu_unloading'],
            'sj_send_date' => $post['send_date'],
            'time_arival' => $post['toa'],
            'remarks' => $post['remarks'],
            'updated_by' => userId(),
            'updated_at' => currentDateTime()
        );

        $this->inbound_m->editTaskCompleted($id, $params);

        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true,
                'message' => 'Edit successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to edit!'
            );
        }

        echo json_encode($response);
    }

    public function editActivity()
    {
        $response = array();
        $post = $_POST;
        $timeString = $post['time'];
        $dateTime = new DateTime($timeString);
        $newFormat = $dateTime->format('Y-m-d H:i:s');

        $params = array(
            'id' => $post['id'],
            'activity' => $post['activity'],
            'time' => $newFormat
        );

        $this->inbound_m->editActivity($params);

        if ($this->db->affected_rows() > 0) {
            $row = $this->inbound_m->getTempActivity($post['id']);
            $response['data'] = $row->row();
            $checkFinish = $this->inbound_m->checkFinishActivity($post['id']);
            if ($checkFinish->num_rows() > 0) {
                if ($this->inbound_m->finishActivity($post['id'])) {
                    $response['isFinish'] = true;
                } else {
                    $response['isFinish'] = false;
                }
            } else {
                $response['isFinish'] = false;
            }
        }

        echo json_encode($response);
    }

    public function editUserActivity()
    {
        $post = $_POST;
        // var_dump($post);
        // die;
        $response = array();
        $this->inbound_m->editUserActivity($post);
        if ($this->db->affected_rows() > 0) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
        }
        echo json_encode($response);
    }

    public function startUnloading()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $cek = $this->inbound_m->getTransTemp($id)->row();
        if (!is_null($cek->start_unloading)) {
            $response = array(
                'success' => false,
                'message' => 'Unloading already started please reload this page!'
            );
        } else {
            $params = array(
                'start_unloading' => currentDateTime(),
            );

            $this->inbound_m->startUnload($id, $params);
            if ($this->db->affected_rows() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Unloading started successfully'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to start unload!'
                );
            }
        }
        echo json_encode($response);
    }

    public function stopUnloading()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $cek = $this->inbound_m->getTransTemp($id)->row();
        if (!is_null($cek->stop_unloading)) {
            $response = array(
                'success' => false,
                'message' => 'Unloading already stoped please reload this page!'
            );
        } else {
            $params = array(
                'stop_unloading' => currentDateTime(),
            );

            $this->inbound_m->stopUnload($id, $params);
            if ($this->db->affected_rows() > 0) {

                $checkFinish = $this->inbound_m->checkFinishActivity($id);
                if ($checkFinish->num_rows() > 0) {
                    $this->inbound_m->finishActivity($id);
                }

                $response = array(
                    'success' => true,
                    'message' => 'Stop unloading successfully'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to stop unload!'
                );
            }
        }
        echo json_encode($response);
    }

    public function startChecking()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $cek = $this->inbound_m->getTransTemp($id)->row();
        if (!is_null($cek->start_checking)) {
            $response = array(
                'success' => false,
                'message' => 'Checking already started please reload this page!'
            );
        } else {
            $params = array(
                'start_checking' => currentDateTime(),
            );

            $this->inbound_m->startChecking($id, $params);
            if ($this->db->affected_rows() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Checking started successfully'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to start unload!'
                );
            }
        }
        echo json_encode($response);
    }

    public function stopChecking()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $cek = $this->inbound_m->getTransTemp($id)->row();
        if (!is_null($cek->stop_checking)) {
            $response = array(
                'success' => false,
                'message' => 'Checking already stoped please reload this page!'
            );
        } else {
            $params = array(
                'stop_checking' => currentDateTime(),
            );

            $this->inbound_m->stopChecking($id, $params);
            if ($this->db->affected_rows() > 0) {

                $checkFinish = $this->inbound_m->checkFinishActivity($id);
                if ($checkFinish->num_rows() > 0) {
                    $this->inbound_m->finishActivity($id);
                }

                $response = array(
                    'success' => true,
                    'message' => 'Stop checking successfully'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to stop checking!'
                );
            }
        }
        echo json_encode($response);
    }
    public function startPutaway()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $cek = $this->inbound_m->getTransTemp($id)->row();

        if (!is_null($cek->start_putaway)) {
            $response = array(
                'success' => false,
                'message' => 'Putaway already started please reload this page!'
            );
        } else {
            $params = array(
                'start_putaway' => currentDateTime(),
            );

            $this->inbound_m->startPutaway($id, $params);
            if ($this->db->affected_rows() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Putaway started successfully'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to start putaway!'
                );
            }
        }
        echo json_encode($response);
    }

    public function stopPutaway()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $cek = $this->inbound_m->getTransTemp($id)->row();
        if (!is_null($cek->stop_putaway)) {
            $response = array(
                'success' => false,
                'message' => 'Putaway already stoped please reload this page!'
            );
        } else {
            $params = array(
                'stop_putaway' => currentDateTime(),
            );

            $this->inbound_m->stopPutaway($id, $params);
            if ($this->db->affected_rows() > 0) {

                $checkFinish = $this->inbound_m->checkFinishActivity($id);
                if ($checkFinish->num_rows() > 0) {
                    $this->inbound_m->finishActivity($id);
                }

                $response = array(
                    'success' => true,
                    'message' => 'Stop putaway successfully'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to stop putaway!'
                );
            }
        }
        echo json_encode($response);
    }
}
