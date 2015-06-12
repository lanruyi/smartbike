<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('ESC_COMMAND_STATUS__OPEN',1);
define('ESC_COMMAND_STATUS__CLOSED',2);
define('ESC_COMMAND_STATUS__READ',3);
define('ESC_COMMAND_STATUS__OVERTIME',4);
define('ESC_COMMAND_STATUS__FAIL',5);
define('ESC_COMMAND_STATUS__REPLACE',6);
define('ESC_COMMAND_STATUS__OVERTIME2',7);

define('ESC_COMMAND_TYPE__GS','gs');
define('ESC_COMMAND_TYPE__REB','reb');
define('ESC_COMMAND_TYPE__ST','st');
define('ESC_COMMAND_TYPE__UR','ur');
define('ESC_COMMAND_TYPE__URC','urc');
define('ESC_COMMAND_TYPE__GP','gp');
define('ESC_COMMAND_TYPE__ON','on');

function h_command_status_array(){
    $array[ESC_COMMAND_STATUS__OPEN] = "正在发送";
    $array[ESC_COMMAND_STATUS__CLOSED] = "已执行";
    $array[ESC_COMMAND_STATUS__READ] = "发送(待执行)";
    $array[ESC_COMMAND_STATUS__FAIL] = "失败";
    $array[ESC_COMMAND_STATUS__REPLACE] = "被覆盖";
    $array[ESC_COMMAND_STATUS__OVERTIME] = "发送超时";
    $array[ESC_COMMAND_STATUS__OVERTIME2] = "执行超时";
    return $array;
}

function h_command_status_name_chn($type){
    return name_or_no_name(h_command_status_array(),$type);
}

function h_command_status_color_array(){
    $array[ESC_COMMAND_STATUS__OPEN] = "正在发送";
    $array[ESC_COMMAND_STATUS__CLOSED] = "<font color=green>已执行</font>";
    $array[ESC_COMMAND_STATUS__READ] = "发送(待执行)";
    $array[ESC_COMMAND_STATUS__FAIL] = "<font color=red>失败</font>";
    $array[ESC_COMMAND_STATUS__REPLACE] = "<font color=red>被覆盖</font>";
    $array[ESC_COMMAND_STATUS__OVERTIME] = "<font color=red>发送超时</font>";
    $array[ESC_COMMAND_STATUS__OVERTIME2] = "<font color=red>执行超时</font>";
    return $array;
}

function h_command_status_color_name_chn($type){
    return name_or_no_name(h_command_status_color_array(),$type);
}

function h_command_setting_lock_name_chn(){
     return "<font color=red>设置锁定</font>";
}

function h_command_status_select($default=0,$first="全部",$width=100){
    return h_make_select(h_command_status_array(),'status',$default,$first,$width);
}

function h_command_type_array(){
$array[ESC_COMMAND_TYPE__GS] = "获取参数(gs)";
$array[ESC_COMMAND_TYPE__GP] = "获取属性(gp)";
$array[ESC_COMMAND_TYPE__REB] = "重启(reb)";
$array[ESC_COMMAND_TYPE__ST] = "设置参数(st)";
$array[ESC_COMMAND_TYPE__UR] = "更新固件(ur)";
$array[ESC_COMMAND_TYPE__URC] = "确认更新固件(urc)";
$array[ESC_COMMAND_TYPE__ON] = "远程开(on)";
return $array;
}

function h_command_type_name_chn($type){
    return name_or_no_name(h_command_type_array(),$type);
}

function h_command_type_select($default=0,$first="全部",$width=200){
    return h_make_select(h_command_type_array(),'command',$default,$first,$width);
}

function h_command_relative_select($name,$objects,$current=0,$first="全部",$width=200){
    return h_make_select(h_objects_array($objects),$name,$current,$first,$width);
}

function h_command_relative_select_sql($name,$objects,$current=0,$first="全部",$width=200){
    return h_make_select(h_objects_array_sql($objects),$name,$current,$first,$width);
}
