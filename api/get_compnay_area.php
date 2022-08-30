<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{     
      if(!empty($_GET['comp_id'])){
         $sql="SELECT  cities.city_state from valuations INNER JOIN users ON users.company_name=valuations.name 
INNER JOIN cities ON users.area=cities.city_name
 WHERE valuations.id=".$_GET['comp_id']." GROUP BY  cities.city_state";
        $result=$exe->getallquerydata($sql); 
      }else if(!empty($_GET['state_id']) && !empty($_GET['cp_id'])){
        $sql="SELECT  cities.city_name,cities.city_id from valuations INNER JOIN users ON users.company_name=valuations.name INNER JOIN cities ON users.area=cities.city_name WHERE valuations.id=".$_GET['cp_id']." AND cities.city_state='".$_GET['state_id']."' GROUP BY  cities.city_name";
         $result=$exe->getallquerydata($sql); 
      }
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
?>