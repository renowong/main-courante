<?php

function rev_date($mysql_date){
    $arrdate = explode("-",$mysql_date);
    return $arrdate[2]."-".$arrdate[1]."-".$arrdate[0];
}

?>