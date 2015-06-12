<?php if (isset($_SERVER['REMOTE_ADDR'])) { die('Command Line Only!'); }

//执行函数
if (!isset($argv[1])) {
    start_test();
} elseif ($argv[1] == 'test') {
    //调用自己的单元测试
    test_test();
}

//自己的单元测试主函数
function test_test() {
    tt_noticeerror();
    //tt_getOutput(); //测试时间较长 平时可以注释
    tt_getTimeFromStr();
    tt_print_slow_pages();
}


//////////////////////////////////////////////////
// 主函数
//////////////////////////////////////////////////
function start_test() {
    //初始化
    init_php_url();

    $host = "http://127.0.0.1";

    //生成测试需要的url
    $test_urls = generate_test_url($host);
    $error_array = array();
    $str = "";
    //开始测试
    $time_array = array();
    foreach ($test_urls as $url) {
        echo "开始测试" . $url . "...\n";
        //获取url的输出

        $output = getOutput($url);
        //判断是否为空
        if (!$output) {
            echo "网页为空!!!!!!!!!!!\n";
            continue;
        }
        //判断是否有错误和警告
        if (checkheader($output)) {
            echo "网页404错误~！！\n";
            $error_array[$url] = "网页404错误";
            continue;
        }
        if (fatalerror($output)) {
            echo "网页上有php错误";
            $error_array[$url] = "网页上有php错误";
            continue;
        }

        if (Database_Error($output)) {
            echo "数据库没有此页面数据";
            $error_array[$url] = "数据库没有此页面数据";
            continue;
        }

        if (noticeerror($output)) {
            echo "网页中有notice错误!!!!!!!!!!!!\n";
            $error_array[$url] = "网页上有notice错误";
            continue;
        }
        echo "一切正常！\n";
        //找内存并存入数组
        //找时间并存入数组 该数组以时间为键名 url为键值

        $time = getTimeFromStr($output);
        $time_array[$time] = $url;
    }
    //排序 并打印性能报表
    echo "----------------------------------\n";
    echo print_slow_pages($time_array);
    if ($error_array) {
        echo "有错误的网页:-->\n";
        foreach ($error_array as $url => $error) {
            $str.= $url . "  -->错误为 -->  " . $error . "\r\n";
        }
        echo $str;
        return $str;
    }
}

//打印出加载最慢的3个页面
function print_slow_pages($time_array) {
    krsort($time_array);
    $count = 3;
    $str = "";
    foreach ($time_array as $time => $url) {
        $str.="执行较慢: [" . $time . "] " . $url . "\n";
        if (0 == ($count-=1))
            break;
    }
    return $str;
}

//判断一个字符串中是否包含php错误
//返回 true or false
function noticeerror($str) {
    if(preg_match('/PHP.*encountered/', $str)){
        echo $str;
    }
    return preg_match('/PHP.*encountered/', $str);
}

function fatalerror($str) {
    return preg_match('/Fatal.*error/', $str);
}

function Database_Error($str) {
    return preg_match('/Database.*Occurred/', $str);
}

function checkheader($str) {
    return preg_match('/404.*Found/', $str);
}

//获取一个url的结果
function getOutput($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/local_cookie.temp");
    curl_setopt($ch, CURLOPT_URL, $url);
    $output = @curl_exec($ch);
    curl_close($ch);
    return $output;
}

//测试check_error
function tt_noticeerror() {
    $test_result = array();
    array_push($test_result, true == noticeerror('asdjfhasdfhasj PHP encountered dfhasjdfhasdfh'));
    array_push($test_result, true == noticeerror('asdjfhasdfhasj PHP  encountered dfhasjdfhasdfh'));
    array_push($test_result, true == noticeerror('asdjfhasdfhasj PHP asd encountered dfhasjdfhasdfh'));
    array_push($test_result, false == noticeerror('asdjfhasdfhasjphp errfhencounteredasdfh'));
    array_push($test_result, false == noticeerror('asdjfhasdfhasjhp errordfhasjencountered'));
    var_dump($test_result);
}

//测试getOutput
function tt_getOutput() {
    init_php_url();
    $test_result = array();
    array_push($test_result, true == preg_match('/本系统按不同的使用者用途分成了七个子系统/', getOutput("http://127.0.0.1")));
    array_push($test_result, true == preg_match('/昨日节能/', getOutput("http://127.0.0.1/frontend")));
    var_dump($test_result);
}

//从页面字符串中取出页面的执行时间
function getTimeFromStr($str) {
    preg_match_all('/\d+?\.\d+?S/', $str, $result);
    //不带S的是结果里的第二组
    if ($result[0]) {
        $time_result = $result[0][0];
    } else {
        $time_result = "0.00S";
    }
    //取匹配的最后一个（页面的时间总出现在最后）
    return $time_result;
}

