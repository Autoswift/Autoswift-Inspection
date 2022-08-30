<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="POST")
{ 
  $data=$_POST;
       
  $data=$_POST;
    $fields=array("user_id",'status');
    $error = $valid->check_empty($data,$fields);
      if(!$error){
          $user_id=$data['user_id'];
          unset($data['user_id']);
          $result=$exe->update('users',$data,'id',$user_id);  
          if(isset($result)&& $result=="true"){
                    $temp['id']= $user_id;
                    $error= "Sucssfully";
                    $status = true;
                    $code   = "200";
          }
        }
echo json_encode(array("data"=>$temp,"message" => $error,"success" => $status,"code" => $code));   
}
