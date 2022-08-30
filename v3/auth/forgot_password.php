<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';
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
    $error = $validation->check_empty($data,array('ref_id'));
    if(!$error){
        $data=$crud->escape_stringdata($data);
        $id=$data['ref_id'];
        $sql="select * From users where email_id='".$id."' Or user_id='".$id."'";
        $result=$crud->checkdata($sql);
        if($result){
            $data['email_id']=$result['email_id'];
            $data['username']=$result['username'];
            $token=$crud->emailvarification($data); 
            $data['token']=$token;
            $mail=sendmail($data);
            if($mail){
                $error= "Sucssfully";
                $status = true;
                $code   = "200";
            }else{
                $error= "Somthin Wrong Contact Admin";
            }
        }else{
              $error= "Not associte With Us";
        }
    }
}
?>