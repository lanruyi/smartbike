<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//过滤垃圾数据
function h_filterBugs($arr, $lng, $lat) {
    $tmp = array();
    if (count($arr)) {
        foreach ($arr as $bug) {
            if (h_calDistance($bug['lng'], $bug['lat'], $lng, $lat)) {
                array_push($tmp, $bug);
            }
        }
    }
    return $tmp;
}

//最东端 东经135度2分30秒 黑龙江和乌苏里江交汇处 
//最西端 东经73度40分 帕米尔高原乌兹别里山口（乌恰县） 
//最南端 北纬3度52分 南沙群岛曾母暗沙 
//最北端 北纬53度33分 漠河以北黑龙江主航道（漠河县）2日本朝鲜韩国
//这里以我国经纬度的极限作为边界
//====有单元测试====
function h_ll_inside_china($lng1, $lat1) {
    if ($lng1 > 136 || $lng1 < 73 || $lat1 > 54 || $lat1 < 3) {
        return false;
    } else {
        return true;
    }
}

//弧度转换
function rad($d) {
    return $d * pi() / 180.0;
}

//计算距离，结果的单位为千米(经纬度,这里相邻城市的最大距离以200千米为边界）
//====有单元测试====
function h_pointsDistance($lng1, $lat1, $lng2, $lat2){
    if(!($lng1 && $lat1 && $lat2 && $lng2)){
        return false;
    }
    $radLat1 = rad($lat1);
    $radLat2 = rad($lat2);
    $lat = $radLat1 - $radLat2;
    $lng = rad($lng1) - rad($lng2);
    $distance = 2 * asin(
                    sqrt(
                            pow(sin($lat / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($lng / 2), 2)
                    )
    );

    $distance = $distance * 6378.137;
    $distance = round($distance * 10000) / 10000;
    if ($distance <= 200) {
        return true;
    } else {
        return false;
    }
} 

//判断字符串的组成部分是由数字.数字（eg:120.234）
//====有单元测试====
function h_filterPoint($str) {
    $pattern = '/(^[1-9]\d{0,2}(\.\d{1,8})$)|(^[1-9]\d{0,2}$)/';    //注：为什么这最后不能再加个$符号呢。。结果有异常
    if(preg_match($pattern,$str)){
        return true;
    }else{
        return false;
    }
}

//过滤异常点（距离城市偏差太大的点）
//===有单元测试
function h_calDistance($lng1, $lat1, $lng2, $lat2) {
    $lng1 = trim($lng1);
    $lat1 = trim($lat1);
    $lng2 = trim($lng2);
    $lat2 = trim($lat2);
    //不在国内的不进行判断
    if (!h_ll_inside_china($lng1, $lat1) || !h_ll_inside_china($lng2, $lat2)) {
        return false;
    }
    //基站经纬度的格式错误的
    if (!h_filterPoint($lng1) || !h_filterPoint($lat1)) {
        return false;
    }
    //基站与城市距离太远的排除
     if(!h_pointsDistance($lng1, $lat1, $lng2, $lat2)){
         return false;
     }
     
     return true;
}





