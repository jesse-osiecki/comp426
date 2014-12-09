<?php
include_once 'db.php';
global $db;

$now = time(); //get current unix time

$query = $db->get_results("select * from email where scheduledtime<='$now'");
//echo(json_encode($query));
foreach($query as $key=>$row){
    echo(json_encode($row) . "\n");
}
?>
