<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$data=$_POST;
	if(!empty($data['id'])){
		if(!empty($_FILES['upload']['name'])){
			$ch_photo=ch_photo($tokendata,$time);
			 if(!empty($ch_photo['photo'])){
			 	$data['chachees_number_photo']=$ch_photo['photo'];
			 }	
		}
		if(!empty($_FILES['uploadPhotos'])){
			$photo=photo($tokendata,$time);
			 if(!empty($photo['photo'])){
			 	$data['photo']=json_encode($photo['photo']);
			 }
		}
		unset($data['upload']);
		unset($data['uploadPhoto']);
		unset($data['applicatioNumber']);
		$data['right_tyer_quantity']=json_encode((array_filter($data['right_tyer_quantity'])));
		$data['right_tyer_company']=json_encode((array_filter($data['right_tyer_company'])));
		$data['right_quality']=json_encode((array_filter($data['right_quality'])));
		$data['left_tyer_quantity']=json_encode((array_filter($data['left_tyer_quantity'])));
		$data['left_tyer_company']=json_encode((array_filter($data['left_tyer_company'])));
		$data['left_quality']=json_encode((array_filter($data['left_quality'])));
		$data['updated']=$time;
		$result=$exe->update('finances',$data,'id',$data['id']);
		if($result=="true"){
			$temp['ref_id']=$data['id'];
			$error= "Sucssfully Updated";
			$status = true;
			$code   = "200";	
		}else{
			$error=$result;
		}
	}else{
		unset($data['upload']);
		unset($data['uploadPhoto']);
		unset($data['applicatioNumber']);
		$data['right_tyer_quantity']=json_encode((array_filter($data['right_tyer_quantity'])));
		$data['right_tyer_company']=json_encode((array_filter($data['right_tyer_company'])));
		$data['right_quality']=json_encode((array_filter($data['right_quality'])));
		$data['left_tyer_quantity']=json_encode((array_filter($data['left_tyer_quantity'])));
		$data['left_tyer_company']=json_encode((array_filter($data['left_tyer_company'])));
		$data['left_quality']=json_encode((array_filter($data['left_quality'])));
		$ch_photo=ch_photo($tokendata,$time);
		 if(!empty($ch_photo['photo'])){
		 	$data['chachees_number_photo']=$ch_photo['photo'];
		 }
		 $photo=photo($tokendata,$time);
		 if(!empty($photo['photo'])){
		 	$data['photo']=json_encode($photo['photo']);
		 }
		$data['created']=$time;
		$result=$exe->insert($data,'finances');
		if(isset($result['id'])){
			$temp['ref_id']=$result['id'];
			$error= "Sucssfully Inserted";
			$status = true;
			$code   = "200";	
		}else{
			$error=$result;
		}
	}	
	
echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code)); 	
}
function ch_photo($tokendata,$time){
	$photo=null;
	$error=null;
	$allowTypes = array('jpg','png','jpeg','gif');
	if(!empty($_FILES['upload']['name'])){
			$filename=md5($_FILES['upload']['name'].$tokendata['id'].$time.(uniqid(rand(), true)));
			$imageFileType = strtolower(pathinfo($_FILES["upload"]["name"],PATHINFO_EXTENSION));
			$check = getimagesize($_FILES["upload"]["tmp_name"]);
		    if($check !== false) {
		        if ($_FILES["upload"]["size"] < 5000000	) {
		        	if(in_array($imageFileType, $allowTypes)) {
		        		$target_file = "../uploads/finance/".$filename.".".$imageFileType;
		        		if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
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
function photo($tokendata,$time){
	$photo=[];
	$error=null;
	if(!empty($_FILES['uploadPhotos'])){
		$allowTypes = array('jpg','png','jpeg','gif');
		foreach ($_FILES['uploadPhotos']['name'] as $key => $value) {
			 	$imageFileType = strtolower(pathinfo($_FILES["uploadPhotos"]["name"][$key],PATHINFO_EXTENSION));
				$filename=md5($_FILES['uploadPhotos']['name'][$key].$tokendata['id'].$time.(uniqid(rand(), true)));
				$target_file = "../uploads/finance/".$filename.".".$imageFileType;
			  	$image_name = $_FILES['uploadPhotos']['name'][$key];
		        $tmp_name   = $_FILES['uploadPhotos']['tmp_name'][$key];
		        $size       = $_FILES['uploadPhotos']['size'][$key];
		        $type       = $_FILES['uploadPhotos']['type'][$key];
		        $error      = $_FILES['uploadPhotos']['error'][$key];
		      if(in_array($imageFileType, $allowTypes)){    
		            if(move_uploaded_file($_FILES['uploadPhotos']['tmp_name'][$key],$target_file)){
		              	 $photo[] = $filename.".".$imageFileType;  
		            }else{
		            	$error.="Image Not Uploaded";
		            }
        		}else{
        			$error=$imageFileType." Image Not Allow";
        		}   
			}	
		}
return array('photo'=>$photo,'error'=>$error);
}

?>