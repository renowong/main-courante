<?
include_once("headers.php");
include_once("agents_top.php");
include_once("includes/menu.php");

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <?php echo $title.$icon.$charset.$nocache.$menucss.$defaultcss.$jquery.$jqueryui.$message_div ?>
    <script type="application/x-javascript">
        $(document).ready(function () {
            recap_agents('1');
            $("#slt_equipe").change(function(){
                //alert($("#slt_equipe").val());
                recap_agents($("#slt_equipe").val());
                });
            
        });
        
    
        function recap_agents(eq){
            $("<div>").load("recap_agents.php?eq="+eq, function(){
            $("#list_agents").html($(this));
            });
        }
        
        function add_new(){
            var name = $('#txt_agent').val();
            var equipe = $('#slt_equipe').val();
            var url = 'submit_agent.php';
            
            if(name.length>0){
                $.post( url, {type: 'ajout', agent: name,equipe: equipe},function(response) {
                //readresponse(response);
                //alert(response);
                recap_agents();
                });
            }else{
                message("Veuillez entrer un nom!");
            }
            
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
    <div name="message" id="message" ></div>
    
    <table>
        <th>Gestion des Agents</th>
        <tr>
            <td>Equipe : 
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