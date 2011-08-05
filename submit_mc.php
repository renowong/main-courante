<?
session_start();
include_once("includes/global_vars.php");

/*
 $update type
 1 - save_mc
 2 - save_agents
 3 - save_info
 4 - del_mc
*/

$list = $_POST["list"];
$col = $_POST["col"];
$update = $_POST["update"];
$horaire = $_POST["txt_horaire"];
$type = $_POST["slt_inter"];
$designation = htmlentities ($_POST["txt_designation"],ENT_QUOTES,'UTF-8');
$idmc = $_POST["idmc"];
$date = $_POST["datej"];
//$id_agent = $_POST["id_agent"];
$val = $_POST["val"];
$del = $_POST["del"];
$id_user = $_SESSION['id_user'];

if($del=='true'){
    del_agents($id_agent,$col,$idmc);
}else{
    if($update=='1'){save_mc($horaire,$type,$designation,$idmc,$date,$id_user);}
    if($update=='2'){save_agents($id_agent,$col,$idmc,$list);}
    if($update=='3'){save_info($val,$col,$idmc);}
    if($update=='4'){del_mc($val,$id_user);}
}



function del_mc($val,$user){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);   
    $query = "UPDATE `mcd` SET `active` = '0', `id_agent` = '$user', `update` = CURRENT_TIMESTAMP WHERE `id_mcd` = '$val'";
    $mysqli->query($query);
    $mysqli->close();
}

function save_info($val,$col,$idmc){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);   
    $query = "UPDATE `mc` SET `$col` = '$val' WHERE `id_mc` = '$idmc'";
    $mysqli->query($query);
    $mysqli->close();
}

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
    $mysqli->close();
}

function save_agents($val,$col,$idmc,$checkexisting){
    if($checkexisting){
        $existing_val = get_list($idmc,$col);
        if($existing_val!==""){
            $ar_val = explode(",",$existing_val);
            if(in_array($val,$ar_val)){return false;}
            $val=$existing_val.",".$val;
        }
    }
    
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);   
    $query = "UPDATE `mc` SET `$col` = '$val' WHERE `id_mc` = '$idmc'";
    $mysqli->query($query);
    $mysqli->close();
    //print $query;

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

function save_mc($horaire,$type,$designation,$idmc,$date,$id_user){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);   
    $query = "INSERT INTO `mc`.`mcd` (`id_mc`, `id_type`, `id_agent`, `datetime`, `designation`, `update`) VALUES ('$idmc', '$type', '$id_user', '$date $horaire', '$designation', CURRENT_TIMESTAMP)";
    $mysqli->query($query);
    
    $affected_r = $mysqli->affected_rows;
   
    $mysqli->close();
    //print $query;

}
?>