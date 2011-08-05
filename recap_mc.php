<?php
include_once("includes/global_vars.php");


$id_mc = $_GET['id'];

    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    
    $response = "<table border='1'><tr><th width='50'>Date/Heure</th><th width='50'>Type</th><th>D&eacute;signation</th><th width='50'>Agent</th><th width='50'>Actions</th><th width='50'>Mise à jour le</th></tr>";
    
    $query = "SELECT `mcd`.`id_mcd`, `mcd`.`datetime`, `mcd`.`designation`, `mcd`.`update`, (SELECT `users`.`login` FROM `users` WHERE `users`.`id_user` = `mcd`.`id_agent`) AS `login_agent`, `type`.`code`, `type`.`type` FROM `mcd` JOIN `type` ON `mcd`.`id_type` = `type`.`id_type` WHERE `mcd`.`id_mc` = '$id_mc' AND `active` = '1' ORDER BY `datetime` ASC";
    if ($result = $mysqli->query($query)) {
        while($row = $result->fetch_assoc()){
            $formatted_designation = str_replace(array("\r\n", "\r", "\n"), '<br/>', trim($row["designation"]));
            $response .= "<tr id='".$row["id_mcd"]."'><td>".$row["datetime"]."</td><td>".$row["code"]." - ".$row["type"]."</td><td>".$formatted_designation."</td><td>".$row["login_agent"]."</td><td style='text-align:center;'><a href='javascript:del_mc(\"".$row["id_mcd"]."\")'>X</a></td><td>".$row["update"]."</td></tr>";
        }
        $result->free();
    }
    $mysqli->close();
    
    $response .= "</table>";
    print $response;    
    


?>