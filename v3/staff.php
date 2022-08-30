<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{		
		if(!empty($_GET['staff_id'])){
			$sql="select * From staff where id=".$_GET['staff_id'];
		}else if(!empty($_GET['status'])){
			$sql="select * From staff where status=".$_GET['status'];
		}else{
			$sql="select * From staff order by id desc";
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
	$error=$valid->check_empty($data,array('name','address','mobile_number','sort_name'));
	if(!$error){
		$data=$exe->escape_stringdata($data);
			if(!$error){
					$photo=photo($tokendata,$time);
					if(!empty($photo['photo'])){
					 	$data['photo']=json_encode($photo['photo']);
					}
				/*	print_r($photo)
					die();*/
					if(!empty($_POST['staff_id'])){
					$data['date']=$time;
					unset($data['staff_id']);
					$result=$exe->update('staff',$data,'id',$_POST['staff_id']);
						if($result=="true"){
							$temp['ref_id']=$_POST['staff_id'];
							$error= "Update Sucssfully";
						    $status = true;
						    $code   = "200";	
						}else{
							$error=$result;
						}
					}else{
						$data['date']=$time;
						unset($data['staff_id']);
						$result=$exe->insert($data,'staff');
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
if($_SERVER['REQUEST_METHOD']=="PUT")
{	
	$data  = json_decode(file_get_contents("php://input"), true);
	if(!empty($data['staff_id'])){
		$sql="UPDATE staff SET STATUS=(1-STATUS) WHERE id=".$data['staff_id'];
		$result=$exe->execute($sql);
		if($result=="true"){
			$temp['ref_id']=$result['staff_id'];
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
if($_SERVER['REQUEST_METHOD']=="DELETE")
{	
	$data  = json_decode(file_get_contents("php://input"), true);
	if(!empty($data['staff_id'])){
		$result=$exe->delete($data['staff_id'],'staff');
		if($result=="true"){
			$temp['ref_id']=$result['staff_id'];
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
function photo($tokendata,$time){
	$photo=[];
	$error=null;
	if(!empty($_FILES['uploadPhotos'])){
		$allowTypes = array('jpg','png','jpeg','gif');
		foreach ($_FILES['uploadPhotos']['name'] as $key => $value) {
			 	$imageFileType = strtolower(pathinfo($_FILES["uploadPhotos"]["name"][$key],PATHINFO_EXTENSION));
				$filename=md5($_FILES['uploadPhotos']['name'][$key].$tokendata['id'].$time.(uniqid(rand(), true)));
				$target_file = "../uploads/document/".$filename.".".$imageFileType;
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