<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("main_helper.php");

function h_db_esgconf_array(){
    $esgconf[1] = array("sid"=>"s01","cn"=>"更新周期",        "dbc"=>"update_duration",
                        "is_str"=>"","is_disable"=>"",
                        "desc"=>"");
    $esgconf[2] = array("sid"=>"s02","cn"=>"新风采样持续",    "dbc"=>"fan_sampling_last_time",
                        "is_str"=>"","is_disable"=>"",
                        "desc"=>"");
    $esgconf[3] = array("sid"=>"s03","cn"=>"基准日空调设温",  "dbc"=>"base_day_ac_temp",
                        "is_str"=>"","is_disable"=>"",
                        "desc"=>"");
    $esgconf[4] = array("sid"=>"s04","cn"=>"节能日空调设温",  "dbc"=>"energy_saving_ac_temp",
                        "is_str"=>"","is_disable"=>"",
                        "desc"=>"");
    $esgconf[5] = array("sid"=>"s05","cn"=>"基本周期",        "dbc"=>"base_interval",
                        "is_str"=>"","is_disable"=>"",
                        "desc"=>"");
    $esgconf[6] = array("sid"=>"s06","cn"=>"告警周期",        "dbc"=>"warning_period",
                        "is_str"=>"","is_disable"=>"",
                        "desc"=>"");
    $esgconf[7] = array("sid"=>"s07","cn"=>"最低负压",        "dbc"=>"lowest_press",
                        "is_str"=>"","is_disable"=>"",
                        "desc"=>"");
    return $esgconf; 
}


// 如何添加一个设置 下列5个函数都要修改 并且记得修改数据库（migration）
function h_esgconf_is_dis($s){
    $str_array = array("s05");
    return in_array($s,$str_array);
}

function h_esgconf_is_str($s){
    $str_array = array("s28","s34");
    return in_array($s,$str_array);
}

function h_esgconf_array(){
    return array(
        "s01"=>array("en"=>"update_duration",       "cn"=>"更新周期",          
                        "desc"=>""),
        "s02"=>array("en"=>"fan_sampling_last_time","cn"=>"新风采样持续", 
                        "desc"=>""),
        "s03"=>array("en"=>"base_day_ac_temp",      "cn"=>"基准日空调设置温度",
                        "desc"=>""),
        "s04"=>array("en"=>"energy_saving_ac_temp", "cn"=>"节能日空调设置温度",
                        "desc"=>""),
        "s05"=>array("en"=>"base_interval",         "cn"=>"基本周期", 
                        "desc"=>""),
        "s06"=>array("en"=>"warning_period",        "cn"=>"告警周期", 
                        "desc"=>""),
        "s07"=>array("en"=>"lowest_press",          "cn"=>"最低负压", 
                        "desc"=>""),
        "s08"=>array("en"=>"highest_colds_temp",    "cn"=>"最高出风口温度",
                        "desc"=>""),
        "s09"=>array("en"=>"highest_indoor_tmp",    "cn"=>"最高室内温度", 
                        "desc"=>""),
        "s10"=>array("en"=>"highest_indoor_hum",    "cn"=>"最高室内湿度", 
                        "desc"=>""),
        "s11"=>array("en"=>"highest_box_tmp",       "cn"=>"最高恒温柜温度", 
                        "desc"=>""),
        "s12"=>array("en"=>"ch_tmp",                "cn"=>"空调1启动温度", 
                        "desc"=>""),
        "s13"=>array("en"=>"cd_tmp",                "cn"=>"步进量", 
                        "desc"=>""),
        "s14"=>array("en"=>"all_close_temp",        "cn"=>"设备全关补偿因子", 
                        "desc"=>""),
        "s15"=>array("en"=>"temp_adjust_factor",    "cn"=>"新风启动补偿因子", 
                        "desc"=>""),
        "s16"=>array("en"=>"fan_min_time",          "cn"=>"新风最小开时间",
                        "desc"=>""),
        "s17"=>array("en"=>"sys_mode",              "cn"=>"系统模式",
                        "desc"=>""),
        "s18"=>array("en"=>"simple_control",        "cn"=>"简单控制",
                        "desc"=>""),
        "s19"=>array("en"=>"day_of_week",           "cn"=>"6+1节能日",
                        "desc"=>""),
        "s20"=>array("en"=>"ctime",                 "cn"=>"现在时间",
                        "desc"=>""),
        "s21"=>array("en"=>"colds_order",           "cn"=>"空调启动次序",
                        "desc"=>"0为正常顺序，1为交换顺序"),
        "s22"=>array("en"=>"colds_min_time",        "cn"=>"空调最短时间",
                        "desc"=>"单位：分钟"),
        "s23"=>array("en"=>"colds_box_type",        "cn"=>"恒温柜类型",
                        "desc"=>"0春兰 1榜样"),
        "s24"=>array("en"=>"smart_meter_type",      "cn"=>"智能电表类型",
                        "desc"=>"0博欧 1雅达2060"),
        "s25"=>array("en"=>"colds_0_ctrl_type",     "cn"=>"空调1控制方式",
                        "desc"=>"0继电器 1表示485 2脉冲"),
        "s26"=>array("en"=>"colds_1_ctrl_type",     "cn"=>"空调2控制方式",
                        "desc"=>"0继电器 1表示485 2脉冲"),
        "s27"=>array("en"=>"fan_keep_on_time",      "cn"=>"新风延长开启时间",
                        "desc"=>"到空调开的条件时,不立即关闭而继续开新风时间长度，单位是min，0表示不延长"),
        "s28"=>array("en"=>"fan_full_speed_duration", "cn"=>"风机调速",
                        "desc"=>"格式********,例07002100表示从早上7点到晚上21点全速运行，其余时段半速运行"),
        "s29"=>array("en"=>"colds_onoff_distance",  "cn"=>"空调开关温差",
                        "desc"=>"浮点数，1位小数点;单位℃"),
        "s30"=>array("en"=>"in_out_distance",       "cn"=>"新风启动内外温差", 
                        "desc"=>"新风启动内外温差"),
        "s31"=>array("en"=>"colds_box_workpoint",   "cn"=>"恒温柜空调制冷点",
                        "desc"=>""),
        "s32"=>array("en"=>"colds_box_worksens",    "cn"=>"制冷点灵敏度",       
                        "desc"=>""),
        "s33"=>array("en"=>"load_num",              "cn"=>"基站负载",
                        "desc"=>"保留两位小数"),
        "s34"=>array("en"=>"host",                  "cn"=>"上位机主机名",
                        "desc"=>"形如jslt.s 出厂默认的应该是s")
    );
}

function h_esgconf_exist($c){
    $array = h_esgconf_array(); 
    return isset($array[$c]);
}
function h_esgconf_name_en($c){
    $array = h_esgconf_array(); 
    return isset($array[$c])?$array[$c]['en']:null;
}
function h_esgconf_name_chn($c){
    $array = h_esgconf_array(); 
    return isset($array[$c])?$array[$c]['cn']:"未知";
}
function h_esgconf_name_desc($c){
    $array = h_esgconf_array(); 
    return isset($array[$c])?$array[$c]['desc']:"";
}

function h_num_to_sxx($num){
    if($num<10) { return "s0".$num; }else{ return "s".$num; }
}


