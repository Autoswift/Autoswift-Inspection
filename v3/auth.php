<?php
include_once("src/defalt.php");
$sql="select photo,company_name From users where id=".$tokendata['id'];
$result=$exe->getsinglequery($sql);
$tokendata['photo']=$result['photo'];
$tokendata['company_name']=$result['company_name'];
unset($tokendata['id']); 
echo json_encode($tokendata);
?>