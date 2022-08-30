<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{	

			$query1="SELECT COUNT(*) AS pending from finances JOIN users ON finances.refenence_no LIKE CONCAT(users.employe_id, '%') WHERE (report_date IS NULL OR report_date='') AND mobile_data='1' AND users.company_name=(SELECT company_name FROM users WHERE users.id=".$tokendata['id'].") AND users.position='Employe'";
			$query = "SELECT COUNT(*) AS pending from finances WHERE (report_date IS NULL OR report_date='') AND mobile_data='1' AND valuatation_by=".$comp_id['id'];
			$result['pending']=$exe->getsinglequery($query1); 
			
			 $query1="SELECT COUNT(*) AS approve from finances JOIN users ON finances.refenence_no LIKE CONCAT(users.employe_id, '%') WHERE finances.photo IS NOT NULL AND finances.fair_amount='0' AND finances.mobile_data='1' AND users.company_name=(SELECT company_name FROM users WHERE users.id=".$tokendata['id'].") AND users.position='Employe'";
			 $query = "SELECT COUNT(*) AS approve from finances WHERE photo IS NOT NULL AND fair_amount='0' AND mobile_data='1' AND valuatation_by=".$comp_id['id'];
			$result['approve']=$exe->getsinglequery($query1); 
			
			 $query1="SELECT COUNT(*) AS complete from finances JOIN users ON finances.refenence_no LIKE CONCAT(users.employe_id, '%') WHERE finances.photo IS NOT NULL AND finances.fair_amount >0 AND finances.mobile_data='1' AND users.company_name=(SELECT company_name FROM users WHERE users.id=".$tokendata['id'].") AND users.position='Employe'";
			 $query = "SELECT COUNT(*) AS complete from finances WHERE photo IS NOT NULL AND fair_amount >0 AND mobile_data='1' AND valuatation_by=".$comp_id['id'];
			$result['complete']=$exe->getsinglequery($query1);
				
			
			$query1 = "SELECT COUNT(*) AS pending from finances JOIN users ON finances.refenence_no LIKE CONCAT(users.employe_id, '%') WHERE finances.mobile_data='1' AND (finances.report_date IS NULL OR finances.report_date='') AND  DATE(finances.created)='".date('Y-m-d',strtotime($time))."' AND users.company_name=(SELECT company_name FROM users WHERE users.id=".$tokendata['id'].") AND users.position='Employe'";
	
			  $query = "SELECT COUNT(*) AS pending from finances  WHERE mobile_data='1' AND (report_date IS NULL OR report_date='') AND  DATE(created)='".date('Y-m-d',strtotime($time))."' AND valuatation_by=".$comp_id['id'];
			$result['daily']['pending']=$exe->getsinglequery($query1);

	
		$query1 = "SELECT COUNT(*) AS daily_complate from finances JOIN users ON finances.refenence_no LIKE CONCAT(users.employe_id, '%') WHERE finances.mobile_data='1' AND finances.photo IS NOT NULL AND finances.fair_amount >0 AND  DATE(finances.created)='".date('Y-m-d',strtotime($time))."' AND users.company_name=(SELECT company_name FROM users WHERE users.id=".$tokendata['id'].") AND users.position='Employe'";
	
			  $query = "SELECT COUNT(*) AS daily_complate from finances WHERE mobile_data='1' AND DATE(created)='".date('Y-m-d',strtotime($time))."' and photo IS NOT NULL AND fair_amount >0 AND valuatation_by=".$comp_id['id'];
			$result['daily']['complete']=$exe->getsinglequery($query1);

		$query1 = "SELECT COUNT(*) AS pending from finances JOIN users ON finances.refenence_no LIKE CONCAT(users.employe_id, '%') WHERE finances.mobile_data='1' AND (finances.report_date IS NULL OR finances.report_date='') AND  MONTH(finances.created)='".date('m',strtotime($time))."' AND YEAR(finances.created) = '".date('Y',strtotime($time))."' AND users.company_name=(SELECT company_name FROM users WHERE users.id=".$tokendata['id'].") AND users.position='Employe'";
	
			  $query = "SELECT COUNT(*) AS pending from finances WHERE mobile_data='1' AND (report_date IS NULL OR report_date='') AND MONTH(created)='".date('m',strtotime($time))."' AND YEAR(created) = '".date('Y',strtotime($time))."' AND valuatation_by=".$comp_id['id'];
			$result['month']['month_pending']=$exe->getsinglequery($query1);
		
	$query1 = "SELECT COUNT(*) AS month_complate from finances JOIN users ON finances.refenence_no LIKE CONCAT(users.employe_id, '%') WHERE finances.mobile_data='1' AND  finances.photo IS NOT NULL AND finances.fair_amount >0 AND  MONTH(finances.created)='".date('m',strtotime($time))."' AND YEAR(finances.created) = '".date('Y',strtotime($time))."' AND users.company_name=(SELECT company_name FROM users WHERE users.id=".$tokendata['id'].") AND users.position='Employe'";
	
			  $query = "SELECT COUNT(*) AS month_complate from finances WHERE mobile_data='1' AND MONTH(created)='".date('m',strtotime($time))."' AND YEAR(created) = '".date('Y',strtotime($time))."'  AND  photo IS NOT NULL AND fair_amount >0 AND valuatation_by=".$comp_id['id'];
	
			$result['month']['month_complate']=$exe->getsinglequery($query1);
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
if($_SERVER['REQUEST_METHOD']=="OPTION")
{
	$query = "SELECT id,name FROM users where POSITION = 'Employe' and status='Active' and company_name=(SELECT company_name FROM users WHERE users.id=".$tokendata['id'].")";
			$result=$exe->getallquerydata($query);
			if($result){
				$temp=$result;
		 		$error= "Sucssfully";
			    $status = true;
			    $code   = "200";
			}else{
				$error="Nodata Found";
			}
	echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code));
}
?>