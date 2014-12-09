<?php
include_once 'db.php';
global $db;
$now = time(); //get current unix time

$query = $db->get_results("select * from email where scheduledtime<='$now'");
foreach($query as $key=>$row){
    $to = $row->email_to;
    $subject = 'F.E.E.R Reminder Email'; //This is a defacto subject.... I forgot to add a subject variable everywhere else
    $message = $row->messagebody;
    $headers = 'From: ' . $row->email_from . "\r\n";
    $headers = (strlen($row->email_cc) > 1) ? ($headers . 'Cc: ' . $row->email_cc . "\r\n") : $headers;
    $headers .= 'Reply-To: ' . $row->email_from . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    $mail = mail($to, $subject, $message, $headers);
    echo $mail ? "true " : "false ";
    echo($row->id . "\n");
}
?>
