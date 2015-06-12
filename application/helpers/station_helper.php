<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function h_station_ids($stations){
    $ids = array();
    foreach ($stations as $station){
        $ids[]= $station['id'];
    }
    return $ids;
}
    
//返回每个基站类型对应的故障“紧急系数”
function h_station_type_modulus($station_type){
    $modulus[ESC_STATION_TYPE_COMMON]=1;
    $modulus[ESC_STATION_TYPE_SAVING]=100;
    $modulus[ESC_STATION_TYPE_STANDARD]=100;
    $modulus[ESC_STATION_TYPE_NPLUSONE]=50;
    if(isset($modulus[$station_type])){
        return $modulus[$station_type];
    }else{
        return 1;
    }
    
}
    
function h_station_bug_point_select($default=""){
    $array[1] = "无故障(0)";
    $array[2] = "轻微故障(<50)";
    $array[3] = "严重故障(>=50)";
    return h_make_select($array, 'bug_point_select',$default,"全部",100);
}
    
    
function h_station_colds_type_name_chn($colds_type){
    $colds_type_name_chn = array("未定义");
    $colds_type_name_chn[ESC_STATION_COLDS_TYPE_MEDIA] = "美的机房空调";
    $colds_type_name_chn[ESC_STATION_COLDS_TYPE_DAIKIN] = "大金机房空调";
    $colds_type_name_chn[ESC_STATION_COLDS_TYPE_FEIFAN] = "非凡鸿盛精密空调";
    $colds_type_name_chn[ESC_STATION_COLDS_TYPE_SANLINGHAIER] = "三菱海尔工业空调";
    return $colds_type_name_chn[$colds_type];
}
    
    
function h_station_colds_num_array(){
    $array[0] = "无空调";
    $array[1] = "一台空调";
    $array[2] = "两台空调";
    $array[3] = "三台空调";
    return $array;
}
    
function h_station_colds_num_name_chn($num){
    return name_or_no_name(h_station_colds_num_array(),$num);
}
    
function h_station_station_type_array(){
    $array[ESC_STATION_TYPE_STANDARD] = "基准站";
    $array[ESC_STATION_TYPE_SAVING] = "标杆站";
    $array[ESC_STATION_TYPE_COMMON] = "节能站";
    $array[ESC_STATION_TYPE_NPLUSONE] = "n+1站";
    return $array;
}
function h_station_station_type_name_chn_slist($type){
    $mark = array();
    $mark[ESC_STATION_TYPE_STANDARD] = "<font style='color:#339'>基准站</font>";
    $mark[ESC_STATION_TYPE_COMMON] = "<font style='color:#5b5'>节能站</font>";
    $mark[ESC_STATION_TYPE_SAVING] = "<font style='color:#b55'>标杆站</font>";
    $mark[ESC_STATION_TYPE_NPLUSONE] = "<font style='color:#999'>N+1站</font>";
    return $mark[$type];
}
    
function h_station_station_type_name_chn($type){
    return name_or_no_name(h_station_station_type_array(),$type);
}
function h_station_station_type_select($default=0,$first="全部",$width=100){
    return h_make_select(h_station_station_type_array(),'station_type',$default,$first,$width);
}


function h_station_fan_type_array(){
    $name_chn[ESC_FAN_TYPE_BOOU] = "博欧";
    $name_chn[ESC_FAN_TYPE_BANGYANG] = "榜样";
    return $name_chn;
}

function h_station_fan_type_name_chn($type){
    return name_or_no_name(h_station_fan_type_array(),$type);
}

function h_station_fan_type_select($default=0,$first="全部",$width=100){
    return h_make_select(h_station_fan_type_array(),'fan_type',$default,$first,$width);
}


    
function h_project_station_type_select($project_type,$default=0,$first="全部",$width=100){
    $array = array();
    if(ESC_PROJECT_TYPE_STANDARD_SAVING_COMMON == $project_type){
        $array[ESC_STATION_TYPE_STANDARD] = "基准站";
        $array[ESC_STATION_TYPE_SAVING] = "标杆站";
        $array[ESC_STATION_TYPE_COMMON] = "节能站";
    }
    if(ESC_PROJECT_TYPE_NPLUSONE == $project_type){
        $array[ESC_STATION_TYPE_NPLUSONE] = "n+1站";
    }
    return h_make_select($array,'station_type',$default,$first,$width);
}
    
