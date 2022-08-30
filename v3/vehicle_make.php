<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{		
		if(!empty($_GET['vehicle_id'])){
			$sql="select * From vehicle_make where vehicle_id=".$_GET['vehicle_id'];
		}else{
			$sql="select * From vehicle_make";
		}
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
	$error=$valid->check_empty($data,array('vehicle_make'));
	if(!$error){
		$data=$exe->escape_stringdata($data);
			if(!$error){
					if(!empty($_POST['vehicle_id'])){
					unset($data['vehicle_id']);
					$result=$exe->update('vehicle_make',$data,'vehicle_id',$_POST['vehicle_id']);
						if($result=="true"){
							$temp['ref_id']=$_POST['vehicle_id'];
							$error= "Update Sucssfully";
						    $status = true;
						    $code   = "200";	
						}else{
							$error=$result;
						}
					}else{
						
						unset($data['vehicle_id']);
						$result=$exe->insert($data,'vehicle_make');
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

	}
	echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code)); 
}

if($_SERVER['REQUEST_METHOD']=="DELETE")
{	
	$data  = json_decode(file_get_contents("php://input"), true);
	if(!empty($data['vehicle_id'])){
		$sql="DELETE FROM vehicle_make where vehicle_id=".$data['vehicle_id'];
		$result=$exe->execute($sql);
		if($result=="true"){
			$temp['ref_id']=$data['vehicle_id'];
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