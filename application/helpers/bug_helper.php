<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function h_bug_type_array(){
    $array[ESC_BUG__DISCONNECT] = "失去连接";
    $array[ESC_BUG__INDOOR_TMP_HIGH] = "室内高温";
    $array[ESC_BUG__BOX_TMP_HIGH] = "恒温柜高温";
    $array[ESC_BUG__CONNECT_WEAK] = "连接不稳定";	
    $array[ESC_BUG__485_DIE] = "485故障";
    $array[ESC_BUG__REMOTE_OFF] = "远程关站";

    //$array[ESC_BUG__485_LONG_DIE] = "485顽固故障";
    $array[ESC_BUG__SENSOR_INDOOR_BROKEN] = "室内传感故障";
    $array[ESC_BUG__SENSOR_OUTDOOR_BROKEN] = "室外传感故障";
    $array[ESC_BUG__SENSOR_BOX_BROKEN] = "柜温传感故障";
    $array[ESC_BUG__SENSOR_COLDS0_BROKEN] = "空调1传感故障";
    $array[ESC_BUG__SENSOR_COLDS1_BROKEN] = "空调2传感故障";	
    $array[ESC_BUG__SMART_METER_BROKEN] = "智能电表故障";	
    $array[ESC_BUG__SMART_METER_BROKEN_2] = "智能电表故障2";	
    $array[ESC_BUG__SMART_METER_REVERSE] = "电表反接";	

    $array[ESC_BUG__NO_POWER] = "市电停电";
    $array[ESC_BUG__COLDS_OUT_CTRL] = "空调不受控"; 
    $array[ESC_BUG__HAS_OTHER_EQP] = "有其他交流设备";

    $array[ESC_BUG__AUTOCHECK] = "正在自检";
    $array[ESC_BUG__MAINTAINANCE_BUTTON] = "代维按钮";
    $array[ESC_BUG__COLDS_0_FAIL] = "空调1坏";
    $array[ESC_BUG__COLDS_1_FAIL] = "空调2坏";
    $array[ESC_BUG__DC_ENERGY_ABNORMAL] = "DC负载错误";
    $array[ESC_BUG__MAIN_ENERGY_ABNORMAL] = "总能耗异常(偏大)";
    $array[ESC_BUG__NO_COLDS_ON] = "基准日(站)异常";
    return $array;
}

function h_frontend_bug_type_array(){
    $array[ESC_BUG__DISCONNECT] = "失去连接";
    $array[ESC_BUG__INDOOR_TMP_HIGH] = "室内高温";
    $array[ESC_BUG__BOX_TMP_HIGH] = "恒温柜高温";
    $array[ESC_BUG__REMOTE_OFF] = "远程关站";

    $array[ESC_BUG__SENSOR_INDOOR_BROKEN] = "室内传感故障";
    $array[ESC_BUG__SENSOR_OUTDOOR_BROKEN] = "室外传感故障";
    $array[ESC_BUG__SENSOR_BOX_BROKEN] = "柜温传感故障";
    $array[ESC_BUG__SENSOR_COLDS0_BROKEN] = "空调1传感故障";
    $array[ESC_BUG__SENSOR_COLDS1_BROKEN] = "空调2传感故障";	
    $array[ESC_BUG__SMART_METER_BROKEN] = "智能电表故障";		

    $array[ESC_BUG__NO_POWER] = "市电停电";
    $array[ESC_BUG__COLDS_OUT_CTRL] = "空调不受控"; 
    $array[ESC_BUG__HAS_OTHER_EQP] = "有其他交流设备";

    $array[ESC_BUG__MAINTAINANCE_BUTTON] = "代维按钮";
    return $array;
}

function h_frontend_disp_bug_types() {
    foreach(h_frontend_bug_type_array() as $key=>$value) {
        $type[] = $key;
    }
    
    return $type;
}

function h_get_front_display_bugs($bugs) {
    $disp_bugs = array();
    $front_bugs_type = h_frontend_disp_bug_types();
    foreach ($bugs as $bug) {
        if(in_array($bug['type'], $front_bugs_type)) {
            $disp_bugs[] = $bug;
        }
    }
    
    return $disp_bugs;
}

