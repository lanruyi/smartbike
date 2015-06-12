<?php

$wx_name = "wangfeng1985731@gmail.com";
$wx_pwd = md5("123123");
$message = "第二个测试";
$ids = array("1607428880", "3989785", "2420147160");

wx_sendmsg($wx_name,$wx_pwd,$message,$ids);

function wx_sendmsg($wx_name,$wx_pwd,$message,$ids) {
    date_default_timezone_set('PRC');
    $wx_loginPage = "http://mp.weixin.qq.com/cgi-bin/login?lang=zh_CN";


    //0.准备登录post数据
    $post_data = array();
    $post_data['username'] = $wx_name;
    $post_data['pwd'] = $wx_pwd;
    $post_data['imgcode'] = "";
    $post_data['f'] = "json";
    $o = "";
    foreach ($post_data as $k => $v) {
        $o.= "$k=" . urlencode($v) . "&";
    }
    $post_data = substr($o, 0, -1);
    // 1. 初始化
    $ch = curl_init();
    // 2. 设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, "$wx_loginPage");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/wx_cookie.txt");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    var_dump($post_data);
    // 3. 执行并获取HTML文档内容
    $out = curl_exec($ch);
    var_dump($out);
    // var_dump($post_data);
    // curl_close($ch);
    //0.准备登录post数据
    foreach ($ids as $id) {
        send($ch, $message, $id);
    }
}

function send($ch, $message, $id) {
    $post_data = array();
    $post_data['type'] = "1";
    $post_data['content'] = $message;
    $post_data['error'] = "false";
    $post_data['tofakeid'] = $id;
    $post_data['ajax'] = "1";
    $post_data['fid'] = "";
    $o = "";
    foreach ($post_data as $k => $v) {
        $o.= "$k=" . urlencode($v) . "&";
    }
    $post_data = substr($o, 0, -1);
    // 1. 初始化
    //$ch = curl_init();
    // 2. 设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, "http://mp.weixin.qq.com/cgi-bin/singlesend?t=ajax-response&lang=zh_CN");
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/wx_cookie.txt");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    // 3. 执行并获取HTML文档内容
    //$information = curl_getinfo($ch);
    //var_dump($information);

    $output = curl_exec($ch);
    var_dump($output);
    // curl_close($ch);
}