<?php
class Work_schedule_m extends CI_Model
{
    public function getWorkSchedule()
    {

        // var_dump($_POST);
        // die;

        $sql = "select a.id, a.user_id, a.position_id, b.fullname, a.date, a.start_time, a.end_time, c.name as position_name  
        from work_schedule a
        inner join master_user b on a.user_id = b.id
        left join master_position c on a.position_id = c.id
        WHERE a.is_deleted <> 'Y'";

        if (isset($_POST['startDate']) != '' && isset($_POST['endDate']) != '') {
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
            $sql .= " AND a.date between CONVERT(DATE, '$startDate')and CONVERT(DATE, '$endDate')";
        } else {
            $sql .= " AND a.date = CONVERT(DATE, GETDATE())";
        }


        $sql .= " ORDER BY a.date DESC";
        $query = $this->db->query($sql);
        return $query;
    }

    public function createdestination($params)
    {
        $this->db->insert('work_schedule', $params);
    }

    public function editdestination($id, $params)
    {
        $where = ['id' => $id];
        $this->db->where($where);
        $this->db->update('work_schedule', $params);
    }

    public function deletedestination($id, $params)
    {
        $where = ['id' => $id];
        $this->db->where($where);
        $this->db->update('work_schedule', $params);
    }
}
