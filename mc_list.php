<?
include_once("headers.php");
include_once("mc_list_top.php");
include_once("includes/menu.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php echo $title.$icon.$charset.$nocache.$menucss.$defaultcss.$jquery.$jqueryui.$message_div ?>
    <script type="text/javascript" src="js/jquery.ui.datepicker-fr.js"></script>
    <script type="application/x-javascript">
    $(document).ready(function () {
	
	// message to user//
	//  Get the parameter value after the # symbol
	var url=document.URL.split('#')[1];
	if(url == undefined){
	    url = '';
	}
	if(url != ''){
	    message("Veuillez cl\364turer la pr\351c\351dente MC avant de continuer.");
	}
	$("#txt_search").datepicker({inline: true,minDate: "-10Y",maxDate: "0"});
	
	$( "input:submit, button" ).button();
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
	    if(date.length>0){
		window.location = "mc_list.php?date="+date;
	    }else{
		message("Veuillez entrer une date pour la recherche!");
	    }
        }
    </script>
</head>
<body>
    <? print $menu; ?>
    <div name="message" id="message" ></div>
    <table style="width:50em;">
	<th>
	    <table class="innertable" style="width:100%;background-color:inherit;border:0px;">
		<tr>
		    <th>Liste des MC</th>
		    <td style="text-align:right;">
		Afficher &agrave; partir de :<input type="text" size="10" maxlength="10" id="txt_search" />
		<button type="button" onclick="javascript:redirect2date($('#txt_search').val());">Rechercher</button>
		    </td>
		</tr>
	    </table>
	</th>
	<tr>
	    <td>
		<button type="button" onclick="javascript:redirect2mc(0);">Cr&eacute;er une nouvelle mc</button>
	    </td>
	</tr>
	<tr>
	    <td>
		<div id="list"><? print $listmc; ?></div>
	    </td>
	</tr>
    </table>
    <hr/>
    <div id="mcd" style="width:100%;">
    </div>
</body>
</html>
