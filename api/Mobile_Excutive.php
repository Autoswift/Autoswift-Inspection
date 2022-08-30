<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{ 
      if(!empty($_GET['user_id'])){
           $query = "SELECT  position  FROM users where id=".$_GET['user_id'];
            $res=$exe->getsinglequery($query);
            if($res['position']=='Admin'){
                $query = "SELECT  * FROM (Select company_name from users WHERE  id=".$_GET['user_id']." AND POSITION='Admin') as comp,users WHERE comp.company_name=users.company_name AND users.position='Employe' order by id desc "; 
            }else{
                $query = "Select * from users WHERE position='Employe' and status='Active' OR status='Inactive' order by id desc";    
            }
      }    
      $result=$exe->getallquerydata($query); 
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
if($_SERVER['REQUEST_METHOD']=="POST")
{ 
  $data = $_POST;
  $error = $valid->check_empty($data, array("position","name","username","password","employe_id","mobile_number","user_ref"));
  if(!$error){
      $data=$exe->escape_stringdata($data);
      $error =$valid->validate_phone_number($data['mobile_number']);
      if(!$error){ 
        $data['created']=$time; 
        $data['status']='Requested';
        $data['pass1']=$data['password'];
        $data['password']=md5($data['password']);
        $result=$exe->insert($data,'users');
        if(isset($result['id'])){
          $temp['ref_id']=$result['id'];
          $error= "Successful";
            $status = true;
            $code   = "200";  
        }else{
          $error=$result;
        }
    }
  }
  echo json_encode(array("data"=>$temp,"message" => $error,"success" => $status,"code" => $code)); 
}
?>
