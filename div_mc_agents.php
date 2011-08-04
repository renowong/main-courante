<?

include_once("includes/global_vars.php");

/*
updates are :
1 - MC
2 - equipe
3 - chef
4 - adjoint
5 - agents
6 - conges
7 - malades
8 - absents
*/

$id = $_GET['mc'];
$colnum = $_GET['colnum'];
switch($colnum){
    case 5:
        $update = 'agents';
    break;
}

$val = get_list($id,$update);
if($val!==""){
$ar_val = explode(",",$val);
    foreach($ar_val as &$v){
        $list .= "- ".div_list($v);
        $list .= " <a href='javascript:save_equipe(\"$v\",\"-$colnum\")'>X</a><br/>";
    }
    print $list;  
}



function div_list($id){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $query = "SELECT `agent` FROM `agents` WHERE `id_agent`='$id'";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
        $output = $row['agent'];
    $result->free();
    $mysqli->close();
    
    return $output;
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
?>