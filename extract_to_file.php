<?
include_once("includes/global_vars.php");

$myFile = "extract/tableau_de_bord.csv";
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = "Interventions;Code;Nombre\n";
fwrite($fh, $stringData);
$stringData = get_extract('1');
fwrite($fh, $stringData);
$stringData = get_extract('2');
fwrite($fh, $stringData);
$stringData = get_extract('3');
fwrite($fh, $stringData);
$stringData = get_extract('4');
fwrite($fh, $stringData);
$stringData = get_extract('5');
fwrite($fh, $stringData);
$stringData = get_extract('6');
fwrite($fh, $stringData);
fclose($fh);



function get_extract($cat){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $query = "SELECT `categories`.`categorie` FROM  `categories` WHERE `categories`.`id_cat` = '$cat'";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    $output .= $row["categorie"].";;\n";
    $result->free();
    
    $query = "SELECT `type`.`id_type`,`type`.`code`,`type`.`type` FROM `type` WHERE `type`.`export` = '$cat'";
    $result = $mysqli->query($query);
    while($row = $result->fetch_assoc()){
        $count = get_count($row["id_type"]);
        $output .= html_entity_decode($row["type"]).";".$row["code"].";".$count."\n";    
    }
    $result->free();
    $mysqli->close();

    return $output;
}

function get_count($t){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $query = "SELECT COUNT(`mcd`.`id_type`) AS `count` FROM `mcd` WHERE `id_type`='$t'";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    $count = $row["count"];
    $result->free();
    $mysqli->close();
    return $count;
}
?>