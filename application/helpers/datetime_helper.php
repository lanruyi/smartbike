<?php if (!defined('BASEPATH')) exit('No direct script accessss allowed');
// ..\..\tests\helpers\DateTimeHelperTest.php

function h_dt_format($time_str,$format="YmdHis"){  return $time_str != NULL?date($format,strtotime($time_str)):NULL; }
function h_dt_diff($time1,$time2){ return strtotime($time1) - strtotime($time2); }
function h_dt_now(){ return date('YmdHis', strtotime('now')); }
function h_dt_JS_unix($t){ return strtotime($t)*1000; }

function h_dt_diff_day($time1,$time2){
    $day1 = h_dt_start_time_of_day($time1);
    $day2 = h_dt_start_time_of_day($time2);
    return abs(strtotime($day1) - strtotime($day2))/(3600*24);
}

//有测试 返回给定时间的那个小时的开始时间 如20121015190000 （15号19点整）
function h_dt_start_time_of_hour($time_str) {
    $timestamp = strtotime($time_str);
    return (0 == $timestamp)?"":date("YmdH0000", $timestamp);
}

//有测试 返回给定时间的那个小时的结束时间 如20121015195959  （15号19点59分59秒）
function h_dt_stop_time_of_hour($time_str) {
    $timestamp = strtotime($time_str);
    return (0 == $timestamp)?"":date("YmdH5959", $timestamp);
}

//有测试 返回给定时间的那天的开始时间 如20121015000000  （15号凌晨0点0分0秒）
function h_dt_start_time_of_day($time_str) {
    $timestamp = strtotime($time_str);
    return (0 == $timestamp)?"":date("Ymd000000", $timestamp);
}

//有测试 返回给定时间的那天的开始之后的21分钟 如20121015002100  （15号凌晨0点21分0秒）
function h_dt_start_time_of_day_21($time_str) {
    $timestamp = strtotime($time_str);
    return (0 == $timestamp)?"":date("Ymd002100", $timestamp);
}

//有测试 返回给定时间的那天的结束时间 如20121015235959  （15号晚上23点59分59秒）
function h_dt_stop_time_of_day($time_str) {
    $timestamp = strtotime($time_str);
    if (0 == $timestamp)
        return "";
    return date("Ymd235959", $timestamp);
}

//有测试 返回 给定时间的那个月的开始时间 如20121001000000  （1号早上0点0分0秒）
function h_dt_start_time_of_month($time_str) {
    $timestamp = strtotime($time_str);
    if (0 == $timestamp)
        return "";
    return date("Ym01000000", $timestamp);
}

//有测试 返回 给定时间的那个月的结束时间 如20121031235959  （31号晚上23点59分59秒）
function h_dt_stop_time_of_month($time_str) {
    $timestamp = strtotime($time_str);
    if (0 == $timestamp)
        return "";
    $firstday = date('Ym01000000', strtotime($time_str));
    return date('Ymd235959', strtotime("$firstday +1 month -1 day"));
}


// 以上为千锤百炼的白金函数




// 常用的函数

function h_last_time($from,$to='now',$second=false){
    $timediff = strtotime($to) - strtotime($from);
    $str = "";
    if($timediff > 0){
        $days  = intval($timediff/86400); 
        $hours = intval(($timediff%86400)/3600); 
        $mins  = intval(($timediff%3600)/60); 
        $secs  = $timediff%60; 
        if($days  > 0 ){ $str .= $days."天 "; }
        if($hours > 0 ){ $str .= $hours."小时 "; }
        if($mins  > 0 ){ $str .= $mins."分 "; }
        if($secs  > 0 ){ $str .= $secs."秒"; }
    }
    return $str;
}

//echo is_date("2009-01-01 23:59:59")
function h_dt_is_date($date){
    if($date == date('Y-m-d H:i:s',strtotime($date))){
        return true;
    }
    
     return false;
 }


function h_dt_month_array($start,$stop){
    $_t = h_dt_start_time_of_month($start);
    $month_array = array();
    while(!h_dt_compare($_t,$stop)){
        $month_array[$_t] = h_dt_format($_t,"Y-m-d");
        $_t = h_dt_add_month($_t);
    }
    return $month_array;
}


//返回一个月多少天
function h_dt_past_days_of_month($time_str){
    if(h_dt_is_time_this_month($time_str)){
        return (int)h_dt_format('now','d');
    }else if(h_dt_is_time_future_month($time_str)){
        return 0;
    }else{
        return date("t",strtotime($time_str));
    }
}

//返回一个月多少天
function h_dt_days_of_month($time_str){
    return date("t",strtotime($time_str));
}

//比较两个时间
//第一个时间比第二个时间晚（大）返回true
//nmins用于修正
function h_dt_compare($time1,$time2,$nmins=0){
    return strtotime($time1)+60*$nmins > strtotime($time2);
}

