<?php defined('BASEPATH') or exit('No direct script access allowed');

class Executive_m extends CI_Model
{
    public function GetTotalStockDC()
    {
        $sql = "SELECT 
                SUM(ibs.TOTAL_INBOUND) AS TOTAL_INBOUND,
                SUM(obs.TOTAL_OUTBOUND) AS TOTAL_OUTBOUND,
                SUM(ibs.TOTAL_INBOUND) - SUM(obs.TOTAL_OUTBOUND) AS STOCK_TODAY FROM
                (SELECT WH_CODE, SUM(qty) AS TOTAL_INBOUND FROM
                (SELECT 'DC_1' AS WH_CODE, qty FROM [YAMVAS_DC_1].[dbo].[tb_trans]
                UNION ALL
                SELECT 'DC_2' AS WH_CODE, qty FROM [YAMVAS_DC_2].[dbo].[tb_trans]) ib
                GROUP BY ib.WH_CODE) ibs
                INNER JOIN
                (SELECT WH_CODE, SUM(tot_qty) AS TOTAL_OUTBOUND FROM
                (SELECT 'DC_1' AS WH_CODE, CONVERT(int, tot_qty) as tot_qty FROM [YAMVAS_DC_1].[dbo].[pl_h]
                UNION ALL
                SELECT 'DC_2' AS WH_CODE, CONVERT(int, tot_qty) as tot_qty FROM [YAMVAS_DC_2].[dbo].[pl_h]) ob
                GROUP BY ob.WH_CODE) obs
                ON ibs.WH_CODE = obs.WH_CODE";
        $query = $this->db->query($sql);
        return $query;
    }

    public function GetMonthlyStockDC(){
        $sql = "SELECT * FROM 
                (SELECT 
                    'DC_1' AS whs_code,
                    SUM(qty) AS total_qty_in_dc_1,
                    FORMAT(activity_date, 'd-MMM') AS formatted_date,
                    CONVERT(date, activity_date) AS activity_date
                FROM [YAMVAS_DC_1].[dbo].[tb_trans]
                WHERE 
                YEAR(activity_date) = '2025' AND
                MONTH(activity_date) = '01'
                GROUP BY activity_date
                -- ORDER BY activity_date ASC
                ) a
                LEFT JOIN
                (SELECT 
                    'DC_2' AS whs_code,
                    SUM(qty) AS total_qty_in_dc_2,
                    FORMAT(activity_date, 'd-MMM') AS formatted_date,
                    CONVERT(date, activity_date) AS activity_date
                FROM [YAMVAS_DC_2].[dbo].[tb_trans]
                WHERE 
                YEAR(activity_date) = '2025' AND
                MONTH(activity_date) = '01'
                GROUP BY activity_date
                -- ORDER BY activity_date ASC
                ) b
                ON a.formatted_date = b.formatted_date
                ";
        $query = $this->db->query($sql);
    }


    public function GetTotalStockDCDetail(){
        $sql = "SELECT ibs.TOTAL_INBOUND,
                obs.TOTAL_OUTBOUND,
                ibs.TOTAL_INBOUND - obs.TOTAL_OUTBOUND AS STOCK_TODAY FROM
                (SELECT WH_CODE, SUM(qty) AS TOTAL_INBOUND FROM
                (SELECT 'DC_1' AS WH_CODE, qty FROM [YAMVAS_DC_1].[dbo].[tb_trans]
                UNION ALL
                SELECT 'DC_2' AS WH_CODE, qty FROM [YAMVAS_DC_2].[dbo].[tb_trans]) ib
                GROUP BY ib.WH_CODE) ibs
                INNER JOIN
                (SELECT WH_CODE, SUM(tot_qty) AS TOTAL_OUTBOUND FROM
                (SELECT 'DC_1' AS WH_CODE, CONVERT(int, tot_qty) as tot_qty FROM [YAMVAS_DC_1].[dbo].[pl_h]
                UNION ALL
                SELECT 'DC_2' AS WH_CODE, CONVERT(int, tot_qty) as tot_qty FROM [YAMVAS_DC_2].[dbo].[pl_h]) ob
                GROUP BY ob.WH_CODE) obs
                ON ibs.WH_CODE = obs.WH_CODE";
        $query = $this->db->query($sql);
        return $query->result();
    }
}