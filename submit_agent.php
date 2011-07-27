<?
include_once("includes/global_vars.php");

if (isset($_POST['agent'])){
    $agent_name = $_POST['agent']; 
    add_agent($agent_name);
}


function add_agent($a){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    /* check connection */
    if (mysqli_connect_errno()) {
        //printf("Connect failed: %s\n", mysqli_connect_error());
        print("<?xml version='1.0' encoding='utf-8' ?><!DOCTYPE response SYSTEM 'response.dtd' [<!ENTITY eacute '&#233;'><!ENTITY agrave '&#224;'>]><response success='0' msg='Erreur de connexion &agrave; la base de donn&eacute;es'></response>");
        exit();
    }
  
    $query = "INSERT INTO `mc`.`agents` (`agent`) VALUES ('$a')";
    $mysqli->query($query);
    $mysqli->close();
     
    //print $query;
}

?>