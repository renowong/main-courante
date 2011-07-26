<?php
include_once("includes/global_vars.php");


    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    /* check connection */
    if (mysqli_connect_errno()) {
        //printf("Connect failed: %s\n", mysqli_connect_error());
        print("<?xml version='1.0' encoding='utf-8' ?><!DOCTYPE response SYSTEM 'response.dtd' [<!ENTITY eacute '&#233;'><!ENTITY agrave '&#224;'>]><response success='0' msg='Erreur de connexion &agrave; la base de donn&eacute;es'></response>");
        exit();
    }
    
    $today = (date("Y-m-d"));
    $yesterday  = date ("Y-m-d", mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));
    
    $listmc = "<table border='1'><tr><td>Date</td><td>Actions</td></tr>";
    
    $query = "SELECT `mc`.`id_mc`,`mc`.`date` FROM `mc` ORDER BY `date` DESC LIMIT 7";
    if ($result = $mysqli->query($query)) {
        while($row = $result->fetch_assoc()){
            if($row["date"]==$today || $row["date"]==$yesterday){$editlink="<a href='javascript:redirect2mc(".$row["id_mc"].")'>Editer</a>";}else{$editlink="";}
            $listmc .= "<tr><td><a href='javascript:showmcd(".$row["id_mc"].");'>".$row["date"]."</a></td><td>$editlink</td></tr>";
        }
        $result->free();
    }
    $mysqli->close();
    
    $listmc .= "</table>";

    


?>