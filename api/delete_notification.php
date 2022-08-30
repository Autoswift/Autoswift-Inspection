<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$data  = json_decode(file_get_contents("php://input"), true);
	if(!empty($data['not_id'])){
		$result=$exe->delete($data['not_id'],'notification');
		if($result=="true"){
			$temp['ref_id']=$data['not_id'];
			$error= "Sucssfully";
		    $status = true;
		    $code   = "200";
		}else{
			$error=$result;
		}
	}else{
		$error="Missing Parameters";
	}
	echo json_encode(array("data"=>$temp,"message" => $error,"status" => $status,"code" => $code)); 
}
?>