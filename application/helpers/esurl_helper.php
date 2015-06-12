<?
function h_url_report_final_table_url($project_id,$city_id,$datetime,$backurl=""){
    return "/reporting/table/final_table?project_id=".$project_id
        ."&city_id=".$city_id
        ."&datetime=".$datetime
        ."&backurl=".$backurl;
}

function h_url_report_common_table_url($project_id,$city_id,$datetime,$building,$backurl=""){
    return "/reporting/table/common_table/".$building."?project_id=".$project_id
        ."&city_id=".$city_id
        ."&datetime=".$datetime
        ."&backurl=".$backurl;
}

function h_url_report_common_stage_table_url($project_id,$city_id,$datetime,$building,$backurl=""){
    return "/reporting/table/common_stage_table/".$building."?project_id=".$project_id
        ."&city_id=".$city_id
        ."&datetime=".$datetime
        ."&backurl=".$backurl;
}

function h_url_report_saving_table_url($project_id,$city_id,$datetime,$building,$backurl=""){
    return "/reporting/table/saving_table/".$building."?project_id=".$project_id
        ."&city_id=".$city_id
        ."&datetime=".$datetime
        ."&backurl=".$backurl;
}

function h_url_report_table_calc_common_table($project_id,$city_id,$datetime,$building,$backurl=""){
    return "/reporting/table/calc_common_table_cache/".$building."?project_id=".$project_id
        ."&city_id=".$city_id
        ."&datetime=".$datetime
        ."&backurl=".$backurl;
}

function h_url_report_table_calc_saving_table($project_id,$city_id,$datetime,$building,$backurl=""){
    return "/reporting/table/calc_saving_table_cache/".$building."?project_id=".$project_id
        ."&city_id=".$city_id
        ."&datetime=".$datetime
        ."&backurl=".$backurl;
}

function h_url_report_init_savtablecache($project_id,$city_id,$datetime,$backurl=""){
    return "/reporting/table/init_savtablecache?project_id=".$project_id
        ."&city_id=".$city_id
        ."&datetime=".$datetime
        ."&backurl=".$backurl;
}

function h_url_report_auto_config_all($project_id,$city_id,$building,$datetime,$backurl=""){
    return "/reporting/savpair/auto_config_all?project_id=".$project_id
        ."&city_id=".$city_id
        ."&building=".$building
        ."&datetime=".$datetime
        ."&backurl=".$backurl;
}

function h_url_report_recalc_row($project_id,$city_id,$building,$datetime,$backurl=""){
    return "/reporting/savpair/recalc_row?project_id=".$project_id
        ."&city_id=".$city_id
        ."&building=".$building
        ."&datetime=".$datetime
        ."&backurl=".$backurl;
}
function h_url_report_recalc_savpairs($project_id,$city_id,$building,$datetime,$backurl=""){
    return "/reporting/savpair/recalc_savpairs?project_id=".$project_id
        ."&city_id=".$city_id
        ."&building=".$building
        ."&datetime=".$datetime
        ."&backurl=".$backurl;
}

function h_url_report_set_savpair($project_id,$city_id,$building,$datetime,$backurl="",$bookmark=""){
    return "/reporting/savpair/savpair_detail?project_id=".$project_id
        ."&city_id=".$city_id
        ."&building=".$building
        ."&datetime=".$datetime
        ."&backurl=".$backurl
        ."#".$bookmark;
}

function h_url_report_add_savpairs($project_id,$city_id,$building,$datetime,$backurl=""){
    return "/reporting/savpair/add_savpairs?project_id=".$project_id
        ."&city_id=".$city_id
        ."&building=".$building
        ."&datetime=".$datetime
        ."&backurl=".$backurl;
}

function h_url_report_del_savpair($savpair_id,$project_id,$city_id,$building,$datetime,$backurl=""){
    return "/reporting/savpair/del_savpair/".$savpair_id."?project_id=".$project_id
        ."&city_id=".$city_id
        ."&building=".$building
        ."&datetime=".$datetime
        ."&backurl=".$backurl;
}

function h_project_url($url_str,$project_type){
    if('station_list' == $url_str){
        if(ESC_PROJECT_TYPE_STANDARD_SAVING_COMMON == $project_type){
            return "/frontend/stations/newlist";
        }else if(ESC_PROJECT_TYPE_NPLUSONE == $project_type){
            return "/frontend/stations/slist";
        }else if(ESC_PROJECT_TYPE_STANDARD_SAVING == $project_type){
            return "/frontend/stations/stdlist";
        } else if(ESC_PROJECT_TYPE_STANDARD_SAVING_SH == $project_type) {
            return "/frontend/stations/stdlist_sh";
        }
    }
    return "";
}

