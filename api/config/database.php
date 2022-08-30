<?php
class DatabaseService {
 private $db_host = "localhost";
 private $db_name = "admin_arvindam";
 private $db_user = "admin_arvindam";
 private $db_password = "Kchl84?9";
 protected $conn;
 public function __construct()
 {
    if (!isset($this->conn)) {
        $this->conn = new mysqli($this->db_host, $this->db_user, $this->db_password, $this->db_name);
        if (!$this->conn) {
            echo 'Cannot connect to database server';
            exit;
        }            
    }    
    return $this->conn;
 }
  
}
?>