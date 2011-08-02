<?
include_once("mc_top.php");
include_once("includes/menu.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
    <title>title</title>
    <!-- Stylesheets -->
    <style type="text/css">@import url("css/menu.css");</style>
    
    <!-- Javascripts -->
    <script type="application/x-javascript" src="js/jquery.js"></script>
    <script type="application/x-javascript">
    $(document).ready(function () {
       
       loadtype("INC");
       
       // begin get variable
       var $_GET = {};
        
        document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
            function decode(s) {
                return decodeURIComponent(s.split("+").join(" "));
            }
        
            $_GET[decode(arguments[1])] = decode(arguments[2]);
        });
        
       recap_mc("mcj",$("#idmc").val());
       // end get variable
       
            //submit form process
     $("#frm_mc").submit(function(event){
         // stop form from submitting normally
         event.preventDefault();
         var $form = $( this ),
         txt_horaire = $form.find( 'input[name="txt_horaire"]' ).val(),
         idmc = $form.find( 'input[name="idmc"]' ).val(),
         datej = $form.find( 'input[name="datej"]' ).val(),
         slt_inter = $('#slt_inter').val(),
         txt_designation = $('#txt_designation').val(),
         url = $form.attr( 'action' );
         

         // Send the data using post and put the results in a div
         $.post( url, {
             update: 1,
             id_agent: 1,
             txt_horaire: txt_horaire,
             idmc: idmc,
             datej: datej,
             slt_inter: slt_inter,
             txt_designation: txt_designation
         } ,function(response) {
             readresponse(response);
             //alert(response);
             recap_mc("mcj",idmc);
         },"xml");
         //});
         return false; 
     });
       
    });
    
    
    function recap_mc(div,id) {
        $("<div>").load("recap_mc.php?id="+id, function(){
            $("#"+div).html($(this));
            });
    }
    
    function readresponse(xml){
        $(xml).find("response").each(function(){
            var success = $(this).attr("success");
            //alert(success);
            var msg = $(this).attr("msg");
            //alert(msg);
            if(success==1){
                $('#frm_mc').each(function(){
	        this.reset();
                });
                loadtype("INC");
            }
        });
    }
    
    function loadtype(code){
        //alert(code);
        
        $.post("get_types.php", {code:code},
        function(response) {
            results = read_types(response);
            //alert(response);
        //},'xml'); //incompatible Firefox...
        });
    }
    
   
    function read_types(xml) {
        var output="";
        $('#slt_inter').empty();
        
        $(xml).find("type").each(function(){    
            id = $(this).attr("id");
            designation = $(this).text();
       
            $('#slt_inter').
                append($("<option></option>").
                attr("value",id).
                text(designation)); 
            //output+="<option value='"+id+"'>"+designation+"</option>"
        });
        
        //alert(output);
    }
    
    function save_equipe(x){
        idmc = $("#idmc").val();
        //alert(idmc);
        $.post( 'submit_mc.php', {
             idmc: idmc,
             update: 2,
             id_agent: x
         });
    }
    
    </script>
</head>
<body>
    <? print $menu; ?>
    <h1>Main Courante du <? print $date; ?></h1>
    <table border="1">
        <tr>
            <td>V&eacute;hicule</td><td>Km D&eacute;part</td><td>Km Arriv&eacute;</td><td>Huile moteur</td><td>Huile frein</td><td>Radiateur</td><td>Batterie</td><td>Lavage</td><td>Plein</td>
        </tr>
        <tr>
            <td>VSR</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>
        <tr>
            <td>VSAV</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>
        <tr>
            <td>VSAB</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>
        <tr>
            <td>FPT 1</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>
        <tr>
            <td>FPT 2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>
        <tr>
            <td>CCF</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>
        <tr>
            <td>VTU</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>
        <tr>
            <td>MPR</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>
        <tr>
            <td>EMBARCATION</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>
    </table>
    <table border="1">
        <tr>
            <td>Indicatif</td><td>Observation / fenzy / Oxyg&eacute;ne</td>
        </tr>
        <tr>
            <td>FPT 1</td><td><input type="text" size="100" maxlength="100" id="indic_fpt1" name="indic_fpt1" /></td>
        </tr>
        <tr>
            <td>VSAV</td><td><input type="text" size="100" maxlength="100" id="indic_vsav" name="indic_vsav" /></td>
        </tr>
        <tr>
            <td>VSAB</td><td><input type="text" size="100" maxlength="100" id="indic_vsab" name="indic_vsab" /></td>
        </tr>
    </table>
    <hr/>
    <table border="1" width="100%">
        <tr>
            <td>
                <form method="post" id="frm_mc" action="submit_mc.php">
                    <table>
                        <tr>
                            <td>
                                Horaire :
                            </td>
                            <td>
                                <input type="hidden" name="idmc" id="idmc" value="<? print $edit; ?>" />
                                <input type="hidden" name="datej" id="datej" value="<? print date("Y-m-d"); ?>" />
                                <input type="text" name="txt_horaire" value="<? print $time; ?>" size="5" maxlength="5"  min="" max="" accept=""/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Code :
                            </td>
                            <td>
                                <select name="slt_code" id="slt_code" onchange="loadtype(this.value)">
                                    <option value="INC">INC</option>
                                    <option value="SAP">SAP</option>
                                    <option value="ADC">ADC</option>
                                    <option value="OD">OD</option>
                                    <option value="DEB">DEB</option>
                                    <option value="FIN">FIN</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Type :
                            </td>
                            <td>
                                <select name="slt_inter" id="slt_inter"></select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                D&eacute;signation :
                            </td>
                            <td>
                                <textarea name="txt_designation" id="txt_designation" cols="40" rows="10" wrap="SOFT"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="reset" /> <input type="submit" value="Soumettre" />
                            </td>
                        </tr>
                    </table>    
                </form> 
            </td>
            <td>
                <table>
                    <tr>
                        <td>
                            Equipe de Permanence
                        </td>
                        <td>
                            <select id="slt_eq" name="slt_eq" onchange="javascript:save_equipe(this.value);"><? print load_equipe($edit); ?></select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Chef &Eacute;quipe
                        </td>
                        <td>
                            <select id="slt_chef" name="slt_chef"><? print load_agents(); ?></select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Adjoint
                        </td>
                        <td>
                            <select id="slt_adj" name="slt_adj"><? print load_agents(); ?></select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Agents
                        </td>
                        <td>
                            <select id="slt_agents" name="slt_agents"><? print load_agents(); ?></select>
                            <div id="list_agents" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Cong&eacute;s
                        </td>
                        <td>
                            <select id="slt_conge" name="slt_conge"><? print load_agents(); ?></select>
                            <div id="list_conge" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Malades
                        </td>
                        <td>
                            <select id="slt_malade" name="slt_malade"><? print load_agents(); ?></select>
                            <div id="list_malade" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Absents
                        </td>
                        <td>
                            <select id="slt_absent" name="slt_absent"><? print load_agents(); ?></select>
                            <div id="list_absent" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <hr />
    <div id="mcj">
    </div>
</body>
</html>
