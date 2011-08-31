<?
include_once("includes/global_vars.php");

$myFile = "extract/tableau_de_bord.csv";
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = "Interventions;Code;Nombre\n";
fwrite($fh, $stringData);
//$stringData = "Tracy Tanner\n";
//fwrite($fh, $stringData);
fclose($fh);
?>