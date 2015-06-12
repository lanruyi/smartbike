<?php

////////////////////////////////////////////////
//  运行请执行systest.php
//  系统页面测试::测试页面中的各种错误信息并以邮件的方式发送到相关人员;
//  为了避免把邮箱塞满的尴尬 , 特设置发信之间为 0分钟 10分钟 20分钟 100分钟 200分钟 ....
//  
//  此分两部分设置 ,
//     第一部分:邮件发送系统  ,可以设置发送到邮箱 发件人姓名和收件人
//     第二部分: 主函数 ,设置要测试的网站,要测试用的帐号还有要测试用的主页及其他也面
//              (子网页部分请在model的最后一部分设置)
////////////////////////////////////////////////
require 'class.phpmailer.php';

//  邮件发送错误报告
function error_report() {
    require 'config.systest.php';
    $mail_host = $config["mail_host"];  //需要的smtp邮箱服务器;
    $mail_username = $config["mail_username"];   // 登录邮箱的帐号
    $mail_password = $config["mail_password "];   //登录邮箱的密码
    $mail_sendfrom = $config["mail_sendfrom"];   //发件人
    $mail_sendto = $config["mail_sendto"];  //收件人
    $message = $config["mail_message "];  //发送组合的信息
    $username = $config["username"];     //网站测试登录所需的帐号
    $password = $config["password"];  // 登录所需的密码
    $loginpage = $config["loginpage"];  //登录所在的网页
    $host = $config["host"];   // 要访问的网页的域名

    $i = 0;
    while (1) {
        $str = start_test($username, $password, $loginpage, $host);
        //如果存在str 证明有错误
        if ($str) {
            $time = $i * 10;
            $message = $str;
            if ($i == 0) {
                $strs = $str; //备份错误 
            }
            if ($i < 3) {
                email($mail_host, $mail_username, $mail_password, $mail_sendfrom, $mail_sendto, $message . "本次错误报警持续时间为" . $time . "分");                //发送邮件
            } elseif ($i % 10 == 0 && $strs == $str) {      //如果错误继续存在
                email($mail_host, $mail_username, $mail_password, $mail_sendfrom, $mail_sendto, $message . "本次错误报警持续时间为" . $time . "分");
            } elseif ($strs !== $str) {
                $i = 0;
                continue;
            }
            $i++;
            echo "本错误已持续了" . $time . "分钟\n";
        } else {
            $i = 0;
        }
        sleep(600);
    }
}

//////////////////////////////////////////////////
// 主函数
//////////////////////////////////////////////////
function start_test($username, $password, $loginpage, $host) {
    //初始化
    //设置
    init_php_url($username, $password, $loginpage);

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
    curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
    curl_setopt($ch, CURLOPT_URL, $url);
    $output = @curl_exec($ch);
    curl_close($ch);
    return $output;
}

