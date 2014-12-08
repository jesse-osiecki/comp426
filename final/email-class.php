<?php
include_once 'auth-class.php';
include_once 'db.php';

class emailclass{
    private $id, $uid, $to, $from, $cc, $time, $message;

    private function __construct($id, $uid, $from, $to, $cc, $time, $message){
        $this->id = $id;
        $this->uid = $uid;
        $this->to = $to;
        $this->from = $from;
        $this->cc = $cc;
        $this->time = $time;
        $this->message = $message;
    }

    public function getID() {
        return $this->id;
    }
    public function getUID() {
        return $this->uid;
    }
    public function getTO() {
        return $this->to;
    }
    public function getFrom() {
        return $this->from;
    }
    public function getCC() {
        return $this->cc;
    }
    public function getTime() {
        return $this->time;
    }
    public function getBody() {
        return $this->message;
    }

    public function setTO($to) {
        $this->to = $to;
        return $this->update();
    }
    public function setFrom($from) {
        $this->from = $from;
        return $this->update();
    }
    public function setCC($cc) {
        $this->cc = $cc;
        return $this->update();
    }
    public function setTime($time) {
        $this->time = $time;
        return $this->update();
    }
    public function setBody($body) {
        $this->message = $body;
        return $this->update();
    }
    
    private function update() {
        global $db;

        $result = $db->query("update email set " .
            "title=" .
            "'" . $mysqli->real_escape_string($this->title) . "', " .
            "note=" .
            "'" . $mysqli->real_escape_string($this->note) . "', " .
            "project=" .
            "'" . $mysqli->real_escape_string($this->project) . "', " .
            "due_date=" . $dstr . ", " .
            "priority=" . $this->priority . ", " .
            "complete=" . $cstr . 
            " where id=" . $this->id);
        return $result;
    }

    public static function _create_email($email_from, $email_to, $email_cc, $scheduled, $message) {
        global $db;
        $authclass = new userauth();
        //sanitize inputs
        $email_to = $db->escape($email_to);
        $email_from = $db->escape($email_from);
        $email_cc = $db->escape($email_cc);
        $scheduled = strtotime($db->escape($scheduled)); //to unix time stamp
        $uid = get_user_id();
        $message = $db->escape($message);
        //insert into db
        $query = $db->query("INSERT INTO email (uid, email_from, email_to, email_cc, scheduledtime, messagebody) VALUES ('$uid', '$email_from', '$email_to', '$email_cc', '$scheduled', '$message'");
        //make sure that the entry made it into the sql    
        if ($query) {
            $id = $db->insert_id;
            return new emailclass($id, $uid, $email_from, $email_to, $email_cc, $scheduled, $message);
        }
        return null;
    }


    public static function _get_email_by_id($id){
        global $db;
        $authclass = new userauth();
        $id = $db->escape($id);
        $user = $_SESSION['user_login'];
        $uid = $authclass->get_user_id();
        if($uid != -1){
            $query = $db->get_row("select * from email where id='$id' and uid='$uid'");
            if ($query->num_rows == 0) {
                return null;
            }
            $email_info = $query->fetch_array();
            return new emailclass(
                intval($email_info['id']),
                intval($email_info['uid']),
                $email_info['email_from'],
                $email_info['email_to'],
                $email_info['email_cc'],
                $email_info['scheduledtime'],
                $email_info['messagebody']
            );
        }
        return null;
    }
    public static function _getAllIDs() {
        global $db;
        $authclass = new userauth();
        $uid = $authclass->get_user_id();
        $query = $db->get_results("select * from email where uid='$uid'");
        $id_array = array();

        if ($query) {
            foreach($query as $next_key=>$next_row) {
                $id_array[] = intval($next_row['id']);
            }
        }
        return $id_array;
    }
}
