<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$data=$_POST;
	if(!empty($data['id'])){
		$ch_photo=ch_photo($tokendata,$time,$data['upload']);
		 if(!empty($ch_photo['photo'])){
		 	$data['chachees_number_photo']=$ch_photo['photo'];
		 }
		if(isset($data['approve_photo'])){
			$data['approve_photo']=json_encode($data['approve_photo']);	
		}else{
			$data['approve_photo']=Null;
		}
		if(!empty($_FILES['uploadPhotos'])){
			$photo=photo($tokendata,$time);
			 if(!empty($photo['photo'])){
			 	$data['photo']=json_encode($photo['photo']);
				$data['approve_photo']=json_encode($photo['photo']);
			 	$sql="select photo,approve_photo from finances where id=".$data['id'];
			 	$resu=$exe->getsinglequery($sql);
			 	if(!empty($resu['photo'])){
			 		$p=json_decode($resu['photo']);
			 		$data['photo']=json_encode(array_merge($p,$photo['photo']));  
					$ap=json_decode($resu['photo']);
			 		$data['approve_photo']=json_encode(array_merge($ap,$photo['photo']));  
			 	}
			 }
		}
		if($data['mobile_data']==1){
		  $data['user_id']=$tokendata['id'];
		  
		}
		unset($data['upload']);
		unset($data['uploadPhoto']);
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
		$data['right_tyer_quantity']=json_encode((array_filter($data['right_tyer_quantity'])));
		$data['right_tyer_company']=json_encode((array_filter($data['right_tyer_company'])));
		$data['right_quality']=json_encode((array_filter($data['right_quality'])));
		$data['left_tyer_quantity']=json_encode((array_filter($data['left_tyer_quantity'])));
		$data['left_tyer_company']=json_encode((array_filter($data['left_tyer_company'])));
		$data['left_quality']=json_encode((array_filter($data['left_quality'])));
		$ch_photo=ch_photo($tokendata,$time,$data['upload']);
		 if(!empty($ch_photo['photo'])){
		 	$data['chachees_number_photo']=$ch_photo['photo'];
		 }
		 $photo=photo($tokendata,$time);
		 if(!empty($photo['photo'])){
		 	$data['photo']=json_encode($photo['photo']);
		 	$data['approve_photo']=json_encode($photo['photo']);
		 }
		unset($data['upload']);
		unset($data['uploadPhoto']);
		if(isset($data['duplicate_reason'])){
			$data['duplicate_entry']=1;
		}
		$data['created']=$time;
		$data['user_id']=$tokendata['id'];
		$result=$exe->insert($data,'finances');
		if(isset($result['id'])){
			$sql="update users set ref_start=ref_start+1 where id=".$tokendata['id'];
			$exe->execute($sql);
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
function ch_photo($tokendata,$time,$chphphoto){
	$photo=null;
	$error=null;
	if($chphphoto != 'undefined'){
		$org_image="../uploads/tmp/".$chphphoto;
	  if (file_exists($org_image)) {   
			$filename=md5($chphphoto.$tokendata['id'].$time.(uniqid(rand(), true)));
			$ext = pathinfo($org_image, PATHINFO_EXTENSION);
			$destination="../uploads/finance/".$filename.'.'.$ext;
			if(rename( $org_image , $destination)){
				 $photo= $filename.'.'.$ext;
				} else {
				 $error= "Somthing Wrong";
				}                       
		}else{
			 $error= "File Not Found";
		}
	 	
		return array('photo'=>$photo,'error'=>$error);
	}
	/*$photo=null;
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
		}*/
	/*return array('photo'=>$photo,'error'=>$error);*/			
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