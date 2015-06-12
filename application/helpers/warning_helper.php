<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("main_helper.php");


function h_warning_type_name_chn_short($type){
    $warning_type_name_chn = array("未定义");
    $warning_type_name_chn[ESC_WARNING_TYPE__DISCONNECT] = "失去连接";
    $warning_type_name_chn[ESC_WARNING_TYPE__ENERGY_WRONG] = "能耗异常";
    $warning_type_name_chn[ESC_WARNING_TYPE__INDOORTMP_HIGH] = "室温过高";
    $warning_type_name_chn[ESC_WARNING_TYPE__BOXTMP_HIGH] = "柜温过高";
    $warning_type_name_chn[ESC_WARNING_TYPE__MAINTAINANCE_BUTTON] = "代维按钮";
	$warning_type_name_chn[ESC_WARNING_TYPE__SENSOR_INDOOR_BROKEN] = "室内传感坏";
	$warning_type_name_chn[ESC_WARNING_TYPE__SENSOR_OUTDOOR_BROKEN] = "室外传感坏";
	$warning_type_name_chn[ESC_WARNING_TYPE__SENSOR_BOX_BROKEN] = "柜温传感坏";
	$warning_type_name_chn[ESC_WARNING_TYPE__SENSOR_COLDS0_BROKEN] = "空调0传感坏";
	$warning_type_name_chn[ESC_WARNING_TYPE__SENSOR_COLDS1_BROKEN] = "空调1传感坏";	
	$warning_type_name_chn[ESC_WARNING_TYPE__SENSOR_ENERGY_MAIN_BROKEN] = "总能耗传感坏";
	$warning_type_name_chn[ESC_WARNING_TYPE__SENSOR_ENERGY_DC_BROKEN] = "DC能耗传感坏";
    $warning_type_name_chn[ESC_WARNING_TYPE__UTILITY_FAILURE] = "市电停电";
	$warning_type_name_chn[ESC_WARNING_TYPE__485_DIE] = "485故障";
    $warning_type_name_chn[ESC_WARNING_TYPE__ESG_TIME_INCORRECT] = "ESG时间有误";
    return name_or_no_name($warning_type_name_chn,$type);
}

function h_warning_finish_type_desc($type){
        
    switch($type){
        case ESC_WARNING_FINISH_TYPE__AUTO:
            return "问题解决自动清除";
        case ESC_WARNING_FINISH_TYPE__MANUAL:
            return "请手动清除";
        case ESC_WARNING_FINISH_TYPE__ONCE:
            return "问题10分钟清除";
    }

}



function h_warning_priority_color($priority){
    switch($priority){
        case ESC_WARNING_PRIORITY__HIGH:
            return "red";
        case ESC_WARNING_PRIORITY__MIDDLE:
            return "orange";
        case ESC_WARNING_PRIORITY__LOW:
            return "gray";
    }
}

function h_warning_priority_name_chn($priority){
    switch($priority){
        case ESC_WARNING_PRIORITY__HIGH:
            $name_chn = "高";
            break;
        case ESC_WARNING_PRIORITY__MIDDLE:
            $name_chn = "中";
            break;
        case ESC_WARNING_PRIORITY__LOW:
            $name_chn = "低";
            break;
    }
    return $name_chn;
}

function h_warning_priority_mark($priority){
    return '<font style="background-color:'.h_warning_priority_color($priority)
        .';padding:2px;color:#fff;font-weight:bold">'.h_warning_priority_name_chn($priority).'</font>';
}

function h_warning_priority_png($priority){
    return '/static/site/img/icon/warning_'.$priority.'.png';
}

function h_warning_type_array(){
    $array[ESC_WARNING_TYPE__DISCONNECT] = "失去连接";
	$array[ESC_WARNING_TYPE__SENSOR_INDOOR_BROKEN] = "室内传感器坏";
	$array[ESC_WARNING_TYPE__SENSOR_OUTDOOR_BROKEN] = "室外传感器坏";
	$array[ESC_WARNING_TYPE__485_DIE] = "485总线故障";
    $array[ESC_WARNING_TYPE__INDOORTMP_HIGH] = "室温过高";
    $array[ESC_WARNING_TYPE__BOXTMP_HIGH] = "柜温过高";
	$array[ESC_WARNING_TYPE__SENSOR_ENERGY_MAIN_BROKEN] = "总能耗传感器坏";
	$array[ESC_WARNING_TYPE__SENSOR_ENERGY_DC_BROKEN] = "DC能耗传感器坏";
	$array[ESC_WARNING_TYPE__SENSOR_BOX_BROKEN] = "柜温传感器坏";
	$array[ESC_WARNING_TYPE__SENSOR_COLDS0_BROKEN] = "空调0传感器坏";
	$array[ESC_WARNING_TYPE__SENSOR_COLDS1_BROKEN] = "空调1传感器坏";	
    $array[ESC_WARNING_TYPE__UTILITY_FAILURE] = "市电停电";
    $array[ESC_WARNING_TYPE__MAINTAINANCE_BUTTON] = "代维按钮";
    $array[ESC_WARNING_TYPE__ESG_TIME_INCORRECT] = "ESG时间有误";
    $array[ESC_WARNING_TYPE__ENERGY_WRONG] = "能耗异常";
    return $array;
}


function h_warning_type_name_chn($type){
    return  name_or_no_name(h_warning_type_array(),$type);
}

function h_warning_type_select($default=0,$first="全部",$width=100){
    return h_make_select(h_warning_type_array(),'type',$default,$first,$width);
}

function h_warning_status_array(){
    $array[ESC_WARNING_STATUS__OPEN] = "打开";
    $array[ESC_WARNING_STATUS__CLOSED] = "关闭";
    return $array;
}

function h_warning_status_name_chn($type){
    return name_or_no_name(h_warning_status_array(),$type);
}

function h_warning_status_select($default=0,$first="全部",$width=100){
    return h_make_select(h_warning_status_array(),'status',$default,$first,$width);
}

function h_warning_relative_select($name,$objects,$current=0,$first="全部",$width=200){
    return h_make_select(h_objects_array($objects),$name,$current,$first,$width);
}