function h_dt_diff_mins($time1,$time2){
    if($time1 && $time2){
        $seconds = strtotime($time1) - strtotime($time2);
        return  floor($seconds/60);
    }else{
        return null;
    }
}


//已单元测试
function h_dt_add_month($time_str,$n=1){
    return date('YmdHis', strtotime($time_str." +".$n." month"));
}
function h_dt_sub_month($time_str,$n=1){
    return date('YmdHis', strtotime($time_str." -".$n." month"));
}
function h_dt_add_day($time,$n=1){
    return date('YmdHis', strtotime($time)+86400*$n);
}
function h_dt_sub_day($time,$n=1){
    return date('YmdHis', strtotime($time)-86400*$n);
}
function h_dt_add_hour($time,$n=1){
    return date('YmdHis', strtotime($time)+ 3600*$n);
}
function h_dt_sub_hour($time,$n=1){
    return date('YmdHis', strtotime($time)- 3600*$n);
}
function h_dt_add_min($time,$n=1){
    return date('YmdHis', strtotime($time)+60*$n);
}
function h_dt_sub_min($time,$n=1){
    return date('YmdHis', strtotime($time)-60*$n);
}



//返回昨天的此时此刻(24小时前)
function h_dt_yesterday() {
    return date("YmdHis",strtotime("-1 day"));
}

//返回前天的此时此刻(48小时前)
function h_dt_day_before_yesterday() {
    return date("YmdHis",strtotime("-2 day"));
}


function h_dt_is_first_day_of_month($time){
   return h_dt_start_time_of_month($time) == h_dt_start_time_of_day($time); 
}


//判断给定时间是否为今天或者未来
//已单元测试
function h_dt_is_today_or_future($_ts) {
    return strtotime($_ts) >= strtotime(h_dt_start_time_of_day("now"));
}
//判断给定时间是否为未来
//已单元测试
function h_dt_is_future($_ts) {
    return strtotime($_ts) >= strtotime('now');
}
function h_dt_is_future_day($_ts) {
    return strtotime($_ts)>strtotime(h_dt_stop_time_of_day("now"));
}


//返回 给定时间的下个月的开始时间 如20121101000000  （下个月1号早上0点0分0秒）
//已单元测试
function h_dt_next_month($_ts) {
    $timestamp = strtotime($_ts);
    if (0 == $timestamp)
        return "";
    return date('Ym01000000', strtotime("$_ts +1 month"));
}

//返回 给定时间的上个月的开始时间 如20121101000000  （上个月1号早上0点0分0秒）
//已单元测试
function h_dt_prev_month($_ts) {
    $timestamp = strtotime($_ts);
    if (0 == $timestamp)
        return "";
    return date('Ym01000000', strtotime("$_ts -1 month"));
}

//返回一个时间第二天的开始时间 （第二天早上0点） 
//已单元测试
function h_dt_start_time_of_tommorrow($time_str) {
    $timestamp = strtotime($time_str);
    if (0 == $timestamp)
        return "";
    return date('Ymd000000', $timestamp + 3600 * 24);
}

//判断给定时间是否为今天
//已单元测试
function h_dt_is_today($_ts) {
    $timestamp = strtotime($_ts);
    if (0 == $timestamp)
        return "";
    $today_start = date('Ymd000000', strtotime("now"));
    $today_stop = date('Ymd235959', strtotime("now"));
    return strtotime($_ts) >= strtotime($today_start) && strtotime($_ts) <= strtotime($today_stop);
}


////////////////////////////////////////////////
/////////////////// clear //////////////////////
////////////////////////////////////////////////


function h_dt_date_str($time_str) {
    $_t = new DateTime($time_str);
    return $_t->format('Y-m-d H:i:s');
}

function h_dt_date_str_db($time_str) {
    $_t = new DateTime($time_str);
    return $_t->format('YmdHis');
}


function h_dt_datetime_str_db($time_str) {
    $_t = new DateTime($time_str);
    return $_t->format('Ymd');
}

function h_dt_date_str_no_time($time_str) {
    $_t = new DateTime($time_str);
    return $_t->format('Y-m-d');
}

function h_dt_date_str_no_day($time_str) {
    $_t = new DateTime($time_str);
    return $_t->format('Y-m');
}

function h_dt_date_str_timestamp($time_str) {
    $_t = new DateTime($time_str);
    return $_t->getTimestamp();
}

function h_dt_datetime_is_same_day($d1, $d2) {
    return floor((strtotime($d1) - strtotime($d2)) / 86400);
}

// return where day in n+1; 0 means standard; 1~n means saving
// 已单元测试
function h_dt_np1_day_sql($time_str, $ns, $ns_start) {
    if (!($ns_start && $ns))
        return 0;
    $days = floor((strtotime($time_str) - (strtotime($ns_start))) / 86400 + ($ns + 1) * 6000); //In case its a minea 
    return $days % ($ns + 1);
}


