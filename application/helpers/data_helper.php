<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("station_helper.php");


function h_datas_average_power($datas){
    $main_all = 0;
    $dc_all   = 0;
    $num      = count($datas);
    $result   = array("main"=>0,"dc"=>0);
    if($num){
        foreach($datas as $data){
            $main_all += $data['power_main'];
            $dc_all   += $data['power_dc'];
        }
        $result['main'] = $main_all/$num;
        $result['dc']   = $dc_all/$num;
    }
    return $result;
}


function h_data_min_box_tmp($tmp1,$tmp2,$tmp3){
    if($tmp1 !== "" && $tmp2 !== ""){
        $min = ($tmp1 <= $tmp2) ? $tmp1:$tmp2;
    }else{ 
        $min = ($tmp1 !== "") ? $tmp1:$tmp2;
    }
    if($min !== "" && $tmp3 !== ""){
        $min = ($min <= $tmp3) ? $min:$tmp3;
    }else{ 
        $min = ($min !== "") ? $min:$tmp3;
    }
    return $min;
}

function h_data_change_energy_array($array){
    $result = array();
    $old_value = null;
    foreach($array as $value){
        if($old_value!==null){
            if($value && $old_value){
                $hour_value = $value - $old_value;
            }else{
                $hour_value = 0;
            }
            if($hour_value < 0 || $hour_value >400){
                $hour_value = 0;
            }
            $result[] = $hour_value; 
        }
        $old_value = $value;
    }
    return $result;
}

function h_data_check_day_energy_normal($day_energy){
    if( $day_energy < 0 || $day_energy > 400){
        return 0;
    }else{
        return round($day_energy,2);
    }
}

function h_make_highchart_str($time,$value){
    return '['.h_dt_JS_unix($time).','.($value?$value:"null").']';
}

function h_temperature_name_chn(){
	$temperature_name_chn = array("未定义");
	$temperature_name_chn[ESC_INDOOR_TMP] = "室内温度";
	$temperature_name_chn[ESC_OUTDOOR_TMP] = "室外温度";
	$temperature_name_chn[ESC_BOX_TMP] = "恒温柜温度";
	$temperature_name_chn[ESC_COLDS_0_TMP] = "空调1风口温度";
	$temperature_name_chn[ESC_COLDS_1_TMP] = "空调2风口温度";
	$temperature_name_chn[ESC_COLDS_2_TMP] = "空调3风口温度";
	return $temperature_name_chn;
}

function h_temperature_options(){
	$options = h_temperature_name_chn();
	$options[0] = "全部温度类型";
	return $options;
}

function h_temperature_name_get($type){
	$name_chn = h_temperature_name_chn();
	return $name_chn[$type];
}

function h_humidity_name_chn(){
	$humidity_name_chn = array("未定义");
	$humidity_name_chn[ESC_INDOOR_HUM] = "室内湿度";
	$humidity_name_chn[ESC_OUTDOOR_HUM] ="室外湿度";
	return $humidity_name_chn;
}

function h_humidity_options(){
	$options = h_humidity_name_chn();
	$options[0] = "全部湿度类型";
	return $options;
}

function h_humidity_name_get($type){
	$name_chn = h_humidity_name_chn();
	return $name_chn[$type];
}

function h_switchon_name_chn(){
	$switchon_name_chn = array("未定义");
	$switchon_name_chn[ESC_COLDS_0_ON] = "空调1开关";
	$switchon_name_chn[ESC_COLDS_1_ON] = "空调2开关";
	$switchon_name_chn[ESC_COLDS_2_ON] = "空调3开关";
	$switchon_name_chn[ESC_FAN_0_ON] = "新风进口开关";
	$switchon_name_chn[ESC_FAN_1_ON] = "新风出口开关";
	$switchon_name_chn[ESC_COLDS_BOX_ON] = "恒温柜冷源开关";
	return $switchon_name_chn;
}

function h_switchon_options(){
	$options = h_switchon_name_chn();
	$options[0] = "全部开关类型";
	return $options;
}

function h_switchon_name_get($type){
	$name_chn = h_switchon_name_chn();
	return $name_chn[$type];	
}

function h_power_name_chn(){
	$power_name_chn = array("未定义");
	$power_name_chn[ESC_POWER_MAIN] = "总功率";
	$power_name_chn[ESC_POWER_DC] = "直流负载功率";
	$power_name_chn[ESC_POWER_COLDS_0] = "空调1功率";
	$power_name_chn[ESC_POWER_COLDS_1] = "空调2功率";
	$power_name_chn[ESC_POWER_FAN] = "新风功率";
	return $power_name_chn;
}

function h_power_options(){
	$options = h_power_name_chn();
	$options[0] = "全部功率类型";
	return $options;
}

function h_power_name_get($type){
	$name_chn = h_power_name_chn();
	return $name_chn[$type];	
}

function h_energy_name_chn(){
	$power_name_chn = array("未定义");
	$power_name_chn[ESC_ENERGY_MAIN] = "总电能";
	$power_name_chn[ESC_ENERGY_DC] = "直流负载电能";
	$power_name_chn[ESC_ENERGY_COLDS_0] = "空调1电能";
	$power_name_chn[ESC_ENERGY_COLDS_1] = "空调2电能";
	$power_name_chn[ESC_ENERGY_FAN] = "新风电能";
	return $power_name_chn;
}

function h_energy_options(){
	$options = h_energy_name_chn();
	$options[0] = "全部电能类型";
	return $options;
}

function h_energy_name_get($type){
	$name_chn = h_energy_name_chn();
	return $name_chn[$type];	
}

///////////////////////////////////////////////////////////////////////
function h_data_dql_str($type,$inputs){
	$params = array();
	foreach ($inputs as $key => $value) {
		if(!$value) continue;
		if($key=="type"){array_push($params,$type.".type=".$value);}
		if($key=="start_time"){array_push($params,$type.".create_time>".$value);}
		if($key=="stop_time"){array_push($params,$type.".create_time<".$value);}
	}
	if($params){
		return "and ".implode(" and ", $params);
	}else{
		return "";
	}	
}

function h_data_get_str($per_page,$inputs){
	$params = array("?per_page=".$per_page);
	foreach ($inputs as $key => $value) {
		array_push($params,$key."=".$value);
	}
	return implode("&", $params);
}

function h_data_station_id_judge($id,$array){
	$result = 0;
	if($id){
		foreach ($array as $key => $value) {
			if($id!=$key) continue;
			$result = 1;
		}
		return $result;
	}else{
		return 1;
	}
}

function h_data_switch_on_select($name,$default=0){
	if(!$default){
		$default = 0;
	}
	$str = "
	<select name='".$name."' style='width:60px'>
		<option value=0 ".($default==0?"selected":"")."> </option>
		<option value=1 ".($default==1?"selected":"")."> 关 </option>
		<option value=2 ".($default==2?"selected":"")."> 开 </option>
	</select>
	";
	return $str;
}



function h_flist_project_select($projects,$default){
	$projects_for_select= array();
	foreach($projects as $project){
		$projects_for_select[$project['id']] = $project['name_chn']; 
	}
	return h_make_select($projects_for_select,'project_id',$default,"");
}


function h_flist_city_select($cities,$default){
    
	$cities_for_select= array();
	foreach($cities as $city){
		$cities_for_select[$city['id']] = $city['name_chn']; 
	}
	return h_make_select($cities_for_select,'city_id',$default,"");
}




