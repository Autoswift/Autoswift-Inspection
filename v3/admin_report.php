<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{	
	$data=$_GET;
	$requestData=$_REQUEST;	
	if($tokendata['position']=='Admin'){
		$where='';
		if(!empty($data['filterdata'])){
			switch ($data['filterdata']) {
			case 'Pending':
				$where=" And (finances.report_date IS NULL OR finances.report_date='')";
				break;
			case 'Approve':
				$where=" And  finances.photo IS NOT NULL AND fair_amount='0'";
				break;
			case 'Complete':
				$where=" and  finances.photo IS NOT NULL AND fair_amount >0 ";
				break;	
			default:
				$where='';
				break;
			}
		}
		$sear='';
		if(!empty($data['search']['value'])){
				
				$srt= array('finances.id','finances.financer_representative','finances.registration_no','finances.appliction_no');
				$search=[];
				foreach ($srt as $key => $value)
				{	
					 $key=$value;
					 $val="%".$data['search']['value']."%";
					 $search[] = "$key Like '$val'";			
		        }
		        $sear= 'and ('.implode(" OR ",$search).')';
			}
		         $query = "SELECT name,finances.* from finances JOIN users ON finances.refenence_no LIKE CONCAT(users.employe_id, '%')   
WHERE users.company_name=(SELECT company_name FROM users WHERE users.id=".$tokendata['id'].") AND users.position='Employe' $where $sear AND finances.mobile_data='1' GROUP BY finances.id desc LIMIT ".$requestData['start']." ,".$requestData['length']."";
		
		
			$result1=$exe->getallquerydata($query);
			  $sql = "SELECT COUNT(*) AS total FROM (SELECT finances.id from finances  JOIN users ON finances.refenence_no LIKE CONCAT(users.employe_id, '%') 
WHERE users.company_name=(SELECT company_name FROM users WHERE users.id=".$tokendata['id'].") AND users.position='Employe' $where $sear AND finances.mobile_data='1' GROUP BY finances.id DESC) AS total"; 
			 $row=$exe->getsinglequery($sql);
			 $totalData=$row['total'];
			 $totalFiltered=$row['total'];
			if($result1){
						$i=$requestData['start'];
						foreach ($result1 as $key => $value) {
							$i++;
							$result1[$key]['id']=$i;
							$result1[$key]['ids']=$value['id'];
							if(!empty($result1[$key]['report_date'])){
							  $result1[$key]['report_date']=date('d-m-Y', (int)$value['report_date']);  
							}else{
								$result1[$key]['report_date']='';
							}
			 			}
			 		$temp = $result1;	
					}
	}		
		
		$json_data = array(
	    "draw"            => intval($requestData['draw']),
	    "recordsTotal"    => intval($totalData),
	    "recordsFiltered" => intval($totalFiltered),
	    "data"            => $temp
	);	
		echo json_encode($json_data); 
}
if($_SERVER['REQUEST_METHOD']=="OPTION")
{
	  $query = "SELECT  COUNT(*) as count,Month(finances.created) as month FROM finances JOIN users ON finances.refenence_no LIKE CONCAT(users.employe_id, '%') WHERE YEAR(finances.created)='2020' AND mobile_data='1' and users.company_name=(SELECT company_name FROM users WHERE users.id=".$tokendata['id'].") AND users.position='Employe' GROUP BY DATE_FORMAT(finances.created, '%Y-%m')";
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