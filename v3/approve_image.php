<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="PUT")
{
	$data  = json_decode(file_get_contents("php://input"), true);
	$error=$valid->check_empty($data,array('imageids_arr','id'));
	if(!$error){
		$data['photo']=json_encode($data['imageids_arr']);
		unset($data['imageids_arr']);
		$data['updated']=$time;
		$result=$exe->update('finances',$data,'id',$data['id']);
		if($result=="true"){
			$temp['ref_id']=$data['id'];
			$error= "Change Image Order Sucssfully";
			$status = true;
			$code   = "200";	
		}else{
			$error=$result;
		}		
	}
 echo json_encode(array("result"=>$result,"message" => $error,"status" => $status,"code" => $code)); 	
}
if($_SERVER['REQUEST_METHOD']=="DELETE")
{
	$data  = json_decode(file_get_contents("php://input"), true);
	 $query = "Select 	photo,approve_photo from finances WHERE id=".$data['id'];
	 $result=$exe->getsinglequery($query); 
	 if($result){
	 	$photo=json_decode($result['photo']);
		 	if($photo){
		 		foreach (array_keys($photo, $data['image'], true) as $key) {
	    		unset($photo[$key]);
				}
			 $data['photo']=json_encode(array_values($photo));
		 	}
	 	$approve_photo=json_decode($result['approve_photo']);
		 	if($approve_photo){
		 			foreach (array_keys($approve_photo, $data['image'], true) as $key) {
	    		unset($approve_photo[$key]);
			}
			$data['approve_photo']=json_encode(array_values($approve_photo));
	 	}
	 	$image=$data['image'];
	 	unset($data['image']);
	 	$data['updated']=$time;
	 	$result=$exe->update('finances',$data,'id',$data['id']);
			if($result==true){
				unlink('../uploads/finance/'.$image);
				$temp['ref_id']=$data['id'];
				$error= "Sucssfully";
			    $status = true;
			    $code   = "200";	
			}else{
				$error=$result;
			}
	 }
 echo json_encode(array("result"=>$result,"message" => $error,"status" => $status,"code" => $code)); 	
}
?>