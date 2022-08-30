<?php
include_once("src/defalt.php");
unset($tokendata['id']);
echo json_encode($tokendata);
?>