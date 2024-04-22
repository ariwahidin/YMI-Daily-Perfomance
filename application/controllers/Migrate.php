<?php defined('BASEPATH') or exit('No direct script access allowed');
class Migrate extends CI_Controller
{
    // public function index()
    // {
    //     $this->createTable("IF NOT EXISTS (SELECT * FROM sys.tables WHERE name = 'test_table2')
    //     BEGIN
    //         CREATE TABLE test_table2 (
    //             Id INT IDENTITY NOT NULL,
    //             LineNumber SMALLINT NOT NULL,
    //             ProductID INT NULL,
    //             UnitPrice MONEY NULL,
    //             OrderQty SMALLINT NULL,
    //             ReceivedQty FLOAT NULL,
    //             RejectedQty FLOAT NULL,
    //             DueDate DATETIME NULL
    //         );
    //     END;");
    // }

    public function test(){
        echo "ess";
    }

    private function createTable($sql)
    {
        $query = $this->db->query($sql);

        // Periksa apakah tabel telah berhasil dibuat
        $tableExists = $this->checkIfTableExists('test_table2');

        if ($tableExists) {
            echo "Tabel berhasil dibuat";
        } else {
            echo "Tabel gagal dibuat";
        }
    }

    private function checkIfTableExists($tableName)
    {
        // Query untuk memeriksa apakah tabel ada dalam database
        $checkTableSql = "SELECT COUNT(*) as tableExists FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '$tableName'";
        $result = $this->db->query($checkTableSql);

        if ($result->num_rows() > 0) {
            $row = $result->row();
            return $row->tableExists > 0;
        }

        return false;
    }
}
