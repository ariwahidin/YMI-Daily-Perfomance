<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model');
        $this->load->helper('security'); // Security helper untuk input sanitization
    }

    // Endpoint to get data
    public function get_data()
    {
        // Set response header for JSON output
        header('Content-Type: application/json');

        // Only allow GET requests
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->output->set_status_header(405); // Method Not Allowed
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        // Get parameters (e.g., table and conditions)
        $table = $this->input->get('table', TRUE); // Sanitize input
        $field = $this->input->get('field', TRUE);
        $value = $this->input->get('value', TRUE);

        if (empty($table)) {
            // Return error if table is not provided
            $this->output->set_status_header(400); // Bad Request
            echo json_encode(['error' => 'Table name is required']);
            return;
        }

        // Define conditions if field and value are provided
        $conditions = [];
        if (!empty($field) && !empty($value)) {
            $conditions[$field] = xss_clean($value);  // Clean input to prevent XSS
        }

        try {
            // Get data from model
            $data = $this->Api_model->get_data($table, $conditions);

            // Send success response with data
            echo json_encode(['status' => 'success', 'data' => $data]);
        } catch (Exception $e) {
            // Catch any errors and return a 500 Internal Server Error response
            $this->output->set_status_header(500);
            echo json_encode(['error' => 'Failed to retrieve data']);
        }
    }
}
