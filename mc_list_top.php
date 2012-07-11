<?php
session_start();
include_once("includes/global_vars.php");
include_once("includes/global_functions.php");

if(isset($_GET['date'])){
    $searchdate = "WHERE `date` <= '".rev_date($_GET['date'])."'";
}

    $mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DB);
    
    $today = (date("Y-m-d"));
    $yesterday  = date ("Y-m-d", mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));
    
    $listmc = "";
    $todaymc = "";
    $tr = 1;
    $query = "SELECT `mc`.`id_mc`,`mc`.`date` FROM `mc` $searchdate ORDER BY `date` DESC LIMIT 8";
    if ($result = $mysqli->query($query)) {
        $listmc .= "<table name='archive' id='mc' class='innertable' style=\"width:100%;\"><tr><th colspan='4'>Archives</th></tr><tr>";
        while($row = $result->fetch_assoc()){
            
            if($row["date"]==$today){
                $editlink="<a href='javascript:redirect2mc(".$row["id_mc"].")'><button>Editer</button></a>";
                $todaymc .= "<table name='mcd' id='mc' class='innertable'><tr><th colspan='2'>Main courantes en cours</th></tr>";
                $todaymc .= "<tr><td class='right'><a href='javascript:showmcd(".$row["id_mc"].");' title='Cliquez pour afficher'>".rev_date($row["date"])."</a></td><td>$editlink</td></tr>";
                $row = $result->fetch_assoc();
                if($row["date"]==$yesterday){
                    $editlink="<a href='javascript:redirect2mc(".$row["id_mc"].")'><button>Editer</button></a>";
                    $todaymc .= "<tr><td class='right'><a href='javascript:showmcd(".$row["id_mc"].");' title='Cliquez pour afficher'>".rev_date($row["date"])."</a></td><td>$editlink</td></tr>";
                }
                $todaymc .= "</table>";
                $row = $result->fetch_assoc();
            }
            
            if($row["date"]==$yesterday){
                $editlink="<a href='javascript:redirect2mc(".$row["id_mc"].")'><button>Editer</button></a>";
                $todaymc .= "<table name='mcd' id='mc' class='innertable'><tr><th colspan='2'>Main courante en cours</th></tr>";
                $todaymc .= "<tr><td class='right'><a href='javascript:showmcd(".$row["id_mc"].");' title='Cliquez pour afficher'>".rev_date($row["date"])."</a></td><td>$editlink</td></tr>";
                $todaymc .= "</table>";
            }
            
                if($_SESSION['usertype']=='1'){$editlink="<a href='javascript:redirect2mc(".$row["id_mc"].")'><button>Editer</button></a>";}else{$editlink="";}
                if($tr==2){$addtr="</tr><tr>";$tr=1;}else{$addtr="";$tr++;}
                $listmc .= "<td style='text-align:center;'><a href='javascript:showmcd(".$row["id_mc"].");' title='Cliquez pour afficher'>".rev_date($row["date"])."</a></td><td>$editlink</td>".$addtr;
            
            
        }
        $result->free();
    }
   
    $listmc=substr($listmc,0,-4);
    $listmc .= "</table>";
    
    $listmc = "<table style=\"border:0px;width:100%;\" class=\"innertable\"><tr><td style='vertical-align : top;'>".$todaymc."</td><td>".$listmc."</td></tr></table>";
    $mysqli->close();
    

    //print $query;


?>