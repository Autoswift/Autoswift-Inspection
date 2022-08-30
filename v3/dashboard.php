<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{	
			$query = "SELECT sum(case when POSITION = 'Administrator' then 1 else 0 end) as admin,sum(case when POSITION = 'Employe' then 1 else 0 end) as Employe,sum(case when POSITION = 'Admin' then 1 else 0 end) as Mobile_admin from users";
			$result['udata']=$exe->getallquerydata($query);
			if($tokendata['position']=='SuperAdmin'){
			    $query = "SELECT COUNT(*) AS today_report from finances WHERE DATE (created) = '".date('Y-m-d')."' and report_date is Not Null";
			}else{
			     $query = "SELECT COUNT(*) AS today_report from finances WHERE DATE (created) = '".date('Y-m-d')."' and report_date is Not Null and user_id=".$tokendata['id'];
			}  
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