<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$data=$_POST;
	$error=$valid->check_empty($data,array('valuations_by','area','user_id','not_id'));
	if(!$error){
		$data=$exe->escape_stringdata($data);
		unset($data['state']);
				$sql="select * From comp_not where note_id=".$data['not_id'];
				$result=$exe->getsinglequery($sql);
				if($result){
					$data['registration_no']=$result['registration_no'];
					$data['make_model']=$result['make_model'];	
					$data['party_name']=$result['party_name'];
					$data['mobile_no']=$result['mobile_no'];
					$data['place']=$result['place'];
					$data['payment']=$result['payment'];
					$data['sender_id']=$tokendata['id'];
					$data['date']=$time;
					unset($data['not_id']);
					$result=$exe->insert($data,'notification');
					if(isset($result['id'])){
						$temp['ref_id']=$result['id'];
						$error= "Sucssfully";
						$status = true;
						$code   = "200";	
					}else{
						$error=$result;		
					}
				}else{
					$error= "Somthing went wrong";
				}	
	}
echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code)); 	
}
?>