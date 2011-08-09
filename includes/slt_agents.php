<?
include_once("global_vars.php");

$e = $_GET['equipe'];
$idmc = $_GET['idmc'];
$field = $_GET['field'];
$agentid = get_agentid($field,$idmc);
print list_agents($e,$agentid);


function list_agents($e,$s){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $response = "<?xml version='1.0' encoding='utf-8' ?><!DOCTYPE response SYSTEM 'response.dtd' [<!ENTITY eacute '&#233;'><!ENTITY agrave '&#224;'>]>";
    $response .= "<response>";
    $query = "SELECT `id_agent`,`agent` FROM `agents` WHERE `equipe` = '$e' ORDER BY `agent`";
    if ($result = $mysqli->query($query)) {
        while($row = $result->fetch_assoc()){
            if($s==$row['id_agent']){$selected="1";}else{$selected="0";}
            $response .= "<agent id='".$row['id_agent']."' select='$selected'>".$row['agent']."</agent>";
        }
        $result->free();
    }
    $mysqli->close();
    $response .= "</response>";
    return $response;
}

function get_agentid($field,$idmc){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $query = "SELECT `$field` FROM `mc` WHERE `id_mc` = '$idmc'";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    $value = $row[$field];
    $result->free();
    $mysqli->close();
    return $value;
}

?>