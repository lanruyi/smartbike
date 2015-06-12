<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function h_ddct_array(){
    $array[ESC_DDCT_NOCALC] = "算不出能耗";
    $array[ESC_DDCT_NORMAL] = "能耗正常";
    $array[ESC_DDCT_TRUE_LOAD] = "能耗符合实际负载";
    $array[ESC_DDCT_WRONG_SMALL] = "能耗偏小";
    $array[ESC_DDCT_WRONG_LARGE] = "能耗偏大";
    return $array;
}

function h_ddct_name_chn($num){
    return name_or_no_name(h_station_colds_num_array(),$num);
}

function h_ddct_color($num){
    $array[ESC_DDCT_NOCALC] = "<font color='red'>算不出能耗</font>";
    $array[ESC_DDCT_NORMAL] = "<font color='green'>能耗正常</font>";
    $array[ESC_DDCT_TRUE_LOAD] = "<font color='green'>能耗符合实际负载</font>";
    $array[ESC_DDCT_TRUE_LOAD_WRONG] = "<font color='red'>符合实际但负载异常</font>";
    $array[ESC_DDCT_WRONG_SMALL] = "<font color='red'>能耗偏小</font>";
    $array[ESC_DDCT_WRONG_LARGE] = "<font color='red'>能耗偏大</font>";
    if(isset($array[$num])){
        return $array[$num];
    }else{
        return "";
    }
}

function h_days_str_of_month($time_str){
    $start_time = h_dt_start_time_of_month($time_str);
    $stop_time = h_dt_stop_time_of_month($time_str);
    $day_array = array();
    $_t = h_dt_start_time_of_month($time_str);
    while(!h_dt_compare($_t,$stop_time)){
        $day_array[] = h_dt_format($_t);
        $_t = h_dt_add_day($_t,1);
    }
    return implode(',',$day_array);
}







