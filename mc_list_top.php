<?php
include_once("includes/global_vars.php");


    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    /* check connection */
    if (mysqli_connect_errno()) {
        //printf("Connect failed: %s\n", mysqli_connect_error());
        print("<?xml version='1.0' encoding='utf-8' ?><!DOCTYPE response SYSTEM 'response.dtd' [<!ENTITY eacute '&#233;'><!ENTITY agrave '&#224;'>]><response success='0' msg='Erreur de connexion &agrave; la base de donn&eacute;es'></response>");
        exit();
    }
    
    $listmc = "<table border='1'><tr><td>Date</td><td>Actions</td></tr>";
    
    $query = "SELECT `mc`.`id_mc`,`mc`.`date` FROM `mc` ORDER BY `date` DESC LIMIT 7";
    if ($result = $mysqli->query($query)) {
        while($row = $result->fetch_assoc()){
            $listmc .= "<tr><td><a href='javascript:showmcd(".$row["id_mc"].");'>".$row["date"]."</a></td><td><a href='mc.php?edit=".$row["id_mc"]."'>Editer</a></td></tr>";
        }
        $result->free();
    }
    $mysqli->close();
    
    $listmc .= "</table>";

    


?>