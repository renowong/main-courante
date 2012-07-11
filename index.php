<?
include_once("headers.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php echo $title.$icon.$charset.$nocache.$menucss.$defaultcss.$jquery.$jqueryui.$message_div ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#txt_login").keydown(function (e){
                if(e.keyCode == 13){
                    login();
                }
        })
        
        $("#txt_password").keydown(function (e){
                if(e.keyCode == 13){
                    login();
                }
        })
        
        $( "#dialog-form" ).dialog({
                height: 180,
                width: 320,
                modal: false,
                resizable: false,
                buttons: {
                        "Se connecter": function() {
                                login();
                        },
                        RAZ: function() {
                                reset();
                        }
                },
                beforeclose : function() { return false; }
        });
        $('#txt_login').focus();
    });
    
    function reset() {
        $("#txt_login").val("");
        $("#txt_password").val("");
        $('#txt_login').focus();
    }
    
    function login(){
        var login = $("#txt_login").val();
        var password = $("#txt_password").val();
        $.post("login.php",{login:login,password:password},
               function(response){
            //alert(response);
            var obj = jQuery.parseJSON(response);
            if(obj.autorise=="True"){
                
                window.location="mc_list.php"; 
            }else{
                message("Utilisateur non-autoris&eacute;!");
                reset();
            }
        });
    }
</script>
</head>
<body style="text-align:center;">
    <br/> <br/>
    <img src="img/logo.png"/>
    <div name="message" id="message" ></div>
        <div id="dialog-form" title="Main courante">
                <form style="text-align:right;">
                        Utilisateur : <input type="text" name="txt_login" id="txt_login" value="" maxlength="10" size="20" autocomplete="off" /><br/><br/>
                        Mot de passe : <input type="password" name="txt_password" id="txt_password" value="" maxlength="10" size="20" autocomplete="off" />
                </form>
        </div>
</body>
</html>