<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{	
	
		$data=$_GET;
		$result=[];
		if($data){
				if(!empty($data['page_id'])){
				 $results_per_page =50;
				 $sql = "SELECT COUNT(ID) AS total FROM users"; 
				 $row=$exe->getsinglequery($sql);
				 $result['total_page']=$total_pages = ceil($row["total"] / $results_per_page);
				 settype($_GET['page_id'], "integer");
				 $result['page']=$_GET['page_id'];
				 $result['size']=$results_per_page;
				 $start_from = (($_GET['page_id'])-1) * $results_per_page;
				 $sql = "SELECT * FROM companies ORDER BY ID ASC LIMIT $start_from, ".$results_per_page;
				 $result['data']=$exe->getallquerydata($sql); 
				}else{
					foreach ($data as $key => $value)
					{
			            $whereArr[] = "$key = {$value}";
			        }
					$whereStr = implode(" AND ", $whereArr);
					$query = "Select * from companies WHERE $whereStr";
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
if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$data=$_POST;
	$result=[];
	if($data){
		$data=$exe->escape_stringdata($data);
		if(!empty($_POST['comp_id'])){
			$data['modified']=$time;
			unset($data['comp_id']);
			$result=$exe->update('companies',$data,'id',$_POST['comp_id']);
			print_r($result);
			if($result=="true"){
				$temp['ref_id']=$_POST['comp_id'];
				$error= "Sucssfully";
			    $status = true;
			    $code   = "200";	
			}else{
				$error=$result;
			}
		}else{
			$data['created']=$time;
			$result=$exe->insert($data,'companies');
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
?>