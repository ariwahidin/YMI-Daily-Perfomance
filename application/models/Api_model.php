<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_model extends CI_Model
{

    // Constructor to load the SQL Server database
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default'); // Pastikan 'default' mengarah ke SQL Server di database.php
    }

    // Function to get data using raw query
    public function get_data($table, $conditions = []) {
        // Raw query with parameter binding to prevent SQL injection
        $sql = "SELECT * FROM $table WHERE 1=1";  // Basic query

        // Dynamically add conditions if provided
        $params = [];
        foreach ($conditions as $field => $value) {
            $sql .= " AND $field = ?";
            $params[] = $value;
        }

        // Execute the query securely using bindings
        $query = $this->db->query($sql, $params);

        return $query->result();
    }
}
