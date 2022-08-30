<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="POST")
{ 
  $data = $_POST;
  $error = $valid->check_empty($data, array("user_id","device_id"));
  if(!$error){
	 $id=$data['user_id'];
	 unset($data['user_id']);
	 $data['id']=$id;
	 $result=$exe->update('users',$data,'id',$id);
	  if($result=="true"){
				$error= "Sucssfully Updated";
                $status = true;
                $code   = "200";
			}else{
				$error= $result;
			}
  }
echo json_encode(array("data"=>$result,"message" => $error,"status" => $status,"code" => $code)); 
}
?>	  