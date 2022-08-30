<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{		
		if(!empty($_GET['vehicle_variant_id'])){
			$sql="select * From vehicle_variant where vehicle_variant_id=".$_GET['vehicle_variant_id'];
		}else{
			$sql="select * From vehicle_variant";
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
	$error=$valid->check_empty($data,array('vehicle_variant','vehicle_model_id'));
	if(!$error){
		$data=$exe->escape_stringdata($data);
			if(!$error){
					if(!empty($_POST['vehicle_variant_id'])){
					unset($data['vehicle_variant_id']);
					$result=$exe->update('vehicle_variant',$data,'vehicle_variant_id',$_POST['vehicle_variant_id']);
						if($result=="true"){
							$temp['ref_id']=$_POST['vehicle_variant_id'];
							$error= "Update Sucssfully";
						    $status = true;
						    $code   = "200";	
						}else{
							$error=$result;
						}
					}else{
						
						unset($data['vehicle_variant_id']);
						$result=$exe->insert($data,'vehicle_variant');
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
	if(!empty($data['vehicle_variant_id'])){
		$sql="DELETE FROM vehicle_variant where vehicle_variant_id=".$data['vehicle_variant_id'];
		$result=$exe->execute($sql);
		if($result=="true"){
			$temp['ref_id']=$data['vehicle_variant_id'];
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