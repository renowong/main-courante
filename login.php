<?
//session_destroy();
session_start();
include_once("includes/global_vars.php");
//header('Content-type: text/json');

if (isset($_POST['login'])){
    $login = $_POST['login'];
    $password = $_POST['password'];
    
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
            $type = $row["type"];
            $id_user = $row["id_user"];
        }
    }
    $result->free();
    $mysqli->close();
     
    if($clear){
        print '{"autorise":"True"}';
    } else {
        print '{"autorise":"False"}';
    }
}

?>