function h_bar_station_type_string($type){
    if(0 != $type)
    return '<font class="label label-success">'.h_station_station_type_name_chn($type).'</font>';
}
    
    
function h_station_total_load_array(){
    $a = array();
    $a[ESC_TOTAL_LOAD_10A20A] = "10-20A"; 
    $a[ESC_TOTAL_LOAD_20A30A] = "20-30A"; 
    $a[ESC_TOTAL_LOAD_30A40A] = "30-40A"; 
    $a[ESC_TOTAL_LOAD_40A50A] = "40-50A"; 
    $a[ESC_TOTAL_LOAD_50A60A] = "50-60A"; 
    $a[ESC_TOTAL_LOAD_60A70A] = "60-70A"; 
    $a[ESC_TOTAL_LOAD_70APLUS] = "70A+"; 
    return $a;
}
    
function h_station_frontend_visible_array(){
    $a = array();
    $a[ESC_FRONTEND_VISIBLE] = "可见";
    $a[ESC_FRONTEND_UNVISIBLE] = "隐藏";
    return $a;
}
function h_station_have_box_array(){
    $a = array();
    $a[ESC_HAVE_BOX_NONE] = "否";
    $a[ESC_HAVE_BOX] = "是";
    return $a;
}

function h_station_box_filter_array() {
    $a = array();
    $a[ESC_STATION_BOX_TYPE_CHUNLAN] = "春兰";
    $a[ESC_STATION_BOX_TYPE_BANGYANG] = "榜样";
    $a[ESC_STATION_BOX_TYPE_LANGJI] = "郎吉";
    $a[ESC_STATION_BOX_TYPE_MAIRONG] = "麦融高科";
    $a[ESC_STATION_BOX_TYPE_NUOXI] = "诺西";
    $a[ESC_STATION_BOX_TYPE_HUAWEI] = "华为";
    $a[ESC_STATION_BOX_TYPE_NONE] = "未安装";
    return $a;
}

function h_station_have_box_name_chn($type){
    return name_or_no_name(h_station_have_box_array(),$type);
}

function h_check_total_load($total_load){
    $hash = h_station_total_load_array();
    return isset($hash[$total_load]);
}

function h_check_station_type($station_type){
    $hash = h_station_station_type_array();
    return isset($hash[$station_type]);
}
function h_station_total_load_name_chn($type){
    return name_or_no_name(h_station_total_load_array(),$type);
}

//此函数重构时应该删除
function h_station_total_load_select($default=0,$first="全部",$width=100){
    return h_make_select(h_station_total_load_array(),'total_load',$default,$first,$width);
}

function h_bar_total_load_string($type){
    if(0 != $type)
    return '<font class="label">'.h_station_total_load_name_chn($type).'</font>';
}

function h_get_total_load_by_load_num($load_num){
    $total_load = floor($load_num/10);
    if($total_load < 1){ $total_load = 1; }
    if($total_load > 7){ $total_load = 7; }
    return $total_load;
}
function h_get_ggh($load_num){
    if(!($load_num > 0)) return 1;
    return round((h_get_total_load_by_load_num($load_num)*10+5)/$load_num,2);
}

function h_power_main_out_range($power_main,$load_num){
    $U_min = $load_num*60*0.8; 
    $U_max = $load_num*60*1.2+650;
    if(($power_main > $U_min) and ($power_main < $U_max)){
        return 0;
    }else if($power_main < $U_min){
        return -1;
    }else if($power_main > $U_max){
        return 1;
    }
}

function h_power_dc_out_range($power_dc,$load_num){
    $U_min = $load_num*60*0.8; 
    $U_max = $load_num*60*1.2;
    if(($power_dc > $U_min) and ($power_dc < $U_max)){
        return 0;
    }else if($power_dc < $U_min){
        return -1;
    }else if($power_dc > $U_max){
        return 1;
    }
}

function h_judge_power_dc_by_load_num($power_dc,$load_num){
    $U_min = 60*0.8; 
    $U_max = 60*1.2;
    $str = "";
    if($load_num){
        if(($power_dc < $load_num*$U_min) or ($power_dc > $load_num*$U_max)){
            return $str .= "background-color:red;color:white;";
        }
    }
    return $str;
}

