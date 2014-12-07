<?php
include_once 'auth-class.php';
include_once 'db.php';

class emailclass{

    var $authclass;
    var $get;
    var $post;
    public function __construct() {
        $authclass = new userauth();
        $get = $authclass->get;
        $post = $authclass->post;
    }

    private function _create_email($username, $email_to, $email_from, $email_cc, $scheduled, $message) {
        global $db;
        //sanitize inputs
        $email_to = $db->escape($email_to);
        $email_from = $db->escape($email_from);
        $email_cc = $db->escape($email_cc);
        $scheduled = $db->escape($scheduled); //to unix time stamp
        $uid = get_user_id(db->escape($username));
        //insert into db
        $query = $db->query("INSERT INTO email (uid, email_from, email_to, email_cc, scheduledtime, messagebody) VALUES ('$uid', '$email_from', '$email_to', '$email_cc', UNIX_TIMESTAMP('$scheduled')");
        //make sure that the entry made it into the sql
        return $query;
    }

    private function _delete_email_by_id($id){
        global $db;
        $id = $db->escape($id);
        $user = $_SESSION['user_login'];
        $uid = $authclass->get_user_id($user);
        if($uid != -1){
            $query = $db->query("delete from email where id='$id' and uid='$uid'");
            return $query;
        }
        else{
            return -1;
        }
    }

    private function _list_emails(){
        global $db;
        $user = $_SESSION['user_login'];
        $uid = $authclass->get_user_id($user);
        if($uid != -1){
            $query = $db->get_row("select * from email where uid='$uid'");
            return $query;
        }
        else{
            return -1;
        }
    }
}
