<?php if (isset($_SERVER['REMOTE_ADDR'])) { die('Command Line Only!'); }

$esg_ids = array(
    //三个测试项目
    "1100114169","1100114170","1100114168",
    //山明水秀
    "1100110045");
$config['host'] = "http://www.sl.com";


for(;;){
    main($esg_ids,$config);
    echo "+";
    sleep(58);
}


function post($url,$post_data) {
    $ch = curl_init();
    // 2. 设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, "$url");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    // 3. 执行并获取HTML文档内容
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}


function main($esg_ids,$config){
    $url = $config['host']."/s";
    $data = '{"2013-11-04 11:02:32":[32,35,4,8,22,1,1,0,0,0,26,27,"","","",1,500,67788,460,45645,33,33,33,"","","","",""]}';
    $short_data = '{"2013-11-04 11:02:32":[32,35,4,8,22,1,1,0,0,0,26,27,"","","",1,500,67788,460,45645]}';
    foreach($esg_ids as $esg_id){
        //上传数据
        $output = post($url,'s='.$esg_id.'&v=2&d='.$data);
        //$output = post($url,'s='.$esg_id.'&d='.$short_data);
        echo $output;
        $commands = json_decode($output,true);
        if($commands){
            foreach($commands as $command){
                echo "[".$command['1']."] ";
                //完成命令
                post($url,'s='.$esg_id.'&f={"'.$command[0].'":"success"}');
            }
        }
    }
}














