<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{	
	
			$data=$_GET;
			if(!empty($data['valu_id'])){
			   $result=$exe->getData('valuations','id',$data['valu_id']); 
			}else{
			    $sql="select * from valuations order by id desc";
				 $result=$exe->getallquerydata($sql); 
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
if($_SERVER['REQUEST_METHOD']=="OPTIONS")
{	
				$sql="select * from valuations order by id asc";
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
	$result=[];
	if(!empty($_FILES['gridpdf'])){
	   $photo=photo($tokendata,$time);
		 if(!empty($photo['photo'])){
		 	$data['grid_pdf']=json_encode($photo['photo']);
		 }
	}	 
	if($data){
		$data=$exe->escape_stringdata($data);
		if(!empty($_POST['valu_id'])){
			$data['updated']=$time;
			unset($data['valu_id']);
			$result=$exe->update('valuations',$data,'id',$_POST['valu_id']);
			if($result==true){
				$temp['ref_id']=$_POST['valu_id'];
				$error= "Sucssfully";
			    $status = true;
			    $code   = "200";	
			}else{
				$error=$result;
			}
		}else{
			$data['created']=$time;
			unset($data['valu_id']);
			$result=$exe->insert($data,'valuations');
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
	if(!empty($data['valu_id'])){
		$result=$exe->delete($data['valu_id'],'valuations');
		if($result=="true"){
			$temp['ref_id']=$result['valu_id'];
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
	if(!empty($_FILES['gridpdf'])){
		$allowTypes = array('pdf');
		foreach ($_FILES['gridpdf']['name'] as $key => $value) {
			 	$imageFileType = strtolower(pathinfo($_FILES["gridpdf"]["name"][$key],PATHINFO_EXTENSION));
				$filename=md5($_FILES['gridpdf']['name'][$key].$tokendata['id'].$time.(uniqid(rand(), true)));
				$target_file = "../uploads/com_pdf/".$filename.".".$imageFileType;
			  	$image_name = $_FILES['gridpdf']['name'][$key];
		        $tmp_name   = $_FILES['gridpdf']['tmp_name'][$key];
		        $size       = $_FILES['gridpdf']['size'][$key];
		        $type       = $_FILES['gridpdf']['type'][$key];
		        $error      = $_FILES['gridpdf']['error'][$key];
		      if(in_array($imageFileType, $allowTypes)){    
		            if(move_uploaded_file($_FILES['gridpdf']['tmp_name'][$key],$target_file)){
		              	 $photo[] = $filename.".".$imageFileType;  
		            }else{
		            	$error.="File Not Uploaded";
		            }
        		}else{
        			$error=$imageFileType." File Not Allow";
        		}   
			}	
		}
return array('photo'=>$photo,'error'=>$error);
}
		
?>