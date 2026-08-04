<?php
class Dashboardall_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        // $this->load->database();
    }

    public function getOutbound()
    {

        $post = $this->input->post();
        $start_date = $post['start_date'];
        $end_date = $post['end_date'];

        $sql = "WITH
            OutboundUnProses AS (
                SELECT COUNT(*) AS count_unproses,
                    COALESCE(SUM(CONVERT(INT, tot_qty)), 0) AS qty_unproses
                FROM pl_h a
                WHERE
                a.pl_no NOT IN (SELECT b.pl_no FROM tb_out_temp a 
                LEFT JOIN pl_h b ON a.no_pl = b.id WHERE b.activity_date BETWEEN '$start_date' AND '$end_date')
                AND a.pl_no NOT IN (SELECT b.pl_no FROM tb_out a 
                LEFT JOIN pl_h b ON a.no_pl = b.pl_no WHERE b.activity_date BETWEEN '$start_date' AND '$end_date')
                AND a.activity_date BETWEEN '$start_date' AND '$end_date'
            ),
            OutboundProses AS (
                SELECT COUNT(*) AS count_proses,
                    COALESCE(SUM(CONVERT(INT, tot_qty)), 0) AS qty_proses
                FROM tb_out_temp a 
                LEFT JOIN pl_h b ON a.no_pl = b.id 
                WHERE b.activity_date BETWEEN '$start_date' AND '$end_date'
            ),
            OutboundComplete AS (
                SELECT COUNT(*) AS count_complete,
                    COALESCE(SUM(CONVERT(INT, tot_qty)), 0) AS qty_complete
                FROM tb_out a
                INNER JOIN pl_h b ON a.pl_id = b.id
                WHERE b.activity_date BETWEEN '$start_date' AND '$end_date'
            ),
            InfoSuratJalan AS (
                SELECT COUNT(sj_no) AS total_sj FROM pl_h
                WHERE activity_date BETWEEN '$start_date' AND '$end_date'
                AND sj_no <> ''
            )
            SELECT 
                ou.count_unproses AS outbound_unproses,
                ou.qty_unproses AS qty_unproses,
                op.count_proses AS outbound_proses,
                op.qty_proses AS qty_proses,
                oc.count_complete AS outbound_complete,
                oc.qty_complete AS qty_complete,
                isj.total_sj AS total_sj,
                (op.count_proses + oc.count_complete + ou.count_unproses) AS total_pl,
                (op.qty_proses + oc.qty_complete + ou.qty_unproses) AS total_qty
            FROM OutboundUnProses ou, OutboundProses op, OutboundComplete oc, InfoSuratJalan isj;";

        $query = $this->db->query($sql);
        return $query;
    }
}