//测试getTimeFromStr
function tt_getTimeFromStr() {
    $test_result = array();
    array_push($test_result, "0.4129" == getTimeFromStr('bsp; Page use 0.4129S and 5.62MB</strong>'));
    array_push($test_result, "1.20" == getTimeFromStr('nbsp; Page use 1.20S and 5.62MB</strong>'));
    array_push($test_result, "1.20" == getTimeFromStr(' 123S asdfasdfasdfnbsp; Page use 1.20S and 5.62MB</strong>'));
    array_push($test_result, "1.20" == getTimeFromStr(' 1.23S asdfasdfasdfnbsp; Page use 1.20S and 5.62MB</strong>'));
    var_dump($test_result);
}

//测试print_slow_pages
function tt_print_slow_pages() {
    $test_result = array();
    array_push($test_result, "执行较慢: [8.2S] page6\n执行较慢: [8.1S] page7\n执行较慢: [8.0S] page1\n" ==
            print_slow_pages(array("8.0" => "page1", "1.9" => "page2", "1.2" => "page3", "2.2" => "page4", "0.2" => "page5", "8.2" => "page6", "8.1" => "page7", "1.34" => "page8")));
    //var_dump($test_result);
}

//登录系统 初始化cookies
function init_php_url() {
    date_default_timezone_set('PRC');
    //0.准备登录post数据
    $post_data = array();
    $post_data['login'] = "yzk";
    $post_data['password'] = "123456";
    $o = "";
    foreach ($post_data as $k => $v) {
        $o.= "$k=" . urlencode($v) . "&";
    }
    $post_data = substr($o, 0, -1);
    // 1. 初始化
    $ch = curl_init();
    // 2. 设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1/user/login");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/local_cookie.temp");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    // 3. 执行并获取HTML文档内容
    curl_exec($ch);
    curl_close($ch);
}

//生成需要测试的url数组
function generate_test_url($host) {
    $test_urls = array(
        //江苏联通站点, 
        $host . "/frontend/project/change_project/4",
        $host . "/frontend",
        $host . "/frontend/single/day/1001",
        $host . "/frontend/single/day/2156",
        $host . "/frontend/single/month/2384",
        //广西电信
        $host . "/frontend/project/change_project/3",
        $host . "/frontend",
        $host . "/frontend/single/day/773",
        $host . "/frontend/single/month/785",
        //广西百色移动站点
        $host . "/frontend/project/change_project/2",
        $host . "/frontend",
        $host . "/frontend/single/day/697",
        $host . "/frontend/single/month/2388",
        $host . "/frontend/project/change_project/4",
        //装站维修系统
        $host . "/setup",
        $host . "/setup/home/station",
        //运维系统
        $host . "/maintain",
        $host . "/maintain/home/detail",
        $host . "/maintain/home/history",
        $host . "/maintain/home/map",
        $host . "/maintain/home/rinse",
        $host . "/maintain/home/uncorrected",
        //数据分析 
        $host . "/analysis",
        $host . "/analysis/home/energy2",
        $host . "/analysis/home/energy_consumption_sorted",
        $host . "/analysis/home/energy_sav_vs_std",
        //报表系统
        $host . "/reporting",
        $host . "/reporting/savpair",
        $host . "/reporting/table",
        //后台管理系统
        $host . "/backend/station/slist",
        $host . "/backend/data?station_id=17",
        $host . "/backend/command?station_id=17",
        $host . "/backend/bug?station_id=17",
        $host . "/backend/warning?station_id=17",
        $host . "/backend/restart?station_id=17",
        $host . "/backend/station/mod_station/17",
        $host . "/backend/esgconf/set_setting/17",
        $host . "/backend/rom_update/single?station_id=17",
        $host . "/backend/blog/index?station_id=17",
        $host . "/backend/data?station_id=17",
        $host . "/backend/command?station_id=17",
        $host . "/backend/bug?station_id=17",
        $host . "/setup/home/station/17",
        $host . "/backend/esg",
        $host . "/backend/warning",
        $host . "/backend/bug",
        $host . "/backend/esgconf",
        $host . "/backend/blog",
        $host . "/backend/restart/station_list",
        $host . '/backend/edge',
        $host . "/backend/area",
        $host . "/backend/area/mod_city/40",
        $host . "/backend/cmail",
        $host . "/backend/user",
        $host . "/backend/user/mod_user/3",
        $host . "/backend/project",
        $host . "/backend/prjconfig",
        $host . "/backend/project/mod_project/100",
        $host . "/backend/home/onebridge",
        $host . "/backend/department",
        $host . "/backend/department/add_department",
        $host . "/backend/role"
    );
    return $test_urls;
}


