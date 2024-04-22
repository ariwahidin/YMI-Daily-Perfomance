<?php
class Outbound_m extends CI_Model
{
    function createTask($params)
    {
        return $this->db->insert('tb_out_temp', $params);
    }

    function editTask($id, $params)
    {
        $this->db->where(['id' => $id]);
        $this->db->update('tb_out_temp', $params);
    }

    public function getTaskByUser($post = null)
    {
        if (isset($post['search'])) {
            if ($post['search'] != '') {
                $search = $post['search'];
                $this->db->like('no_pl', $search, 'both');
            }
        }

        if (isset($post['id'])) {
            if ($post['id'] != '') {
                $id = $post['id'];
                $this->db->where('a.id', $id);
            }
        }

        $this->db->select('a.*, b.fullname as checker_name, c.name as ekspedisi_name, e.fullname as created_by_name');
        $this->db->from('tb_out_temp a');
        $this->db->join('master_user b', 'a.checker_id = b.id');
        $this->db->join('master_ekspedisi c', 'a.ekspedisi = c.id', 'left');
        $this->db->join('master_user e', 'a.created_by = e.id', 'left');

        if ($_SESSION['user_data']['role'] == 4) {
            $this->db->where('checker_id', userId());
        }

        return $this->db->get();
    }

    function prosesActivity($id, $params)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_out_temp', $params);
        if ($this->db->affected_rows() > 0) {
            $act = $this->db->get_where('tb_out_temp', ['id' => $id])->row();
            if ($act->stop_picking != null && $act->stop_checking != null && $act->stop_scanning != null) {
                $data = array(
                    'no_pl' => $act->no_pl,
                    'no_truck' => $act->no_truck,
                    'qty' => $act->qty,
                    'checker_id' => $act->checker_id,
                    'pl_date' => $act->pl_date,
                    'pl_time' => $act->pl_time,
                    'time_arival' => $act->time_arival,
                    'ekspedisi' => $act->ekspedisi,
                    'driver' => $act->driver,
                    'start_picking' => $act->start_picking,
                    'stop_picking' => $act->stop_picking,
                    'duration_picking' => countDuration($act->start_picking, $act->stop_picking),
                    'start_checking' => $act->start_checking,
                    'stop_checking' => $act->stop_checking,
                    'duration_checking' => countDuration($act->start_checking, $act->stop_checking),
                    'start_scanning' => $act->start_scanning,
                    'stop_scanning' => $act->stop_scanning,
                    'duration_scanning' => countDuration($act->start_scanning, $act->stop_scanning),
                    'remarks' => $act->remarks,
                    'activity_created_date' => $act->created_date,
                    'activity_created_by' => $act->created_by,
                    'created_date' => currentDateTime(),
                    'created_by' => userId(),
                    'is_deleted' => 'N'
                );
                $this->db->insert('tb_out', $data);
                if ($this->db->affected_rows() > 0) {
                    $this->db->where(['id' => $id]);
                    $this->db->delete('tb_out_temp');
                }
            }
        }
    }

    function deleteOutTemp($post)
    {
        $this->db->where(['id' => $post['id']]);
        $this->db->delete('tb_out_temp');
    }

    public function getCompletedActivity()
    {
        $sql = "select a.*, b.fullname as checker_name, d.name as ekspedisi_name
        from tb_out a 
        inner join master_user b on a.checker_id = b.id
        left join master_ekspedisi d on a.ekspedisi = d.id
        where a.is_deleted <> 'Y' ";

        if (isset($_POST['startDate']) != '' && isset($_POST['endDate']) != '') {
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
            $sql .= " AND CONVERT(DATE, created_date) between CONVERT(DATE, '$startDate')and CONVERT(DATE, '$endDate')";
        } else {
            $sql .= " AND CONVERT(DATE, created_date) = CONVERT(DATE, GETDATE())";
        }

        // if (isset($_POST['checker'])) {
        //     if ($_POST['checker'] != '') {
        //         $checker = $_POST['checker'];
        //         $sql .= " AND checker like '%$checker%'";
        //     }
        // }


        $sql .= " ORDER BY id DESC";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getPresentaseOutbound()
    {
        $sql = "SELECT 
        (SELECT COUNT(*) FROM tb_out_temp) AS outbound_proses,
        (SELECT COUNT(*) FROM tb_out) AS outbound_complete,
        (SELECT COUNT(*) FROM tb_out_temp) + (SELECT COUNT(*) FROM tb_out) AS total_outbound,
        CASE WHEN (SELECT COUNT(*) FROM tb_out) <> 0 
             THEN ((SELECT COUNT(*) FROM tb_out) / CAST(((SELECT COUNT(*) FROM tb_out_temp) + (SELECT COUNT(*) FROM tb_out))   AS float)) * 100 
             ELSE 0 
        END AS presentase;";
        $query = $this->db->query($sql);
        return $query;
    }


    public function getAllOutboundProccess()
    {
        $sql = "select * from (
            select a.no_pl, b.fullname as checker_name,
            start_picking, stop_picking,
            start_checking, stop_checking, start_scanning, stop_scanning, created_date as created_at
            from tb_out_temp a 
            inner join  master_user b on a.checker_id = b.id
            union all
            SELECT no_pl, b.fullname as checker_name, a.start_picking,
            a.stop_picking, a.start_checking, a.stop_checking,
            a.start_scanning, a.stop_scanning, a.activity_created_date as created_at
            FROM tb_out a
            INNER JOIN master_user b ON a.checker_id = b.id) ss
            WHERE CONVERT(DATE, created_at) = CONVERT(DATE, GETDATE())
            order by created_at desc";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getTaskCompleteById($post = null)
    {
        // if (isset($post['search'])) {
        //     if ($post['search'] != '') {
        //         $search = $post['search'];
        //         $this->db->like('no_sj', $search, 'both');
        //     }
        // }

        if (isset($post['id'])) {
            if ($post['id'] != '') {
                $id = $post['id'];
                $this->db->where('a.id', $id);
            }
        }

        $this->db->select('a.*, b.fullname as checker_name');
        $this->db->from('tb_out a');
        $this->db->join('master_user b', 'a.checker_id = b.id');
        return $this->db->get();
    }

    public function editTaskCompleted($id, $params)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_out', $params);
    }

    public function deleteActivityComplete($id, $params)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_out', $params);
    }

    public function createPickingList($params)
    {
        $this->db->insert('pl_h', $params);
    }

    public function getAllPickingList($id = null)
    {
        $sql = "SELECT * FROM pl_h";

        if ($id != null) {
            $sql .= " WHERE id = '$id'";
        }
        
        $query = $this->db->query($sql);
        return $query;
    }
}
