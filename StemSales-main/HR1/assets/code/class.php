<?php
define('HOST', 'localhost');  
define('USER', 'root');  
define('PASS', '');  
define('DB', 'stemopp');  
class DB  
  
{  
    function dbcon() {  
        $con = mysql_connect(HOST, USER, PASS) or die('Connection Error! '.mysql_error());  
        mysql_select_db(DB, $con) or die('DB Connection Error: ->'.mysql_error());  
    }  
}  
  
class User  
  
{  
    public  
  
    function __construct() {  
        $db = new DB;  
    }  
  
    public  
  
    function register($trn_date, $name, $username, $email, $pass) {  
        $pass = md5($pass);  
        $checkuser = mysql_query("Select id from users where email='$email'");  
        $result = mysql_num_rows($checkuser);  
        if ($result == 0) {  
            $register = mysql_query("Insert into users (trn_date, name, username, email, password) values ('$trn_date','$name','$username','$email','$pass')") or die(mysql_error());  
            return $register;  
        } else {  
            return false;  
        }  
    }  
  
    public  
  
    function login($email, $pass) {  
        $pass = md5($pass);  
        $check = mysql_query("Select * from users where email='$email' and password='$pass'");  
        $data = mysql_fetch_array($check);  
        $result = mysql_num_rows($check);  
        if ($result == 1) {  
            $_SESSION['login'] = true;  
            $_SESSION['id'] = $data['id'];  
            return true;  
        } else {  
            return false;  
        }  
    }  
  
    public  
  
    function fullname($id) {  
        $result = mysql_query("Select * from users where id='$id'");  
        $row = mysql_fetch_array($result);  
        echo $row['name'];  
    }  
  
    public  
  
    function session() {  
        if (isset($_SESSION['login'])) {  
            return $_SESSION['login'];  
        }  
    }  
  
    public  
  
    function logout() {  
        $_SESSION['login'] = false;  
        session_destroy();  
    }  
}  
  
?>  