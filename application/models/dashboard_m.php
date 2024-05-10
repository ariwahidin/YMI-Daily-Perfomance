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
        $sql = "select TOP 10 a.*, b.fullname from 
        (select count(a.no_sj) as tot_sj, sum(a.qty) as tot_qty, a.checker_id, CONVERT(date, a.created_date) as created_date
        from tb_trans a
        group by a.checker_id, CONVERT(date, a.created_date))a
        inner join master_user b on a.checker_id =  b.id
        WHERE convert(date, a.created_date) = convert(date, getdate())
        order by a.created_date desc";
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
        WHERE a.is_deleted <> 'Y' and a.date = convert(date, getdate()) AND c.id = 1";
        $query = $this->db->query($sql);
        return $query;
    }

    function getUserOutbound()
    {
        $sql = "select distinct a.id, a.user_id, b.fullname, a.date, a.start_time, a.end_time, c.name as position
        from work_schedule a
        inner join master_user b on a.user_id = b.id
        inner join master_position c on a.position_id = c.id
        WHERE a.is_deleted <> 'Y' and a.date = convert(date, getdate()) AND c.id = 2";
        $query = $this->db->query($sql);
        return $query;
    }
}