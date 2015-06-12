<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("main_helper.php");

function h_func_view_name_chn($func_view_name){
    $name_chn = array("realtime"=>"监控",
    "day"=>"日图表",
    "month"=>"月图表",
    "month_statistics"=>"每月报表",
    "warning"=>"报警",
    "control"=>"控制");
    return $name_chn[$func_view_name];
}

function h_realtime_box_on_off($onoff){
    if($onoff){
         return '<span class="label label-success">工作中</span>';
    }else{
         return '<span class="label label-inverse">关闭</span>';
    }
}
