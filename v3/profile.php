<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{
	$query="SELECT 	name,username,photo,mobile_number,employe_id,ref_start from users WHERE id='".$tokendata['id']."'";
	$result=$exe->getallquerydata($query);
	if(isset($result[0])){
		$result=$result[0];
		$temp=$result;
		$error= "Sucssfully";
        $status = true;
        $code   = "200";
	}else{
		$error= "No Data Found";
	}
	echo json_encode(array("data"=>$temp,"message" => $error,"status" => $status,"code" => $code));	
}
if($_SERVER['REQUEST_METHOD']=='PUT') {
	$data  = json_decode(file_get_contents("php://input"), true);
	$error = $valid->check_empty($data, array("oldpassword",'newpassword'));
	if(!$error){
	    $data=$exe->escape_stringdata($data);
	    $sql="select pass1 from users where id=".$tokendata['id'];
	    $result=$exe->getsinglequery($sql);
	    if($result){
	        if($result['pass1']==$data['oldpassword']){
	        $pass=md5($data['newpassword']);
	        $sql="Update users set pass1='".$data['newpassword']."',password='$pass' Where id ='".$tokendata['id']."'";
		    $res=$exe->execute($sql);
        	    if($res=="true"){
          			$error= "Sucssfully";
                    $status = true;
                    $code   = "200";
          		}else{
          			$error= "Something Went Wrong";
          		}
	        }else{
	           $error="Old Password Is Invalid"; 
	        }
	    }
	}
	echo json_encode(array("message" => $error,"status" => $status,"code" => $code));
}
if($_SERVER['REQUEST_METHOD']=="POST")
{		    
	$data=$_POST;
	if($tokendata){
		if(isset($data['persnol'])){
		$fields=array("name",'username','mobile_number','employe_id','persnol','ref_start');
		$error = $valid->check_extrafields($data,$fields);
			if(!$error){
				$error = $valid->validate_phone_number($data['mobile_number']);
				if(!$error){
					unset($data['persnol']);
					$result=$exe->update('users',$data,'id',$tokendata['id']);
					if(isset($result)&& $result=="true"){
						$error= "Sucssfully";
		                $status = true;
		                $code   = "200";
					}
				}
			}
		}
		if(!empty($_FILES['profile_pic']['name']) && isset($_POST['profile'])){
			$imageFileType = strtolower(pathinfo($_FILES["profile_pic"]["name"],PATHINFO_EXTENSION));
			$target_file = "../uploads/image/000".$tokendata['id'].'profile'.'.'.$imageFileType;
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