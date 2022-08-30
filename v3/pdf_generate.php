<?php
include_once 'config/database.php';
class pdf extends DatabaseService
{
    public function getData($id)
    {
        $query="select finances.*,valuations.name AS valuationsname,declerations.name AS declerations  From finances left join valuations on finances.valuatation_by=valuations.id LEFT JOIN declerations  ON declerations.id= finances.notice where finances.id=".$id;
        $result = $this->conn->query($query);
        if ($result == false) {
            return false;
        }
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows['data'] = $row;
        }
        $query2="select * From headers";  
        $result = $this->conn->query($query2);
        if ($result == false) {
            return false;
        }
        while ($row = $result->fetch_assoc()) {
            $rows['header'] = $row;
        }
        return $rows;
    }
   public function escape_stringdata($value)
    {
         return $this->conn->real_escape_string(trim($value));
    }
}
?>