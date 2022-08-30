<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{	
	
			$data=$_GET;
			if(!empty($data['city_id'])){
			   $result=$exe->getData('cities','id',$data['city_id']); 
			}else{
				 $result=$exe->getall('valuations'); 
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
if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$data=$_POST;
	$result=[];
	if($data){
		$data=$exe->escape_stringdata($data);
		if(!empty($_POST['city_id'])){
			unset($data['city_id']);
			$result=$exe->update('cities',$data,'id',$_POST['city_id']);
			if($result==true){
				$temp['ref_id']=$_POST['city_id'];
				$error= "Sucssfully";
			    $status = true;
			    $code   = "200";	
			}else{
				$error=$result;
			}
		}else{
			$result=$exe->insert($data,'cities');
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
?>