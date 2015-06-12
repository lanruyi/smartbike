<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("main_helper.php");


function h_property_array(){
    $property["p01"] = "rom_version";
    $property["p02"] = "es_main_bd_ver";
    $property["p03"] = "es_ext_bd_ver";
    $property["p04"] = "outdoor_ts_ver";
    $property["p05"] = "indoor_ts_ver";
    $property["p06"] = "colds_0_ts_ver";
    $property["p07"] = "colds_1_ts_ver";
    $property["p08"] = "box_1_ts_ver";
    $property["p09"] = "box_2_ts_ver";
    $property["p10"] = "up_time";
    $property["p11"] = "gprs_type";
    $property["p12"] = "platform";
    return $property;
}

function h_property_name_en($id){
    $property_array = h_property_array();
    if(isset($property_array[$id])){
        return $property_array[$id];
    }else{
        return null;
    }
}