function h_building_stcache_saving($building){
    $array[ESC_BUILDING_ZHUAN] = "zhuan_saving";
    $array[ESC_BUILDING_BAN] = "ban_saving";
    return $array[$building];
}
function h_building_stcache_common($building){
    $array[ESC_BUILDING_ZHUAN] = "zhuan_common";
    $array[ESC_BUILDING_BAN] = "ban_common";
    return $array[$building];
}

function h_station_building_array(){
    $array[ESC_BUILDING_ZHUAN] = "砖墙";
    $array[ESC_BUILDING_BAN] = "彩钢板";
    return $array;
}
function h_check_building_type($building_type){
    $hash =  h_station_building_array();
    return isset($hash[$building_type]);
}
function h_station_building_name_chn($type){
    return name_or_no_name(h_station_building_array(),$type);
}

function h_station_building_select($default=0,$first="全部",$width=100){
    return h_make_select(h_station_building_array(),'building',$default,$first,$width);
}






function h_station_status_array(){
    $array[ESC_STATION_STATUS_NORMAL] = "正常运营";
    $array[ESC_STATION_STATUS_CREATE] = "新建站点";
    $array[ESC_STATION_STATUS_PASS]   = "工程已验收";
    $array[ESC_STATION_STATUS_YUNWEI] = "运维验收";
    $array[ESC_STATION_STATUS_REMOVE] = "已拆除";
    return $array;
}
function h_check_status_type($status_type){
    $hash =  h_station_status_array();
    return isset($hash[$status_type]);
}
function h_station_status_name_chn($type){
    return name_or_no_name(h_station_status_array(),$type);
}
function h_station_status_select($default=0,$first="全部",$width=100){
    return h_make_select(h_station_status_array(),'status',$default,$first,$width);
}








function h_station_type_select($default=0,$first="全部",$width=100){
    return h_make_select(h_station_station_type_array(),'station_type',$default,$first,$width);
}


function h_station_relative_select($name,$objects,$current=0,$first="全部",$width=100){
    return h_make_select(h_objects_array($objects),$name,$current,$first,$width);
}
//by boyu.liu
function h_station_relative_select_sql($name,$array,$current=0,$first="全部",$width=100){
    $res = array();
    foreach($array as $item){
        $res[$item['id']] = $item['name_chn'];
    }
    return h_make_select($res,$name,$current,$first,$width);
}
//by liwen
function h_work_order_relative_select($name,$objects,$current=0,$first="全部",$width=100){
    return h_make_select(h_objects_array($objects),$name,$current,$first,$width);
}


function h_station_rom_select($roms,$current=0,$first="全部",$width=100){
	foreach ($roms as $key => $rom) {
		$array[$rom['id']] = $rom['version']."(".$rom['station_num'].")";
	}
    return h_make_select($array,"rom_id",$current,$first,$width);
}

function h_bar_building_string($type){
    $css = array("");
    $css[ESC_BUILDING_ZHUAN] = "label";
    $css[ESC_BUILDING_BAN] = "label";
    if($type == 0) return "";
    return '<font class="'.$css[$type].'">'.
        h_station_building_name_chn($type).'</font>';
}



function get_process_status_css($my,$now){
    if($my < $now){
        return "finish";
    }else if($my == $now){
        return "ing";
    }else if($my > $now){
        return "wait";
    }
}

function get_process_status_icon($my,$now){
    if($my < $now){
        return "<li class='icon icon-ok'></li>";
    }else if($my == $now){
        return "<li class='icon icon-arrow-right'></li>";
    }else if($my > $now){
        return "<li class='icon icon-time'></li>";
    }
}


function h_bar_online_string($online){
	if($online){
        return '<font class="label label-success">在线</font>';
	}else{
        return '<font class="label label-important">不在线</font>';
	}
} 


function h_online_gif_new($station_alive){
    if(1 == $station_alive){
        return '/static/site/img/icon/connect.png'.hsid();
    }else if(2 == $station_alive){
        return '/static/site/img/icon/disconnect.png'.hsid();
    }else{
        return '';
    }
}


function h_bar_on_off($onoff,$type="fan"){
    if($type === "fan") $name = "新风";
    if($type === "colds_0") $name = "空调1";
    if($type === "colds_1") $name = "空调2";
    if($onoff){
         return '<font class="label label-success">'.$name.'开</font>';
    }else{
         return '<font class="label label-inverse">'.$name.'关</font>';
    }
}

