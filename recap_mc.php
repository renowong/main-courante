<?php
include_once("includes/global_vars.php");


$id_mc = $_GET['id'];
$show_action = $_GET['action'];

    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    
    $response = "<table border='1' width='95%'><tr><th>Date/Heure</th><th>Type</th><th>D&eacute;signation</th><th>Agent</th><th>Actions</th><th width='100'>Mise à jour le</th></tr>";
    
    $query = "SELECT `mcd`.`id_mcd`, DATE_FORMAT(`mcd`.`datetime`, '%e-%m-%Y, %H:%i') as format_date, `mcd`.`designation`, DATE_FORMAT(`mcd`.`update`, '%e-%m-%Y, %H:%i') as format_update, (SELECT `users`.`login` FROM `users` WHERE `users`.`id_user` = `mcd`.`id_agent`) AS `login_agent`, `type`.`code`, `type`.`type` FROM `mcd` JOIN `type` ON `mcd`.`id_type` = `type`.`id_type` WHERE `mcd`.`id_mc` = '$id_mc' AND `active` = '1' ORDER BY `datetime` ASC";
    if ($result = $mysqli->query($query)) {
        while($row = $result->fetch_assoc()){
            $formatted_designation = str_replace(array("\r\n", "\r", "\n"), '<br/>', trim($row["designation"]));
            if($show_action){$action = "<a href='javascript:del_mc(\"".$row["id_mcd"]."\")'><img class='imgtrash' src='img/trash.png'></a>";}
            $response .= "<tr id='".$row["id_mcd"]."'><td>".$row["format_date"]."</td><td>".$row["code"]." - ".$row["type"]."</td><td>".$formatted_designation."</td><td>".$row["login_agent"]."</td><td style='text-align:center;'>$action</td><td>".$row["format_update"]."</td></tr>";
        }
        $result->free();
    }
    $mysqli->close();
    
    $response .= "</table>";
    print $response;    
    


?>