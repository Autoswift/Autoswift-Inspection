<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{	
			$query = "Select id,name,position from users";
			$result=$exe->getallquerydata($query); 
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

?>