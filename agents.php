<?
include_once("agents_top.php");
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
            recap_agents();
        });
        
    
        function recap_agents(){
            $("<div>").load("recap_agents.php", function(){
            $("#list_agents").html($(this));
            });
        }
        
        function add_new(){
            var name = $('#txt_agent').val();
            var equipe = $('#slt_equipe').val();
            var url = 'submit_agent.php';
            // Send the data using post and put the results in a div
            $.post( url, {type: 'ajout', agent: name,equipe: equipe},function(response) {
            //readresponse(response);
            //alert(response);
            recap_agents();
         //},"xml");
            });
        }
        
        function radier(id){
            var yesno = confirm("Etes vous sur de vouloir radier cet agent?");
        if(yesno){
            $.post( 'submit_agent.php', {
                 type: 'radiation',
                 id: id
             },
            function(response) {
                //alert(response);
            });
            $("#"+id).hide();
        }
        }
    </script>
</head>
<body>
    <? print $menu; ?>
    <h1>Liste des Agents</h1>
    <table border="1">
        <tr>
            <td colspan="2">Equipe : 
                <select id="slt_equipe">
                    <? print $list_equipe ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" size="30" id="txt_agent" name="txt_agent" maxlength="30" /> <button id="btn_add" onclick="javascript:add_new();">Ajouter</button>
            </td>
        </tr>
    </table>
    <hr/>
    <div id="list_agents" /> 
</body>
</html>