<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("main_helper.php");

function h_fake_JsBoxTmp($tmp_str){
    $res = json_decode($tmp_str);
    if(!$res){
        return "";
    }
    foreach($res as $key=>$temp){
        if($res[$key][1]>=34){$res[$key][1]=22;}
        if($res[$key][1]>=30){$res[$key][1]-=6;}
        if($res[$key][1]>=28){$res[$key][1]-=4;}
    }
    return json_encode($res);
}

function h_fake_jizhu_to_biaogan($type,$project_id=0){
    if(105 == $project_id && ESC_STATION_TYPE_STANDARD == $type){
        return "标杆站.";
    }
    return h_station_station_type_name_chn($type);
}