//自己的单元测试主函数
function test_test() {
    tt_noticeerror();
    tt_fatalerror();
    tt_Databaseerror();
    tt_checkheader();
    //tt_getOutput(); //测试时间较长 平时可以注释
    tt_getTimeFromStr();
    tt_print_slow_pages();
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

function tt_fatalerror() {
    $test_result = array();
    array_push($test_result, true == fatalerror('asdjfhasdfhasj Fatal error dfhasjdfhasdfh'));
    array_push($test_result, true == fatalerror('asdjfhasdfhasj  Fatal  error dfhasjdfhasdfh'));
    array_push($test_result, true == fatalerror('asdjfhasdfhasj  Fatal asd error dfhasjdfhasdfh'));
    array_push($test_result, false == fatalerror('asdjfhasdfhasjFatal errfhencounteredasdfh'));
    array_push($test_result, false == fatalerror('asdjfhasdfhasatel errordfhasjencountered'));
    var_dump($test_result);
}

function tt_Databaseerror() {
    $test_result = array();
    array_push($test_result, true == Database_Error('asdjfhasdfhasj Database Occurred dfhasjdfhasdfh'));
    array_push($test_result, true == Database_Error('asdjfhasdfhasj  Database  Occurred dfhasjdfhasdfh'));
    array_push($test_result, true == Database_Error('asdjfhasdfhasj  Database asd Occurred dfhasjdfhasdfh'));
    array_push($test_result, false == Database_Error('asdjfhasdfhasDatabasdase sdafeOccurredasd'));
    array_push($test_result, false == Database_Error('Database errordOasdccurredencountered'));
    var_dump($test_result);
}

function tt_checkheader() {
    $test_result = array();
    array_push($test_result, true == checkheader('asdjfhasdfhasj 404 Found dfhasjdfhasdfh'));
    array_push($test_result, true == checkheader('asdjfhasdfhasj  404  Found dfhasjdfhasdfh'));
    array_push($test_result, true == checkheader('asdjfhasdfhasj  404 asd Found dfhasjdfhasdfh'));
    array_push($test_result, false == checkheader('asdjfhasd4.04Fatal Found'));
    array_push($test_result, false == checkheader('404 errordfhasjF.oundencountered'));
    var_dump($test_result);
}

//测试getOutput
function tt_getOutput() {
    init_php_url();
    $test_result = array();
    array_push($test_result, true == preg_match('/本系统按不同的使用者用途分成了七个子系统/', getOutput("http://semos-cloud.com:8988")));
    array_push($test_result, true == preg_match('/昨日节能/', getOutput("http://semos-cloud.com:8988/frontend")));
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
    array_push($test_result, "0.4129S" == getTimeFromStr('bsp; Page use 0.4129S and 5.62MB</strong>'));
    array_push($test_result, "1.20S" == getTimeFromStr('nbsp; Page use 1.20S and 5.62MB</strong>'));
    array_push($test_result, "1.20S" == getTimeFromStr(' 123S asdfasdfasdfnbsp; Page use 1.20S and 5.62MB</strong>'));
    array_push($test_result, "1.20S" == getTimeFromStr(' 123Sxxx asdfasdfasdfnbsp; Page use 1.20S and 5.62MB</strong>'));
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
function init_php_url($username, $password, $loginpage) {
    date_default_timezone_set('PRC');
    //0.准备登录post数据
    $post_data = array();
    $post_data['login'] = $username;
    $post_data['password'] = $password;
    $o = "";
    foreach ($post_data as $k => $v) {
        $o.= "$k=" . urlencode($v) . "&";
    }
    $post_data = substr($o, 0, -1);
    // 1. 初始化
    $ch = curl_init();
    // 2. 设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, "$loginpage");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    // 3. 执行并获取HTML文档内容
    curl_exec($ch);
    curl_close($ch);
}

//生成需要测试的url数组
function generate_test_url($host) {
    $test_urls = array(
        //    江苏联通站点, 
        $host . "/frontend/project/change_project/4",
        $host . "/frontend",
        $host . "/frontend/single/day/1001",
        $host . "/frontend/single/day/2156",
        $host . "/frontend/single/day/2384",
        //广西电信
        $host . "/frontend/project/change_project/3",
        $host . "/frontend",
        $host . "/frontend/single/day/773",
        $host . "/frontend/single/day/785",
        //广西百色移动站点
        $host . "/frontend/project/change_project/2",
        $host . "/frontend",
        $host . "/frontend/single/day/697",
        $host . "/frontend/single/day/2388",
        //其他测试页面
        $host . "/frontend/single/note/2384",
        $host . "/frontend/single/realtime/2384",
        $host . "/frontend/single/month/2384",
        $host . "/frontend/single/maintenance/2384",
        //装站维修系统
        $host . "/setup",
        $host . "/setup/home/work_order_maintain",
        $host . "/setup/home/station",
        //运维系统
        $host . "/maintain",
        $host . "/maintain/home/detail",
        $host . "/maintain/home/history",
        $host . "/maintain/home/map",
        $host . "/maintain/home/rinse",
        $host . "/maintain/home/uncorrected",
        $host . "/maintain/work_order/prepare_orders",
        //数据分析 
        $host . "/analysis",
        $host . "/analysis/home/energy",
        //后台管理系统
        $host . "/backend/station/slist",
        $host . "/backend/data?station_id=2384",
        $host . "/backend/command?station_id=3091",
        $host . "/backend/bug?station_id=3091",
        $host . "/backend/warning?station_id=3091",
        $host . "/backend/statistics?station_id=2947",
        $host . "/backend/restart?station_id=3091",
        $host . "/backend/station/mod_station/2947",
        $host . "/backend/esgconf/read_setting/2947",
        $host . "/backend/esgconf/set_setting/2947",
        $host . "/backend/station/update_rom/2947",
        $host . "/backend/blog/index?station_id=2947",
        $host . "/backend/data?station_id=2922",
        $host . "/backend/command?station_id=2922",
        $host . "/backend/bug?station_id=2922",
        $host . "/setup/home/station/2922",
        $host . "/backend/esg",
        $host . "/backend/warning",
        $host . "/backend/bug",
        $host . "/backend/fixbug",
        $host . "/backend/esgconf",
        $host . "/backend/note",
        $host . "/backend/blog",
        $host . "/backend/restart/station_list",
        $host . '/backend/edge',
        $host . "/backend/area",
        $host . "/backend/area/mod_area/40",
        $host . "/backend/cmail",
        $host . "/backend/user",
        $host . "/backend/user/mod_user/3",
        $host . "/backend/project",
        $host . "/backend/prjconfig",
        $host . "/backend/project/mod_project/100",
        $host . "/backend/sysconfig",
        $host . "/backend/home/onebridge",
        $host . "/backend/role/add_role",
        $host . "/backend/usergroup",
        $host . "/backend/usergroup/add_usergroup",
        $host . "/backend/role",
            // $host . "/backend/role/x",
    );
    return $test_urls;
}

function email($mail_host, $mail_username, $mail_password, $mail_sendfrom, $mail_sendto, $mail_message) {
    $mail = new PHPMailer;

    $mail->IsSMTP();                                      // Set mailer to use SMTP
    $mail->Host = $mail_host;  // Specify main and backup server
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $mail_username;                            // SMTP username
    $mail->Password = $mail_password;                           // SMTP password
//$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted

    $mail->From = $mail_username;
    $mail->FromName = $mail_sendfrom;
//$mail->AddAddress('josh@example.net', 'Josh Adams');  // Add a recipient
    $mail->AddAddress($mail_sendto);               // Name is optional
//$mail->AddReplyTo('info@example.com', 'Information');
//    $mail->AddCC('cc@example.com');
//    $mail->AddBCC('bcc@example.com');

    $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
    $mail->AddAttachment('');         // Add attachments
    $mail->AddAttachment('');    // Optional name
    $mail->IsHTML(true);                                  // Set email format to HTML

    $mail->Subject = "Error Report";
    $mail->Body = $mail_message;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if (!$mail->Send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        exit;
    }

    echo 'error report has been sent';
}

