<?
include_once("comptes_top.php");
include_once("includes/menu.php");

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Gestion des Agents</title>
    <!-- Stylesheets -->
    <style type="text/css">@import url("css/menu.css");</style>
    <style type="text/css">@import url("css/mc.css");</style>
    
    <!-- Javascripts -->
    <script type="application/x-javascript" src="js/jquery.js"></script>
    <script type="application/x-javascript">
    $(document).ready(function () {  
        
       //submit form process
        $("#frm_compte").submit(function(event){
            // stop form from submitting normally
            event.preventDefault();       
            
            if(check_passwords() && check_login()){
               var $form = $( this ),
               hid_id = $('#hid_id').val(),
               txt_login = $('#txt_login').val(),
               txt_password = $('#txt_password').val(),
               chk_active = $('#chk_active').is(':checked'),
               url = $form.attr( 'action' );
               if(chk_active){active=1;}else{active=0;};
            
               // Send the data using post and put the results in a div
               $.post( url, {
                   hid_id: hid_id, 
                   txt_login: txt_login,
                   txt_password: txt_password,
                   active: active,
                   submit: 1
               } ,function() {
                   alert("Utilisateur ajout\351/mis a jour.");
               });
               return false;
            }
        });   
     });
        
        function check_passwords(){
            if($("#hid_id").val()==''){ //new user
                if($("#txt_password").val()===$("#txt_password2").val() && $("#txt_password").val().length !=0){
                    return true;
                } else {
                    alert("Les mots de passes ne correspondent pas ou sont vides");
                    return false;   
                }
            }else{
                if($("#txt_password").val()===$("#txt_password2").val()){
                    return true;
                } else {
                    alert("Les mots de passes ne correspondent pas");
                    return false;   
                }
            }
        }
        
        function check_login(){
            if($("#txt_login").val()===''){
                alert("Veuillez entrer un login.");
                return false;
            } else {
                return true;
            }
        }
        
        function newuser(){
            $('#hid_id').val('');
            $('#txt_login').val('');
            $('#txt_password').val('');
            $('#txt_password2').val('');
            $('#chk_active').prop("checked", true);
        }
        
        function loaduser(id){
            alert(id);
        }
    </script>

</head>
<body>
    <? print $menu; ?>
    <form id="frm_compte" action="<?php print $_SERVER['PHP_SELF'];?>" method="POST" autocomplete="OFF">
        <input type="hidden" name="hid_id" id="hid_id" value="<? print $id_user; ?>" />
        <? print $listusers; ?>
        <table>
        <tr>
            <td>
                Compte Actif :
            </td>
            <td>
                <input type="checkbox" id="chk_active"<? print $checkactive.$lock; ?> />
            </td>
        </tr>
        <tr>
            <td>
                Login :
            </td>
            <td>
                <input type="text" id="txt_login" name="txt_login" size="20" maxlength="20" value="<? print $login; ?>"<? print $lock; ?> />
            </td>
        </tr>
        <tr>
            <td>
                Mot de passe :
            </td>
            <td>
                <input type="password" id="txt_password" name="txt_password" size="20" maxlength="20" />
            </td>
        </tr>
        <tr>
            <td>
                Mot de passe (confirmation):
            </td>
            <td>
                <input type="password" id="txt_password2" name="txt_password2" size="20" maxlength="20" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
               <button type="button" onclick="javascript:newuser();"<? print $lock; ?>>Nouvel Utilisateur</button> <button type="button" onclick="javascript:window.location.reload();">RAZ</button> <button type="submit">Soumettre</button>
            </td>
        </tr>
    </table>
    </form>
</body>
</html>