
<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$data  = json_decode(file_get_contents("php://input"), true);
	if(!empty($data['report_id'])){
		$result=$exe->delete($data['report_id'],'finances');
		if($result=="true"){
			$temp['ref_id']=$data['report_id'];
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