<?php

class Dashboard_m extends CI_Model
{
    public function getUserProses()
    {
        $sql = "SELECT a.id, a.fullname,'inbound' as [proses], 
        'checker' as posisi,
        b.no_sj as [pl/sj] 
        FROM 
        master_user a
        inner join  tb_trans_temp b ON a.id = b.checker_id
        union 
        select d.id, d.fullname, 'outbound' as [proses],
        b.sts as posisi,
        a.pl_no as [pl/sj]
        from pl_h a
        inner join pl_p b on a.id = b.pl_id
        inner join tb_out_temp c on a.id = c.no_pl
        inner join master_user d on b.user_id = d.id
        order by proses";
        $query = $this->db->query($sql);
        return $query;
    }

    function getUserIdle()
    {
        $sql = "select a.fullname, b.name as position_name from master_user a
        inner join master_position b on a.position = b.id 
        where a.id not in(select checker_id from tb_trans_temp)
        and a.id not in(select user_id from pl_p a
        inner join tb_out_temp b on a.pl_id =b.no_pl)
        and is_active = 'Y' and position is not null";
        $query = $this->db->query($sql);
        return $query;
    }

    function getResumeUserInbound()
    {

        $post = $this->input->post();
        $start_date = $post['start_date'];
        $end_date = $post['end_date'];

        $sql = "select a.*, b.fullname from 
        (select count(a.no_sj) as tot_sj, sum(a.qty) as tot_qty, a.checker_id, convert(date, a.activity_date) as activity_date
        from tb_trans a
        group by a.checker_id, CONVERT(date, a.activity_date))a
        inner join master_user b on a.checker_id =  b.id
        WHERE convert(date, a.activity_date) between CONVERT(date, '$start_date') and CONVERT(date, '$end_date')
        order by a.activity_date desc";
        $query = $this->db->query($sql);
        return $query;
    }

    function getResumeUserOutbound()
    {
        $post = $this->input->post();
        $start_date = $post['start_date'];
        $end_date = $post['end_date'];

        $sql = "select distinct c.user_id, d.fullname, count(a.pl_id) as tot_pl, sum(CONVERT(int, b.tot_qty)) as tot_qty, 
        convert(date, b.activity_date) as activity_date
        from tb_out a
        inner join pl_h b on a.pl_id = b.id
        inner join pl_p c on c.pl_id = b.id
        inner join master_user d on c.user_id = d.id
        WHERE convert(date, b.activity_date) between CONVERT(date, '$start_date') and CONVERT(date, '$end_date')
        group by d.fullname, c.user_id, CONVERT(date, b.activity_date)
        order by fullname";
        $query = $this->db->query($sql);
        return $query;
    }

    function getUserInboundActivity()
    {
        $sql = "select distinct a.id, a.user_id, b.fullname, a.date, a.start_time, a.end_time, c.name as position, 
        case when d.id is not null then 'active' else 'idle' end as [status]
        from work_schedule a
        inner join master_user b on a.user_id = b.id
        inner join master_position c on a.position_id = c.id
        left join tb_trans_temp d on a.user_id = d.checker_id
        WHERE a.is_deleted <> 'Y' AND a.is_active = 'Y'
        -- AND a.date = convert(date, getdate())
        AND getdate() > a.start_time
        AND getdate() < a.end_time 
        AND c.id = 1";
        $query = $this->db->query($sql);
        return $query;
    }


    function getUserOutbound()
    {
        $sql = "select distinct a.id, a.user_id, b.fullname, a.date, a.start_time, a.end_time, c.name as position
        from work_schedule a
        inner join master_user b on a.user_id = b.id
        inner join master_position c on a.position_id = c.id
        WHERE a.is_deleted <> 'Y' AND a.is_active = 'Y'
        -- AND a.date = convert(date, getdate()) 
        AND getdate() > a.start_time
        AND getdate() < a.end_time  
        AND c.id = 2";
        $query = $this->db->query($sql);
        return $query;
    }

