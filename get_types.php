<?php
include_once("includes/global_vars.php");

$code = $_POST["code"];

$mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);

/* check connection */
    if (mysqli_connect_errno()) {
        //printf("Connect failed: %s\n", mysqli_connect_error());
        print("<?xml version='1.0' encoding='utf-8' ?><!DOCTYPE response SYSTEM 'response.dtd' [<!ENTITY eacute '&#233;'><!ENTITY agrave '&#224;'>]></response>");
        exit();
    }
    
    $response = "<?xml version='1.0' encoding='utf-8' ?><!DOCTYPE response SYSTEM 'response.dtd' [<!ENTITY eacute '&#233;'><!ENTITY agrave '&#224;'>]>";
    $response .= "<response>";
    $query = "SELECT * FROM `type` WHERE `code`='$code'"; 
    if ($result = $mysqli->query($query)) {
    
    while($row = $result->fetch_assoc()){
        $response .= "<type id=".$row["id_type"].">".$row["type"]."</type>";
    }
    $result->free();
    }
    
    $mysqli->close();
    $response .= "</response>";
    print $response;
    //print $query;
?>