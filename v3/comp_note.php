<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{		
		if(!empty($_GET['not_id'])){
			$sql="select * From comp_not where note_id=".$_GET['not_id'];
		}else{
		    if($tokendata['position']=='comp'){
		       	 $sql="select *,DATE_FORMAT(date,'%d-%m-%Y') AS date from comp_not where sender_id=".$tokendata['id']." order by note_id desc"; 
		    }else{
		     	 $sql="select comp_not.*,DATE_FORMAT(comp_not.date,'%d-%m-%Y') AS date,users.name,users.company_name from comp_not join users ON users.id=comp_not.sender_id order by comp_not.note_id desc";   
		    }
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
	$error=$valid->check_empty($data,array('registration_no','make_model','party_name','mobile_no','place'));
	if(!$error){
		$data=$exe->escape_stringdata($data);
		unset($data['state']);
		
					if(!empty($_POST['not_id'])){
					$data['date']=$time;
					unset($data['not_id']);
					$result=$exe->update('comp_not',$data,'note_id',$_POST['not_id']);
						if($result=="true"){
							$temp['ref_id']=$_POST['not_id'];
							$error= "Update Sucssfully";
						    $status = true;
						    $code   = "200";	
						}else{
							$error=$result;
						}
					}else{
						$data['sender_id']=$tokendata['id'];
						$data['date']=$time;
						unset($data['not_id']);
						$result=$exe->insert($data,'comp_not');
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
	if(!empty($data['not_id'])){
		$sql="DELETE FROM comp_not WHERE note_id =".$data['not_id'];
		$result=$exe->execute($sql);
		if($result=="true"){
			$temp['ref_id']=$result['not_id'];
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