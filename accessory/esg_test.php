<?php if (isset($_SERVER['REMOTE_ADDR'])) { die('Command Line Only!'); }

date_default_timezone_set('PRC');
include "esg_test_config.php";


$test_cases = make_test_case($config);
start_test($config,$test_cases);


function make_test_case($config){
    $data    =  '{"'.time().'":[24,25,4,8,20,1,1,0,2,"",22,24,"","","",1,500,67788,460,45645,"","","","","","","",""]}';  // 28个
    $data_v2 =  '{"'.time().'":[24,25,4,8,20,1,1,0,2,"",22,24,"","","",1,500,67788,460,45645,"","","","","","","","","","",""]}';  // 31个
    $warning =  '{"'.time().'":[2,3]}' ; 
    $t       =  '{"s":["","","","","","","","","","","","","","","","","","","","","","","","","","",""],"p":["2012090321",""]}';
    $st      =  '{"s01":0,"s02":"0 0 0 0 0 30","s03":4,"s04":"0 0 0 0 0 0","s05":5,"s06":10}';
    $p       =  '{"p01":"20120812","p02":"021","p03":"021","p04":"011","p05":"011"}';
    $finish  =  '{"14":"success","18":"failed"}';

    $test_cases['d']    = array("s"=>$config['id'],"d"=>$data);
    $test_cases['d_v2'] = array("s"=>$config['id'],"v"=>2 ,"d"=>$data_v2);
    $test_cases['w']    = array("s"=>$config['id'],"w"=>$warning);
    $test_cases['t']    = array("s"=>$config['id'],"t"=>$t);
    $test_cases['st']   = array("s"=>$config['id'],"st"=>$st);
    $test_cases['p']    = array("s"=>$config['id'],"p"=>$p);
    $test_cases['f']    = array("s"=>$config['id'],"f"=>$finish);

    return $test_cases;
}

function start_test($config,$test_cases) {
    foreach($test_cases as $name => $test_case){
        echo "start to test ".$name."\n";
        check_error($config['host'], post_str($test_case));
    }       
}

function post_str($data) {
    $post = array();
    foreach ($data as $k => $v) {

        $post[] = $k."=".$v;
    }
    return  implode("&",$post);
}

function get_output($host,$post) {
    $ch = curl_init();
    // 2. 设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, "$host");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    // 3. 执行并获取HTML文档内容
    $output = curl_exec($ch);
    //echo $output;
    return $output;
    curl_close($ch);
}

// 查找出现的错误
function check_error($host,$post) {
    $output = get_output($host,$post);
    if (!$output) {
        echo "服务器down了";
    }else if (checkheader($output)) {
        echo "网页404错误~！！\n";
    }else if (Database_Error($output)) {
        echo "数据库无法连接\n";
    }else if (noticeerror($output)) {
        $line = check_notice_line($output);
        $file = check_notice_file($output);
        echo "notice错误,请检查代码--> 错误如下\n" . $file[0]." -> ".$line[0]."\n";
    }else if (check_parse($output)) {
        $line = check_error_line($output);
        echo "代码语法错误,请检查代码--> 错误如下\n" . $line[0]."\n";
    }else {
        echo "页面一切正常\n";
    }

}

//正则
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
function check_parse($str) {
    return preg_match('/syntax error/', $str);
}
function check_error_line($str) {
    preg_match('/<b>.*<\/b>/', $str, $matches);
    return $matches;
}
function check_notice_file($str) {
    preg_match('/Filename: .*\.php/', $str, $matches);
    return $matches;
}
function check_notice_line($str) {
    preg_match('/Line Number:.*/', $str, $matches);
    return $matches;
}



