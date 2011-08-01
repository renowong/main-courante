<?
include_once("includes/global_vars.php");

if (isset($_POST['txt_login'])){
    $login = $_POST['txt_login'];
    $password = $_POST['txt_password'];
    
    login($login,$password);
}

function login($l, $p){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
  
    $query = "SELECT `id_user` FROM `users` WHERE `login` = '$l' AND `password` = '$p'";
    if ($result = $mysqli->query($query)) {
        $num_rows = $result->num_rows;
        if ($num_rows>0){$clear=true;}
        }
    $result->free();
    $mysqli->close();
     
    if($clear){
        header('Location: mc_list.php'); 
    }
}

?>