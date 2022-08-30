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
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$uri_segments = explode('/', $uri_path);
	if(isset($uri_segments[5])&&isset($uri_segments[6])){
		$fname= $uri_segments[5];
		$parameter= $uri_segments[6];
		$isverify=$crud->tokenverify($parameter);
		if(isset($isverify->data)){
    		$email=$isverify->data->email;
    		$sql="Update users set email_verify=1 where email_id='".$email."'";
    		$result=$crud->execute($sql);
    		if($result){
    			$error= "Sucssfully";
                $status = true;
                $code   = "200";
    		}
    		}else{
    			$error = str_replace('token','Link',$isverify);		
    	}
	}
}
echo json_encode(array("data"=>$temp,"message" => $error,"status" => $status,"code" => $code));
function sendmail($data)
{   
    $dir = dirname(__FILE__);
    $emailfile = file_get_contents('F:/xampp/htdocs/namoapi/api/src/email_varification_link.html');
    $str=str_replace("[email&#160;protected]","".$data['email_id']."",$emailfile);
    $str=str_replace("Smiles Davis","".$data['username']."",$str);
    $str=str_replace("verifylink","http://localhost/namoapi/api/auth/email_verify.php/email/".$data['token']."",$str);
    $mail = new PHPMailer(true);
    try {
        //Server settings
        //$mail->SMTPDebug = 2;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'nikunj@serverwala.org';                     // SMTP username
        $mail->Password   = 'archna@2019N';                               // SMTP password
        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 587;                                    // TCP 
        $mail->setFrom('info@naughtyspy.net', 'Naughtyspy');
        $mail->addAddress($data['email_id'],'User');     // Add a recipient
        //$mail->addAddress('Naughtyspy');               // Name is optional
        $mail->addReplyTo('info@naughtyspy.net', 'Information');
      /*  $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');*/
        // Attachments
       // Optional name
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Naughtyspy Login Credential';
        $mail->Body    = ''.$str.'';
        $mail->AltBody = '';

        $mail->send();
        return true; 
    } catch (Exception $e) {
       return false; 
    }

}   
?>	