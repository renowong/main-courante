<?php
include_once("includes/global_vars.php");
include_once("includes/global_functions.php");

$edit = $_GET['edit'];
if($edit==0){
    $editid = checkmcexist(date("Y-m-d"));
    if($editid>0){$edit=$editid;}else{$edit = createmc(date("Y-m-d"));}
    }

$date = getmcdate($edit);
$date = rev_date($date);
$time = date("H:i");

function getexistingdata($id,$col){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $query = "SELECT `$col` FROM `mc` WHERE `id_mc` = '$id'";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    $output = $row[$col];
    $mysqli->close();
    return $output;    
}

function load_equipe($id){
    $val = getexistingdata($id,"slt_eq");

    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $query = "SELECT `designation`,`id_equipe` FROM `equipes` ORDER BY `designation`";
    $output = "<option value='0'>S&eacute;lectionner</option>";
    if ($result = $mysqli->query($query)) {
        while($row = $result->fetch_assoc()){
            if($row['id_equipe']==$val){$selected=" selected";}else{$selected="";}
            $output .= "<option value='".$row['id_equipe']."'$selected>".$row['designation']."</option>";
        }
        $result->free();
    }
    $mysqli->close();
    return $output;
}

function load_agents($id,$col){
    if($id!==NULL){$val = getexistingdata($id,$col);};
    
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $query = "SELECT `agent`,`id_agent` FROM `agents` ORDER BY `agent`";
    $output = "<option value='0'>S&eacute;lectionner</option>";
    if ($result = $mysqli->query($query)) {
        while($row = $result->fetch_assoc()){
            if($row['id_agent']==$val){$selected=" selected";}else{$selected="";}
            $output .= "<option value='".$row['id_agent']."'$selected>".$row['agent']."</option>";
        }
        $result->free();
    }
    $mysqli->close();
    
    return $output;
}

function checkmcexist($today){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $query = "SELECT `id_mc` FROM `mc` WHERE `mc`.`date` = '$today'";
    if ($result = $mysqli->query($query)) {
        $row = $result->fetch_assoc();
        $idexist = $row["id_mc"];
        $result->free();
    }
    $mysqli->close();
    
    return $idexist;
}

function createmc($today){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $query = "INSERT INTO `mc`.`mc` (`date`) VALUES ('$today')";
    $mysqli->query($query);
    $lastid = $mysqli->insert_id;
    $mysqli->close();
    
    return $lastid;
}

function getmcdate($id){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $query = "SELECT `mc`.`date` FROM `mc` WHERE `mc`.`id_mc` = '$id'";
    if ($result = $mysqli->query($query)) {
        $row = $result->fetch_assoc();
        $date = $row["date"];
        $result->free();
    }
    $mysqli->close();
    
    return $date;
}

?>