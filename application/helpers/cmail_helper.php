<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("main_helper.php");

function h_cmail_status_array(){
    $array[ESC_CMAIL_STATUS__WAIT] = "等待发送";
    $array[ESC_CMAIL_STATUS__SENT] = "已发送";
    return $array;
}

function h_cmail_status_name_chn($type){
 return name_or_no_name(h_cmail_status_array(),$type);
}

function h_cmail_status_select($default=0,$first="全部",$width=100){
    return h_make_select(h_cmail_status_array(),'status',$default,$first,$width);
} 
