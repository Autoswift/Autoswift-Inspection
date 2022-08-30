<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$data=$_POST;
	if(!empty($data['id'])){
		$result=$exe->getData('finances','id',$data['id']);
		if($result){
			$photo=json_decode($result[0]['photo']);
			if(!empty($result[0]['videos'])&&$result[0]['videos']!='null'){
				$video=json_decode($result[0]['videos']);
			}
			$ch_photo=$result[0]['chachees_number_photo'];
			$selfie=$result[0]['selfie'];
			if($photo){
				$filename = $result[0]['registration_no'].'.zip';
				$zip = new ZipArchive();
				$tmp_file = "../uploads/tmp/".$filename;
				$zip->open($tmp_file, ZipArchive::CREATE);
				foreach($photo as $file){
					if(file_exists("../uploads/finance/".$file)){
						$download_file = file_get_contents("../uploads/finance/".$file);
				    	$zip->addFromString(basename($file),$download_file);
					}
				}
				$download_file = file_get_contents("../uploads/finance/".$ch_photo);
				$zip->addFromString(basename($ch_photo),$download_file);
				
				$download_file = file_get_contents("../uploads/finance/".$selfie);
				$zip->addFromString(basename($selfie),$download_file);
				if(!empty($result[0]['videos'])&&$result[0]['videos']!='null'){
					$download_file = file_get_contents("../uploads/videos/".$video[0]);
					$zip->addFromString(basename($video[0]),$download_file);
				
					$download_file = file_get_contents("../uploads/videos/".$video[1]);
					$zip->addFromString(basename($video[1]),$download_file);
				}
				$zip->close();
				if(file_exists($tmp_file)){
					$temp=$filename;
					$error="success";
					$status=true;
				}else{
					$error="Somthing Went Wrong";	
				}
				
			}else{
				$error="There are No image to zip";
			}
		}else{
			$error="Somthing went wrong";
		}
	}
	echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code)); 
}
?>