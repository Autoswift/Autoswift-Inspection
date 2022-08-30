<?php
ini_set('display_errors', 1);
include_once("validation.php"); 
$valid = new validation();
include_once("excute.php");
$exe = new Crud();
$msg 	   = "";
$status     = false;
$error      = "";
$code       = "401";
$temp       = array();
define("url","https://www.arvindampro.in/");
date_default_timezone_set('asia/kolkata');
$time = date("Y-m-d H:i:s");
/*$date = new DateTime($time);
		$date->setTimezone(new DateTimeZone('Asia/Kolkata'));
		$date->format("Y-m-d H:i:s");*/
?>