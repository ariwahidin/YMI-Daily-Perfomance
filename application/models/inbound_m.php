<?php
class Inbound_m extends CI_Model
{
    public function currentDateTime()
    {
        $timezone = new DateTimeZone('Asia/Jakarta');
        $dateTime = new DateTime('now', $timezone);
        $formattedDateTime = $dateTime->format('Y-m-d H:i:s');
        return $formattedDateTime;
    }

    public function createTempActivity($post)
    {
        $user_id = $this->session->userdata('user_data')['user_id'];
        $params = array(
            'no_sj' => $post['sj'],
            'no_truck' => $post['noTruck'],
            'qty' => $post['qty'],
            'checker' => $post['checker'],
            'checker_id' => $post['checker_id'],
            'tanggal' => $post['date'],
            'created_date' => $this->currentDateTime(),
            'created_by' => $user_id,
            'session_id' => $_SESSION['__ci_last_regenerate']
        );
        $this->db->insert('tb_trans_temp', $params);
    }

    public function createNewTask($params)
    {
        return $this->db->insert('tb_trans_temp', $params);
    }

    public function getTempActivity($id = null)
    {
        $sql = "SELECT a.*, b.name as ekspedisi_name, c.name as factory_name FROM tb_trans_temp a 
        LEFT JOIN master_ekspedisi b on a.ekspedisi = b.id
        LEFT JOIN master_factory c on a.factory_code = c.id";
        if ($id != null) {
            $sql .= " WHERE a.id='$id'";
        }

        $sql .= " ORDER BY a.id DESC";
        $query = $this->db->query($sql);
        return $query;
    }

    public function deleteRowTrans($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_trans_temp');
    }

    public function getActCompleteById()
    {
        $sql = "select id, no_sj, checker_id, no_truck, qty, checker, ref_date,
        time_format(time(unload_st_time), '%H:%i') as start_unload,
        time_format(time(unload_fin_time), '%H:%i') as stop_unload,
        time_format(TIMEDIFF(time_format(time(unload_fin_time), '%H:%i'),time_format(time(unload_st_time), '%H:%i')), '%H:%i') AS unload_duration,
        time_format(time(checking_st_time), '%H:%i') as start_checking,
        time_format(time(checking_fin_time), '%H:%i') as stop_checking,
        time_format(TIMEDIFF(time_format(time(checking_fin_time), '%H:%i'),time_format(time(checking_st_time), '%H:%i')), '%H:%i') AS checking_duration,
        time_format(time(putaway_st_time), '%H:%i') as start_putaway,
        time_format(time(putaway_fin_time), '%H:%i') as stop_putaway,
        time_format(TIMEDIFF(time_format(time(putaway_fin_time), '%H:%i'),time_format(time(putaway_st_time), '%H:%i')), '%H:%i') AS putaway_duration
        from tb_trans 
        where ";

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $sql .= " id = '$id'";
        }