function h_online_string_mobile($online,$size=14){
	if($online){
		return '<font style="background-color:#0f0;size:'.$size.'px;color:#fff;font-weight:bold;padding:1px">在线</font>';
	}else{
		return '<font style="background-color:#f00;size:'.$size.'px;color:#fff;font-weight:bold;padding:1px">不在线</font>';
	}
} 

//橙蓝两色的站点类型小图标
function h_station_type_mark($type,$size=14){
    if(ESC_STATION_TYPE_STANDARD === $type){
        return '<font style="background-color:#d61;size:'.$size.'px;color:#fff;font-weight:bold;">标准</font>';
    }else{
        return '<font style="background-color:#369;size:'.$size.'px;color:#fff;font-weight:bold;">节能</font>';
    }
}

function h_station_type_mark_short($type){
    if(ESC_STATION_TYPE_STANDARD == $type){ return "[标]"; }
    if(ESC_STATION_TYPE_SAVING == $type){ return "[节]"; }
    if(ESC_STATION_TYPE_COMMON == $type){ return "[普]"; }
}

// mobile新风空调开关判别_基站信息
function h_fan_colds_on_off_mark($status){
	if($status==1){
		return "开";
	}else{
		return "关";
	}
}

function h_list_page_get_str($con,$p,$v){
    $str="?";
    $str.=$p."=".$v;
    foreach($con as $key => $value){
        if($key === $p) continue;
        $str.="&".$key."=".$value;
    }
    return $str;
}

function h_list_page_dql_str($p_id,$con){
    $str="select s from Entities\Station s where ";
    $str.=" s.project_id=".$p_id;
    foreach($con as $key => $value){
        if(!$value) continue;
        $str.=" and s.".$key."=".$value;
    }
    return $str;
}


function h_sort_page_con_status($status){
	$value = "";
	if($status == "asc") $value = "btn-inverse";
	if($status == "desc") $value = "btn-primary";
	return $value;
}

function h_sort_page_con_order($order){
	if($order=="desc") {$order = "asc";}
	else {$order = "desc";}
	return $order;
}


function h_station_force_on_array(){
    $array[ESC_STATION_FORCE_NORMAL] = "";
    $array[ESC_STATION_FORCE_ONOFF] = "干预";
    return $array;
}

function h_station_force_on_name_chn($type){
    return name_or_no_name(h_station_force_on_array(),$type);
}

function h_station_force_on_color_name($type){
    $array[ESC_STATION_FORCE_NORMAL] = "";
    $array[ESC_STATION_FORCE_ONOFF] = "#f00";
    return '<font style="color:'.$array[$type].'">'.name_or_no_name(h_station_force_on_array(),$type).'</font>';
}

function h_station_force_on_select($default=0,$first="全部",$width=100){
    return h_make_select(h_station_force_on_array(),'force_on',$default,$first,$width);
}

function h_station_air_volume_array(){
    $array[ESC_STATION_VOLUME_1700] = "1700风量";
    $array[ESC_STATION_VOLUME_3000] = "3000风量";
    $array[ESC_STATION_VOLUME_OTHER] = "其它风量";
    $array[ESC_STATION_VOLUME_NONE] = "未安装";
    
    return $array;
}

function h_station_air_volume_name_chn($type){
    return name_or_no_name(h_station_air_volume_array(),$type);
}


function h_station_air_volume_select($default=0,$first="全部",$width=100){
    return h_make_select(h_station_air_volume_array(),'air_volume',$default,$first,$width);
}

function h_station_warning_priority_select($default=0,$first="全部",$width=100){
    return h_make_select(h_station_warning_priority_array(), 'warning_priority',$default,$first,$width);
}

function h_station_warning_priority_array(){
    $array[ESC_WARNING_PRIORITY__HIGH] = "严重";
    $array[ESC_WARNING_PRIORITY__MIDDLE] = "中等";
    $array[ESC_WARNING_PRIORITY__LOW] = "轻微";
    return $array;
}

function h_station_warning_priority_name_chn($type){
    return name_or_no_name(h_station_warning_priority_array(),$type);
}

