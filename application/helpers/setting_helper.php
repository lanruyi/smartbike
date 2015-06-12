<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("main_helper.php");


// 如何添加一个设置 下列5个函数都要修改

function h_setting_name_inside($type=false){
    $setting_name_ens = array("undefine","update_duration", "update_fixed_datetime", "sample_duration",
        "sample_fixed_datetime", "base_interval", "warning_period", "lowest_press",
        "highest_colds_temp", "highest_indoor_tmp", "highest_indoor_hum", "highest_box_tmp",
        "ch_tmp", "cd_tmp", "all_close_temp", "temp_adjust_factor", "fan_min_time","sys_mode","simple_control","day_of_week",
        "ctime","colds_order","colds_min_time","colds_box_type","smart_meter_type","colds_0_ctrl_type",
        "colds_1_ctrl_type","fan_keep_on_time");
    if($type === false){
        return $setting_name_ens;
    }else{
        return $setting_name_ens[$type];
    }
}

function h_setting_name_chn($type){
    $setting_name_chns = array("未知","更新周期", "更新周期字符串", "采样周期",
        "采样周期字符串", "基本周期", "告警周期", "最低负压",
        "最高出风口温度", "最高室内温度", "最高室内湿度", "最高恒温柜温度",
        "ch_tmp", "cd_tmp", "全关室内温度", "温度补偿因子", "新风最小开时间","系统模式","简单控制","6+1节能日","现在时间","空调启动次序","空调最短时间","恒温柜类型","智能电表类型","空调1控制方式","空调2控制方式","新风延长开启时间");
    return $setting_name_chns[$type];
}

function h_setting_desc($type){
    $setting_name_chns = array("未知","", "", "", "", "", "", "", "", "", "", "",
        "", "", "", "", "","","","","","0为正常顺序，1为交换顺序","单位：分钟","0春兰 1榜样",
        "0博欧 1雅达2060","0继电器 1表示485 2脉冲","0继电器 1表示485 2脉冲",
        "即到空调开的条件时,不立即关闭新风，而继续开新风时间长度，单位是min，0表示不延长");
    return $setting_name_chns[$type];
}

function h_setting_item_type_check($type){
    if($type<0 || $type>27) return false;
    return true;
}

function h_setting_is_str($type){
    $_is_setting_str = array(0/*0*/,0/*1*/,1,0,1/*4*/,0,0,0,0,0,0,0,0,0,0,0,0/*16*/,0,0,0,0,0/*21*/,0,0,0,0/*25*/,0,0);
    return $_is_setting_str[$type];
}
function h_setting_disable($type){
    $res = array(0/*0*/,0/*1*/,1,1,1/*4*/,1,0,0,0,0,0,0,0,0,0,0,0/*16*/,0,0,0,0,0/*21*/,0,0,0,0/*25*/,0,0);
    return $res[$type];
}