//获取故障类型的名字
function h_bug_type_name_chn($type){
    return  name_or_no_name(h_bug_type_array(),$type);
}

//获取多个故障类型的名字
//有单元测试
function h_bugs_type_name_chn($type_ids){
    return implode(',',h_bugs_type_name_chn_hash($type_ids));
}

//获取多个故障类型的名字
//有单元测试
function h_bugs_type_name_chn_hash($type_ids){
    if(!$type_ids){ 
        return array();
    }
    $type_id_array = explode(',',$type_ids);
    $bug_name_array = array();
    foreach($type_id_array as $type_id){
        $bug_name_array[$type_id] = h_bug_type_name_chn($type_id);
    }
    ksort($bug_name_array);
    return $bug_name_array;
}

function h_bug_type_select($default=0,$first="全部",$width=100){
    return h_make_select(h_bug_type_array(),'type',$default,$first,$width);
}

// 前端故障只显示告警类型
function h_frontend_bug_type_select($default=0,$first="全部",$width=100){
    return h_make_select(h_frontend_bug_type_array(),'type',$default,$first,$width);
}
function h_bug_status_array(){
    $array[ESC_BUG_STATUS__OPEN] = "打开";
    $array[ESC_BUG_STATUS__CLOSED] = "关闭";
    return $array;
}

function h_bug_status_name_chn($type){
    return name_or_no_name(h_bug_status_array(),$type);
}

function h_bug_status_select($default=0,$first="全部",$width=100){
    return h_make_select(h_bug_status_array(),'status',$default,$first,$width);
}

function h_bug_relative_select($name,$objects,$current=0,$first="全部",$width=200){
    return h_make_select(h_objects_array($objects),$name,$current,$first,$width);
}

function h_last_time_front_bug($start_time,$end_time=null){
	if($end_time){
		$timediff = abs(strtotime($start_time->format('r')) - strtotime($end_time->format('r')));
	}else{
   		$timediff = abs(strtotime($start_time->format('r')) - strtotime('now'));		
	}
    $days = intval($timediff/86400); 
    $remain = $timediff%86400; 
    $hours = intval($remain/3600); 
    $remain = $remain%3600; 
    $mins = intval($remain/60); 
    $secs = $remain%60; 
    $str = "";
    if($days != 0 ) {
        $str .= $days."天 ";
    }else if($hours != 0 ){
        $str .= $hours."小时 ";
    }else if($mins != 0 ){
        $str .= $mins."分 ";
    }else if($secs != 0 ){
        $str .= $secs."秒"; 
    }
    return $str;
}

//记录是否是严重故障的，可能暂时用不着
//如果出现新的严重故障，直接往里面加就行
function h_bug_serious_fault(){
	return array(ESC_BUG__INDOOR_TMP_HIGH,ESC_BUG__DISCONNECT,ESC_BUG__485_LONG_DIE,ESC_BUG__SENSOR_INDOOR_BROKEN);
}

//判断故障是否属于严重故障，是返回true，否则返回false
//这里不能使用ctype_digit，会报错
//====有单元测试====
function h_bug_is_serious_fault($type){
	if(!is_numeric($type)){
        return false;
    }
    $arr = h_bug_serious_fault();
	if(in_array($type,$arr)){
		return true;
	}else{
		return false;
	}
}

//故障，如果是严重故障，则标记红字
function h_bug_return_bugs_msg($bugs){
    $str = "";
    if(is_array($bugs) && count($bugs)>0){
        foreach($bugs as $bug){
            if(h_bug_is_serious_fault($bug['type'])){
                $str.="<span style='color:red'>".h_bug_type_name_chn($bug['type'])."</span> ";
            }else{
                $str.="<span>".h_bug_type_name_chn($bug['type'])."</span> ";    
                }
        }
    }
    return $str;
}

//时间排序，找出最大的时间
//====有单元测试====
function h_bug_time_desc($bug_time){
    if($bug_time){
        $max="";
        $key=0;
        foreach($bug_time as $k=>$v){
            if($max < strtotime($v)){
                $max = strtotime($v);
                $key = $k;
            }
        }
        return $bug_time[$key];
    }else{
        return ;
    }    
}


