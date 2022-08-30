<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{     
      if(!empty($_GET['state_id'])){
        $result=$exe->getData('cities','city_state',$_GET['state_id']);  
      }else if(!empty($_GET['city_id'])){
        $result=$exe->getData('cities','city_name',$_GET['city_id']);  
      }
      else{
       $sql="select * from  cities GROUP BY city_state";
       $result=$exe->getallquerydata($sql);
      }
      if($result){
        $temp=$result;
        $error= "Sucssfully";
        $status = true;
        $code   = "200";
      }else{
        $error="Nodata Found";
      }
    
  echo json_encode(array("result"=>$result,"message" => $error,"status" => $status,"code" => $code)); 
}
?>