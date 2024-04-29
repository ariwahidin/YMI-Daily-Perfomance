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
        $sql = "select fullname from master_user 
        where id not in(select checker_id from tb_trans_temp)
        and id not in(select user_id from pl_p a
        inner join tb_out_temp b on a.pl_id =b.no_pl)
        and is_active = 'Y'";
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
        order by a.created_date desc";
        $query = $this->db->query($sql);
        return $query;
    }
}
