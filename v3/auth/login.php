<?php
include_once ("auth.php");
include_once("../src/validation.php");
$role   = false;
$status   = false;
$msg      = "";
$token    = "";
$code       = 400;
$auth = new auth();
$time = gmdate("Y-m-d H:i:s");
$validation = new Validation();
if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$data  = json_decode(file_get_contents("php://input"), true);
	$error = $validation->check_empty($data, array('username', 'password'));
    if (!$error){
    	  $data=$auth->escape_stringdata($data);
    	  $sql="select * From users WHERE username='".$data['username']."' And pass1='".$data['password']."' ";
    	  $result=$auth->login($sql);
    	  if($result){
			 if($result['position']=='SuperAdmin'|| $result['position']=='Administrator'){ 
    	  		 if($result['status']=='Active'){
					if($result['pass1']){
							$token= $auth->gettoken($result);
							$error= "Login Successfully";
							$code=200;
							$status=true;
						
					}else{
						$error="Invalid Authentication"; 	
					}	
		    	 }else{
		    	 	$error=  "Account Inactivated "; 
		    	 }
			}else{
							$error="You don't Have Access";
						}	 
    	  }else{
    	  		$error="Invalid Authentication"; 
    	  }
    	 
    	}  
	echo json_encode(array("token"=>$token,"message" => $error,"status" => $status,"code" => $code)); 
}
if($_SERVER['REQUEST_METHOD']=="OPTION")
{	
	$data  = json_decode(file_get_contents("php://input"), true);
	$error = $validation->check_empty($data, array('username', 'password'));
    if (!$error){
    	  $data=$auth->escape_stringdata($data);
    	  $sql="select * From users WHERE username='".$data['username']."' And pass1='".$data['password']."' And position='Admin'";
    	  $result=$auth->login($sql);
    	  if($result){
    	  		 if($result['status']=='Active'){
					if($result['pass1']){
						$token= $auth->gettoken($result);
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


