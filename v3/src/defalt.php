<?php
include_once("validation.php"); 
$valid = new validation();
$headers =  getallheaders();
$token = $valid->checktoken($headers);
include_once("excute.php");
$exe = new Crud($token);
$tokendata = (array)$exe->tokedata;
$msg 	   = "";
$status     = false;
$error      = "";
$code       = "401";
$temp       = array();
date_default_timezone_set('asia/kolkata');
$time = date("Y-m-d H:i:s");
/*$date = new DateTime($time);
		$date->setTimezone(new DateTimeZone('Asia/Kolkata'));
		$date->format("Y-m-d H:i:s");*/
?>