    function getUserOutboundRangeDate()
    {
        // var_dump($_POST);
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        // die;
        $sql = "select distinct a.id, a.user_id, b.fullname, a.date, a.start_time, a.end_time, c.name as position
        from work_schedule a
        inner join master_user b on a.user_id = b.id
        inner join master_position c on a.position_id = c.id
        WHERE a.is_deleted <> 'Y' AND a.is_active = 'Y'
        AND convert(date, a.start_time) between '$start_date' and '$end_date'
        AND c.id = 2";
        $query = $this->db->query($sql);
        return $query;
    }

    function getUserInboundRangeDate()
    {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $sql = "select distinct a.id, a.user_id, b.fullname, a.date, a.start_time, a.end_time, c.name as position
        from work_schedule a
        inner join master_user b on a.user_id = b.id
        inner join master_position c on a.position_id = c.id
        WHERE a.is_deleted <> 'Y' AND a.is_active = 'Y'
        AND convert(date, a.start_time) between '$start_date' and '$end_date'
        AND c.id = 1";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getCompletedActivity()
    {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];

        $sql = "with tes as (";

        $sql .= "select * from
        (select c.outbound_id, c.activity_date as [ACTIVITY DATE], CONVERT(DATE, a.created_date) as TANGGAL, c.pl_no AS [NO PL], c.sj_no AS [NO SJ], c.dest as TUJUAN, c.no_truck as [NO TRUCK], 
        c.dealer_code as [KODE DEALER], d.name AS EXPEDISI, c.dock as [MD/DDS], c.tot_qty as QTY, c.pintu_loading as [PINTU LOADING],
        c.pl_print_time as [JAM CETAK PL],
        c.adm_pl_time as [JAM AMANO], 
        a.start_picking as [MULAI DORONG], 
        a.stop_picking as [SELESAI DORONG], a.start_checking as [MULAI CHECK], 
        a.stop_checking as [SELESAI CHECK], a.start_scanning as [MULAI SCAN], 
        a.stop_scanning as [SELESAI SCAN],
        c.sj_time as [JAM TERIMA SJ],
        c.remarks as [REMARKS] 
        from tb_out a 
        left join master_user b on a.checker_id = b.id 
        left join pl_h c on c.id = a.pl_id 
        left join master_ekspedisi d on c.expedisi = d.id  
        where a.is_deleted <> 'Y'
        union all
        select b.outbound_id, b.activity_date as [ACTIVITY DATE], CONVERT(DATE, a.created_date) as [TANGGAL], b.pl_no as [NO PL], b.sj_no as [NO SJ], b.dest as [TUJUAN], b.no_truck as [NO TRUCK],b.dealer_code as [KODE DEALER],
        c.name as [EXPEDISI], b.dock as [MD/DDS], b.tot_qty as [QTY],
        b.pintu_loading as [PINTU LOADING], b.pl_print_time as [JAM CETAK PL], b.adm_pl_time as [JAM AMANO], a.start_picking as [MULAI DORONG], a.stop_picking as [SELESAI DORONG],
        a.start_checking as [MULAI CHECK], a.stop_checking as [SELESAI CHECK], a.start_scanning as [MULAI SCAN], a.stop_scanning as [SELESAI SCAN], b.sj_time as [JAM TERIMA SJ], b.remarks as [REMARKS]
        from tb_out_temp a
        RIGHT JOIN pl_h b on a.no_pl = b.id
        LEFT JOIN master_ekspedisi c on b.expedisi = c.id 
        WHERE b.pl_no NOT IN (SELECT no_pl from tb_out WHERE activity_date between CONVERT(DATE, '$startDate') and CONVERT(DATE, '$endDate')))a";

        $sql .= " WHERE a.[ACTIVITY DATE] between CONVERT(DATE, '$startDate')and CONVERT(DATE, '$endDate')";
        // $sql .= " ORDER BY a.[ACTIVITY DATE] DESC";

        $sql .= ")
        select *, b.pintu_loading as loading_gate, b.parking_time, b.start_loading, b.finish_loading,
        b.picking_status, b.checking_status, b.scanning_status
        from tes a
        left join outbound_h b on a.outbound_id = b.id
        order by [ACTIVITY DATE] DESC";

        // print_r($sql);
        // die;
        $query = $this->db->query($sql);
        return $query;
    }
}
