<?php
include_once 'db.php';
global $db;
$db->debug();

$now = time();

$query = $db->get_results("select * from email where scheduledtime<='$now'");
echo(json_encode($query));
?>
