<?php
include_once '../config/database.php';
require "../../vendor/autoload.php";
use \Firebase\JWT\JWT;
class auth extends DatabaseService
{
    public function __construct()
    {
        parent::__construct();
    }
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
    public function singledata($table, $column, $id)
    {
        $query  = "SELECT * FROM $table where $column = '$id'";
        $result = $this->conn->query($query);
        if ($result == false) {
            return false;
        }
        $rows = $result->fetch_assoc();
        return $rows;
    }
    public function execute($query)
    {
        $result = $this->conn->query($query);
        if ($result == false) {
            echo 'Error: cannot execute the command';
            return false;
        } else {
            return true;
        }
    }
    public function delete($id, $table)
    {
        $query = "DELETE FROM $table WHERE id = $id";
        
        $result = $this->conn->query($query);
        
        if ($result == false) {
            echo 'Error: cannot delete id ' . $id . ' from table ' . $table;
            return false;
        } else {
            return true;
        }
    }
    public function insert($data, $table)
    {
        $keys   = array();
        $values = array();
        foreach ($data as $key => $column) {
           
            $keys[]   = "`{$key}`";
            $values[] = "'{$column}'";
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
    public function escape_stringdata($array)
    {
        foreach ($array as $key => $value) {
            $data[$key] = $this->conn->real_escape_string(trim($value));
        }
       return $data; 
    }
    public function login($sql){
        $result = $this->conn->query($sql);
        if ($result == false) {
            return false;
        }
        $rows = array();
        $rows=$result->fetch_assoc();
        return $rows;
    }   
    public function gettoken($data){    
        $tokenId = base64_encode(bin2hex(32));
        $secret_key = $this->key();
        $issuer_claim = "THE_ISSUER";
        $audience_claim = "THE_AUDIENCE";
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim ;
        $expire = $notbefore_claim + 40000; //not before
        $token = array("iss" => $issuer_claim, 'jti' => $tokenId, "aud" => $audience_claim, "iat" => $issuedat_claim, "nbf" => $notbefore_claim, "exp" => $expire, 
            "data" => array("id" => $data['id'], "name" => $data['name'],"position" => $data['position'],"employe_id" => $data['employe_id'],"ref_start" => $data['ref_start']));
        $token = JWT::encode($token, $secret_key);
        return $token;  
    }
    public function emailvarification($value){
       $tokenId = base64_encode(bin2hex(32));
        $secret_key = $this->key();
        $issuer_claim = "THE_ISSUER";
        $audience_claim = "THE_AUDIENCE";
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim + 10 ;
        $expire = $notbefore_claim + 300; //not before
        $token = array("iss" => $issuer_claim, 'jti' => $tokenId, "aud" => $audience_claim, "iat" => $issuedat_claim, "nbf" => $notbefore_claim, "exp" => $expire, 
            "data" => array("email" => $value['email_id'],"username" => $value['username']));
        return $token = JWT::encode($token, $secret_key);
    }
    public function tokenverify($token){
        $jwt=$token;
        $secret_key = $this->key();
       try {
        $decoded = JWT::decode($jwt, $secret_key, array('HS256'));
          return $decoded;
        }catch (Exception $e){
            return $e->getMessage();
        } 

    }
    public function checkdata($sql){
        $result = $this->conn->query($sql);
        $row =$result->fetch_assoc();
        if($row){
            return $row;
        }
        return false;
    }
}
header("Content-Type: application/json; charset=UTF-8");
?>