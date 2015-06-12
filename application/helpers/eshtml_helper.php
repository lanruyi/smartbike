<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function h_html_year_month_select($name,$default){
    $str = "";
    $str .= h_html_year_select($name."_year",h_dt_format($default,"Y")); 
    $str .= h_html_month_select($name."_month",h_dt_format($default,"m")); 
    return $str;
}

function h_html_month_select($name,$default){
    $str ="<select id='".$name."' name='".$name."'>";
    foreach(range(1,12) as $m){
        $str.="<option value=".sprintf("%02d",$m)." ".($default==$m?"selected":"").">";
        $str.=$m."月";
        $str.="</option>";
    }
    $str .= "</select>";
    return $str;
}

function h_html_year_select($name,$default,$from="20120101",$to="now"){
    $str ="<select id='".$name."' name='".$name."'>";
    $start_year = h_dt_format($from,"Y");
    $stop_year  = h_dt_format($to,"Y");
    for($y=$start_year;$y<=$stop_year;$y++){
        $str .= "<option value=".$y." ".($default==$y?"selected":"").">";
        $str .= $y."年";
        $str .= "</option>";
    }
    $str .= "</select>";
    return $str;
}
