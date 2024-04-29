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
            'user_proses' => $this->dashboard_m->getUserProses(),
            'user_idle' => $this->dashboard_m->getUserIdle(),
            'inbound' => $this->dashboard_m->getResumeUserInbound()
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
}
