<?

include_once("includes/global_vars.php");

print get_agents();


function get_agents(){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
  
    $query = "SELECT `agents`.`agent`, `equipes`.`designation` FROM `agents` INNER JOIN `equipes` ON `agents`.`equipe` = `equipes`.`id_equipe` ORDER BY `agent` ASC";
    $output ="<table>";
    if ($result = $mysqli->query($query)) {
        while($row = $result->fetch_assoc()){
            $output .= "<tr><td>".$row['agent']."</td><td>".$row['designation']."</td></tr>";
        }
    }
    $result->free();
    $mysqli->close();
     
    $output .="</table>";
    return $output;
}

?>