        $query = $this->db->query($sql);
        return $query;
    }

    public function getCompletedActivity()
    {

        $sql = "SELECT * FROM (SELECT a.id, a.activity_date, a.created_date as sj_created_at, a.sj_send_date, a.unload_seq, a.no_sj, a.sj_date, a.sj_time, a.no_truck, a.driver, a.alloc_code, a.pintu_unloading, a.qty, a.time_arival, null as unload_duration,
        null as checking_duration, null as putaway_duration, b.fullname as checker_name, a.start_unloading as start_unload, a.stop_unloading as stop_unload, a.start_checking, a.stop_checking, a.start_putaway, a.stop_putaway,
        c.name as factory_name, d.name as ekspedisi_name, null as [status]
        FROM tb_trans_temp a
        left join master_user b on a.checker_id =b.id
        left join master_factory c on a.factory_code = c.id
        left join master_ekspedisi d on a.ekspedisi = d.id
        union
        select  
                a.id,
                a.activity_date,
                a.sj_created_at,
                a.sj_send_date,
                a.unload_seq,
                a.no_sj,
                a.sj_date,
                a.sj_time,
                a.no_truck,
                a.driver,
                a.alloc_code,
                a.pintu_unloading,
                a.qty,
                a.time_arival,
                a.unload_duration,
                a.checking_duration,
                a.putaway_duration,
                b.fullname as checker_name,
                a.unload_st_time as start_unload,
                a.unload_fin_time as stop_unload,
                a.checking_st_time as start_checking,
                a.checking_fin_time as stop_checking,
                a.putaway_st_time as start_putaway,
                a.putaway_fin_time as stop_putaway,
                c.name as factory_name, 
                d.name as ekspedisi_name,
                'complete' as [status]
                from tb_trans a 
                inner join master_user b on a.checker_id = b.id
                left join master_factory c on a.factory_code = c.id
                left join master_ekspedisi d on a.ekspedisi = d.id
                where a.is_deleted <> 'Y')a";

        if (isset($_POST['startDate']) != '' && isset($_POST['endDate']) != '') {
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
            $sql .= " WHERE CONVERT(DATE, activity_date) between CONVERT(DATE, '$startDate')and CONVERT(DATE, '$endDate')";
        } else {
            $sql .= " AND CONVERT(DATE, activity_date) = CONVERT(DATE, GETDATE())";
        }

        if (isset($_POST['checker'])) {
            if ($_POST['checker'] != '') {
                $checker = $_POST['checker'];
                $sql .= " WHERE checker like '%$checker%'";
            }
        }


        $sql .= " order by sj_created_at desc, unload_seq desc";

        // print_r($sql);

        $query = $this->db->query($sql);
        return $query;
    }

    public function updateActivityComplete($post)
    {
        $data = array(
            'no_sj' => $post['no_sj'],
            'no_truck' => $post['no_truck'],
            'qty' => $post['qty'],
            'checker' => $post['checker_name'],
            'checker_id' => $post['checker_id'],
            'ref_date' => $post['ref_date'],
            'updated_by' => $this->session->userdata('user_data')['user_id'],
            'updated_at' => $this->currentDateTime()
        );

        $where = array(
            'id' => $post['id']
        );

        $this->db->update('tb_trans', $data, $where);
    }

    public function deleteActivityComplete($post)
    {
        $data = array(
            'is_deleted' => 'Y',
            'deleted_by' => userId(),
            'deleted_at' => currentDateTime()
        );

        $where = array(
            'id' => $post['id']
        );

        $this->db->update('tb_trans', $data, $where);
    }

    public function getChecker()
    {
        $sql = "select * from master_employee";
        $query = $this->db->query($sql);
        return $query;
    }

    public function editActivity($post)
    {
        $data = array(
            $post['activity'] => $post['time']
        );

        $where = array(
            'id' => $post['id']
        );

        $this->db->update('tb_trans_temp', $data, $where);
    }

    public function hitungDurasi($tanggal_awal, $tanggal_akhir)
    {
        $durasi_detik = strtotime($tanggal_akhir) - strtotime($tanggal_awal);

        // Konversi durasi detik menjadi jam:menit:detik
        $durasi_format = gmdate("H:i:s", $durasi_detik);

        return $durasi_format;
    }

    public function checkFinishActivity($id)
    {
        $sql = "select * from tb_trans_temp
        where id = '$id'
        and stop_unloading is not null
        and stop_checking is not null
        and stop_putaway is not null";
        $query = $this->db->query($sql);
        return $query;
    }

    public function finishActivity($id)
    {
        $this->db->trans_begin();

        try {
            $data1 = $this->getTempActivity($id)->row_array();

            $params_insert = array(
                'unload_seq' => $data1['unload_seq'],
                'no_sj' => $data1['no_sj'],
                'no_truck' => $data1['no_truck'],
                'qty' => $data1['qty'],
                'checker_id' => $data1['checker_id'],
                'sj_send_date' => $data1['sj_send_date'],
                'sj_date' => $data1['sj_date'],
                'sj_time' => $data1['sj_time'],
                'ekspedisi' => $data1['ekspedisi'],
                'time_arival' => $data1['time_arival'],
                'driver' => $data1['driver'],
                'factory_code' => $data1['factory_code'],
                'alloc_code' => $data1['alloc_code'],
                'pintu_unloading' => $data1['pintu_unloading'],
                'remarks' => $data1['remarks'],
                'sj_created_at' => $data1['created_date'],
                'sj_created_by' => $data1['created_by'],
                'unload_st_time' => $data1['start_unloading'],
                'unload_fin_time' => $data1['stop_unloading'],
                'unload_duration' => countDuration($data1['start_unloading'], $data1['stop_unloading']),
                'checking_st_time' => $data1['start_checking'],
                'checking_fin_time' => $data1['stop_checking'],
                'checking_duration' => countDuration($data1['start_checking'], $data1['stop_checking']),
                'putaway_st_time' => $data1['start_putaway'],
                'putaway_fin_time' => $data1['stop_putaway'],
                'putaway_duration' => countDuration($data1['start_putaway'], $data1['stop_putaway']),
                'activity_date' => $data1['activity_date'],
                'created_date' => $this->currentDateTime(),
                'created_by' => $data1['created_by']
            );

            $this->db->insert('tb_trans', $params_insert);

            $this->db->delete('tb_trans_temp', array('id' => $id));

            $this->db->trans_commit();

            return true;
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Error in transaction: ' . $e->getMessage());
            return false;
        }
    }

    public function editUserActivity($post)
    {
        $data = array(
            'no_sj' => $post['sj'],
            'no_truck' => $post['no_truck'],
            'qty' => $post['qty'],
            'checker_id' => $post['checker_id'],
            'checker' => $post['checker'],
            'tanggal' => $post['ref_date']
        );

        $this->db->where('id', $post['id']);
        $this->db->update('tb_trans_temp', $data);
    }

    public function editTask($id, $params)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_trans_temp', $params);
    }

    public function editTaskCompleted($id, $params)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_trans', $params);
    }

    public function getTaskByUser($post = null)
    {
        if (isset($post['search'])) {
            if ($post['search'] != '') {
                $search = $post['search'];
                $this->db->like('no_sj', $search, 'both');
            }
        }

        if (isset($post['id'])) {
            if ($post['id'] != '') {
                $id = $post['id'];
                $this->db->where('a.id', $id);
            }
        }

        $this->db->select('a.*, b.fullname as checker_name, c.name as ekspedisi_name, d.name as factory_name, e.fullname as created_by_name');
        $this->db->from('tb_trans_temp a');
        $this->db->join('master_user b', 'a.checker_id = b.id');
        $this->db->join('master_ekspedisi c', 'a.ekspedisi = c.id', 'left');
        $this->db->join('master_factory d', 'a.factory_code = d.id', 'left');
        $this->db->join('master_user e', 'a.created_by = e.id', 'left');

        if ($_SESSION['user_data']['role'] == 4) {
            $this->db->where('checker_id', userId());
        }
        // print_r($this->db->last_query());
        return $this->db->get();
    }


    public function getTaskCompleteById($post = null)
    {
        if (isset($post['search'])) {
            if ($post['search'] != '') {
                $search = $post['search'];
                $this->db->like('no_sj', $search, 'both');
            }
        }

        if (isset($post['id'])) {
            if ($post['id'] != '') {
                $id = $post['id'];
                $this->db->where('a.id', $id);
            }
        }

        $this->db->select('a.*, b.fullname as checker_name');
        $this->db->from('tb_trans a');
        $this->db->join('master_user b', 'a.checker_id = b.id');
        return $this->db->get();
    }

    public function getTransTemp($id)
    {
        return $this->db->get_where('tb_trans_temp', ['id' => $id]);
    }

    public function startUnload($id, $params)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_trans_temp', $params);
    }
    public function stopUnload($id, $params)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_trans_temp', $params);
    }

    public function startChecking($id, $params)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_trans_temp', $params);
    }

    public function stopChecking($id, $params)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_trans_temp', $params);
    }

    public function startPutaway($id, $params)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_trans_temp', $params);
    }

    public function stopPutaway($id, $params)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_trans_temp', $params);
    }

    public function getAllInboundProccess()
    {
        $post = $this->input->post();
        $start_date = $post['start_date'];
        $end_date = $post['end_date'];

        $sql = "select * from (
            select a.no_sj, b.fullname as checker_name,
            start_unloading as start_unload, stop_unloading as stop_unload,
            start_checking, stop_checking, start_putaway, stop_putaway, created_date as created_at, activity_date
            from tb_trans_temp a 
            inner join  master_user b on a.checker_id = b.id
            union all
            SELECT no_sj, b.fullname as checker_name, a.unload_st_time as start_unload,
            a.unload_fin_time as stop_unload, a.checking_st_time as start_checking, a.checking_fin_time as stop_checking,
            a.putaway_st_time as start_putaway, a.putaway_fin_time as stop_putaway, a.sj_created_at as created_at, activity_date
            FROM tb_trans a
            INNER JOIN master_user b ON a.checker_id = b.id)ss
            WHERE CONVERT(DATE, ss.activity_date) between CONVERT(date, '$start_date') and CONVERT(date, '$end_date')
            ORDER BY ss.activity_date DESC";

            // print_r($sql);
        $query = $this->db->query($sql);
        return $query;
    }

    public function getPresentaseInbound()
    {
        // $sql = "SELECT 
        // (SELECT COUNT(*) FROM tb_trans_temp WHERE convert(date, created_date) = convert(date, getdate())) AS inbound_proses,
        // (SELECT COUNT(*) FROM tb_trans WHERE convert(date, created_date) = convert(date, getdate())) AS inbound_complete,
        // (SELECT COUNT(*) FROM tb_trans_temp WHERE convert(date, created_date) = convert(date, getdate())) + (SELECT COUNT(*) FROM tb_trans WHERE convert(date, created_date) = convert(date, getdate())) AS total_inbound,
        // CASE WHEN (SELECT COUNT(*) FROM tb_trans WHERE convert(date, created_date) = convert(date, getdate())) <> 0 
        //      THEN ((SELECT COUNT(*) FROM tb_trans WHERE convert(date, created_date) = convert(date, getdate())) / CAST(((SELECT COUNT(*) FROM tb_trans_temp WHERE convert(date, created_date) = convert(date, getdate())) + (SELECT COUNT(*) FROM tb_trans WHERE convert(date, created_date) = convert(date, getdate())))   AS float)) * 100 
        //      ELSE 0 
        // END AS presentase";


        $post = $this->input->post();
        $start_date = $post['start_date'];
        $end_date = $post['end_date'];

        $sql = "WITH 
        InboundProses AS (
            SELECT COUNT(*) AS count_proses
            FROM tb_trans_temp
            WHERE CONVERT(date, activity_date) between CONVERT(date, '$start_date') and CONVERT(date, '$end_date')
        ),
        InboundComplete AS (
            SELECT COUNT(*) AS count_complete
            FROM tb_trans
            WHERE CONVERT(date, activity_date) between CONVERT(date, '$start_date') and CONVERT(date, '$end_date')
        ),
        TotalInbound AS (
            SELECT 
                (SELECT count_proses FROM InboundProses) + 
                (SELECT count_complete FROM InboundComplete) AS total_count
        )
        SELECT 
            (SELECT count_proses FROM InboundProses) AS inbound_proses,
            (SELECT count_complete FROM InboundComplete) AS inbound_complete,
            (SELECT total_count FROM TotalInbound) AS total_inbound,
            CASE 
                WHEN (SELECT total_count FROM TotalInbound) <> 0 THEN
                    (CAST((SELECT count_complete FROM InboundComplete) AS FLOAT) / 
                     (SELECT total_count FROM TotalInbound)) * 100
                ELSE 0 
            END AS presentase";
        $query = $this->db->query($sql);
        return $query;
    }
}
