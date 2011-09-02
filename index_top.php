<?
session_destroy();
session_start();
include_once("includes/global_vars.php");

if (isset($_POST['txt_login'])){
    $login = $_POST['txt_login'];
    $password = $_POST['txt_password'];
    
    login($login,$password);
}

function login($l, $p){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
  
    $query = "SELECT `id_user`,`login`, `type` FROM `users` WHERE `login` = '$l' AND `password` = '".md5($p)."' AND `active` = '1'";
    if ($result = $mysqli->query($query)) {
        $num_rows = $result->num_rows;
        if ($num_rows>0){
            $clear=true;
            $row = $result->fetch_assoc();
            $_SESSION['usertype'] = $row["type"];
            $_SESSION['id_user'] = $row["id_user"];
        }
    }
    $result->free();
    $mysqli->close();
     
    if($clear){
        header('Location: mc_list.php'); 
    }
}

?>