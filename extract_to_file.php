<?
include_once("includes/global_vars.php");
include_once("includes/global_functions.php");

$deb = rev_date($_GET['deb']);
$end = rev_date($_GET['end']);

$myFile = "extract/tableau_de_bord.csv";
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = "Interventions;Code;Nombre\n";
fwrite($fh, $stringData);
$stringData = get_extract('1',$deb,$end);
fwrite($fh, $stringData);
$stringData = "SECOURS A VICTIMES/ AIDES A PERSONNES;;\n";
fwrite($fh, $stringData);
$stringData = get_extract('2',$deb,$end);
fwrite($fh, $stringData);
$stringData = get_extract('3',$deb,$end);
fwrite($fh, $stringData);
$stringData = get_extract('4',$deb,$end);
fwrite($fh, $stringData);
$stringData = "OPERATIONS DIVERSES;;\n";
fwrite($fh, $stringData);
$stringData = get_extract('5',$deb,$end);
fwrite($fh, $stringData);
$stringData = get_extract('6',$deb,$end);
fwrite($fh, $stringData);
fclose($fh);

header('Location:extract/tableau_de_bord.csv');
ob_flush();

function get_extract($cat,$deb,$end){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $query = "SELECT `categories`.`categorie` FROM  `categories` WHERE `categories`.`id_cat` = '$cat'";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    $output .= $row["categorie"].";;\n";
    $result->free();
    
    $query = "SELECT `type`.`id_type`,`type`.`code`,`type`.`type` FROM `type` WHERE `type`.`export` = '$cat'";
    $result = $mysqli->query($query);
    while($row = $result->fetch_assoc()){
        $count = get_count($row["id_type"],$deb,$end);
        $output .= html_entity_decode($row["type"]).";".$row["code"].";".$count."\n";    
    }
    $result->free();
    $mysqli->close();

    return $output;
}

function get_count($t,$deb,$end){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $query = "SELECT COUNT(`mcd`.`id_type`) AS `count` FROM `mcd` WHERE `id_type`='$t' AND `datetime` BETWEEN '$deb' AND AddDate('$end',INTERVAL 1 DAY)";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    $count = $row["count"];
    $result->free();
    $mysqli->close();
    //print $query;
    return $count;
}
?>