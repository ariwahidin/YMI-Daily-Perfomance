<?php defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(['master_m', 'customer_m', 'item_m', 'top_m', 'user_m', 'transaction_m']);
        is_not_logged_in();
    }

    public function render($view, ?array $data = null)
    {
        $this->load->view('template/header');
        $this->load->view($view, $data);
        $this->load->view('template/footer');
    }

    public function salesOrder()
    {
        $data = array();
        $this->render('transaction/sales_order', $data);
    }

    public function loadDataForSalesOrder()
    {

        $item = $this->transaction_m->getItemSubdist();
        $customer = $this->transaction_m->getCustomerSubdist();
        $data = array(
            'item' => $item->result(),
            'customer' => $customer->result()
        );

        $responseData = array(
            'success' => true,
            'data' => $data
        );

        echo json_encode($responseData);
    }

    public function validationSalesOrder()
    {
        $req = json_decode(file_get_contents('php://input'), true);
        // var_dump($req);
        $response = array(
            'success' => true
        );

        echo json_encode($response);
    }

    public function prosesSimpanOrder()
    {
        $order_data = json_decode(file_get_contents('php://input'), true);
        $result = $this->transaction_m->createOrder($order_data);
        if ($result['status'] === 'success') {
            $response = array('success' => true, 'message' => 'Data order berhasil disimpan.');
        } else {
            $response = array('status' => false, 'message' => 'Gagal simpan data order.');
        }
        echo json_encode($response);
    }

    public function salesorderdata()
    {
        $this->render('transaction/sales_order_data');
    }

    public function getDataSalesOrder()
    {
        $order = $this->transaction_m->getDataSalesOrder();
        $data = array(
            'success' => true,
            'data' => array(
                'order' => $order->result()
            )
        );
        echo json_encode($data);
    }

    public function getDetailOrder($orderId)
    {
        $order = $this->transaction_m->getSalesOrderDetail($orderId);
        if ($order->num_rows() > 0) {
            $response = array(
                'success' => true,
                'data' => array(
                    'detail' => $order->result()
                )
            );
        } else {
            $response = array(
                'success' => false
            );
        }
        echo json_encode($response);
    }
}
