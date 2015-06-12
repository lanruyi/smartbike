<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("main_helper.php");

function h_report_time_type_select($default=0,$first="全部",$width=100){
    return h_make_select(h_report_time_type_array(),'time_type',$default,$first,$width);
}

function h_report_time_type_array(){
    $array=array();
    $array[ESC_DAY] = "天报表";
    $array[ESC_MONTH] = "月报表";
    return $array;
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
