<?

include_once("includes/global_vars.php");

print get_agents();


function get_agents(){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    /* check connection */
    if (mysqli_connect_errno()) {
        //printf("Connect failed: %s\n", mysqli_connect_error());
        print("<?xml version='1.0' encoding='utf-8' ?><!DOCTYPE response SYSTEM 'response.dtd' [<!ENTITY eacute '&#233;'><!ENTITY agrave '&#224;'>]><response success='0' msg='Erreur de connexion &agrave; la base de donn&eacute;es'></response>");
        exit();
    }
  
    $query = "SELECT `agent` FROM `agents` ORDER BY `agent` ASC";
    $output ="<table>";
    if ($result = $mysqli->query($query)) {
        while($row = $result->fetch_assoc()){
            $output .= "<tr><td>".$row['agent']."</td></tr>";
        }
    }
    $result->free();
    $mysqli->close();
     
    $output .="</table>";
    return $output;
}

?>