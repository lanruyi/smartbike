<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//// user_helper ////////////////////////////////////////////////////
function h_authority_name_chn(){
	$authority_name_chn[ESC_AUTHORITY__FRONTEND_READ] = "前端数据查看权限";
	$authority_name_chn[ESC_AUTHORITY__FRONTEND_CONTROL] = "前端基站控制权限";
        $authority_name_chn[ESC_AUTHORITY__FRONTEND_DETAIL] = "前端基站详细数据权限";

	$authority_name_chn[ESC_AUTHORITY__BACKEND_STATION_DATA] = "后端基站数据管理权限";
	$authority_name_chn[ESC_AUTHORITY__BACKEND_ESG] = "后端ESG管理权限";
	$authority_name_chn[ESC_AUTHORITY__BACKEND_ADMINISTRATOR] = "后端超级管理权限";
	$authority_name_chn[ESC_AUTHORITY__BACKEND_AGING] = "后端老化管理权限";
	$authority_name_chn[ESC_AUTHORITY__BACKEND_STATION_LOG] = "后端基站维护日志管理权限";
	$authority_name_chn[ESC_AUTHORITY__BACKEND_INSTALLATION] = "后端施工管理权限";		
	return $authority_name_chn;
}

//// contract_helper ////////////////////////////////////////////////////

//超过8期就会出问题 如何解决;
function h_contract_phase_name_chn($num){
    $names = array("0"=>"未知","1"=>"一期","2"=>"二期",
        "3"=>"三期","4"=>"四期","5"=>"五期",
        "6"=>"六期","7"=>"七期","8"=>"八期");
    return $names[$num];
}


//// batch_helper ////////////////////////////////////////////////////

//超过8批就会出问题 如何解决;
function h_batch_batch_name_chn($num){
    $names = array("0"=>"未知","1"=>"一批","2"=>"二批",
        "3"=>"三批","4"=>"四批","5"=>"五批",
        "6"=>"六批","7"=>"七批","8"=>"八批");
    return $names[$num];
}

function h_batch_interval($start,$current){ 
    if(strtotime($current) <= strtotime($start)){
        return 0;
    }else{
        $year  = date("Y",strtotime($current)) - date("Y",strtotime($start));
        $month = date("m",strtotime($current)) - date("m",strtotime($start));
        return $year * 12 + $month;
    }

}


//// auto_check /////////////////////////////////////////////////////

//
function h_autocheck_report_trans($autocheck_report){
    if(!$autocheck_report){
        return '<font style="color:#3f3">自检通过</font>';
    }
    if($autocheck_report == '["no_check"]'){
        return "未自检";
    }
    if($autocheck_report == '["no_data"]'){
        return '<font style="color:red">自检未通过</font>: 没数据';
    }
    if($autocheck_report == '["no_alloff"]'){
        return '<font style="color:red">自检未通过</font>: 无设备全关数据';
    }
    if($autocheck_report == '["dc_wrong"]'){
        return '<font style="color:red">自检未通过</font>: 直流功率错误';
    }
    if($autocheck_report == '["main_wrong"]'){
        return '<font style="color:red">自检未通过</font>: 总功率错误';
    }


    return $autocheck_report;
}



//// correct /////////////////////////////////////////////////////

function h_available_slope($slope){
    return  $slope<1.1 && $slope >0.9;
}



////// esgfix ////////////////////////////////////////////////////

function h_esgfix_ver_name_chn_array(){
    $a["0"] = "其他版本"; 
    $a["1"] = "版本a"; 
    $a["2"] = "版本b"; 
    $a["3"] = "版本c"; 
    $a["4"] = "版本d"; 
    $a["5"] = "版本e"; 
    $a["6"] = "版本f"; 
    $a["7"] = "版本g"; 
    $a["8"] = "版本h"; 
    return $a;
}

function h_esgfix_ver_name_chn($esg_ver){
    return name_or_no_name(h_esgfix_ver_name_chn_array(),$esg_ver);
}

function h_esgfix_reason_array(){
    $a["0"] = "其他原因"; 
    $a["1"] = "电源模块坏";
    $a["2"] = "通信模块坏";
    $a["3"] = "新风控制板坏";
    $a["4"] = "ARM板坏";
    $a["5"] = "485板坏";
    $a["6"] = "智能电表坏";
    $a["7"] = "ESG整机故障";
    $a["8"] = "智能电表电压采集线断开";
    $a["9"] = "ESG无故断电";
    $a["10"] = "智能电表感应环坏";
    return $a;
}

function h_esgfix_reason($reason){
    return name_or_no_name(h_esgfix_reason_array(),$reason);
}


//function h_sharp_to_dot($org){
    //return strtr($org,"#",".");
//}

function h_dot_to_sharp($org){
    return strtr($org,".","#");
}









