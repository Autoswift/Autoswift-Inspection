<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{     
      if(!empty($_GET['state'])){
        $sql="select city_state,city_id from cities group by city_state order by id desc";
        $result=$exe->getallquerydata($sql);
      }else if(!empty($_GET['city'])){
        $sql="select city_name,city_id from cities";
        $result=$exe->getallquerydata($sql);
      }else if(!empty($_GET['state_name'])){
        $sql="select * from cities WHERE  city_state=(SELECT city_state AS state_name FROM cities WHERE city_id=".$_GET['state_name'].")";
        $result=$exe->getallquerydata($sql);
      }else if(!empty($_GET['state_id'])){
        $sql="select city_state FROM  cities WHERE city_id=".$_GET['state_id'];
        $result=$exe->getsinglequery($sql);
      }
      else{
        $sql="select city_state,city_id from cities group by city_state";
        $result['state']=$exe->getallquerydata($sql);
       /* $sql="select city_name,city_id from cities limit 10";
        $result['city']=$exe->getallquerydata($sql);*/
      }
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
  $error=$valid->check_empty($data,array('city_name'));
  if(!$error){
    if($data['state']=='New' && !empty($data['newstate'])){
        $data1['city_name']=$data['city_name'];
        $data1['city_state']=$data['newstate'];
    }
    if(!empty($data['state']) && $data['state']!='New'){
        $data1['city_name']=$data['city_name'];
        $data1['city_state']=$data['state'];
    }
    if($data1){
       $sql="Select * FROM cities where city_name='".$data['city_name']."'";
        $result=$exe->getsinglequery($sql);
        if($result){
           $error="City Already Exists";
        }else{
           $result=$exe->insert($data1,'cities');
           if(isset($result['id'])){
                $temp['ref_id']=$result['id'];
                $error= "Sucssfully";
                  $status = true;
                  $code   = "200";  
            }else{
              $error=$result;   
            }
        }
    }else{
       $error="Somthing Wrong";   
    }
  }
  echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code)); 
}
if($_SERVER['REQUEST_METHOD']=="PUT")
{ 
    $data  = json_decode(file_get_contents("php://input"), true);
    $error=$valid->check_empty($data,array('id'));
    if(!$error){
        if(!empty($data['new_state'])){
          $sql="SELECT city_state AS state_name FROM cities WHERE city_id=".$data['id'];
          $result=$exe->getsinglequery($sql);
          if(!empty($result['state_name'])){
            $sql="Update cities SET city_state='".$data['new_state']."' Where city_state='".$result['state_name']."'";
          }
        }
        if(!empty($data['new_city'])){
          $sql="Update cities SET city_name='".$data['new_city']."' Where city_id=".$data['id'];
        } 
       if($sql){
         $res=$exe->execute($sql);
            if($res=="true"){
              $temp['ref_id']=$data['id'];
              $error= "Sucssfully Updated";
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
  if(!empty($data['delstate'])){
    $sql="SELECT city_state AS state_name FROM cities WHERE city_id=".$data['delstate'];
    $result=$exe->getsinglequery($sql);
    if(!empty($result['state_name'])){
      $sql="DELETE FROM cities where city_state='".$result['state_name']  ."'";
      $result=$exe->execute($sql);
      if($result=="true"){
        $temp['ref_id']=$data['delstate'];
        $error= "Sucssfully Deleted";
          $status = true;
          $code   = "200";
      }else{
        $error=$result;
      }
    }
  }
  if(!empty($data['delcity'])){
    $sql="DELETE FROM cities where  city_id=".$data['delcity'];
    $result=$exe->execute($sql);
    if($result=="true"){
      $temp['ref_id']=$data['delcity'];
      $error= "Sucssfully Deleted";
        $status = true;
        $code   = "200";
    }else{
      $error=$result;
    }
  }
  echo json_encode(array("result"=>$temp,"message" => $error,"status" => $status,"code" => $code)); 
}
?>