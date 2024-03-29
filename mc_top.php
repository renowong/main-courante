<?php
//session_start();
include_once("includes/global_vars.php");
include_once("includes/global_functions.php");

//print "usertype : ".$_SESSION['usertype'];


$edit = $_GET['edit'];
if($edit==0){
    $lastmc_closed = checkclose_lastmc();
    $editid = checkmcexist(date("Y-m-d"));
    if($editid>0){
        $edit=$editid;
        header('Location:mc.php?edit='.$edit);
        ob_flush();
    }else{
        if($lastmc_closed=='1'){
            $edit = createmc(date("Y-m-d"));
            header('Location:mc.php?edit='.$edit);
            ob_flush();
        }else{
            
            header('Location:mc_list.php#notclosed');
            ob_flush(); 
            //print "test";
        }
        
    }
}

$sql_date = getmcdate($edit);
$date = rev_date($sql_date);
$time = date("H:i");

if($_COOKIE['usertype']!=='1'){checkrights($sql_date);}

function checkrights($sql_date){
    $today = (date("Y-m-d"));
    $yesterday  = date ("Y-m-d", mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));
    if($sql_date!==$today && $sql_date!==$yesterday){
        header('Location: mc_list.php');
    }
}

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

function checkclose_lastmc(){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $query = "SELECT `mc`.`closed` FROM `mc` WHERE `mc`.`id_mc`=(SELECT MAX(`mc`.`id_mc`) FROM `mc`)";
    
    if ($result = $mysqli->query($query)) {
        $row = $result->fetch_assoc();
        $closed = $row["closed"];
        $result->free();
    }
    $mysqli->close();
    
    return $closed;
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

function getdata($field,$id){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $query = "SELECT `$field` FROM `mc` WHERE `id_mc` = '$id'";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    $output = $row[$field];
    $mysqli->close();
    return $output;
}

?>