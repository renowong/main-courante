<?
session_start();

$menu = "<div class='hovermenu'>";
$menu .= "<ul>";
$menu .= "<li><a href='mc_list.php'>Retour Liste</a></li>";
if($_SESSION['usertype']=='1'){$menu .= "<li><a href='agents.php'>Gestion des Agents</a></li>";}
if($_SESSION['usertype']=='1'){$menu .= "<li><a href='extract.php'>Extractions</a></li>";}
$menu .= "<li><a href='comptes.php'>Compte</a></li>";
$menu .= "<li><a href='index.php'>Quitter</a></li>";
$menu .= "</ul>";
$menu .= "</div>";

?>






