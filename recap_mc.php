<?php
include_once("includes/global_vars.php");


$id_mc = $_GET['id'];

    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    
    $response = "<table border='1'><tr><td>Date/Heure</td><td>Type</td><td>D&eacute;signation</td><td>Agent</td><td>Mise à jour le</td></tr>";
    
    $query = "SELECT `mcd`.`datetime`, `mcd`.`designation`, `mcd`.`update`, (SELECT `users`.`login` FROM `users` WHERE `users`.`id_user` = `mcd`.`id_agent`) AS `login_agent`, `type`.`code`, `type`.`type` FROM `mcd` JOIN `type` ON `mcd`.`id_type` = `type`.`id_type` WHERE `mcd`.`id_mc` = '$id_mc' ORDER BY `datetime` ASC";
    if ($result = $mysqli->query($query)) {
        while($row = $result->fetch_assoc()){
            $response .= "<tr><td>".$row["datetime"]."</td><td>".$row["code"]." - ".$row["type"]."</td><td>".$row["designation"]."</td><td>".$row["login_agent"]."</td><td>".$row["update"]."</td></tr>";
        }
        $result->free();
    }
    $mysqli->close();
    
    $response .= "</table>";
    print $response;    
    


?>