<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function h_aging_process_array(){
    $name_chn[ESC_ESG_AGING_NONE] = "未老化";
    $name_chn[ESC_ESG_AGING_ING] = "老化中";
    $name_chn[ESC_ESG_AGING_FINISH] = "老化完成";
    return $name_chn;
}

function h_aging_color_array(){
    $name_chn[ESC_ESG_AGING_NONE] = "<font color=red>未老化</font>";
    $name_chn[ESC_ESG_AGING_ING] = "<font color=green>正在老化</font>";
    $name_chn[ESC_ESG_AGING_FINISH] = "<font color=black>老化完成</font>";
    return $name_chn;
}

function h_aging_process_name_chn($aging_status){
    return name_or_no_name(h_aging_process_array(),$aging_status);
}

function h_aging_status_clolor($aging_status) {
    return name_or_no_name(h_aging_color_array(),$aging_status);
}

function h_aging_process_select($default=0,$first="全部",$width=100){
    return h_make_select(h_aging_process_array(),'aging_status',$default,$first,$width);
}

function h_start_stop_time($esg){
	$aging_name = h_aging_process_name_chn($esg['aging_status']);
	$start_time = $esg['aging_start_time'];
	$stop_time = $esg['aging_stop_time'];
	if(ESC_ESG_AGING_ING === $esg['aging_status']){
		 return $aging_name.",刷新统计最新数据! 上次统计时间: ".$refresh_time." 老化时间: ".$start_time." ~";
	}
	if(ESC_ESG_AGING_FINISH === $esg['aging_status']){
		return $aging_name."! 老化时间: ".$start_time." ~ ".$stop_time;
	}	
}

