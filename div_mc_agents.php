<?

include_once("includes/global_vars.php");


$id = $_GET['mc'];
$col = $_GET['col'];

$val = get_list($id,$col);
if($val!==""){
$ar_val = explode(",",$val);
    foreach($ar_val as &$v){
        $list .= "- ".div_list($v);
        $list .= " <a href='javascript:save_equipe(\"$col\",\"$v\",\"true\")'><img class='imgtrash' src='img/trash.png'></a><br/>";
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