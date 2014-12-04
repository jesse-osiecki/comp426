<?php
# I owe credit to http://www.intechgrity.com/login-logout-and-administrate-using-php-session-cookie-mysql-version-2-with-remember-me-option/#
$dbuser = 'db_user';
$dbname = 'db_name';
$dbpassword = 'db_password';
$dbhost = 'localhost';
 
require_once 'php/ez_sql_core.php';
require_once 'php/ez_sql_mysql.php';
global $db;
$db = new ezSQL_mysql($dbuser, $dbpassword, $dbname, $dbhost);
