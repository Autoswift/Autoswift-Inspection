<?php
include_once("auth.php");
include_once("../src/Validation.php");
$crud       = new auth();
$validation = new Validation();
$status     = false;
$error      = "";
$code       = "401";
$temp       =array();
$time = gmdate("Y-m-d H:i:s");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data  = json_decode(file_get_contents("php://input"), true);
    $error = $validation->check_empty($data, array(
        "username",
        'email_id',
        'password'
    ));
    if (!$error) {
        $data=$crud->escape_stringdata($data);
        $error = $validation->is_email_valid($data['email_id']);
        if ($error == "true") {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            $data['create_date']=$time;
            $result = $crud->insert($data, 'users');
            if(isset($result['id'])) {
                $temp['ref_id'] =$result['id'];
                $error= "Sucssfully Insert";
                $status = true;
                $code   = "200";
            } else {
       		if(strpos($result,"'username'")==true){
       			$error= "UserName Alredy Exit";
       		}else if(strpos($result,"'email_id'")==true){
			     $error= "Email Alredy Exit";
			}else{
					$error = $result;	
				 }
            }
        }
    }
echo json_encode(array("data"=>$temp,"message" => $error,"status" => $status,"code" => $code));
}else{
	http_response_code(400);
}
?>