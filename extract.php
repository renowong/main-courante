<?
session_start();

include_once("headers.php");
include_once("includes/menu.php");

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <?php echo $title.$icon.$charset.$nocache.$menucss.$defaultcss.$jquery.$jqueryui ?>
    <script type="application/x-javascript">
    $(document).ready(function () {
	var d = new Date();
	/* needed to convert to human months*/
        var month=new Array(12);
        month[0]="01";
        month[1]="02";
        month[2]="03";
        month[3]="04";
        month[4]="05";
        month[5]="06";
        month[6]="07";
        month[7]="08";
        month[8]="09";
        month[9]="10";
        month[10]="11";
        month[11]="12";
	
	var deb = "01-"+month[d.getMonth()]+"-"+d.getFullYear();
	var end = daysInMonth(month[d.getMonth()],d.getFullYear())+"-"+month[d.getMonth()]+"-"+d.getFullYear();
	
	$("#txt_beg").val(deb);
	$("#txt_end").val(end);
    });
    
        
    function sendtoextract(){
	//event.preventDefault();   --- does not work in firefox
	var deb = $("#txt_beg").val();
	var end = $("#txt_end").val();
	
	if(deb.length==0 || end.length==0){
	    alert("Veuillez entrer une date de d\351but et une date de fin.");
	} else {
	    window.location = "extract_to_file.php?deb="+deb+"&end="+end;
	}
    }
    
    function daysInMonth(month,year) {
	return new Date(year, month, 0).getDate();
    }
    </script>
        <!-- link calendar files  -->
	<script language="JavaScript" src="js/calendar_eu.js"></script>
	<link rel="stylesheet" href="css/calendar.css">
</head>
<body>
    <? print $menu; ?>
    <form id="frm_control" method="post" action="extract_to_file.php">
           Extraire rapport &agrave; partir de (inclusif) : <input type="text" size="10" maxlength="10" id="txt_beg" READONLY />
       <script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'frm_control',
		// input name
		'controlname': 'txt_beg'
	});

	</script>
       &agrave;
       <input type="text" size="10" maxlength="10" id="txt_end" READONLY />
       <script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'frm_control',
		// input name
		'controlname': 'txt_end'
	});

	</script>
       <input type="button" value="Extraire" onclick="javascript:sendtoextract();"/>
    </form>
</body>
</html>