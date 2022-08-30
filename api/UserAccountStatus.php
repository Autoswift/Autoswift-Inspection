<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="POST")
{ 
  $data = $_POST;
  $error = $valid->check_empty($data, array("user_id"));
  if(!$error){
    $result=$exe->getsingledata('users','id',$data['user_id']);
    $sql="SELECT COUNT(*) AS notification from notification WHERE status=0 and user_id =".$data['user_id'];
    $not=$exe->getsinglequery($sql);
    if($result){
      $temp['id']=$result['id'];
	  $temp['profile_name']=$result['profile_name'];
	  $temp['name']=$result['name'];
	  $temp['employe_id']=$result['employe_id'];
	  $temp['position']=$result['position'];
	  $temp['firebase_id']=$result['firebase_id'];
	  $temp['employe_id']=$result['employe_id'];
	  $temp['ref_start']=$result['ref_start'];
	  $temp['notification']=$not['notification'];
      unset($data['user_id']);
      if(!empty($data['firebase_id'])){
         $res=$exe->update('users',$data,'id',$result['id']);
      }
      if($result['status'] == 'Active' ){
        $temp['user_status']=0;
        $temp['message']="Account Active";
      }
      if($result['status'] == 'Inactive' ){
        $temp['user_status']=1;
        $temp['message']="Account Inactive";
      }
      if($result['status'] == 'Requested' ){
        $temp['user_status']=3;
        $temp['message']="User Data Required";
      }
      if($result['status'] == 'Pending' ){
        $temp['user_status']=2;
         $temp['message']="Account Not Appoved Yet";
      }
      if($result['status'] == 'Rejected' ){
        $temp['user_status']=4;
        $temp['message']="Please Register Again";
      }
    }
     $status = true;
     $code   = "200";
     $error ="success";
  }
  echo json_encode(array("data"=>$temp,"message" => $error,"success" => $status,"code" => $code)); 
}
?>