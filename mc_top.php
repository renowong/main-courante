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




function checkmcexist($today){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    /* check connection */
    if (mysqli_connect_errno()) {
        //printf("Connect failed: %s\n", mysqli_connect_error());
        print("<?xml version='1.0' encoding='utf-8' ?><!DOCTYPE response SYSTEM 'response.dtd' [<!ENTITY eacute '&#233;'><!ENTITY agrave '&#224;'>]><response success='0' msg='Erreur de connexion &agrave; la base de donn&eacute;es'></response>");
        exit();
    }
    
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
    /* check connection */
    if (mysqli_connect_errno()) {
        //printf("Connect failed: %s\n", mysqli_connect_error());
        print("<?xml version='1.0' encoding='utf-8' ?><!DOCTYPE response SYSTEM 'response.dtd' [<!ENTITY eacute '&#233;'><!ENTITY agrave '&#224;'>]><response success='0' msg='Erreur de connexion &agrave; la base de donn&eacute;es'></response>");
        exit();
    }
    
    $query = "INSERT INTO `mc`.`mc` (`date`) VALUES ('$today')";
    $mysqli->query($query);
    $lastid = $mysqli->insert_id;
    $mysqli->close();
    
    return $lastid;
}

function getmcdate($id){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    /* check connection */
    if (mysqli_connect_errno()) {
        //printf("Connect failed: %s\n", mysqli_connect_error());
        print("<?xml version='1.0' encoding='utf-8' ?><!DOCTYPE response SYSTEM 'response.dtd' [<!ENTITY eacute '&#233;'><!ENTITY agrave '&#224;'>]><response success='0' msg='Erreur de connexion &agrave; la base de donn&eacute;es'></response>");
        exit();
    }
    
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