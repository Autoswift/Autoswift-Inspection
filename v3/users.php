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
					$query = "Select * from users WHERE NOT position='SuperAdmin' AND $whereStr ORDER BY id desc";
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
		
	echo json_encode(array("result"=>$result,"message" => $error,"status" => $status,"code" => $code)); 
}
if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$data=$_POST;
	$result=[];
	if($data){
		if($_FILES)
	        {
	          foreach ($_FILES as $key => $value)
	          {
	             $filename=md5($value['name'].$data['user_id'].$time.(uniqid(rand(), true)));
	             $imageFileType = strtolower(pathinfo($value  ["name"],PATHINFO_EXTENSION));
	             $target_file = "../uploads/document/".$filename.'.'.$imageFileType;
	             if(move_uploaded_file($_FILES[$key]["tmp_name"],$target_file)){
	               $data[$key]= $filename.'.'.$imageFileType;
	             }

	          }
	        }
		$data=$exe->escape_stringdata($data);
		if(!empty($_POST['user_id'])){
			$data['modified']=$time;
			$data['password']=md5($data['pass1']);
			unset($data['user_id']);
			unset($data['confirmpassword']);
			$result=$exe->update('users',$data,'id',$_POST['user_id']);
			if($result=='true'){
				$temp['ref_id']=$_POST['user_id'];
				$error= "Sucssfully";
			    $status = true;
			    $code   = "200";	
			}else{
				$error=$result;
			}
		}else{
			$data['created']=$time;
			unset($data['user_id']);
			unset($data['confirmpassword']);
			if($data['position']=="Employe" OR $data['position']=="Admin"){
				$data['status']="Requested";
			}else{
				$data['status']='Inactive';	
			}
			$data['password']=md5($data['pass1']);
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
	if(!empty($data['user_id'])&& empty($data['status'])){
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
	}else if(!empty($data['user_id']) && !empty($data['status'])){
		$userid=$data['user_id'];
		unset($data['user_id']);
		$result=$exe->update('users',$data,'id',$userid);
			if($result=="true"){
				$temp['ref_id']=$userid;
				$error= "Sucssfully";
			    $status = true;
			    $code   = "200";	
			}else{
				$error=$result;
			}
	}
	else{
		$error="Missing Parameters";
	}
	echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code)); 
}
?>