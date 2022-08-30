<?php 
class Validation 
{
    public function check_empty($data, $fields)
    {
        $msg = null;
        foreach ($fields as $value) {
            if (empty($data[$value])) {
                $msg.= "$value field empty <br />";
            }
        } 
        return $msg;
    }
    public function check_isset($data, $fields)
    {   
        $msg = null;
        foreach ($fields as $value) {
            if (!isset($data[$value])) {
                $msg .= "$value Not Set <br />";
            }
        } 
        return $msg;
    }
    public function check_extrafields($data, $fields){
        $msg = null;
        $result=array_diff(array_flip($data),$fields);
        if($result){
            foreach ($result as $value) {
                $msg .= "$value extra filed Not allow <br />";
            } 
        }
        return $msg;
    }
    public function is_number($data, $fields)
    {
        $msg = null;
        foreach ($fields as $value) {
            if (!preg_match("/^[0-9]+$/", $data[$value])) {    
                $msg .= "$value allow numeric value only <br />";
            } 
        }
        return $msg;
    }
    
    public function is_email_valid($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {    
            return true;  
        }
        return "Invalid Email";
    }
    public function password_valid($password){
        $x=array( "options"=> array( "regexp" => "/^[a-zA-Z0-9_\]\[?\/<~#`!@$%^&*()+=}|:\";\',>{ -]\S{7,20}$/"));
        $msg="Password field required alphanumeric character between 8 to 20";
        if(filter_var($password,FILTER_VALIDATE_REGEXP,$x)){
              $msg =null;
        }
        return $msg;
    }
    public function validate_phone_number($phone)
    {
      $msg =null;
     $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
     $phone_to_check = str_replace("-", "", $filtered_phone_number);
        if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 13) {
           $msg = "Mobile Number Invalid"; 
         } 
           return $msg;
    }
    public function escape_string($value)
    {
        return $this->conn->real_escape_string(trim($value));
    }
    public function checktoken($headers)
    {
        $token= "X-Api-Key";
        $error = $this->check_empty($headers, array('X-Api-Key'));
        if(!$error){
            return $headers['X-Api-Key'];     
        }else{ return $token; }
    }
  
}
?>