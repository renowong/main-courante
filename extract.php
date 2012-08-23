<?
//session_start();

include_once("headers.php");
include_once("includes/menu.php");

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <?php echo $title.$icon.$charset.$nocache.$menucss.$defaultcss.$jquery.$jqueryui.$message_div ?>
    <script type="text/javascript" src="js/jquery.ui.datepicker-fr.js"></script>
    <script type="application/x-javascript">
    $(document).ready(function () {
	$("#txt_beg").datepicker({inline: true,minDate: "-1Y",maxDate: "0"});
	$("#txt_end").datepicker({inline: true,minDate: "-1Y",maxDate: "0"});
	$( "input:submit, input:reset, button" ).button();
    });
    
        
    function sendtoextract(){
	var deb = $("#txt_beg").val();
	var end = $("#txt_end").val();
	
	if(deb.length==0 || end.length==0){
	    message("Veuillez entrer une date de d\351but et une date de fin.");
	} else {
	    window.location = "extract_to_file.php?deb="+deb+"&end="+end;
	}
    }
    
    function daysInMonth(month,year) {
	return new Date(year, month, 0).getDate();
    }
    </script>

</head>
<body>
    <? print $menu; ?>
    <div name="message" id="message" ></div>
    <table>
	<th>Module d'extraction</th>
	<tr>
	    <td>
		       Extraire rapport &agrave; partir de (inclusif) : <input type="text" size="10" maxlength="10" id="txt_beg" />
		   &agrave;
		   <input type="text" size="10" maxlength="10" id="txt_end" />
		   <button onclick="javascript:sendtoextract();">Extraire</button>
	    </td>
	</tr>
    </table>
</body>
</html>