<?
include_once("mc_list_top.php");

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Liste des MC</title>
    <script type="application/x-javascript" src="js/jquery.js"></script>
    <script type="application/x-javascript">
        function showmcd(id){
            $("<div>").load("recap_mc.php?id="+id, function(){
            $("#mcd").html($(this));
            });
        }
    </script>
</head>
<body>
    <h1>Liste des MC</h1>
    <div id="list"><? print $listmc; ?></div>
    <hr/>
    <div id="mcd">
    </div>
</body>
</html>