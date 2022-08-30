<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=='POST') {
	$data  = $_POST;
	$field=array("id",'ref_start');
	$error = $valid->check_empty($data,$field);
	if(!$error){
		$error = $valid->check_extrafields($data,$field);
		if(!$error){
			$id=$data['id'];
			unset($data['id']);
			$result=$exe->update('users',$data,'id',$id);
			if($result=="true"){
				$error= "Sucssfully Updated";
                $status = true;
                $code   = "200";
			}else{
				$error= $result;
			}
		}
	}
		echo json_encode(array("data"=>$result,"message" => $error,"status" => $status,"code" => $code)); 
}

?>