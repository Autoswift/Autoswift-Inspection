<?php
include_once("src/defalt.php");
if($_SERVER['REQUEST_METHOD']=="GET")
{	
		$sql='';
		$result='';
		if(!empty($_GET['user_id'])){
			$sql="select notification.*,DATE_FORMAT(DATE,'%d-%m-%Y') AS date,users.name as excutive_name,cities.city_name as area,valuations.name as company_name From notification,users,cities,valuations where valuations.id=notification.valuations_by AND 
					notification.user_id=users.id AND 
					cities.city_id=notification.area AND 
					notification.user_id=".$_GET['user_id']." Order By id Desc";
					$sql1="UPDATE notification set STATUS=1 where user_id=".$_GET['user_id'];
					$exe->execute($sql1);
			
		}else if(!empty($_GET['sender_id'])){
		   $sql1="select position From users where id=".$_GET['sender_id'];
		   $pos=$result=$exe->getsinglequery($sql1);
		   if($pos['position']=='SuperAdmin'){
		       $sql="select notification.*,DATE_FORMAT(DATE,'%d-%m-%Y') AS date,users.name as excutive_name,cities.city_name as area,valuations.name as company_name From notification,users,cities,valuations where valuations.id=notification.valuations_by AND 
					notification.user_id=users.id AND 
					cities.city_id=notification.area  order by id desc"; 
		   }else{
		     $sql="select notification.*,DATE_FORMAT(DATE,'%d-%m-%Y') AS date,users.name as excutive_name,cities.city_name as area,valuations.name as company_name From notification,users,cities,valuations where valuations.id=notification.valuations_by AND 
					notification.user_id=users.id AND 
					cities.city_id=notification.area AND 
					notification.sender_id=".$_GET['sender_id']." Order By id Desc";   
		   }
		}
		if($sql){
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
if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$data=$_POST;
	$error=$valid->check_empty($data,array('valuations_by','area','registration_no','make_model','party_name','mobile_no','place','user_id','sender_id'));
	if(!$error){
		$data=$exe->escape_stringdata($data);
		$error=$valid->validate_phone_number($data['mobile_no']);
			if(!$error){
					if(!empty($_POST['not_id'])){
					$data['date']=$time;
					unset($data['not_id']);
					$result=$exe->update('notification',$data,'id',$_POST['not_id']);
						if($result=="true"){
							$temp['ref_id']=$_POST['not_id'];
							$error= "Update Sucssfully";
						    $status = true;
						    $code   = "200";	
						}else{
							$error=$result;
						}
					}else{
						$data['date']=$time;
						unset($data['not_id']);
						$result=$exe->insert($data,'notification');
							if(isset($result['id'])){
							    $sql= "Select firebase_id From users where id=".$data['user_id'];
        						$fcm=$exe->getsinglequery($sql);
        						if(!empty($fcm['firebase_id'])){
        						  $responce=fcmnotification($fcm['firebase_id']);  
        						}
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
	echo json_encode(array("data"=>$temp,"message" => $error,"status" => $status,"code" => $code,"responce" => $responce)); 
}
function fcmnotification($token){
$title = "AutoSwift";
$body = "You have received a notification";
$notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
$arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
$data = json_encode($arrayToSend);
$url = 'https://fcm.googleapis.com/fcm/send';
$server_key = 'AAAAt7BVyrM:APA91bEsKXBsy0l7FNDs8t073Qfk2pxGvUBAHbdx7dy2erdXjeLgnywxLUqt2Yt1UshoY6WAgon05Yz3xSPfj2fv4K7syBuhjfiAymmUFQ3xw_erN0vwpLStlVEgNroVVe9o09jwaEO0';
$headers = array(
    'Content-Type:application/json',
    'Authorization:key='.$server_key
);
//CURL request to route notification to FCM connection server (provided by Google)
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$result = curl_exec($ch);
if ($result === FALSE) {
}
curl_close($ch);
return $result;
}
?>