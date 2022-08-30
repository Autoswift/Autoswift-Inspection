<?php
include_once("src/defalt.php");
if($tokendata['position']=="SuperAdmin"){
if($_SERVER['REQUEST_METHOD']=="GET")
{	
			$data=$_GET;
			if(!empty($data['hd_id'])){
			   $result=$exe->getData('headers','id',$data['hd_id']); 
			}else{
				 $result=$exe->getall('headers'); 
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
		$logo=logo();
		if($logo['photo'] && !empty($logo['error'])){
			$data['logo']=$logo['photo'];
		}	
		if(!empty($_POST['hd_id'])){
			$data['updated']=$time;
			unset($data['hd_id']);
			$result=$exe->update('headers',$data,'id',$_POST['hd_id']);
			if($result=='true'){
				$temp['ref_id']=$_POST['hd_id'];
				$error= "Sucssfully";
			    $status = true;
			    $code   = "200";	
			}else{
				$error=$result;
			}
		}else{
			$data['created']=$time;
			$result=$exe->insert($data,'headers');
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
function logo(){
	$photo=null;
	$error=null;
	$allowTypes = array('jpg','png','jpeg','gif');
	if(!empty($_FILES['logo']['name'])){
			$filename="logo_auto";
			$imageFileType = strtolower(pathinfo($_FILES["logo"]["name"],PATHINFO_EXTENSION));
			$check = getimagesize($_FILES["logo"]["tmp_name"]);
		    if($check !== false) {
		        if ($_FILES["logo"]["size"] < 500000000) {
		        	if(in_array($imageFileType, $allowTypes)) {
		        		$target_file = "../uploads/image/".$filename.".".$imageFileType;
		        		if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
							$photo= $filename.".".$imageFileType; 	
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
	return array('photo'=>$photo,'error'=>$error);			
}
}else{
	echo json_encode(array("result"=>$temp,"message" => 'Unauthorised Access',"status" => $status,"code" => $code)); 
}	
?>