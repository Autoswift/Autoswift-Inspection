<?php
	include_once("src/defalt.php");
	if($_SERVER['REQUEST_METHOD']=="POST")
	{		$data=$_POST;
			$result=[];
			if($data){
				$repo='';
				if(!empty($data['report_id'])){
					$repo="And id!=".$data['report_id'];
				}
				unset($data['report_id']);
				if(!empty($data['view_id'])){
				   $query="select finances.*,valuations.name AS valuationsname,declerations.name AS declerations,staff.sort_name AS staff  From finances 
					left join valuations on finances.valuatation_by=valuations.id
					LEFT JOIN declerations  ON declerations.id= finances.notice 
					LEFT JOIN staff ON staff.name= finances.staff_name
					where finances.id=".$data['view_id'];
				  $result=$exe->getsinglequery($query); 
				}else{
					foreach ($data as $key => $value)
					{
			            $whereArr[] = "$key = {$value}";
			        }
					$whereStr = implode(" AND ", $whereArr);
					$query = "Select * from finances WHERE  $whereStr $repo";
					$result=$exe->getallquerydata($query);	
				}		
				if($result){
					$temp=$result;
			 		$error= "Sucssfully";
				    $status = true;
				    $code   = "200";
				}else{
					$error="Nodata Found";
				}
			}else{
				$error="Missing Parameters";
			}
			
		echo json_encode(array("result"=>$result,"message" => $error,"status" => $status,"code" => $code)); 
	}

	?>