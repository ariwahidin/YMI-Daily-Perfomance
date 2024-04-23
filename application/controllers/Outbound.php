<?php defined('BASEPATH') or exit('No direct script access allowed');

class Outbound extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(['outbound_m', 'user_m', 'ekspedisi_m', 'factory_m']);
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
        $checker = $this->user_m->getOperator();
        $factory = $this->factory_m->getFactory();
        $ekspedisi = $this->ekspedisi_m->getEkspedisi();
        $data = array(
            'checker' => $checker,
            'factory' => $factory,
            'ekspedisi' => $ekspedisi,
        );
        $this->render('outbound/create_outbound', $data);
    }

    public function createTask()
    {
        $post = $this->input->post();

        // var_dump($post);
        // die;

        $this->db->trans_start();

        foreach ($post['picker_id'] as $key => $val) {
            $params = array(
                'pl_id' => $post['no_pl'],
                'user_id' => $val,
                'sts' => 'picker'
            );
            $this->db->insert('pl_p', $params);
        }

        $params = array(
            'tot_qty' => $post['qty'],
            'no_truck' => $post['no_truck'],
            'remarks' => $post['remarks'],
            'updated_at' => currentDateTime(),
            'updated_by' => userId()
        );

        $this->db->where(['id' => $post['no_pl']]);
        $this->db->update('pl_h', $params);

        $params = array(
            'no_pl' => $post['no_pl'],
            // 'qty' => $post['qty'],
            // 'ekspedisi' => $post['ekspedisi'],
            // 'remarks' => $post['remarks'],
            'created_date' => currentDateTime(),
            'created_by' => userId()
        );

        $this->outbound_m->createTask($params);


        $this->db->trans_complete();

        // Memeriksa apakah transaksi berhasil atau tidak
        if ($this->db->trans_status() === FALSE) {
            // Jika transaksi gagal, bisa dilakukan rollback
            $this->db->trans_rollback();
            // Atau penanganan kesalahan lainnya
            $response = array(
                'success' => false,
                'error' => $this->db->error(),
                'message' => 'Create task failed'
            );
        } else {
            // Jika transaksi berhasil, bisa dilakukan commit
            $this->db->trans_commit();
            $response = array(
                'success' => true,
                'message' => 'Create task successfully'
            );
        }

        echo json_encode($response);
    }

    public function editTask()
    {
        $post = $this->input->post();

        // var_dump($post);
        // die;

        $this->db->trans_start();

        $this->db->delete('pl_p', ['pl_id' => $post['no_pl'], 'sts' => 'picker']);

        foreach ($post['picker_id'] as $picker) {
            $params = array(
                'pl_id' => $post['no_pl'],
                'user_id' => $picker,
                'sts' => 'picker'
            );
            $this->db->insert('pl_p', $params);
        }

        $params = array(
            'remarks' => $post['remarks'],
            'updated_at' => currentDateTime(),
            'updated_by' => userId()
        );

        $this->db->where(['id' => $post['no_pl']]);
        $this->db->update('pl_h', $params);

        $this->db->trans_complete();

        // Memeriksa apakah transaksi berhasil atau tidak
        if ($this->db->trans_status() === FALSE) {
            // Jika transaksi gagal, bisa dilakukan rollback
            $this->db->trans_rollback();
            // Atau penanganan kesalahan lainnya
            $response = array(
                'success' => false,
                'error' => $this->db->error(),
                'message' => 'Edit task failed'
            );
        } else {
            // Jika transaksi berhasil, bisa dilakukan commit
            $this->db->trans_commit();
            $response = array(
                'success' => true,
                'message' => 'Edit task successfully'
            );
        }

        echo json_encode($response);
    }

    public function getAllRowTask()
    {
        $post = $this->input->post();
        $task = $this->outbound_m->getTaskByUser($post);
        $data = array(
            'task' => $task
        );
        $this->load->view('outbound/row_task', $data);
    }

    public function getTaskById()
    {
        $post = $this->input->post();

        // var_dump($post);
        $result = $this->outbound_m->getTaskByUser($post)->row();
        $response = array(
            'data' => $result,
            'picker' => getPicker($post['pl_id'])->result()
        );
        echo json_encode($response);
    }

    public function prosesActivity()
    {
        $post = $this->input->post();

        // var_dump($post);
        // die;

        if ($post['activity'] == 'picking') {
            $user_id = userId();
            $pl_id = $post['pl_id'];
            $sql = "SELECT top 1 * FROM pl_p WHERE user_id = '$user_id' and sts = 'picker' and pl_id = '$pl_id'";
            $query = $this->db->query($sql);
            if ($query->num_rows() < 1) {
                $response = array(
                    'success' => false,
                    'message' => 'This user is not picker for this PL'
                );
                echo json_encode($response);
                exit;
            }
        }

        if ($post['activity'] == 'checking') {
            $user_id = userId();
            $pl_id = $post['pl_id'];
            $sql = "SELECT top 1 * FROM pl_p WHERE user_id = '$user_id' and sts = 'picker' and pl_id = '$pl_id'";
            $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                $response = array(
                    'success' => false,
                    'message' => 'This user is not allowed to checking proccess'
                );
                echo json_encode($response);
                exit;
            }

            $sql = "SELECT TOP 1 * FROM pl_p WHERE sts = 'checker' and user_id = '$user_id' and pl_id = '$pl_id'";
            $query = $this->db->query($sql);

            if ($query->num_rows() < 1) {
                $params = array(
                    'pl_id' => $pl_id,
                    'user_id' => $user_id,
                    'sts' => 'checker'
                );
                $this->db->insert('pl_p', $params);
            }
        }

        if ($post['activity'] == 'scanning') {
            $user_id = userId();
            $pl_id = $post['pl_id'];
            $sql = "SELECT top 1 * FROM pl_p WHERE user_id = '$user_id' and sts = 'picker' and pl_id = '$pl_id'";
            $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                $response = array(
                    'success' => false,
                    'message' => 'This user is not allowed to scanning proccess'
                );
                echo json_encode($response);
                exit;
            }

            $sql = "SELECT TOP 1 * FROM pl_p WHERE sts = 'scanner' and user_id = '$user_id' and pl_id = '$pl_id'";
            $query = $this->db->query($sql);

            if ($query->num_rows() < 1) {
                $params = array(
                    'pl_id' => $pl_id,
                    'user_id' => $user_id,
                    'sts' => 'scanner'
                );
                $this->db->insert('pl_p', $params);
            }
        }

        // var_dump($post);
        // die;

        $id = $post['id'];
        $params = array(
            $post['proses'] => currentDateTime()
        );

        $this->outbound_m->prosesActivity($id, $params);

        $response = array(
            'success' => true,
            'error' => $this->db->error(),
            'message' => 'Activity updated successfully'
        );

        echo json_encode($response);
    }

    public function deleteOut()
    {
        $post = $this->input->post();
        $this->outbound_m->deleteOutTemp($post);
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
        $this->render('outbound/outbound_report', $data);
    }

    public function tableReport()
    {
        $post = $this->input->post();
        $rows = $this->outbound_m->getCompletedActivity($post);

        // var_dump($rows->result());

        foreach ($rows->result() as $data) {
            $data->duration_picking = countDuration($data->start_picking, $data->stop_picking);
            $data->duration_checking = countDuration($data->start_checking, $data->stop_checking);
            $data->duration_scanning = countDuration($data->start_scanning, $data->stop_scanning);
        }

        $data = array(
            'completed' => $rows
        );
        $this->load->view('outbound/table_report', $data);
    }

    public function getDataExcel()
    {
        $rows = $this->outbound_m->getCompletedActivity($_POST)->result();
        $dataExcel = array();
        $no = 1;
        foreach ($rows as $val) {
            $row = array();
            $row['NO'] = $no++;
            $row['TANGGAL AKTIVITAS'] = date('Y-m-d', strtotime($val->created_date));
            $row['PL DATE'] = date('Y-m-d', strtotime($val->pl_date));
            $row['PL TIME'] = date('Y-m-d', strtotime($val->pl_time));
            $row['PL NO'] = $val->no_pl;
            $row['NO TRUCK'] = $val->no_truck;
            $row['EXPEDISI'] = $val->ekspedisi_name;
            $row['NAMA SUPIR'] = $val->driver;
            $row['QTY'] = $val->qty;
            $row['CHECKER'] = $val->checker_name;
            $row['START UNLOAD'] = date('H:i', strtotime($val->start_picking));
            $row['STOP UNLOAD'] = date('H:i', strtotime($val->stop_picking));
            $row['PICKING DURATION'] = date('H:i:s', strtotime($val->duration_picking));
            $row['LEAD TIME PICKING'] = roundMinutes(date('H:i:s', strtotime($val->duration_picking)));
            $row['START CHECKING'] = date('H:i', strtotime($val->start_checking));
            $row['STOP CHECKING'] = date('H:i', strtotime($val->stop_checking));
            $row['CHECKING DURATION'] = date('H:i:s', strtotime($val->duration_picking));
            $row['LEAD TIME CHECKING'] = roundMinutes(date('H:i:s', strtotime($val->duration_picking)));
            $row['START SCANNING'] = date('H:i', strtotime($val->start_scanning));
            $row['STOP SCANNING'] = date('H:i', strtotime($val->stop_scanning));
            $row['SCANNING DURATION'] = date('H:i:s', strtotime($val->duration_scanning));
            $row['LEAD TIME SCANNING'] = roundMinutes(date('H:i:s', strtotime($val->duration_scanning)));
            array_push($dataExcel, $row);
        }

        $data = array(
            'success' => true,
            'data' => $dataExcel
        );
        echo json_encode($data);
    }

    public function getTaskCompleteById()
    {
        $post = $this->input->post();
        $task = $this->outbound_m->getTaskCompleteById($post);
        $response = array(
            'success' => true,
            'task' => $task->row()
        );
        echo json_encode($response);
    }

    public function editTaskCompleted()
    {
        $post = $this->input->post();
        $id = $post['id_task'];
        $params = array(
            'no_pl' => $post['no_pl'],
            'no_truck' => $post['no_truck'],
            'qty' => $post['qty'],
            'checker_id' => $post['checker_id'],
            'pl_date' => $post['pl_date'],
            'pl_time' => $post['pl_time'],
            'ekspedisi' => $post['ekspedisi'],
            'driver' => $post['driver'],
            'remarks' => $post['remarks'],
            'updated_date' => currentDateTime(),
            'updated_by' => userId()
        );

        $this->outbound_m->editTaskCompleted($id, $params);

        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true,
                'message' => 'Update data successfully'
            );
        } else {
            $repsonse = array(
                'success' => false,
                'message' => 'Failed update data'
            );
        }
        echo json_encode($response);
    }

    public function deleteTaskCompleted()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $params = array(
            'is_deleted' => 'Y',
            'deleted_at' => currentDateTime(),
            'deleted_by' => userId()
        );

        $this->outbound_m->deleteActivityComplete($id, $params);

        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true,
                'message' => 'delete data successfully'
            );
        } else {
            $repsonse = array(
                'success' => false,
                'message' => 'Failed delete data'
            );
        }
        echo json_encode($response);
    }

    public function pickingList()
    {
        $data = array(
            'picking_list' => $this->outbound_m->getAllPickingList(),
            'ekspedisi' => $this->ekspedisi_m->getEkspedisi(),
        );
        $this->render('outbound/picking_list/index', $data);
    }

    public function createPickingList()
    {
        $post = $this->input->post();
        $params = array(
            'pl_no' => $post['pl_no'],
            'sj_no' => $post['sj_no'],
            'sj_time' => $post['sj_time'],
            'dest' => $post['dest'],
            'tot_qty' => $post['tot_qty'],
            'dealer_code' => $post['dealer_code'],
            'dealer_det' => $post['dealer_det'],
            'expedisi' => $post['expedisi'],
            'dock' => $post['dock'],
            'no_truck' => $post['no_truck'],
            'pl_print_time' => $post['pl_print_time'],
            'adm_pl_date' => $post['rec_pl_date'],
            'adm_pl_time' => $post['rec_pl_time'],
            'created_at' => currentDateTime(),
            'created_by' => userId()
        );
        $this->outbound_m->createPickingList($params);
        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true,
                'message' => 'Create picking list successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed create picking list'
            );
        }
        echo json_encode($response);
    }

    public function getPickingListAdm()
    {
        $response = array(
            'success' => true,
            'picking_list' => $this->outbound_m->getAllPickingListIdle()->result()
        );
        echo json_encode($response);
    }

    public function getPickingListAdmById()
    {
        $response = array(
            'success' => true,
            'picking_list' => $this->outbound_m->getAllPickingList($_POST['id'])->row_array()
        );
        echo json_encode($response);
    }
}
