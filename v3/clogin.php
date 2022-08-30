<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$token='';
	$data  = json_decode(file_get_contents("php://input"), true);
	$error = $valid->check_empty($data, array('username', 'password'));
    if (!$error){
    	  $data=$exe->escape_stringdata($data);
    	  $sql="select * From users WHERE username='".$data['username']."' AND pass1 = '".$data['password']."' AND position=='SuperAdmin' OR position=='Administrator'";
    	  $result=$exe->getsinglequery($sql);
    	  if($result){
    	  		 if($result['status']=='Active'){
					if($result['pass1']==$data['password']){
						$token= md5($result['username']);
	                   	$error= "Successfully";
	                    $code=200;
	                    $status=true;
					}else{
						$error="Invalid Authentication"; 	
					}	
		    	 }else{
		    	 	$error=  "Account Inactivated "; 
		    	 }
    	  }else{
    	  		$error="Invalid Authentication"; 
    	  }
    	 
    	}  
	echo json_encode(array("token"=>$token,"message" => $error,"status" => $status,"code" => $code)); 
}
?>