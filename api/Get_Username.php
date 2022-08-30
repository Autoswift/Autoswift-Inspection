<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{	          
            $sql="select id,name from users";
	        $result=$exe->getallquerydata($sql);
			if($result){
				$temp=$result;
		 		$error= "Sucssfully";
			    $status = true;
			    $code   = "200";
			}else{
				$error="Nodata Found";
			}
		
	echo json_encode(array("data"=>$result,"message" => $error,"status" => $status,"code" => $code)); 
}