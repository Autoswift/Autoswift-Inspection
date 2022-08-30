<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{	
			$query = "SELECT sum(case when POSITION = 'Administrator' then 1 else 0 end) as admin,sum(case when POSITION = 'Employe' then 1 else 0 end) as Employe from users";
			$result['udata']=$exe->getallquerydata($query); 
			$query = "SELECT COUNT(*) AS today_report from finances WHERE report_date = '1546972200'";
			$result['today_report']=$exe->getallquerydata($query); 
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