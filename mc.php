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
       
    });
    
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
    <table>
        <tr>
            <td>
                Horaire
            </td>
            <td>
                <input type="text" name="txt_horaire" value="<? print $time; ?>" size="5" maxlength="5"  min="" max="" accept=""/>
            </td>
        </tr>
        <tr>
            <td>
                Code
            </td>
            <td>
                <select name="slt_code" id="slt_code" onchange="loadtype(this.value)">
                    <option value="INC">INC</option>
                    <option value="SAP">SAP</option>
                    <option value="ADC">ADC</option>
                    <option value="OD">OD</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Type
            </td>
            <td>
                <select name="slt_inter" id="slt_inter"></select>
            </td>
        </tr>
        <tr>
            <td>
                D&eacute;signation
            </td>
            <td>
                <textarea name="txt_designation" cols="40" rows="10" wrap="SOFT"></textarea>
            </td>
        </tr>
    </table>
</body>
</html>