function h_dt_time_str_last_month() {
    $_t = new DateTime('-1 month');
    return $_t->format('YmdHis');
}

function h_dt_str_to_js_unix_time($str) {
    return strtotime($str) * 1000;
}

function h_dt_readable_time($seconds, $show_seconds = true) {
    $timediff = $seconds;
    $days = intval($timediff / 86400);
    $remain = $timediff % 86400;
    $hours = intval($remain / 3600);
    $remain = $remain % 3600;
    $mins = intval($remain / 60);
    $secs = $remain % 60;
    $str = "";
    if ($days != 0)
        $str .= $days . "天 ";
    if ($hours != 0)
        $str .= $hours . "小时 ";
    $str .= $mins . "分 ";
    if ($show_seconds)
        $str .= $secs . "秒";
    return $str;
}

function h_dt_last_time($start_time, $end_time = null, $show_seconds = false) {
    if ($end_time) {
        $timediff = abs(strtotime($start_time->format('r')) - strtotime($end_time->format('r')));
    } else {
        $timediff = abs(strtotime($start_time->format('r')) - strtotime('now'));
    }
    return h_dt_readable_time($timediff, $show_seconds);
}

function h_dt_last_day_of_month($time_str) {
    $_t = new datetime($time_str);
    $_t->add(new DateInterval('P1M'));
    $_t = new datetime($_t->format("y-m-1 00:00:00"));
    $_t->sub(new DateInterval('P1D'));
    return $_t->format('r');
}

function h_dt_last_7day_of_month($time_str) {
    $_t = new datetime($time_str);
    $_t = new datetime($_t->format("y-m-1 00:00:00"));
    $_t->sub(new DateInterval('P7D'));
    return $_t->format('r');
}

function h_dt_now_str() {
    $_t = new DateTime();
    return $_t->format('r');
}

function h_dt_is_time_this_hour($time_str) {
    $_t = new DateTime($time_str);
    $_t_start = new DateTime(h_dt_start_time_of_hour(h_dt_now_str()));
    $_t_stop = new DateTime(h_dt_stop_time_of_hour(h_dt_now_str()));
    return ($_t >= $_t_start) && ($_t < $_t_stop);
}

function h_dt_is_time_future_hour($time_str) {
    $_t = new DateTime($time_str);
    $_t_stop = new DateTime(h_dt_stop_time_of_hour(h_dt_now_str()));
    return $_t >= $_t_stop;
}

function h_dt_is_time_this_day($time_str) {
    $_t = new DateTime($time_str);
    $_t_start = new DateTime(h_dt_start_time_of_day(h_dt_now_str()));
    $_t_stop = new DateTime(h_dt_stop_time_of_day(h_dt_now_str()));
    return ($_t >= $_t_start) && ($_t < $_t_stop);
}


function h_dt_is_time_this_month($time_str) {
    $_t = new DateTime($time_str);
    $_t_start = new DateTime(h_dt_start_time_of_month(h_dt_now_str()));
    $_t_stop = new DateTime(h_dt_stop_time_of_month(h_dt_now_str()));
    return ($_t >= $_t_start) && ($_t < $_t_stop);
}

function h_dt_is_time_future_month($time_str) {
    $_t = new DateTime($time_str);
    $_t_stop = new DateTime(h_dt_stop_time_of_month(h_dt_now_str()));
    return $_t >= $_t_stop;
}

///////////////////////////////////////////////////////////////////
///////////////////////readable time///////////////////////////////
///////////////////////////////////////////////////////////////////

function h_dt_readable_day($str){
    $time = strtotime($str);
    return date('Y-m-d',$time);
}

function h_dt_week_name($d) {
    $a[0] = '周日';
    $a[1] = '周一';
    $a[2] = '周二';
    $a[3] = '周三';
    $a[4] = '周四';
    $a[5] = '周五';
    $a[6] = '周六';
    return $a[$d];
}

function h_dt_r_day($_ts) {
    return date("Y-m-d",strtotime($_ts));
}

function h_dt_r_mouth_saving_day($_ts) {
    $_t = new DateTime($_ts);
    return $_t->format("m月d日") . "&nbsp;&nbsp;" . h_dt_week_name($_t->format("w"));
}

function h_dt_r_mouth_saving_day_input($_ts) {
    $_t = new DateTime($_ts);
    return $_t->format("Y-m");
}

function h_dt_now_day(){
    return date("Ymd",time());
}


//有单元测试
//function h_dt_interval_month($start_time,$end_time){
    //if(!$start_time || !$end_time || !strtotime($start_time) || !strtotime($end_time)){
        //return "";
    //}
    //$start = new DateTime($start_time);
    //$end = new DateTime($end_time);
    ////符号
    //$mark = h_dt_compare($start_time,$end_time)?"-":"";
    //$interval = $start->diff($end);
    //$years = $interval->format('%y');
    //$months = $interval->format('%m');
    //return intval($mark.($years*12+$months));
//}
