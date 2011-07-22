<?php
include_once("includes/global_vars.php");

$date = date("d/m/Y");
$time = date("H:i");

function loadmcj(){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    /* check connection */
    if (mysqli_connect_errno()) {
        //printf("Connect failed: %s\n", mysqli_connect_error());
        print("<?xml version='1.0' encoding='utf-8' ?><!DOCTYPE response SYSTEM 'response.dtd' [<!ENTITY eacute '&#233;'><!ENTITY agrave '&#224;'>]><response success='0' msg='Erreur de connexion &agrave; la base de donn&eacute;es'></response>");
        exit();
    }
    
    $query = "SELECT * FROM `mc`";
    if ($result = $mysqli->query($query)) {
        while($row = $result->fetch_assoc()){
            $response .= "<tr><td>".$row["id_type"]."</td><td>".$row["datetime"]."</td><td>".$row["designation"]."</td><td>".$row["id_agent"]."</td></tr>";
        }
        $result->free();
    }
    $mysqli->close();
    return $response;    
    
}

?>