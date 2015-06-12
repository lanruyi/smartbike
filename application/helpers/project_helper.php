<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("main_helper.php");

function h_project_type_array() {
    $name_chn[ESC_PROJECT_TYPE_STANDARD_SAVING_COMMON] = "基准标杆节能";
    $name_chn[ESC_PROJECT_TYPE_NPLUSONE] = "n+1节能";
    $name_chn[ESC_PROJECT_TYPE_STANDARD_SAVING] = "全站对比节能";
    $name_chn[ESC_PROJECT_TYPE_STANDARD_SAVING_SH] = "全站对比节能(上海)";
    return $name_chn;
}


function h_project_ope_type_array() {
    $name_chn['common'] = "普通模式";
    $name_chn['big'] = "运营模式";
    $name_chn['pilot'] = "试运营模式";
    $name_chn['abandon'] = '放弃模式';
    return $name_chn;
}

function h_project_ope_type($type) {
    $arr = h_project_ope_type_array();
    if ($arr[$type]) {
        return $arr[$type];
    }
}

function h_project_type_name_chn($type) {
    return name_or_no_name(h_project_type_array(), $type);
}

function h_project_type_select($default = 0, $first = "全部", $width = 100) {
    return h_make_select(h_project_type_array(), 'type', $default, $first, $width);
}

function h_project_ope_type_select($default = 0, $first = "全部", $width = 100) {
    return h_make_select(h_project_ope_type_array(), 'ope_type', $default, $first, $width);
}

