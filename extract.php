<?
include_once("includes/menu.php");

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Extractions</title>
    <!-- Stylesheets -->
    <style type="text/css">@import url("css/menu.css");</style>
    <style type="text/css">@import url("css/mc.css");</style>
    
    <!-- Javascripts -->
    <script type="application/x-javascript" src="js/jquery.js"></script>
    <script type="application/x-javascript">
    
    </script>
        <!-- link calendar files  -->
	<script language="JavaScript" src="js/calendar_eu.js"></script>
	<link rel="stylesheet" href="css/calendar.css">
</head>
<body>
    <? print $menu; ?>
    <form id="frm_control">
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
       <input type="button" value="Extraire"/>
    </form>
</body>
</html>