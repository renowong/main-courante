<?
include_once("includes/global_vars.php");

if (isset($_POST['agent'])){
    $agent_name = $_POST['agent']; 
    add_agent($agent_name);
}


function add_agent($a){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
 
    $query = "INSERT INTO `mc`.`agents` (`agent`) VALUES ('$a')";
    $mysqli->query($query);
    $mysqli->close();
     
    //print $query;
}

?>