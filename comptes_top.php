<?
session_start();
include_once("includes/global_vars.php");

if($_POST['submit']=='1'){
    $login = $_POST['txt_login'];
    $password = $_POST['txt_password'];
    $active = $_POST['active'];
    submit($login,$password,$active);
    }

function submit($login,$password,$active){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $query = "INSERT INTO `mc`.`users` (`id_user`, `login`, `password`, `datetime`, `type`, `active`) VALUES (NULL, '$login', '$password', CURRENT_TIMESTAMP, '0', '$active')";
    $mysqli->query($query);
    $mysqli->close();
}

?>