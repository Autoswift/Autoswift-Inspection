<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{	
			$data=$_GET;
			if(!empty($data['dc_id'])){
			   $result=$exe->getData('declerations','id',$data['dc_id']); 
			}else{
				 $sql= "select * From declerations ORDER BY id desc";
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

			$sql= "select * From declerations ORDER BY id asc";
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
		if(!empty($_POST['dc_id'])){
			$data['updated']=$time;
			unset($data['dc_id']);
			$result=$exe->update('declerations',$data,'id',$_POST['dc_id']);
			if($result==true){
				$temp['ref_id']=$_POST['dc_id'];
				$error= "Sucssfully";
			    $status = true;
			    $code   = "200";	
			}else{
				$error=$result;
			}
		}else{
			$data['created']=$time;
			unset($data['dc_id']);
			$result=$exe->insert($data,'declerations');
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
	if(!empty($data['dc_id'])){
		$result=$exe->delete($data['dc_id'],'declerations');
		if($result=="true"){
			$temp['ref_id']=$result['dc_id'];
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