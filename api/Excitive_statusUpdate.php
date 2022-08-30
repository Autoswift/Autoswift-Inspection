<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="POST")
{ 
  $data  = $_POST;
  if(!empty($data['user_id'])){
     $query="Update users set STATUS=CASE WHEN STATUS = 'Active' THEN 'Inactive' ELSE 'Active' END WHERE id=".$data['user_id'];
    $result=$exe->execute($query);
    if($result=="true"){
      $temp['ref_id']=$data['user_id'];
      $error= "Sucssfully";
        $status = true;
        $code   = "200";
    }else{
      $error=$result;
    }
  }else{
    $error="Missing Parameters";
  }
  echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code)); 
}
?>
