<?
include_once("includes/global_vars.php");

$horaire = $_POST["txt_horaire"];
$type = $_POST["slt_inter"];
$designation = htmlentities ($_POST["txt_designation"],ENT_QUOTES,'UTF-8');
$idmc = $_POST["idmc"];
$date = $_POST["datej"];
$id_agent = 1;

//print $designation;

$mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);

/* check connection */
    if (mysqli_connect_errno()) {
        //printf("Connect failed: %s\n", mysqli_connect_error());
        print("<?xml version='1.0' encoding='utf-8' ?><!DOCTYPE response SYSTEM 'response.dtd' [<!ENTITY eacute '&#233;'><!ENTITY agrave '&#224;'>]><response success='0' msg='Erreur de connexion &agrave; la base de donn&eacute;es'></response>");
        exit();
    }
    
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
?>