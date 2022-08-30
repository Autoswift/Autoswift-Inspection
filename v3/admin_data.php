<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{
	$query = "SELECT * FROM users where POSITION = 'Employe' and company_name=(SELECT company_name FROM users WHERE users.id=".$tokendata['id'].")";
			$result=$exe->getallquerydata($query);
			if($result){
				$temp=$result;
		 		$error= "Sucssfully";
			    $status = true;
			    $code   = "200";
			}else{
				$error="Nodata Found";
			}
	echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code));
}	 
if($_SERVER['REQUEST_METHOD']=="OPTION")
{
	if(!empty($_GET['not_id'])){
			$sql="select * From notification where id=".$_GET['not_id'];
		}else{
			 $sql="select notification.*,DATE_FORMAT(DATE,'%d-%m-%Y') AS date,users.name as excutive_name,cities.city_name as area,valuations.name as company_name From notification,users,cities,valuations where valuations.id=notification.valuations_by AND 
					notification.user_id=users.id AND 
					cities.city_id=notification.area AND 
					notification.sender_id=".$tokendata['id']." order by id desc";
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
	$error=$valid->check_empty($data,array('registration_no','make_model','party_name','mobile_no','place','user_id'));
	if(!$error){
		$data=$exe->escape_stringdata($data);
		unset($data['state']);
		
				$query ="SELECT valuations.id FROM users INNER JOIN valuations ON users.company_name=valuations.name WHERE users.id=".$tokendata['id'];
				$resu=$exe->getsinglequery($query);
				$data['valuations_by']=$resu['id'];
				$query ="SELECT cities.city_id AS id FROM users JOIN cities ON cities.city_name=users.area WHERE users.id=".$tokendata['id'];
				$resu=$exe->getsinglequery($query);
				$data['area']=$resu['id'];
				$data['sender_id']=$tokendata['id'];	
					$data['date']=$time;
					$result=$exe->insert($data,'notification');
						if(isset($result['id'])){
							$temp['ref_id']=$result['id'];
							$error= "Sucssfully";
						    $status = true;
						    $code   = "200";	
						}else{
							$error=$result;		
						}
					
		

	}
	echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code)); 
}
?>