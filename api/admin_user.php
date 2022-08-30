<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{ 
      $query = "Select * from users WHERE position='Admin' and status='Active' OR status='Inactive' order by id desc";
      $result=$exe->getallquerydata($query); 
      if($result){
        $temp=$result;
        $error= "Sucssfully";
          $status = true;
          $code   = "200";
      }else{
        $error="Nodata Found";
      }
    
  echo json_encode(array("data"=>$result,"message" => $error,"status" => $status,"code" => $code)); 
}
?>