<?
include_once("includes/global_vars.php");


/*
updates are :
1 - mc
2 - equipe
3 - chef
4 - adjoint
5 - agents
6 - conges
7 - malades
8 - absents
*/

$update = $_POST["update"];
$horaire = $_POST["txt_horaire"];
$type = $_POST["slt_inter"];
$designation = htmlentities ($_POST["txt_designation"],ENT_QUOTES,'UTF-8');
$idmc = $_POST["idmc"];
$date = $_POST["datej"];
$id_agent = $_POST["id_agent"];

if($update=='1'){save_mc($horaire,$type,$designation,$idmc,$date,$id_agent);}
if($update=='2'){save_agents($id_agent,'equipe',$idmc);}
if($update=='3'){save_agents($id_agent,'chef',$idmc);}
if($update=='4'){save_agents($id_agent,'adjoint',$idmc);}
if($update=='5'){save_agents($id_agent,'agents',$idmc);}
if($update=='-5'){del_agents($id_agent,'agents',$idmc);}



function del_agents($val,$col,$idmc){
    $existing_val = get_list($idmc,$col);
    $ar_val = explode(",",$existing_val);
    $key = array_search($val,$ar_val);
    unset($ar_val[$key]);
    foreach($ar_val as $v){
        $list .= $v.",";
    }
    $list = substr($list,0,-1);
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);   
    $query = "UPDATE `mc` SET `$col` = '$list' WHERE `id_mc` = '$idmc'";
    $mysqli->query($query);
}

function save_agents($val,$col,$idmc){
    $existing_val = get_list($idmc,$col);
    if($existing_val!==""){
        $ar_val = explode(",",$existing_val);
        if(in_array($val,$ar_val)){return false;}
        $val=$existing_val.",".$val;
    }
    
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);   
    $query = "UPDATE `mc` SET `$col` = '$val' WHERE `id_mc` = '$idmc'";
    $mysqli->query($query);
    
    $affected_r = $mysqli->affected_rows;
   
    $mysqli->close();
    print $query;
    if($affected_r>0){
        print("<?xml version='1.0' encoding='utf-8' ?><!DOCTYPE response SYSTEM 'response.dtd' [<!ENTITY eacute '&#233;'><!ENTITY agrave '&#224;'>]><response success='1' msg='Mise &agrave; jour r&eacute;ussie'></response>");
    }else{
        print("<?xml version='1.0' encoding='utf-8' ?><!DOCTYPE response SYSTEM 'response.dtd' [<!ENTITY eacute '&#233;'><!ENTITY agrave '&#224;'>]><response success='0' msg='Erreur de connexion &agrave; la base de donn&eacute;es'></response>"); 
    }
}

function get_list($id,$col){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $query = "SELECT `$col` FROM `mc` WHERE `id_mc`='$id'";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
        $output = $row[$col];
    $result->free();
    $mysqli->close();
    
    return $output;
}

function save_mc($horaire,$type,$designation,$idmc,$date,$id_agent){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);   
    $query = "INSERT INTO `mc`.`mcd` (`id_mc`, `id_type`, `id_agent`, `datetime`, `designation`, `update`) VALUES ('$idmc', '$type', '$id_agent', '$date $horaire', '$designation', CURRENT_TIMESTAMP)";
    $mysqli->query($query);
    
    $affected_r = $mysqli->affected_rows;
   
    $mysqli->close();
    //print $query;
    if($affected_r>0){
        print("<?xml version='1.0' encoding='utf-8' ?><!DOCTYPE response SYSTEM 'response.dtd' [<!ENTITY eacute '&#233;'><!ENTITY agrave '&#224;'>]><response success='1' msg='Mise &agrave; jour r&eacute;ussie'></response>");
    }else{
        print("<?xml version='1.0' encoding='utf-8' ?><!DOCTYPE response SYSTEM 'response.dtd' [<!ENTITY eacute '&#233;'><!ENTITY agrave '&#224;'>]><response success='0' msg='Erreur de connexion &agrave; la base de donn&eacute;es'></response>"); 
    }
}
?>