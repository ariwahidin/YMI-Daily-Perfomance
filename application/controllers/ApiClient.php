<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApiClient extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load security helper to sanitize inputs
        $this->load->helper('security');
    }

    // Function to call the API securely using cURL
    public function call_api()
    {
        // API endpoint URL
        $api_url = 'http://localhost:82/ymi/api/get_data';

        // Parameters for the API request
        $params = array(
            'table' => xss_clean($this->input->get('table')),  // Clean input
            'field' => xss_clean($this->input->get('field')),  // Clean input
            'value' => xss_clean($this->input->get('value'))   // Clean input
        );

        // Initialize cURL session
        $ch = curl_init();

        // Configure cURL options
        curl_setopt($ch, CURLOPT_URL, $api_url . '?' . http_build_query($params));  // Append query parameters
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  // Return response instead of outputting
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);  // Timeout after 10 seconds
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  // Ignore SSL certificate for localhost (set TRUE for production)

        // Execute the cURL request and store the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            // If error occurs, return the error message
            echo 'Error:' . curl_error($ch);
        } else {
            // If no error, print the API response
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($http_code === 200) {
                // Success, return response
                echo 'API Response: ' . $response;
            } else {
                // If not 200, print error message
                echo 'API Error: ' . $http_code;
            }
        }

        // Close the cURL session
        curl_close($ch);
    }

    public function getOutbound()
    {
        $url = 'http://localhost:82/ymi/api/get_data?table=pl_h&field=id&value=1';
        $this->call_api($url);
    }
}
