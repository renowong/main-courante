<?

include_once("includes/global_vars.php");

print get_agents();


function get_agents(){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
  
    $query = "SELECT `agents`.`id_agent`, `agents`.`agent`, `equipes`.`designation` FROM `agents` INNER JOIN `equipes` ON `agents`.`equipe` = `equipes`.`id_equipe` WHERE `agents`.`radie` = '0' ORDER BY `agent` ASC";
    $output ="<table><th>Agent</th><th>Equipe</th><th>Action</th>";
    if ($result = $mysqli->query($query)) {
        while($row = $result->fetch_assoc()){
            $output .= "<tr id='".$row['id_agent']."'><td>".$row['agent']."</td><td>".$row['designation']."</td><td><a href='javascript:radier(\"".$row['id_agent']."\")'><img class='imgtrash' src='img/trash.png'> Radier</a></td></tr>";
        }
    }
    $result->free();
    $mysqli->close();
     
    $output .="</table>";
    return $output;
}

?>