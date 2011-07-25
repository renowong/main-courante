<?php
include_once("includes/global_vars.php");


    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    /* check connection */
    if (mysqli_connect_errno()) {
        //printf("Connect failed: %s\n", mysqli_connect_error());
        print("<?xml version='1.0' encoding='utf-8' ?><!DOCTYPE response SYSTEM 'response.dtd' [<!ENTITY eacute '&#233;'><!ENTITY agrave '&#224;'>]><response success='0' msg='Erreur de connexion &agrave; la base de donn&eacute;es'></response>");
        exit();
    }
    
    $response = "<table border='1'><tr><td>Date/Heure</td><td>Type</td><td>D&eacute;signation</td><td>Agent</td></tr>";
    
    $query = "SELECT `mcd`.`datetime`, `mcd`.`designation`, `mcd`.`id_agent`, `type`.`code`, `type`.`type` FROM `mcd` INNER JOIN `type` ON `mcd`.`id_type` = `type`.`id_type` ORDER BY `datetime` ASC";
    if ($result = $mysqli->query($query)) {
        while($row = $result->fetch_assoc()){
            $response .= "<tr><td>".$row["datetime"]."</td><td>".$row["code"]." - ".$row["type"]."</td><td>".$row["designation"]."</td><td>".$row["id_agent"]."</td></tr>";
        }
        $result->free();
    }
    $mysqli->close();
    
    $response .= "</table>";
    print $response;    
    


?>