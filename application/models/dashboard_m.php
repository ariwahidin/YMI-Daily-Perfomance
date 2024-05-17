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

    function getUserInboundActivity()
    {
        $sql = "select distinct a.id, a.user_id, b.fullname, a.date, a.start_time, a.end_time, c.name as position, 
        case when d.id is not null then 'active' else 'idle' end as [status]
        from work_schedule a
        inner join master_user b on a.user_id = b.id
        inner join master_position c on a.position_id = c.id
        left join tb_trans_temp d on a.user_id = d.checker_id
        WHERE a.is_deleted <> 'Y' 
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
        WHERE a.is_deleted <> 'Y' 
        -- AND a.date = convert(date, getdate()) 
        AND getdate() > a.start_time
        AND getdate() < a.end_time  
        AND c.id = 2";
        $query = $this->db->query($sql);
        return $query;
    }
}
