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
}
if($_SERVER['REQUEST_METHOD']=='PUT') {
	$data=json_decode(file_get_contents("php://input"),true);
	if($tokendata['position']=='SuperAdmin'){
		$sql="Update users  SET ref_start=1  where position=".$data['position'];
		$result=$exe->execute($sql);
		if($result=="true"){
			$error= "Sucssfully Reset All Reference No";
	        $status = true;
	        $code   = "200";
		}else{
			$error= $result;
		}	
	}else{
		$error= "You Don't Have Permission to Reset";
	}
	
}
echo json_encode(array("message" => $error,"status" => $status,"code" => $code));
?>