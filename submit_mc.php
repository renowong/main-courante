<?
include_once("includes/global_vars.php");


/*
updates are :
1 - MC
2 - Equipe
3 - Chef Equipe
4 - Adjoint
5 - Agents
6 - Conges
7 - Malades
8 - Absents
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

function save_agents($val,$col,$idmc){
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