<?
include_once("includes/global_vars.php");

if (isset($_POST['type'])){
    switch($_POST['type']){
        case 'radiation':
            $id = $_POST['id'];
            radier_agent($id);
        break;   
        case 'ajout':
            $agent_name = $_POST['agent'];
            $equipe = $_POST['equipe'];
            add_agent($agent_name,$equipe);
        break;
    }
    
}

function radier_agent($id){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
 
    $query = "UPDATE `mc`.`agents` SET `radie` = '1' WHERE `id_agent` = '$id'";
    $mysqli->query($query);
    $mysqli->close();
}

function add_agent($a,$e){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
 
    $query = "INSERT INTO `mc`.`agents` (`agent`,`equipe`) VALUES ('$a','$e')";
    $mysqli->query($query);
    $mysqli->close();
     
    //print $query;
}

?>