
<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{	
			$requestData=$_REQUEST;
			$result=[];
			$totalData =0;
			$totalFiltered=0;
			$data=$_GET;
		    $sear='';
			if(!empty($data['search']['value'])){
				$data['search']['value'];
				$sql="SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='admin_arvindam' AND `TABLE_NAME`='finances'";
				$srt=$exe->getallquerydata($sql);
				$search=[];
				foreach ($srt as $key => $value)
				{	
					 $key=$value['COLUMN_NAME'];
					 $val=$data['search']['value']."%";
					 $search[] = "finances."."$key Like '$val'";			
		        }	
		         $sear='And  '.implode(" OR ",$search);
			}
			if(isset($data['filterdata'])){
					$filterdata=array_filter($data['filterdata']);
					if(!empty($filterdata['mobile_data'])){
						$ismobile='and finances.report_date IS NULL';
						$asds='ORDER BY finances.ID DESC';
					}else{
					    $ismobile='and report_date IS NOT NULL';
					    $asds='ORDER BY finances.ID DESC';
					}
					$amount='';
					if(!empty($filterdata['amount_from']) AND !empty($filterdata['amount_to']))
					{
					   $amount="AND finances.total_amount BETWEEN '".$filterdata['amount_from']."' AND '".$filterdata['amount_to']."'";
					}
					$created='';
					if(!empty($filterdata['create_date']) AND !empty($filterdata['create_end']))
					{	
					   	$created="AND DATE(finances.created) BETWEEN '".date("Y-m-d",strtotime($filterdata['create_date']))."' AND '".date("Y-m-d",strtotime($filterdata['create_end']))."'";
						$asds='ORDER BY finances.report_date asc';
					}
					$report_date="";
					if(!empty($filterdata['s_date']) AND !empty($filterdata['e_date']))
					{	
						$s_date= strtotime($filterdata['s_date']);
						$e_date= strtotime($filterdata['e_date']);
					   	$report_date="AND finances.report_date BETWEEN '".$s_date."' AND '".$e_date."'";
						$asds='ORDER BY finances.report_date asc';
					}
					$user='';
					if(!empty($filterdata['user']) && $tokendata['position']!='SuperAdmin'){
							$user='And finances.user_id='.$tokendata['id'];
					}
					$valuation='';
					if(!empty($filterdata['valuatation_by'])){
							$valuation="And finances.valuatation_by=".$filterdata['valuatation_by'];
							unset($filterdata['valuatation_by']);	
					}			
					$search_on='';
					if(!empty($filterdata['search_on'])){
						switch ($filterdata['search_on']) {
                            case "1":
                                $search_on='And finances.remaining_amount>=1';
                                break;
                            case "2":
                               $search_on='And finances.remaining_amount=0';
                                break;
                            case "3":
                                $search_on='And finances.amount > 0';
                                break;
                            case "4":
                                $search_on="AND (finances.amount IS NULL OR finances.amount='')";
                                break;
							case "5":
                                $search_on="And finances.fair_amount=0";
                                break;	
                        }
					}
					unset($filterdata['search_on']);	
					unset($filterdata['user']);	
					unset($filterdata['amount_from']);
					unset($filterdata['amount_to']);
					unset($filterdata['create_date']);
					unset($filterdata['create_end']);
					unset($filterdata['s_date']);
					unset($filterdata['e_date']);
					$whereArr=[];
					foreach ($filterdata as $key => $value)
					{
			             $whereArr[] ='finances.'.$key.' Like "%'.$value.'%"';
			        }
					$whereStr = implode(" AND ", $whereArr);
					 $query = "SELECT finances.*,valuations.name FROM finances left JOIN valuations ON valuations.id = finances.valuatation_by WHERE $whereStr $search_on $user $ismobile $valuation $amount $created $report_date $sear $asds LIMIT ".$requestData['start']." ,".$requestData['length'];
					
					 $result=$exe->getallquerydata($query);
					 $sql = "SELECT COUNT(ID) AS total FROM finances WHERE $whereStr $user $ismobile $valuation $search_on $amount $created $report_date $sear "; 
					 $row=$exe->getsinglequery($sql);
					 $totalData=$row['total'];
					 $totalFiltered=$row['total'];	 
				}else{
					$sql="SELECT finances.*,valuations.name FROM finances left JOIN valuations ON valuations.id = finances.valuatation_by where finances.id IS NOT NULL $sear ORDER BY finances.ID DESC  LIMIT ".$requestData['start']." ,".$requestData['length'];
					 $result=$exe->getallquerydata($sql); 
					 $sql = "SELECT COUNT(ID) AS total FROM finances where finances.id IS NOT NULL $sear"; 
					 $row=$exe->getsinglequery($sql);
					 $totalData=$row['total'];
					 $totalFiltered=$row['total'];
				}
				if($result){
						$i=$requestData['start'];
						foreach ($result as $key => $value) {
							if(!empty($result[$key]['report_date'])){
							  $result[$key]['report_date']=date('d-m-Y', (int)$value['report_date']);  
							}else{
								$result[$key]['report_date']='';
							}
							$i++;
							$result[$key]['srno']=$i;
			 			}
			 		$temp = $result;	
					}
			
		$json_data = array(
	    "draw"            => intval($requestData['draw']),
	    "recordsTotal"    => intval($totalData),
	    "recordsFiltered" => intval($totalFiltered),
	    "data"            => $temp
	);	
		echo json_encode($json_data); 
}
if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$data=$_POST;
	$result=[];
	if($data){

		$data=$exe->escape_stringdata($data);
		if(!empty($_POST['report_id'])){
			$data['updated']=$time;
			unset($data['report_id']);
			$result=$exe->update('finances',$data,'id',$_POST['report_id']);
			if($result==true){
				$temp['ref_id']=$_POST['report_id'];
				$error= "Sucssfully";
			    $status = true;
			    $code   = "200";	
			}else{
				$error=$result;
			}
		}else{
			$data['created']=$time;
			$result=$exe->insert($data,'finances');
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
	if($tokendata['position']=='SuperAdmin'){
	  if(!empty($data['report_id'])){
		$result=$exe->delete($data['report_id'],'finances');
		if($result=="true"){
			$temp['ref_id']=$data['report_id'];
			$error= "Sucssfully";
		    $status = true;
		    $code   = "200";
		}else{
			$error=$result;
		}
		}else{
			$error="Missing Parameters";
		}	
	}else{
		$error="Your Not authorize to delete";
	}
	echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code)); 
}
?>