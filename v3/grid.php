<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{		
		if(!empty($_GET['grid_id'])){
			$sql="select * From grid where id=".$_GET['grid_id'];
		}else{
			$sql="select * From grid ORDER by vehicle_make DESC,vehicle_model DESC,variant DESC,year DESC";
		}
		$result=$exe->getallquerydata($sql);
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
if($_SERVER['REQUEST_METHOD']=="POST")
{	

	$data=$_POST;
	$error=$valid->check_empty($data,array('vehicle_make','vehicle_model','variant','chassis_no','year','cost'));
	if(!$error){
		$data=$exe->escape_stringdata($data);
			if(!$error){
					
					if(!empty($_POST['grid_id'])){
					$data['created']=$time;
					unset($data['grid_id']);
					$result=$exe->update('grid',$data,'id',$_POST['grid_id']);
						if($result=="true"){
							$temp['ref_id']=$_POST['grid_id'];
							$error= "Update Sucssfully";
						    $status = true;
						    $code   = "200";	
						}else{
							$error=$result;
						}
					}else{
						$data['created']=$time;
						unset($data['grid_id']);
						$result=$exe->insert($data,'grid');
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

	}
	echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code)); 
}
if($_SERVER['REQUEST_METHOD']=="PUT")
{		
	$data  = json_decode(file_get_contents("php://input"), true);
		$oldvalue=$data['old_value'];
		unset($data['old_value']);
	  	$keys   = array();
        $values = array();
        foreach ($data as $key => $column) {
           
            $keys   = "`{$key}`";
            $values = "'{$column}'";
            $updates[] = "$keys = $values";
        }
        $implodeArray = implode(', ', $updates);
      	$query  = "update grid set ".$implodeArray." Where ".$keys."='".$oldvalue."'";
		$result=$exe->execute($query);
		if($result=="true"){
			$error= "Sucssfully";
		    $status = true;
		    $code   = "200";
		}else{
			$error=$result;
		}
	echo json_encode(array("result"=>$result,"message" => $error,"status" => $status,"code" => $code)); 
}
if($_SERVER['REQUEST_METHOD']=="OPTIONS")
{	
	$data  = json_decode(file_get_contents("php://input"), true);
	if($data){
		$whereStr="";
		$data['filter']=array_filter($data['filter']);
		if($data['filter']){
			foreach ($data['filter'] as $key => $value)
					{
			            $whereArr[] = "$key = '{$value}'";
			        }
			$whereStr = implode(" AND ", $whereArr);
			$query = "Select * from grid WHERE $whereStr ORDER by vehicle_make DESC,vehicle_model DESC,variant DESC,year DESC";
		}else{
			$query="select * From grid ORDER by vehicle_make DESC,vehicle_model DESC,variant DESC,year DESC";
		}
		$temp['record']=$exe->getallquerydata($query);
		if($data['action']=='vehicle_make'){
			$sql="select vehicle_model From grid where $whereStr group by vehicle_model";
			$temp['vehicle_model']=$exe->getallquerydata($sql);
		}
		else if($data['action']=='vehicle_model'){
			$sql="select variant From grid where $whereStr group by variant";
			$temp['variant']=$exe->getallquerydata($sql);
		}
		else if($data['action']=='variant'){
			$sql="select year From grid where $whereStr group by year";
			$temp['year']=$exe->getallquerydata($sql);
		}else{
			$sql="select vehicle_make From grid group by vehicle_make";
			$temp['vehicle_make']=$exe->getallquerydata($sql);
		}
		
	}
	echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code)); 
}
if($_SERVER['REQUEST_METHOD']=="DELETE")
{	
	$data  = json_decode(file_get_contents("php://input"), true);
	if(!empty($data['grid_id'])){
		$result=$exe->delete($data['grid_id'],'grid');
		if($result=="true"){
			$temp['ref_id']=$result['grid_id'];
			$error= "Sucssfully";
		    $status = true;
		    $code   = "200";
		}else{
			$error=$result;
		}
	}else{
		$error="Missing Parameters";
	}
	echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code)); 
}
if($_SERVER['REQUEST_METHOD']=="VIEW")
{	
	$data  = json_decode(file_get_contents("php://input"), true);
	if($data){
		$action=$data['action'];
		unset($data['action']);
		$data=array_filter($data);
			foreach ($data as $key => $value)
					{
			            $whereArr[] = "$key = '{$value}'";
			        }
		$whereStr = implode(" AND ", $whereArr);
		if($action=='vehicle_make'){
			$sql="select vehicle_model From grid where $whereStr group by vehicle_model";
			$temp=$exe->getallquerydata($sql);
		}
		else if($action=='vehicle_model'){
			$sql="select variant From grid where $whereStr group by variant";
			$temp=$exe->getallquerydata($sql);
		}
		else if($action=='variant'){
			$sql="select year From grid where $whereStr group by year";
			$temp=$exe->getallquerydata($sql);
		}
	 }else{
			$sql="select vehicle_make From grid group by vehicle_make";
			$temp=$exe->getallquerydata($sql);
		}
	$error= "Sucssfully";
		$status = true;
		$code   = "200";
	echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code)); 
}
?>	