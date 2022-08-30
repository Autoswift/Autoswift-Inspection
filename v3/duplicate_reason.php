<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{	
	
			$data=$_GET;
			if(!empty($data['dr_id'])){
			   $result=$exe->getData('duplicate_reason','id',$data['dr_id']); 
			}else{
				$sql="select * From duplicate_reason order by id desc";
				 $result=$exe->getallquerydata($sql); 
				}
			if($result){
				$temp=$result;
		 		$error= "Sucssfully";
			    $status = true;
			    $code   = "200";
			}else{
				$error="Nodata Found";
			}
		
	echo json_encode(array("result"=>$result,"message" => $error,"status" => $status,"code" => $code)); 
}
if($_SERVER['REQUEST_METHOD']=="OPTIONS")
{	
			$sql="select * From duplicate_reason order by id asc";
			$result=$exe->getallquerydata($sql); 
			if($result){
				$temp=$result;
		 		$error= "Sucssfully";
			    $status = true;
			    $code   = "200";
			}else{
				$error="Nodata Found";
			}
		
	echo json_encode(array("result"=>$result,"message" => $error,"status" => $status,"code" => $code)); 
}
if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$data=$_POST;
	$result=[];
	if($data){
		$data=$exe->escape_stringdata($data);
		if(!empty($_POST['dr_id'])){
			unset($data['dr_id']);
			$result=$exe->update('duplicate_reason',$data,'id',$_POST['dr_id']);
			if($result==true){
				$temp['ref_id']=$_POST['dr_id'];
				$error= "Sucssfully";
			    $status = true;
			    $code   = "200";	
			}else{
				$error=$result;
			}
		}else{
			unset($data['dr_id']);
			$result=$exe->insert($data,'duplicate_reason');
			if(isset($result['id'])){
				$temp['ref_id']=$result['id'];
				$error= "Sucssfully";
			    $status = true;
			    $code   = "200";	
			}else{
				$error=$result;		
			}
		}
	}
	echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code)); 
}
if($_SERVER['REQUEST_METHOD']=="DELETE")
{	
	$data  = json_decode(file_get_contents("php://input"), true);
	if(!empty($data['dr_id'])){
		$result=$exe->delete($data['dr_id'],'duplicate_reason');
		if($result=="true"){
			$temp['ref_id']=$result['dr_id'];
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