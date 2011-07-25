<?
include_once("includes/global_vars.php");

if (isset($_POST['txt_login'])){
    $login = $_POST['txt_login'];
    $password = $_POST['txt_password'];
    
    login($login,$password);
}

function login($l, $p){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    /* check connection */
    if (mysqli_connect_errno()) {
        //printf("Connect failed: %s\n", mysqli_connect_error());
        print("<?xml version='1.0' encoding='utf-8' ?><!DOCTYPE response SYSTEM 'response.dtd' [<!ENTITY eacute '&#233;'><!ENTITY agrave '&#224;'>]><response success='0' msg='Erreur de connexion &agrave; la base de donn&eacute;es'></response>");
        exit();
    }
  
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