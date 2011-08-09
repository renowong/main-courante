<?
include_once("includes/global_vars.php");

$list_equipe = list_equipes();

function list_equipes(){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $query = "SELECT `designation`,`id_equipe` FROM `equipes` ORDER BY `designation`";
    if ($result = $mysqli->query($query)) {
        while($row = $result->fetch_assoc()){
            if($row['id_equipe']==$val){$selected=" selected";}else{$selected="";}
            $output .= "<option value='".$row['id_equipe']."'$selected>".$row['designation']."</option>";
        }
        $result->free();
    }
    $mysqli->close();
    return $output;
}

?>