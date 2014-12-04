<?php
#thanks http://www.intechgrity.com/login-logout-and-administrate-using-php-session-cookie-mysql-version-2-with-remember-me-option/# 
#
class userauth {
 
    /**
     * Holds the script directory absolute path
     * @staticvar
     */
    static $abs_path;
 
    /**
     * Store the sanitized and slash escaped value of post variables
     * @var array
     */
    var $post = array();
 
    /**
     * Stores the sanitized and decoded value of get variables
     * @var array
     */
    var $get = array();
 
    public function __construct() {
        session_start();
    
        //store the absolute script directory
        //note that this is not the admin directory
        self::$abs_path = dirname(dirname(__FILE__));
    
        //initialize the post variable
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->post = $_POST;
            if(get_magic_quotes_gpc ()) {
                //get rid of magic quotes and slashes if present
                array_walk_recursive($this->post, array($this, 'stripslash_gpc'));
            }
        }
    
        //initialize the get variable
        $this->get = $_GET;
        //decode the url
        array_walk_recursive($this->get, array($this, 'urldecode'));
    }


    private function _check_db_user_pass($username, $password) {
        global $db;
        $user_row = $db->get_row("SELECT * FROM `user` WHERE `username`='" . $db->escape($username) . "'");
    
        //general return
        if(is_object($user_row) && md5($user_row->password) == $password)
            return true;

        //maybe they entered an email instead
        $user_row = $db->get_row("SELECT * FROM `user` WHERE `email`='" . $db->escape($username) . "'");
    
        //general return
        if(is_object($user_row) && md5($user_row->password) == $password)
            return true;
        else
            return false;
    }

    public function _login_action() {
    
        //insufficient data provided
        if(!isset($this->post['username']) || $this->post['username'] == '' || !isset($this->post['password']) || $this->post['password'] == '') {
            header ("location: login.php");
        }
    
        //get the username and password
        $username = $this->post['username'];
        $password = md5(sha1($this->post['password']));
    
        //check the database for username
        if($this->_check_db_user_pass($username, $password)) {
            //ready to login
            $_SESSION['user_login'] = $username;
    
            //check to see if remember, ie if cookie
            if(isset($this->post['remember'])) {
                //set the cookies for 1 day, ie, 1*24*60*60 secs
                //change it to something like 30*24*60*60 to remember user for 30 days
                setcookie('username', $username, time() + 1*24*60*60);
                setcookie('password', $password, time() + 1*24*60*60);
            } else {
                //destroy any previously set cookie
                setcookie('username', '', time() - 1*24*60*60);
                setcookie('password', '', time() - 1*24*60*60);
            }
    
            header("location: index.php");
        }
        else {
            header ("location: login.php");
        }
    
        die();
    }

    public function _authenticate() {
        //first check whether session is set or not
        if(!isset($_SESSION['user_login'])) {
            //check the cookie
            if(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
                //cookie found, is it really someone from the
                if($this->_check_db_user_pass($_COOKIE['username'], $_COOKIE['password'])) {
                    $_SESSION['user_login'] = $_COOKIE['username'];
                    header("location: index.php");
                    die();
                }
                else {
                    header("location: login.php");
                    die();
                }
            }
            else {
                header("location: login.php");
                die();
            }
        }
    }
    private function stripslash_gpc(&$value) {
        $value = stripslashes($value);
    }
 
    /**
     * htmlspecialcarfy
     * Encodes string's special html characters
     * @access protected
     * @param string $value
     */
    private function htmlspecialcarfy(&$value) {
        $value = htmlspecialchars($value);
    }
 
    /**
     * URL Decode
     * Decodes a URL Encoded string
     * @access protected
     * @param string $value
     */
    protected function urldecode(&$value) {
        $value = urldecode($value);
    }
    /**
     * Sample function to return the nicename of currently logged in admin
     * @global ezSQL_mysql $db
     * @return string The nice name of the user
     */
    public function get_nicename() {
        $username = $_SESSION['user_login'];
        global $db;
        $info = $db->get_row("SELECT `nicename` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
        if(is_object($info))
            return $info->nicename;
        else
            return '';
    }
 
    /**
     * Sample function to return the email of currently logged in admin user
     * @global ezSQL_mysql $db
     * @return string The email of the user
     */
    public function get_email() {
        $username = $_SESSION['user_login'];
        global $db;
        $info = $db->get_row("SELECT `email` FROM `user` WHERE `username` = '" . $db->escape($username) . "'");
        if(is_object($info))
            return $info->email;
        else
            return '';
    }
}