function h_station_box_type_array(){
    $array[ESC_STATION_BOX_TYPE_CHUNLAN] = "春兰";
    $array[ESC_STATION_BOX_TYPE_BANGYANG] = "榜样";
    $array[ESC_STATION_BOX_TYPE_LANGJI] = "郎吉";
    $array[ESC_STATION_BOX_TYPE_MAIRONG] = "麦融高科";
    $array[ESC_STATION_BOX_TYPE_NUOXI] = "诺西";
    $array[ESC_STATION_BOX_TYPE_HUAWEI] = "华为";
    $array[ESC_STATION_BOX_TYPE_NONE] = "未安装";
    return $array;
}

function h_station_box_type_name_chn($type){
    return name_or_no_name(h_station_box_type_array(),$type);
}

function h_station_box_type_select($default=0,$first="全部",$width=100){
    return h_make_select(h_station_box_type_array(),'box_type',$default,$first,$width);
}

function h_station_stage_array(){
    $array[1] = "无分期";
    $array[11] = "一期1批";
    $array[12] = "一期2批";
    $array[13] = "一期3批";
    $array[21] = "二期1批";
    $array[22] = "二期2批";
    $array[23] = "二期3批";
    $array[31] = "三期1批";
    $array[32] = "三期2批";
    $array[33] = "三期3批";
    $array[41] = "四期1批";
    $array[42] = "四期2批";
    $array[43] = "四期3批";
    return $array;
}

function h_station_stage_name_chn($stage){
    return name_or_no_name(h_station_stage_array(),$stage);
}

function h_station_stage_select($default=0,$first="全部",$width=100){
    return h_make_select(h_station_stage_array(),'stage',$default,$first,$width);
}

function h_common_select($name,$arrs,$default=0,$width=100){
    if(!$default){$default = "0";}
    $str = '<select id="' . $name . '" name="' . $name . '" value="' . $default . '" style="width:' . $width . 'px">';
    
    $str .= '<option value=0 ' . ((string)$default === "0" ? "selected" : "") . '>全部</option>';
    foreach ($arrs as $arr) {
        $str .= '<option value=' . $arr['id'] . ' ' . ((string)$default === (string)$arr['id'] ? "selected" : "") . '>' . $arr['name_chn'] . '</option>';
    }
    $str .= '</select>';
    return $str;
}

//基站sim号的简单判断,ctype_digit判断是否是整数
function h_station_sim_judge($num){
    if (empty($num)) {
        return false;
    } else {
        $num = trim($num);
        //手机号正则匹配
        $pattern = '/^(1(([35][0-9])|(47)|[8][01236789]))\d{8}$/';
        if (!preg_match($pattern, $num)) {
            return false;
        }
    }
    return true;    
}

//基站类型
function h_station_type($type){
    switch($type){
        case ESC_STATION_TYPE_SAVING:
            return "<span style='color:#BB5555;width=40px'>标杆站</span>";
            break;
        case ESC_STATION_TYPE_STANDARD:
            return "<span style='color:#339999;width=40px'>基准站</span>";
            break;
        case ESC_STATION_TYPE_NPLUSONE:
            return "<span style='color:#999999;width=40px'>n+1站</span>";
            break;
        default:
            return "<span style='color:#55BB55;width=40px'>节能站</span>";
    }
}


function h_station_month_main_energy_err($main_energy,$load_num){
    $err = 0;
    if($main_energy>0){
        //---- 60*24*30/1000 * 0.75 ----
        if($main_energy > $load_num*32.4){
            $err = 0;
        }else{
            $err = 2; 
        }
    }else{
        $err = 1; 
    }
    return $err;
}


function h_station_colds_0_func_array(){
    $array[ESC_STATION_COLDS_FUNC_RELAY] = "继电器";
    //$array[ESC_STATION_COLDS_FUNC_PLUSE] = "脉冲开关";
    $array[ESC_STATION_COLDS_FUNC_485] = "接触器";
    $array[ESC_STATION_COLDS_FUNC_INFRARED] = "红外";
    return $array;
}

function h_station_setting_lock_func_array(){
    $array[ESC_STATION_SETTING_UNLOCK] = "否";
    $array[ESC_STATION_SETTING_LOCK] = "是";
    return $array;
}

function h_station_yes_or_no_array() {
    $array[ESC_STATION_SETTING_NO] = "否";
    $array[ESC_STATION_SETTING_YES] = "是";
    return $array;
}

function h_station_extra_ac_func_array(){
    $array[ESC_STATION_EXTRA_AC] = "有";
    $array[ESC_STATION_NO_EXTRA_AC] = "无";
    return $array;
}

