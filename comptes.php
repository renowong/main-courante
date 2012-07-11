<?
include_once("headers.php");
include_once("comptes_top.php");
include_once("includes/menu.php");

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php echo $title.$icon.$charset.$nocache.$menucss.$defaultcss.$jquery.$jqueryui.$message_div ?>
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
                   message("Utilisateur ajout\351/mis a jour.");
                   //window.location.reload();
               });
               return false;
            }
        });
        $( "input:submit, input:reset, button" ).button();
     });
        
        function check_passwords(){
            if($("#hid_id").val()==''){ //new user
                if($("#txt_password").val()===$("#txt_password2").val() && $("#txt_password").val().length !=0){
                    return true;
                } else {
                    message("Les mots de passes ne correspondent pas ou sont vides");
                    return false;   
                }
            }else{
                if($("#txt_password").val()===$("#txt_password2").val()){
                    return true;
                } else {
                    message("Les mots de passes ne correspondent pas");
                    return false;   
                }
            }
        }
        
        function check_login(){
            if($("#txt_login").val()===''){
                message("Veuillez entrer un login.");
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
            $('#txt_login').prop("disabled", false);
        }
        
        function loaduser(id_active,login){
            var ar = id_active.split("_");
            var id = ar[0];
            var active = ar[1];
            $("#hid_id").val(id);
            $("#txt_login").val(login);
            $('#txt_login').prop("disabled", true);
            if(active=='1'){$('#chk_active').prop("checked", true);}else{$('#chk_active').prop("checked", false);}
        }
    </script>

</head>
<body>
    <? print $menu; ?>
    <div name="message" id="message" ></div>
    <table>
        <th>Gestion de compte</th>
        <tr>
            <td>
                <form id="frm_compte" action="<?php print $_SERVER['PHP_SELF'];?>" method="POST" autocomplete="OFF">
                    <input type="hidden" name="hid_id" id="hid_id" value="<? print $id_user; ?>" />
                    <? print $listusers; ?>
                    <table class="innertable">
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
                            <input type="text" id="txt_login" name="txt_login" size="20" maxlength="20" value="<? print $login; ?>" disabled="disabled" />
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
                            <p style="font-style:italic">** Laisser les mots de passes vides pour garder le mot de passe actuel.</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                           <button type="button" onclick="javascript:newuser();"<? print $lock; ?>>Nouvel Utilisateur</button> <button type="button" onclick="javascript:window.location.reload();">RAZ</button> <button type="submit">Soumettre</button>
                        </td>
                    </tr>
                </table>
                </form>
            </td>
        </tr>
    </table>
</body>
</html>