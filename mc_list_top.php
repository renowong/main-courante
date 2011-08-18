<?php
session_start();
include_once("includes/global_vars.php");
include_once("includes/global_functions.php");

if(isset($_GET['date'])){
    $searchdate = "WHERE `date` <= '".rev_date($_GET['date'])."'";
}

    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    
    $today = (date("Y-m-d"));
    $yesterday  = date ("Y-m-d", mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));
    
    $listmc = "<table><tr><th>Date</th><th>Actions</th></tr>";
    
    $query = "SELECT `mc`.`id_mc`,`mc`.`date` FROM `mc` $searchdate ORDER BY `date` DESC LIMIT 7";
    if ($result = $mysqli->query($query)) {
        while($row = $result->fetch_assoc()){
            if($row["date"]==$today || $row["date"]==$yesterday || $_SESSION['usertype']=='1'){$editlink="<a href='javascript:redirect2mc(".$row["id_mc"].")'>Editer</a>";}else{$editlink="";}
            $listmc .= "<tr><td><a href='javascript:showmcd(".$row["id_mc"].");'>".rev_date($row["date"])."</a></td><td>$editlink</td></tr>";
        }
        $result->free();
    }
    $mysqli->close();
    
    $listmc .= "</table>";

    //print $query;


?>