function h_station_colds_0_func_name_chn($num){
    return name_or_no_name(h_station_colds_0_func_array(),$num);
}

function h_station_colds_1_func_array(){
    $array = h_station_colds_0_func_array();
    $array[ESC_STATION_COLDS_FUNC_NONE] = "无";
    return $array;
}

function h_station_colds_1_func_name_chn($num){
    return name_or_no_name(h_station_colds_1_func_array(),$num);
}

//空调设置对应的启动命令
//1继电器 == command 0
//2脉冲开关 暂时没有用到
//3接触器 == command 1
//4红外 == command 2
//5，默认 无 == command 100
function h_station_colds_exchange_command($num){
    switch($num){
        case ESC_STATION_COLDS_FUNC_RELAY:
            return 0;
            break;
        /*case ESC_STATION_COLDS_FUNC_PLUSE:
            return 2;
            break;*/
        case ESC_STATION_COLDS_FUNC_485:
            return 1;
            break;
        case ESC_STATION_COLDS_FUNC_INFRARED:
            return 2;
            break;
        default:
            return 100;
            break;
    }
}

//恒温柜设置对应的启动命令
//0春兰 1榜样
function h_station_box_exchange_command($num){
    switch($num){
        case ESC_STATION_BOX_TYPE_CHUNLAN:
            return 0;
            break;
        case ESC_STATION_BOX_TYPE_BANGYANG:
            return 1;
            break;
        default:
            return 100;
            break;
    }
}

//基站字段对应的名字
function h_station_column_to_name_chn(){
    $array = array();
    $array['id'] = '基站id';
    $array['name_chn'] = '基站名';
    $array['project_id'] = '项目';
    $array['city_id'] = '城市';
    $array['district_id'] = '区域';
    $array['esg_id'] = 'esg_id';
    $array['station_type'] = '基站类型';
    $array['building'] = '建筑';
    $array['load_num'] = '负载';
    $array['sim_num'] = 'sim卡号';
    $array['ns_start'] = '开始时间';
    $array['frontend_visible'] = '前端可见性';
    $array['standard_station_id'] = '对比基站';
    $array['lng'] = '经度';
    $array['lat'] = '纬度';
    $array['address_chn'] = '地址';
    $array['colds_0_func'] = '空调1启动';
    $array['colds_1_func'] = '空调2启动';
    $array['colds_num'] = '空调个数';
    $array['colds_0_type'] = '空调1类型';
    $array['colds_1_type'] = '空调2类型';
    $array['box_type'] = '恒温箱类型';
    $array['equip_with_outdoor_sensor'] = '安装室外温感';
    $array['force_on'] = '人为干预';
    $array['fan_type'] = '新风类型';
    $array['air_volume'] = '风机风量';
    $array['stage'] = '工程分期';
    $array['price'] = '电价';
    $array['extra_ac'] = '额外交流功率';
    $array['change_name_chn'] = '验收名';
    $array['setting_lock'] = '设置锁定';
    
    return $array;
}

function h_station_differ_array($origin,$end){
    $arr = array();
    if(!is_array($origin) || !is_array($end)){
        return $arr;
    }
    foreach($origin as $k=>$v){
        if(isset($end[$k]) && $end[$k]!=$v){
            $arr[$k] = $v;
        }else if(!isset($end[$k])){
            $arr[$k] = $v;
        }
    }
    return $arr;
}



function h_make_colds_num_select($default,$width = 100){
    $array = array( "1" => "1台", "2" => "2台"); 
    return h_make_select($array,"colds_num",$default,"全部",$width);
}

function h_energy_save_type(){
    $array=array();
    $array[1]="江苏联通";
    $array[2]="上海联通";
    return $array;
}
function h_energy_save_select($array, $name, $default = 0,$first="全部", $width = 100){
    if(!$default){$default = "0";}
    $str = '<select id="' . $name . '" name="' . $name . '" value="' . $default . '" style="width:' . $width . 'px">';
    if ("" != $first) {
        $str .= '<option value=0 ' . ((string)$default === "0" ? "selected" : "") . '>'.$first.'</option>';
    }
    foreach ($array as $key => $value) {
        $str .= '<option value=' . $key . ' ' . ((string)$default === (string)$key ? "selected" : "") . '>' . $value . '</option>';
    }
    $str .= '</select>';
    return $str;
}


