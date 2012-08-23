<?
//session_start();
include_once("includes/global_vars.php");
if($_COOKIE['id_user']==""){header("Location: index.php");}

$usertype = $_COOKIE['usertype'];
if($usertype=='0'){$lock=' disabled="disabled"';}else{$lock='';$listusers=getusers();}
$id_user = $_COOKIE['id_user'];
$data = getdata($id_user);
$login = $data[0]['login'];
$active = $data[0]['active'];
if($active){$checkactive=" checked";}else{$checkactive="";}


if($_POST['submit']=='1'){
    $update_id = $_POST['hid_id'];
    $login = $_POST['txt_login'];
    $password = $_POST['txt_password'];
    $active = $_POST['active'];
    
        if($update_id==''){
            insert($login,$password,$active);
        }else{
            update($update_id,$password,$active);
        }
    }
    
function getusers(){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $query = "SELECT `users`.`id_user`,`users`.`login`,`users`.`active` FROM `users` ORDER BY `login`";
    $options = "<option value='0'>S&eacute;lectionner login</option>";
    if ($result = $mysqli->query($query)) {
        while($row = $result->fetch_assoc()){
            $options .= "<option value='".$row["id_user"]."_".$row["active"]."'>".$row["login"]."</option>";
        }
        $result->free();
    }
    $mysqli->close();

    return "<select id='slt_login' onchange='javascript:loaduser(this.value,this.options[this.selectedIndex].text);'>$options</select>";
}

function insert($login,$password,$active){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $query = "INSERT INTO `mc`.`users` (`id_user`, `login`, `password`, `datetime`, `type`, `active`) VALUES (NULL, '$login', '".md5($password)."', CURRENT_TIMESTAMP, '0', '$active')";
    $mysqli->query($query);
    $mysqli->close();
}

function update($update_id,$password,$active){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    if($password==''){
        $query = "UPDATE `mc`.`users` SET `active` = '$active' WHERE `id_user` = '$update_id'";   
    }else{
        $query = "UPDATE `mc`.`users` SET `password` = '".md5($password)."', `active` = '$active' WHERE `id_user` = '$update_id'";
    }
    $mysqli->query($query);
    $mysqli->close();
}

function getdata($id_user){
    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    $query = "SELECT `login`,`active` FROM `users` WHERE `id_user`='$id_user'";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    $data[] = $row;
    $result->free();
    $mysqli->close();
    
    return $data;
}


?>