<?
include_once("includes/global_vars.php");

if (isset($_POST['agent'])){
    $agent_name = $_POST['agent'];
    $equipe = $_POST['equipe'];
    add_agent($agent_name,$equipe);
}


function add_agent($a,$e){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
 
    $query = "INSERT INTO `mc`.`agents` (`agent`,`equipe`) VALUES ('$a','$e')";
    $mysqli->query($query);
    $mysqli->close();
     
    //print $query;
}

?>