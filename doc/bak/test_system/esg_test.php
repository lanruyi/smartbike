<?php

//发送测试数据
//获取测试结果
//比较给出报告
if (isset($_SERVER['REMOTE_ADDR'])) {
    die('Command Line Only!');
}

//设置循环秒数
$x = 60;
start_test($x);

//////////////////////////////////////////////////
// 主函数
// 死循环执行 
//////////////////////////////////////////////////
function start_test($x) {
    date_default_timezone_set('PRC');
    $i = 0;
    $sids = array("2100110001", "");
    $time = time();
    $inside_tmp = 20;
    $outside_tmp = 21;
    $box = 20;
    $cool_tmp = 20;
    while ($i <= 62) {
        $date = date("Y-m-d H:i:s", $time);
        inside_tmp_test($date, $inside_tmp);
        outside_tmp_test($date, $outside_tmp);
        box_tmp_test($date, $box);
        cool_tmp_test($date, $cool_tmp);
        $i++;
        if ($i > 0) {
            go_bugs();
        }
        if ($i < 21) {
            $inside_tmp = "\"\"";
            $outside_tmp = "\"\"";
            $box = "\"\"";
            $cool_tmp = "\"\"";
        } else {
            $inside_tmp = 21;
            $outside_tmp = 22;
            $box = 23;
            $cool_tmp = 24;
        }
        echo $i . "<\n>";
        sleep($x);
    }
}

//准备post数据 初始化参数
//室内温感测试
function inside_tmp_test($time, $inside_tmp) {
    //0.准备登录post数据
    $post_data = array();
    $post_data['s'] = "2100110001";
    // $post_data['d'] = "{\"".date("Y-m-d H:i:s")."\":[".rand(30,50).",".rand(30,50).",4,8,22,1,1,0,2,\"\",80,90,\"\",\"\",\"\",1,500,67788,460,45645,\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]}";
    //  $post_data['d'] = "{\"".date("Y-m-d H:i:s")."\":[1,2,3,4,5,1,1,0,0,\"\",10,11,\"\",\"\",\"\",1,13,14,15,16,\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]}";
    // test1 
    $post_data['d'] = "{\"" . $time . "\":[" . $inside_tmp . ",35,4,8,22,1,1,0,2,\"\",22,24,\"\",\"\",\"\",1,500,67788,460,45645,\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]}";  //这个是室内温感bug测试;
    //  $post_data['d'] = "{\"".$date."\":[".$inside_tmp.",".$outside_tmp.",".$inside_humidity.",".$out_side_humidity.",".$box.",".$cool_1.",".$cool_2.",1,".$fan_0_on.",\"\",".$cool_1_tmp.",".$cool_2_tmp.",\"\",\"\",\"\",".$colds_box_on.",".$main.",".$e_main.",".$dc.",".$e_dc.",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]}";
    $o = "";
    foreach ($post_data as $k => $v) {
        $o.= "$k=" . ($v) . "&";
    }
    $post = substr($o, 0, -1);
    // 1. 初始化
    set($post);
}

//室外温感测试
function outside_tmp_test($time, $outside_tmp) {
    //0.准备登录post数据
    $post_data = array();
    $post_data['s'] = "2100110002";

    $post_data['d'] = "{\"" . $time . "\":[24," . $outside_tmp . ",4,8,22,1,1,0,2,\"\",22,24,\"\",\"\",\"\",1,500,67788,460,45645,\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]}";  //这个是室内温感bug测试;

    $o = "";
    foreach ($post_data as $k => $v) {
        $o.= "$k=" . ($v) . "&";
    }
    $post = substr($o, 0, -1);
    // 1. 初始化
    set($post);
}

//恒温柜温感
function box_tmp_test($time, $box) {
    //0.准备登录post数据
    $post_data = array();
    $post_data['s'] = "2100110003";

    $post_data['d'] = "{\"" . $time . "\":[24,25,4,8," . $box . ",1,1,0,2,\"\",22,24,\"\",\"\",\"\",1,500,67788,460,45645,\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]}";  //这个是室内温感bug测试;

    $o = "";
    foreach ($post_data as $k => $v) {
        $o.= "$k=" . ($v) . "&";
    }
    $post = substr($o, 0, -1);
    // 1. 初始化
    set($post);
}

//空调1温感
function cool_tmp_test($time, $cool_tmp) {
    //0.准备登录post数据
    $post_data = array();
    $post_data['s'] = "2100110004";

    $post_data['d'] = "{\"" . $time . "\":[24,25,4,8,20,1,1,0,2,\"\"," . $cool_tmp . ",24,\"\",\"\",\"\",1,500,67788,460,45645,\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]}";  //这个是室内温感bug测试;

    $o = "";
    foreach ($post_data as $k => $v) {
        $o.= "$k=" . ($v) . "&";
    }
    $post = substr($o, 0, -1);
    // 1. 初始化
    set($post);
}

function set($post) {
    $ch = curl_init();
    // 2. 设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1/s");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    // 3. 执行并获取HTML文档内容
    $output = curl_exec($ch);
    echo $output;
    curl_close($ch);
}

function go_bugs() {

    // 1. 初始化
    $ch = curl_init();
    // 2. 设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1/rake/bug/go_bugs");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // 3. 执行并获取HTML文档内容
    curl_exec($ch);
    curl_close($ch);
}