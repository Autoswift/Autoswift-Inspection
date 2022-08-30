<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="POST")
{	$data = json_decode(file_get_contents('php://input'), true);
	if(!empty($data['id'])){
		$filename = strtotime($time).'.pdf';
	 	$img = str_replace('data:application/pdf;base64,', '', $data['docData']);
		$img = str_replace(' ', '+', $img);
		$data1 = base64_decode($img);
		file_put_contents('../uploads/finance/pdf/'.$filename, $data1);
		unset($data['docData']);
		$data['updated']=$time;
		$data['pdf_file']=$filename;
		$sql="select pdf_file from finances where id=".$data['id'];
		$resu=$exe->getsinglequery($sql);
		$old=$resu['pdf_file'];
		$result=$exe->update('finances',$data,'id',$data['id']);
		if($result=="true"){
			unlink('../uploads/finance/pdf/'.$old);
			$temp['ref_id']=$data['id'];
			$temp['fileurl']='uploads/finance/pdf/'.$filename;
			$error= "Sucssfully Updated";
			$status = true;
			$code   = "200";	
		}else{
			$error=$result;
		}
	}
 echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code));
}	
?>