<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{   
    if(!empty($_GET['status'])){
      $query = "Select * from users WHERE NOT position='SuperAdmin' and status='".$_GET['status']."' order by id desc";
      $result=$exe->getallquerydata($query);
      if($result){
        foreach($result as $key=> $value){
          if($result[$key]['position']=='Employe'){
             $result[$key]['position']='Mobile Executive'; 
          }
          if($result[$key]['position']=='Admin'){
             $result[$key]['position']='Mobile Admin'; 
          }
          
        }
        $temp=$result;
        $error= "Sucssfully";
          $status = true;
          $code   = "200";
      }else{
        $error="Nodata Found";
      }   
    }else{
        $error="Missing Parameters";
    }
    
  echo json_encode(array("data"=>$result,"message" => $error,"status" => $status,"code" => $code)); 
}
?>
