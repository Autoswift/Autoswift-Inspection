<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="POST")
{ 
  $data=$_POST;
    $fields=array("email_id",'address','user_id');
    $error = $valid->check_empty($data,$fields);
      if(!$error){
         unset($data['mobile_number']);
        $error = $valid->is_email_valid($data['email_id']);
        if(!$error){
          if($_FILES)
            {
              foreach ($_FILES as $key => $value)
              {
                 $filename=md5($value['name'].$data['user_id'].$time.(uniqid(rand(), true)));
                 $imageFileType = strtolower(pathinfo($value  ["name"],PATHINFO_EXTENSION));
                 $target_file = "../uploads/document/".$filename.'.'.$imageFileType;
                 if(move_uploaded_file($_FILES[$key]["tmp_name"],$target_file)){
                   $data[$key]= $filename.'.'.$imageFileType;
                 }

              }
            } 
          $user_id=$data['user_id'];
          unset($data['user_id']);
          $data['status']='Pending';
        
          $result=$exe->update('users',$data,'id',$user_id);  
          if(isset($result)&& $result=="true"){
                    $temp['id']= $user_id;
                    $error= "Sucssfully";
                    $status = true;
                    $code   = "200";
          }
        }
      }   
echo json_encode(array("data"=>$data,"message" => $error,"success" => $status,"code" => $code));   
}

?>