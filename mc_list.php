<?
include_once("mc_list_top.php");
include_once("includes/menu.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Liste des MC</title>
    <!-- Stylesheets -->
    <style type="text/css">@import url("css/menu.css");</style>
    <style type="text/css">@import url("css/mc.css");</style>
    <!-- Javascripts -->
    <script type="application/x-javascript" src="js/jquery.js"></script>
    <script type="application/x-javascript">
    $(document).ready(function () {
	
	// message to user//
	//  Get the parameter value after the # symbol
	var url=document.URL.split('#')[1];
	if(url == undefined){
	    url = '';
	}
	if(url != ''){
	    alert("Veuillez cl\364turer la pr\351c\351dente MC avant de continuer.");
	}
    
    });
      
        function showmcd(id){
            $("<div>").load("recap_mc.php?id="+id, function(){
            $("#mcd").html($(this));
            });
        }
        
        function redirect2mc(edit){
            window.location = "mc.php?edit="+edit;
        }
        
        function redirect2date(date){
            window.location = "mc_list.php?date="+date;
        }
    </script>
    
        <!-- link calendar files  -->
	<script language="JavaScript" src="js/calendar_eu.js"></script>
	<link rel="stylesheet" href="css/calendar.css">
            
</head>
<body>
    <? print $menu; ?>
    <h1>Liste des MC</h1>
    <form id="frm_control">
        <button type="button" onclick="javascript:redirect2mc(0);">Cr&eacute;er une nouvelle mc</button>
        | Rechercher &agrave; partir de : <input type="text" size="10" maxlength="10" id="txt_search" READONLY />
    <script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'frm_control',
		// input name
		'controlname': 'txt_search'
	});

	</script>
    <button type="button" onclick="javascript:redirect2date(document.getElementById('txt_search').value);">Rechercher</button>
    </form>
    <div id="list"><? print $listmc; ?></div>
    <hr/>
    <div id="mcd">
    </div>
</body>
</html>