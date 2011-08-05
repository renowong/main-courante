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
    <style type="text/css">@import url("css/mc.css");</style>
    <!-- Javascripts -->
    <script type="application/x-javascript" src="js/jquery.js"></script>
    <script type="application/x-javascript">
    $(document).ready(function () {
       
        loadtype("INC");
        loaddivagents('list_agents',$("#idmc").val(),'slt_agents');
        loaddivagents('list_conges',$("#idmc").val(),'slt_conges');
        loaddivagents('list_malades',$("#idmc").val(),'slt_malades');
        loaddivagents('list_absents',$("#idmc").val(),'slt_absents');
       
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
             $('#txt_designation').val("");
         },"xml");
         //});
         return false; 
     });
       
    });
    
    
    function recap_mc(div,id) {
        $("<div>").load("recap_mc.php?id="+id+"&action=true", function(){
            $("#"+div).html($(this));
            });
    }
    
    function loaddivagents(div,mc,col) {
        $("<div>").load("div_mc_agents.php?mc="+mc+"&col="+col, function(){
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
    
    function save_equipe(field,x,del,list){
        idmc = $("#idmc").val();
        //alert(field);
        $.post( 'submit_mc.php', {
             idmc: idmc,
             update: 2,
             col: field,
             id_agent: x,
             del: del,
             list: list
         },
        function(response) {
            //alert(response);
        });
        
        loaddivagents('list_agents',$("#idmc").val(),'slt_agents');
        loaddivagents('list_conges',$("#idmc").val(),'slt_conges');
        loaddivagents('list_malades',$("#idmc").val(),'slt_malades');
        loaddivagents('list_absents',$("#idmc").val(),'slt_absents');
    }
    
    function save_info(field,val){
        idmc = $("#idmc").val();
        $.post( 'submit_mc.php', {
             idmc: idmc,
             update: 3,
             col: field,
             val: val
         });
    }

    function del_mc(id){
        var yesno = confirm("Etes vous sur de vouloir supprimer?");
        if(yesno){
            $.post( 'submit_mc.php', {
                 update: 4,
                 val: id
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
    <h1>Main Courante du <? print $date; ?></h1>
    <table border="1">
        <tr>
            <th>V&eacute;hicule</th><th>Km D&eacute;part</th><th>Km Arriv&eacute;</th><th>Huile moteur</th><th>Huile frein</th><th>Radiateur</th><th>Batterie</th><th>Lavage</th><th>Plein</th>
        </tr>
        <tr>
            <th>VSR</th>
            <td><input type="text" size="5" maxlength="5" id="vsr_kmd" name="vsr_kmd" value="<? print getdata('vsr_kmd',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsr_kma" name="vsr_kma" value="<? print getdata('vsr_kma',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsr_mot" name="vsr_mot" value="<? print getdata('vsr_mot',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsr_frein" name="vsr_frein" value="<? print getdata('vsr_frein',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsr_rad" name="vsr_rad" value="<? print getdata('vsr_rad',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsr_bat" name="vsr_bat" value="<? print getdata('vsr_bat',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsr_lav" name="vsr_lav" value="<? print getdata('vsr_lav',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsr_plein" name="vsr_plein" value="<? print getdata('vsr_plein',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
        </tr>
        <tr>
            <th>VSAV</th>
            <td><input type="text" size="5" maxlength="5" id="vsav_kmd" name="vsav_kmd" value="<? print getdata('vsav_kmd',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsav_kma" name="vsav_kma" value="<? print getdata('vsav_kma',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsav_mot" name="vsav_mot" value="<? print getdata('vsav_mot',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsav_frein" name="vsav_frein" value="<? print getdata('vsav_frein',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsav_rad" name="vsav_rad" value="<? print getdata('vsav_rad',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsav_bat" name="vsav_bat" value="<? print getdata('vsav_bat',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsav_lav" name="vsav_lav" value="<? print getdata('vsav_lav',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsav_plein" name="vsav_plein" value="<? print getdata('vsav_plein',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
        </tr>
        <tr>
            <th>VSAB</th>
            <td><input type="text" size="5" maxlength="5" id="vsab_kmd" name="vsab_kmd" value="<? print getdata('vsab_kmd',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsab_kma" name="vsab_kma" value="<? print getdata('vsab_kma',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsab_mot" name="vsab_mot" value="<? print getdata('vsab_mot',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsab_frein" name="vsab_frein" value="<? print getdata('vsab_frein',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsab_rad" name="vsab_rad" value="<? print getdata('vsab_rad',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsab_bat" name="vsab_bat" value="<? print getdata('vsab_bat',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsab_lav" name="vsab_lav" value="<? print getdata('vsab_lav',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vsab_plein" name="vsab_plein" value="<? print getdata('vsab_plein',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
        </tr>
        <tr>
            <th>FPT 1</th>
            <td><input type="text" size="5" maxlength="5" id="fpt1_kmd" name="fpt1_kmd" value="<? print getdata('fpt1_kmd',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="fpt1_kma" name="fpt1_kma" value="<? print getdata('fpt1_kma',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="fpt1_mot" name="fpt1_mot" value="<? print getdata('fpt1_mot',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="fpt1_frein" name="fpt1_frein" value="<? print getdata('fpt1_frein',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="fpt1_rad" name="fpt1_rad" value="<? print getdata('fpt1_rad',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="fpt1_bat" name="fpt1_bat" value="<? print getdata('fpt1_bat',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="fpt1_lav" name="fpt1_lav" value="<? print getdata('fpt1_lav',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="fpt1_plein" name="fpt1_plein" value="<? print getdata('fpt1_plein',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
        </tr>
        <tr>
            <th>FPT 2</th>
            <td><input type="text" size="5" maxlength="5" id="fpt2_kmd" name="fpt2_kmd" value="<? print getdata('fpt2_kmd',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="fpt2_kma" name="fpt2_kma" value="<? print getdata('fpt2_kma',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="fpt2_mot" name="fpt2_mot" value="<? print getdata('fpt2_mot',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="fpt2_frein" name="fpt2_frein" value="<? print getdata('fpt2_frein',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="fpt2_rad" name="fpt2_rad" value="<? print getdata('fpt2_rad',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="fpt2_bat" name="fpt2_bat" value="<? print getdata('fpt2_bat',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="fpt2_lav" name="fpt2_lav" value="<? print getdata('fpt2_lav',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="fpt2_plein" name="fpt2_plein" value="<? print getdata('fpt2_plein',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
        </tr>
        <tr>
            <th>CCF</th>
            <td><input type="text" size="5" maxlength="5" id="ccf_kmd" name="ccf_kmd" value="<? print getdata('ccf_kmd',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="ccf_kma" name="ccf_kma" value="<? print getdata('ccf_kma',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="ccf_mot" name="ccf_mot" value="<? print getdata('ccf_mot',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="ccf_frein" name="ccf_frein" value="<? print getdata('ccf_frein',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="ccf_rad" name="ccf_rad" value="<? print getdata('ccf_rad',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="ccf_bat" name="ccf_bat" value="<? print getdata('ccf_bat',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="ccf_lav" name="ccf_lav" value="<? print getdata('ccf_lav',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="ccf_plein" name="ccf_plein" value="<? print getdata('ccf_plein',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
        </tr>
        <tr>
            <th>VTU</th>
            <td><input type="text" size="5" maxlength="5" id="vtu_kmd" name="vtu_kmd" value="<? print getdata('vtu_kmd',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vtu_kma" name="vtu_kma" value="<? print getdata('vtu_kma',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vtu_mot" name="vtu_mot" value="<? print getdata('vtu_mot',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vtu_frein" name="vtu_frein" value="<? print getdata('vtu_frein',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vtu_rad" name="vtu_rad" value="<? print getdata('vtu_rad',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vtu_bat" name="vtu_bat" value="<? print getdata('vtu_bat',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vtu_lav" name="vtu_lav" value="<? print getdata('vtu_lav',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="vtu_plein" name="vtu_plein" value="<? print getdata('vtu_plein',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
        </tr>
        <tr>
            <th>MPR</th>
            <td><input type="text" size="5" maxlength="5" id="mpr_kmd" name="mpr_kmd" value="<? print getdata('mpr_kmd',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="mpr_kma" name="mpr_kma" value="<? print getdata('mpr_kma',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="mpr_mot" name="mpr_mot" value="<? print getdata('mpr_mot',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="mpr_frein" name="mpr_frein" value="<? print getdata('mpr_frein',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="mpr_rad" name="mpr_rad" value="<? print getdata('mpr_rad',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="mpr_bat" name="mpr_bat" value="<? print getdata('mpr_bat',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="mpr_lav" name="mpr_lav" value="<? print getdata('mpr_lav',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="mpr_plein" name="mpr_plein" value="<? print getdata('mpr_plein',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
        </tr>
        <tr>
            <th>EMBARCATION</th>
            <td><input type="text" size="5" maxlength="5" id="emb_kmd" name="emb_kmd" value="<? print getdata('emb_kmd',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="emb_kma" name="emb_kma" value="<? print getdata('emb_kma',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="emb_mot" name="emb_mot" value="<? print getdata('emb_mot',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="emb_frein" name="emb_frein" value="<? print getdata('emb_frein',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="emb_rad" name="emb_rad" value="<? print getdata('emb_rad',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="emb_bat" name="emb_bat" value="<? print getdata('emb_bat',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="emb_lav" name="emb_lav" value="<? print getdata('emb_lav',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
            <td><input type="text" size="5" maxlength="5" id="emb_plein" name="emb_plein" value="<? print getdata('emb_plein',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
        </tr>
    </table>
    <br />
    <table border="1">
        <tr>
            <th>Indicatif</th><th>Observation / fenzy / Oxyg&egrave;ne</th>
        </tr>
        <tr>
            <th>FPT 1</th><td><input type="text" size="100" maxlength="100" id="indic_fpt1" name="indic_fpt1" value="<? print getdata('indic_fpt1',$edit) ?>" onblur="javascript:save_info(this.id,this.value)"/></td>
        </tr>
        <tr>
            <th>VSAV</th><td><input type="text" size="100" maxlength="100" id="indic_vsav" name="indic_vsav" value="<? print getdata('indic_vsav',$edit) ?>"  onblur="javascript:save_info(this.id,this.value)"/></td>
        </tr>
        <tr>
            <th>VSAB</th><td><input type="text" size="100" maxlength="100" id="indic_vsab" name="indic_vsab" value="<? print getdata('indic_vsab',$edit) ?>"  onblur="javascript:save_info(this.id,this.value)"/></td>
        </tr>
    </table>
    <hr/>
    <table>
        <tr>
            <td>
                <form method="post" id="frm_mc" action="submit_mc.php">
                    <table>
                        <tr>
                            <th>
                                Horaire :
                            </th>
                            <td>
                                <input type="hidden" name="idmc" id="idmc" value="<? print $edit; ?>" />
                                <input type="hidden" name="datej" id="datej" value="<? print date("Y-m-d"); ?>" />
                                <input type="text" name="txt_horaire" value="<? print $time; ?>" size="5" maxlength="5"  min="" max="" accept=""/>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Code :
                            </th>
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
                            <th>
                                Type :
                            </th>
                            <td>
                                <select name="slt_inter" id="slt_inter"></select>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                D&eacute;signation :
                            </th>
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
                        <th>
                            Equipe de Permanence
                        </th>
                        <td>
                            <select id="slt_eq" name="slt_eq" onchange="javascript:save_equipe(this.id,this.value,false,0);"><? print load_equipe($edit); ?></select>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Chef &Eacute;quipe
                        </th>
                        <td>
                            <select id="slt_chef" name="slt_chef" onchange="javascript:save_equipe(this.id,this.value,false,0);"><? print load_agents($edit,"slt_chef"); ?></select>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Adjoint
                        </th>
                        <td>
                            <select id="slt_adj" name="slt_adj" onchange="javascript:save_equipe(this.id,this.value,false,0);"><? print load_agents($edit,"slt_adj"); ?></select>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Agents
                        </th>
                        <td>
                            <select id="slt_agents" name="slt_agents" onchange="javascript:save_equipe(this.id,this.value,false,1);this.selectedIndex=0;"><? print load_agents(); ?></select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            <div id="list_agents" class="list" />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Cong&eacute;s
                        </th>
                        <td>
                            <select id="slt_conges" name="slt_conges" onchange="javascript:save_equipe(this.id,this.value,false,1);this.selectedIndex=0;"><? print load_agents(); ?></select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            <div id="list_conges" class="list" />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Malades
                        </th>
                        <td>
                            <select id="slt_malades" name="slt_malades" onchange="javascript:save_equipe(this.id,this.value,false,1);this.selectedIndex=0;"><? print load_agents(); ?></select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            <div id="list_malades" class="list" />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Absents
                        </th>
                        <td>
                            <select id="slt_absents" name="slt_absents" onchange="javascript:save_equipe(this.id,this.value,false,1);this.selectedIndex=0;"><? print load_agents(); ?></select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            <div id="list_absents" class="list" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <hr />
    <div id="mcj">
    </div>
    <br />
    <br />
</body>
</html>
