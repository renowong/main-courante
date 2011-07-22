<?
include_once("mc_top.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
    <title>title</title>
    <script type="application/x-javascript" src="js/jquery.js"></script>
    <script type="application/x-javascript">
    $(document).ready(function () {
       
       loadtype("INC");
       
            //submit form process
     $("#frm_mc").submit(function(event){
         // stop form from submitting normally
         event.preventDefault();
         var $form = $( this ),
         txt_horaire = $form.find( 'input[name="txt_horaire"]' ).val(),
         datej = $form.find( 'input[name="datej"]' ).val(),
         slt_inter = $form.find( 'input[name="slt_inter"]' ).val(),
         txt_designation = $('#txt_designation').val(),
         url = $form.attr( 'action' );

         // Send the data using post and put the results in a div
         $.post( url, {
             txt_horaire: txt_horaire,
             datej: datej,
             slt_inter: slt_inter,
             txt_designation: txt_designation
         } ,function(response) {
             readresponse(response);
             //alert(response);
         },"xml");
         //});
         return false; 
     });
       
    });
    
    function readresponse(xml){
        $(xml).find("response").each(function(){
            var success = $(this).attr("success");
            //alert(success);
            var msg = $(this).attr("msg");
            alert(msg);
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
    
    
    </script>
</head>
<body>
    <h1>Main Courante du <? print $date; ?></h1>
    <form method="post" id="frm_mc" action="submit_mc.php">
        <table>
            <tr>
                <td>
                    Horaire :
                </td>
                <td>
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
    <hr />
    <div id="mcj">
        <table border="1">
            <tr><td>Type</td><td>Date/Heure</td><td>D&eacute;signation</td><td>Agent</td></tr>
            <? print loadmcj(); ?>
        </table>
    </div>
</body>
</html>
