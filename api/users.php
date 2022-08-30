<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{	
		$data=$_GET;
		$result=[];
		if($data){
				if(!empty($data['all'])){
				  $query = "Select * from users WHERE NOT position='SuperAdmin' ORDER BY id desc";
				  $result=$exe->getallquerydata($query); 
				}else{
					foreach ($data as $key => $value)
					{
			            $whereArr[] = "$key = {$value}";
			        }
					$whereStr = implode(" AND ", $whereArr);
					 $query = "Select name,id  from users WHERE NOT position='SuperAdmin' AND status='Active' AND $whereStr ORDER BY id desc";
					$result=$exe->getallquerydata($query);	
				}		
			if($result){
				$temp=$result;
		 		$error= "Sucssfully";
			    $status = true;
			    $code   = "200";
			}else{
				$error="Nodata Found";
			}
		}else{
			$error="Missing Parameters";
		}
		
	echo json_encode(array("data"=>$result,"message" => $error,"status" => $status,"code" => $code)); 
}
if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$data  = json_decode(file_get_contents("php://input"), true);
	if($data){
			$error = $valid->check_empty($data, array("name","mobile_no","username","password","employe_id","user_ref"));
			if(!$error){
				if(!empty($_POST['user_id'])){
				$data['modified']=$time;
				$data['pass1']=$data['password'];
				$data['password']=md5($data['password']);
				unset($data['user_id']);
				$result=$exe->update('users',$data,'id',$_POST['user_id']);
					if($result==true){
						$temp['ref_id']=$_POST['user_id'];
						$error= "Sucssfully";
					    $status = true;
					    $code   = "200";	
					}else{
						$error=$result;
					}
				}else{
					$data['created']=$time;
					$data['status']='Requested';
					$data['pass1']=$data['password'];
					$data['password']=md5($data['password']);
					$result=$exe->insert($data,'users');
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
	if(!empty($data['user_id'])){
		$result=$exe->delete($data['user_id'],'users');
		if($result=="true"){
			$temp['ref_id']=$result['user_id'];
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
if($_SERVER['REQUEST_METHOD']=="PUT")
{	
	$data  = json_decode(file_get_contents("php://input"), true);
	if(!empty($data['user_id'])){
		 $query="Update users set STATUS=CASE WHEN STATUS = 'Active' THEN 'Inactive' ELSE 'Active' END WHERE id=".$data['user_id'];
		$result=$exe->execute($query);
		if($result=="true"){
			$temp['ref_id']=$data['user_id'];
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