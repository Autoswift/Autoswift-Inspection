<?php

include_once './config/database.php';
class Crud extends DatabaseService
{
    public function getData($table, $column, $id)
    {
        $query  = "SELECT * FROM $table where $column = '$id'";
        $result = $this->conn->query($query);
        if ($result == false) {
            return false;
        }
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
    public function getall($table)
    {
        $query  = "SELECT * FROM $table";
        $result = $this->conn->query($query);
        if ($result == false) {
            return false;
        }
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
    public function getsingledata($table, $column, $id)
    {
        $query  = "SELECT * FROM $table where $column = '$id'";
        $result = $this->conn->query($query);
        if ($result == false) {
            return false;
        }
        $rows = $result->fetch_assoc();
        return $rows;
    }
    public function getsinglequery($query)
    {
        $result = $this->conn->query($query);
        if ($result == false) {
            return false;
        }
        $rows = $result->fetch_assoc();
        return $rows;
    }
    public function getallquerydata($query)
    {
        $result = $this->conn->query($query);
        if ($result == false) {
            return false;
        }
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
     public function inserquery($query)
    {
        $result = $this->conn->query($query);
        if ($result == false) {
            return 'Error: cannot execute the command';
        } else {
            $last_id=$this->conn->insert_id;
            $res=array("id"=>$last_id);
            return $res;
        }
    }
    public function execute($query)
    {
        $result = $this->conn->query($query);
        if ($result == false) {
            return 'Error: cannot execute the command';
        } else {
            return true;
        }
    }
    public function delete($id, $table)
    {
        $query = "DELETE FROM $table WHERE id = $id";
        
        $result = $this->conn->query($query);
        
        if ($result == false) {
            return 'Error: cannot delete id ' . $id . ' from table ' . $table;;
        } else {
            return true;
        }
    }
    public function insert($data, $table)
    {
        $keys   = array();
        $values = array();
        foreach ($data as $key => $column) {
            $value    = $this->escape_string($column);
            $keys[]   = "`{$key}`";
            $values[] = "'{$value}'";
        }
        $query  = "INSERT INTO $table (" . implode(",", $keys) . ") 
          VALUES (" . implode(",", $values) . ");";
        $result = $this->conn->query($query);
        if ($result == false) {
            return $this->conn->error;
            //return false;
        } else {
            $last_id=$this->conn->insert_id;
            $res=array("id"=>$last_id);
            return $res;
        }
    }
    public function update($table,$data,$where,$id){
         $keys   = array();
        $values = array();
        foreach ($data as $key => $column) {
           
            $keys   = "`{$key}`";
            $values = "'{$column}'";
            $updates[] = "$keys = $values";
        }
        $implodeArray = implode(', ', $updates);
        $query  = "update $table set ".$implodeArray." Where `".$where."`='".$id."'";
        $result = $this->conn->query($query);
        if ($result == false) {
            return $this->conn->error;
            //return false;
        } else {
            return true;
        }   
    }
    public function escape_string($value)
    {
         return $this->conn->real_escape_string(trim($value));
    }
    public function escape_stringdata($array)
    {
        foreach ($array as $key => $value) {
            $data[$key] = $this->conn->real_escape_string(trim($value));
        }
       return $data; 
    }
}
header("Content-Type: application/json; charset=UTF-8");
?>