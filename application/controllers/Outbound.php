<?php defined('BASEPATH') or exit('No direct script access allowed');

class Outbound extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(['outbound_m', 'user_m', 'ekspedisi_m', 'factory_m', 'destination_m', 'dealer_m']);
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
        $checker = $this->user_m->getOperatorOutbound();
        $factory = $this->factory_m->getFactory();
        $ekspedisi = $this->ekspedisi_m->getEkspedisi();
        $data = array(
            'checker' => $checker,
            'factory' => $factory,
            'ekspedisi' => $ekspedisi,
        );
        $this->render('outbound/create_outbound', $data);
    }

    public function getOptionEkspedisi()
    {
        $ekspedisi = $this->ekspedisi_m->getEkspedisi();
        $data = array(
            'ekspedisi' => $ekspedisi
        );
        $response = array(
            'success' => true,
            'option_no_truck' => $this->load->view('outbound/picking_list/option_no_truck', $data, true),
            'option_ekspedisi' => $this->load->view('outbound/picking_list/option_ekspedisi', $data, true),
        );
        echo json_encode($response);
    }

    public function getOptionDealerAndDest()
    {
        $data = array(
            'dest' => $this->destination_m->getdestination(),
            'dealer' => $this->dealer_m->getDealer(),
        );
        $response = array(
            'success' => true,
            'option_dest' => $this->load->view('outbound/picking_list/option_dest', $data, true),
            'option_dealer' => $this->load->view('outbound/picking_list/option_dealer', $data, true),
        );
        echo json_encode($response);
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
            'pintu_loading' => $post['pintu_loading'],
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
            'pintu_loading' => $post['pintu_loading'],
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

        // var_dump($post);
        // die;

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
            $id = $post['id'];
            $pl_id = $post['pl_id'];


            $sql = "SELECT TOP 1 stop_picking FROM tb_out_temp WHERE id = '$id' AND stop_picking IS NULL";
            $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                $response = array(
                    'success' => false,
                    'message' => "Can not to checking proccess, Finish picking proccess first"
                );
                echo json_encode($response);
                exit;
            }

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
            $id = $post['id'];

            $sql = "SELECT TOP 1 stop_checking FROM tb_out_temp WHERE id = '$id' AND stop_checking IS NULL";
            $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                $response = array(
                    'success' => false,
                    'message' => "Can not to scanning proccess, Finish checking proccess first"
                );
                echo json_encode($response);
                exit;
            }

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

        $this->db->delete('pl_p', ['pl_id' => $post['pl_id']]);
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

    public function getReportOutbound($post)
    {
        $rows = $this->outbound_m->getCompletedActivity($post);

        foreach ($rows->result() as $data) {
            $data->{'DURASI DORONG'} = $data->{'SELESAI DORONG'} == null ? null : countDuration($data->{'MULAI DORONG'}, $data->{'SELESAI DORONG'});
            $data->{'LEAD TIME DURASI DORONG'} = $data->{'DURASI DORONG'} == null ? '' : roundMinutes($data->{'DURASI DORONG'});
            $data->{'DURASI CHECK'} = $data->{'SELESAI CHECK'} == null ? null : countDuration($data->{'MULAI CHECK'}, $data->{'SELESAI CHECK'});
            $data->{'LEAD TIME DURASI CHECK'} = $data->{'DURASI CHECK'} == null ? '' : roundMinutes($data->{'DURASI CHECK'});
            $data->{'DURASI SCAN'} = $data->{'SELESAI SCAN'} == null ? null : countDuration($data->{'MULAI SCAN'}, $data->{'SELESAI SCAN'});
            $data->{'LEAD TIME DURASI SCAN'} = $data->{'DURASI SCAN'} == null ? '' : roundMinutes($data->{'DURASI SCAN'});
        }

        return $rows;
    }

    public function getPickerOutbound($post)
    {
        $rows = $this->outbound_m->getPickerOutbound();
        $no = 1;
        $dataExcel = array();
        foreach ($rows->result() as $data) {
            $row = array();
            $row['NO'] = $no++;
            $row['PICKER NAME'] = $data->fullname;
            $row['TANGGAL'] = $data->created_date;
            $row['NO PL'] = $data->no_pl;
            $row['PL DATE'] = $data->pl_date;
            $row['MULAI DORONG'] = date('H:i', strtotime($data->start_picking));
            $row['SELESAI DORONG'] = date('H:i', strtotime($data->stop_picking));
            $row['DURASI DORONG'] = countDuration($row['MULAI DORONG'], $row['SELESAI DORONG']);
            $row['LEAD TIME DURASI DORONG'] = roundMinutes($row['DURASI DORONG']);
            array_push($dataExcel, $row);
        }

        return $dataExcel;
    }

    public function tableReport()
    {
        $post = $this->input->post();
        $rows = $this->getReportOutbound($post);

        $data = array(
            'completed' => $rows,
            'picker' => $this->getPickerOutbound($post)
        );

        $response = array(
            'success' => true,
            'summary' => $this->load->view('outbound/table_report', $data, true),
            'picker' => $this->load->view('outbound/table_picker', $data, true)
        );

        echo json_encode($response);
    }

    public function getDataExcel()
    {
        $rows = $this->getReportOutbound($_POST)->result();
        $dataExcel = array();
        $no = 1;
        foreach ($rows as $data) {
            $row = array();
            $row['NO'] = $no++;
            $row['ACTIVITY DATE'] = $data->{'ACTIVITY DATE'};
            $row['TANGGAL'] = $data->{'TANGGAL'};
            $row['NO PL'] = $data->{'NO PL'};
            $row['NO SJ'] = $data->{'NO SJ'};
            $row['TUJUAN'] = $data->{'TUJUAN'};
            $row['NO TRUCK'] = $data->{'NO TRUCK'};
            $row['KODE DEALER'] =  $data->{'KODE DEALER'};
            $row['EXPEDISI'] = $data->{'EXPEDISI'};
            $row['MD/DDS'] = $data->{'MD/DDS'};
            $row['QTY'] = $data->{'QTY'};
            $row['JAM CETAK PL'] = $data->{'JAM CETAK PL'} == null ? '' : date('H:i', strtotime($data->{'JAM CETAK PL'}));
            $row['JAM AMANO'] = $data->{'JAM AMANO'} == null ? '' : date('H:i', strtotime($data->{'JAM AMANO'}));
            $row['ORIGIN MULAI DORONG'] = $data->{'MULAI DORONG'} == null ? '' : date('Y-m-d H:i:s', strtotime($data->{'MULAI DORONG'}));
            $row['MULAI DORONG'] = $data->{'MULAI DORONG'} == null ? '' : date('H:i', strtotime($data->{'MULAI DORONG'}));
            $row['ORIGIN SELESAI DORONG'] = $data->{'SELESAI DORONG'} == null ? '' :  date('Y-m-d H:i:s', strtotime($data->{'SELESAI DORONG'}));
            $row['SELESAI DORONG'] = $data->{'SELESAI DORONG'} == null ? '' :  date('H:i', strtotime($data->{'SELESAI DORONG'}));
            $row['ORIGIN MULAI CHECK'] = $data->{'MULAI CHECK'} == null ? '' : date('Y-m-d H:i:s', strtotime($data->{'MULAI CHECK'}));
            $row['MULAI CHECK'] = $data->{'MULAI CHECK'} == null ? '' : date('H:i', strtotime($data->{'MULAI CHECK'}));
            $row['ORIGIN SELESAI CHECK'] = $data->{'SELESAI CHECK'} == null ? '' : date('Y-m-d H:i:s', strtotime($data->{'SELESAI CHECK'}));
            $row['SELESAI CHECK'] = $data->{'SELESAI CHECK'} == null ? '' : date('H:i', strtotime($data->{'SELESAI CHECK'}));
            $row['ORIGIN MULAI SCAN'] = $data->{'MULAI SCAN'} == null ? '' : date('Y-m-d H:i:s', strtotime($data->{'MULAI SCAN'}));
            $row['MULAI SCAN'] = $data->{'MULAI SCAN'} == null ? '' : date('H:i', strtotime($data->{'MULAI SCAN'}));
            $row['ORIGIN SELESAI SCAN'] = $data->{'SELESAI SCAN'} == null ? '' : date('Y-m-d H:i:s', strtotime($data->{'SELESAI SCAN'}));
            $row['SELESAI SCAN'] = $data->{'SELESAI SCAN'} == null ? '' : date('H:i', strtotime($data->{'SELESAI SCAN'}));
            $row['JAM TERIMA SJ'] = $data->{'JAM TERIMA SJ'} == null ? '' : date('H:i', strtotime($data->{'JAM TERIMA SJ'}));
            $row['PINTU LOADING'] =  $data->{'PINTU LOADING'};
            $row['DURASI DORONG'] =  $data->{'DURASI DORONG'};
            $row['LEAD TIME DURASI DORONG'] = $data->{'LEAD TIME DURASI DORONG'};
            $row['DURASI CHECK'] = $data->{'DURASI CHECK'};
            $row['LEAD TIME DURASI CHECK'] = $data->{'LEAD TIME DURASI CHECK'};
            $row['DURASI SCAN'] = $data->{'DURASI SCAN'};
            $row['LEAD TIME DURASI SCAN'] = $data->{'LEAD TIME DURASI SCAN'};
            $row['REMARKS'] = $data->{'REMARKS'};
            array_push($dataExcel, $row);
        }

        $data_picker = $this->getPickerOutbound($_POST);

        // var_dump($data_picker);
        // exit;

        $data = array(
            'success' => true,
            'data' => $dataExcel,
            'data_picker' => $data_picker
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
            'ekspedisi' => $this->ekspedisi_m->getEkspedisiForOutbound(),
            'dest' => $this->destination_m->getdestination(),
            'dealer' => $this->dealer_m->getDealer(),
        );
        $this->render('outbound/picking_list/index', $data);
    }

    public function getTablePickingList()
    {
        $data = array(
            'picking_list' => $this->outbound_m->getAllPickingList(),
        );
        $response = array(
            'success' => true,
            'table' => $this->load->view('outbound/picking_list/table_pl', $data, true)
        );
        echo json_encode($response);
    }

    public function createPickingList()
    {
        $post = $this->input->post();
        // var_dump($post);
        // exit;
        $params = array(
            'transaction_number' => $this->outbound_m->generateTransactionNumber(),
            'pl_no' => $post['pl_no'],
            'sj_no' => $post['sj_no'],
            'sj_time' => $post['sj_time'] == '' ? null : $post['sj_time'],
            'dest' => $post['dest'],
            'tot_qty' => $post['tot_qty'],
            'remarks' => $post['remarks'],
            'pintu_loading' => $post['pintu_loading'],
            'dealer_code' => $post['dealer_code'],
            'dealer_det' => $post['dealer_det'],
            'expedisi' => $post['expedisi'],
            'dock' => $post['dock'],
            'no_truck' => $post['no_truck'],
            'pl_print_time' => $post['pl_print_time'] == '' ? null : $post['pl_print_time'],
            'adm_pl_date' => $post['rec_pl_date'],
            'adm_pl_time' => $post['rec_pl_time'] == '' ? null : $post['rec_pl_time'],
            'activity_date' => $post['activity_date'],
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

    public function editPickingList()
    {
        $post = $this->input->post();

        // var_dump($post);
        // die;

        $params = array(
            'pl_no' => $post['pl_no'],
            'sj_no' => $post['sj_no'],
            'sj_time' => $post['sj_time'] == '' ? null : $post['sj_time'],
            'dest' => $post['dest'],
            'tot_qty' => $post['tot_qty'],
            'dealer_code' => $post['dealer_code'],
            'dealer_det' => $post['dealer_det'],
            'expedisi' => $post['expedisi'],
            'dock' => $post['dock'],
            'pintu_loading' => $post['pintu_loading'],
            'no_truck' => $post['no_truck'],
            'activity_date' => $post['activity_date'],
            'remarks' => $post['remarks'],
            'pl_print_time' => $post['pl_print_time'] == '' ? null : $post['pl_print_time'],
            'adm_pl_date' => $post['rec_pl_date'],
            'adm_pl_time' => $post['rec_pl_time'] == '' ? null : $post['rec_pl_time'],
            'updated_at' => currentDateTime(),
            'updated_by' => userId()
        );

        $this->db->where(['id' => $post['pl_id']]);
        $this->db->update('pl_h', $params);

        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true,
                'message' => 'Edit picking list successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Edit create picking list'
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
            'picking_list' => $this->outbound_m->getAllPickingListByAdm($_POST['id'])->row_array()
        );
        echo json_encode($response);
    }

    public function cekStatusPickingList()
    {
        $post = $this->input->post();
        $id = $post['id'];
        $rows = $this->outbound_m->getAllPickingListByAdm($id)->row();
        $response = array(
            'success' => true,
            'data' => $rows
        );
        echo json_encode($response);
    }

    public function generateTransactionNumber()
    {
        echo $this->outbound_m->generateTransactionNumber();
    }

    public function deletePickingList()
    {
        $post = $this->input->post();
        $this->db->where(['id' => $post['id']]);
        $this->db->delete('pl_h');
        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true,
                'message' => 'Deleting data successfully'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Error : ' . $this->db->error()
            );
        }
        echo json_encode($response);
    }
}
