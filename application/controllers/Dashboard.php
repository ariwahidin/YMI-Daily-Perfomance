<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(['inbound_m', 'outbound_m', 'user_m', 'ekspedisi_m', 'factory_m', 'dashboard_m']);
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
        $data = array();
        $this->render('dashboard/index', $data);
    }

    public function getUserProses()
    {
        $data = array(
            'inbound' => $this->dashboard_m->getResumeUserInbound(),
            'user_inbound' => $this->dashboard_m->getUserInboundActivity(),
            'user_outbound' => $this->dashboard_m->getUserOutbound()
        );

        $response = array(
            'success' => true,
            'table_user_proses' => $this->load->view('dashboard/table_user_proses', $data, true)
        );
        echo json_encode($response);
    }

    public function getAllProccessInbound()
    {
        $inbound = $this->inbound_m->getAllInboundProccess();
        $data = array(
            'inbound' => $inbound
        );
        $this->load->view('dashboard/table_inbound', $data);
    }

    public function getAllProccessOutbound()
    {
        $outbound = $this->outbound_m->getAllOutboundProccess();
        $data = array(
            'outbound' => $outbound
        );
        $this->load->view('dashboard/table_outbound', $data);
    }

    public function getPresentaseInbound()
    {
        $inbound = $this->inbound_m->getPresentaseInbound()->row();
        $response = array(
            'data' => $inbound
        );
        echo json_encode($response);
    }

    public function getPresentaseOutbound()
    {
        $outbound = $this->outbound_m->getPresentaseOutbound()->row();
        $response = array(
            'data' => $outbound
        );
        echo json_encode($response);
    }

    public function getMonthlyInbound()
    {
        $monthYear = $this->input->post('month');
        $dateParts = explode('-', $monthYear);
        $year = $dateParts[0];
        $month = $dateParts[1];

        // Query untuk mendapatkan total qty berdasarkan bulan dan tahun yang dipilih
        $sql = "SELECT 
            SUM(qty) AS total_qty,
            FORMAT(activity_date, 'd-MMM') AS formatted_date
        FROM tb_trans
        WHERE 
        YEAR(activity_date) = ? AND
        MONTH(activity_date) = ?
        GROUP BY activity_date
        ORDER BY activity_date ASC";
        $query = $this->db->query($sql, array($year, $month));

        // var_dump($query->result());

        $response = array(
            'success' => true,
            'inbound' => $query->result()
        );

        echo json_encode($response);
    }
}
