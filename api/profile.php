<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{
    if(!empty($_GET['user_id'])){
      	$query="SELECT email_id,company_name,username,pass1,profile_name,address,icard,govt_issue_id,back_govt_card from users WHERE id='".$_GET['user_id']."'";
    	$result=$exe->getallquerydata($query);
    	if(isset($result[0])){
    	   /* foreach($result[0] as $key => $value){
    	         $result1[$key]=$value;
    	       $result1['icard']='/uploads/document/'.$result[0]['icard'];
    	       $result1['govt_issue_id']='/uploads/document/'.$result[0]['govt_issue_id'];
    	        $result1['back_govt_card']='/uploads/document/'.$result[0]['back_govt_card'];
    	    };*/
    		
    		$temp=$result[0];
    		$error= "Sucssfully";
            $status = true;
            $code   = "200";
    	}else{
    		$error= "No Data Found";
    	}  
    }else{
        $error= "Missing Parameters";  
    }

	echo json_encode(array("data"=>$temp,"message" => $error,"status" => $status,"code" => $code));	
}
if($_SERVER['REQUEST_METHOD']=='PUT') {
	$data  = json_decode(file_get_contents("php://input"), true);
	$error = $valid->check_empty($data, array("oldpassword",'newpassword'));
	if(!$error){
		$error = $valid->password_valid($data['newpassword']);
		if(!$error){
			$data=$exe->escape_stringdata($data);
			$result=$exe->checkdata('users','email_id',$tokendata['email']);
			if($result){
				$password=$data['oldpassword'];
				$password2 =$result['password'];
					$newpass = password_hash($data['newpassword'], PASSWORD_BCRYPT);
				  		$sql="Update users set password='".$newpass."' Where email_id ='".$tokendata['email']."'";
				  		$res=$exe->execute($sql);
				  if (password_verify($password, $password2)){
				  	 	$newpass = password_hash($data['newpassword'], PASSWORD_BCRYPT);
				  		$sql="Update users set password='".$newpass."' Where email_id ='".$tokendata['email']."'";
				  		$res=$exe->execute($sql);
				  		if($res){
				  			$error= "Sucssfully";
			                $status = true;
			                $code   = "200";
				  		}else{
				  			$error= "Something Went Wrong";
				  		}
				  }else{
				  	 $error= "You have Enter Invalid Password";
				  }
			}else{
				$error= "Something Went Wrong";
			}
		}
	}
	echo json_encode(array("message" => $error,"status" => $status,"code" => $code));
}
if($_SERVER['REQUEST_METHOD']=="POST")
{		    
	$data=$_POST;
	if(!empty($_POST['user_id'])){
	    $user_id=$_POST['user_id'];
		if(isset($data['persnol'])){
    		$fields=array("profile_name",'address','email_id','persnol','user_id');
		    $error = $valid->check_extrafields($data,$fields);
			if(!$error){
					unset($data['persnol']);
					unset($data['user_id']);
					$result=$exe->update('users',$data,'id',$user_id);
					if(isset($result)&& $result=="true"){
						$error= "Sucssfully";
		                $status = true;
		                $code   = "200";
					
				}
			}
		}
		if(!empty($_FILES['profile_pic']['name']) && isset($_POST['profile'])){
			$imageFileType = strtolower(pathinfo($_FILES["profile_pic"]["name"],PATHINFO_EXTENSION));
			$target_file = "../uploads/000".$tokendata['id'].'profile'.'.'.$imageFileType;
			$check = getimagesize($_FILES["profile_pic"]["tmp_name"]);
		    if($check !== false) {
		        if ($_FILES["profile_pic"]["size"] < 500000) {
		        	if($imageFileType = "jpg" && $imageFileType = "png" && $imageFileType = "jpeg") {
		        		if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
							$image['photo']=basename($target_file);
							$result=$exe->update('users',$image,'id',$tokendata['id']);
							$error= "Image Uploaded Sucssfully";
			                $status = true;
			                $code   = "200";		
						}
					}else{
						$error="Sorry, only JPG, JPEG & PNG  files are allowed.";
					}
				}else{
					$error= "Sorry, your file is too large.";
				}
		    } else {
		        $error="File is not an image.";
		    }
		}    		
} else {
	$error="User Not selected";
}
echo json_encode(array("data"=>$temp,"message" => $error,"status" => $status,"code" => $code));		
}
if($_SERVER['REQUEST_METHOD']=="DELETE")
{
	if($tokendata){
		$data['photo']='';
		$result=$exe->update('users',$data,'id',$tokendata['id']);
		if($result=='true'){
			$error= "Sucssfully";
            $status = true;
            $code   = "200";
		}else{
			$error="Something went Wrong";	
		}
	}
echo json_encode(array("message" => $error,"status" => $status,"code" => $code));			
}		    
?>