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
    
    
    </script>
</head>
<body>
    <? print $menu; ?>
    <h1>Main Courante du <? print $date; ?></h1>
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
                            Absence...
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
