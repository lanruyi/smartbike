<?php if ( ! defined('BASEPATH')) exit('No direct script accessss allowed');

require_once("datetime_helper.php");

function hsid(){
    return "?id=110";
}


function h_set_query_string_param($query_string,$param,$value){
    $query_array = array();
    parse_str($query_string, $query_array);
    $query_array[$param] = $value;
    $str_array = array();
    foreach($query_array as $k => $v){
        $str_array[]=$k."=".$v;
    }
    return implode("&",$str_array);
}

function h_round2($num){
    if(!$num)return "";
    $res = round($num,2);
    $parts = explode(".",$res);
    if(count($parts) == 2){
        if(strlen($parts[1])==1){
        $res = $res."0";
        }
    }else{
        $res = $res.".00";
    }
    return $res;
}

function h_hash_count($hashs,$kv){
    $count = 0;
    foreach($hashs as $hash){
        $eq = true;
        foreach($kv as $k => $v){
            if(isset($hash[$k]) && $hash[$k] != $v){
                $eq = false;
                break;
            }
        }
        if($eq) $count++;
    }
    return $count;
}

function h_hash_sum($hashs,$kv,$key){
    $sum = 0;
    foreach($hashs as $hash){
        $eq = true;
        foreach($kv as $k => $v){
            if(isset($hash[$k]) && $hash[$k] != $v){
                $eq = false;
                break;
            }
        }
        if($eq) $sum+=$hash[$key];
    }
    return $sum;
}


function h_array_safe($array,$key){
    return isset($array[$key])?$array[$key]:null;
}

function h_highlight_search_word($search,$word){
    $words = explode($search,"%".$word."%");
    $word = join('<font color=red>'.$search.'</font>',$words);
    echo trim($word,'%');
}

function h_saving_fun($std_energy,$sav_energy,$std_load_num,$sav_load_num){
    $save_rate = 0;
    $load_correct = 1;
    if($std_load_num>0 && $sav_load_num>0 ){
        $load_correct = $std_load_num/$sav_load_num;
    }
    if($std_energy && $sav_energy ){
        $save_rate = round( 
            ($std_energy - $sav_energy * $load_correct) / $std_energy *100 ,2);
        if($save_rate< 0){
            $save_rate = 0;
        }
    }
    return round($save_rate,1);
}


function h_array_to_id_array($array) {
    $ids = array();
    foreach ($array as $item) {
        $ids[] = $item['id'];
    }
    return $ids;
}

function h_array_to_id_hash($array){
    $hash = array();
    foreach($array as $item){
        $hash[$item['id']] = $item;
    }
    return $hash;
}

function h_array_to_array($array,$str="station_id"){
    $res = array();
    foreach ($array as $item) {
        $res[] = $item[$str];
    }
    return $res;
}

function h_array_order_by($array,$str,$order = "asc"){
    $hash = array();
    foreach($array as $key => $item){
        $hash[$item[$str]][] = $item;
    }
    if($order == "asc"){
        ksort($hash);
    }else{
        krsort($hash);
    }
    $res = array();
    foreach($hash as $items){
        foreach($items as $item){
            $res[] = $item;
        }
    }
    return $res;
}

function h_array_to_hash($array,$str="station_id"){
    $hash = array();
    foreach($array as $item){
        $hash[$item[$str]] = $item;
    }
    return $hash;
}


function hp($a){
    header("Content-Type:text/html; charset=utf-8");
    echo "<pre>";
    var_dump($a);
    echo "</pre>";
}

//从hash组装url的参数字符串如a=1&b=2
function h_url_param_str($a){
    $params = array();
    foreach($a as $name=>$value){
        array_push($params,$name."=".$value);
    }
    return implode('&',$params);
}

function h_av_day_energy($v){
    return ($v && $v>0 && $v<500/*480*/);
}


function h_tail($fp,$n,$base=5)  {  
    assert($n>0);
    $pos = $n+1; 
    $lines = array();     
    while(count($lines) <= $n){   
        try{
            fseek($fp,-$pos,SEEK_END);        
        } catch (Exception $e){ 
            fseek(0);
            break;      
        } 
        $pos *= $base;
        while(!feof($fp)){
            array_unshift($lines,fgets($fp)); 
        } 
    } 
    return array_slice($lines,0,$n); 
} 
#example
#var_dump(h_tail(fopen("access.log","r+"),10));;

function h_compare_dur($time_str_1,$time_str_2,$dur_mins){
    $time1 = new DateTime($time_str_1);
    $time2 = new DateTime($time_str_2);
    $time1->add(new DateInterval('PT'.$dur_mins.'M'));
    return $time1 > $time2;
}

function h_auth($authority){
    return $this->current_role->getSingleAuthority($authority);
}

function h_hc_colors($num){
    $colors=array('#d76618','#1d476f','#99dddd', '#ffbb66', 'ee3344', '#66dd88','#887766','007788','#006677');
    return $colors[$num];
}

///////////////////////////  view helper //////////////////////////////////////
//返回在线图标（闪的小绿小红方块）
function h_online_mark($online,$h=12,$w=4){
    return '<img src="/static/site/img/light_'.($online == ESC_ONLINE?'online':'offline').'_2.gif" height='.$h.' width='.$w.'/>';
} 

//function h_station_type_mark($type,$h=16,$w=16){
    //$name = array(ESC_STATION_TYPE_SAVING=>"saving",
                  //ESC_STATION_TYPE_STANDARD=>"standard",
                  //ESC_STATION_TYPE_SIXPULSONE=>"",
                  //ESC_STATION_TYPE_COMMON=>"common");
    //return '<img src="/static/site/img/'.$name[$type].'.jpg" height='.$h.' width='.$w.'/>';
//} 
///////////////////////////////////////////////////////////////////////////////


function h_array_2_select($items,$attr="name_chn"){
    $selects = array();
    foreach($items as $item){
        $selects[$item['id']] = $item[$attr];
    }
    return $selects;
}

function h_array_2_html_select($items){
    $selects = array();
    foreach($items as $item){
        $selects[$item['id']]['str'] = $item['name_chn'];
        $selects[$item['id']]['css'] = "";
    }
    return $selects;
}
function h_make_html_select($array, $name, $default = 0,$first="全部", $width = 100) {
    if(!$default){$default = "0";}
    $str = '<select id="' . $name . '" name="' . $name . '" value="' . $default . '" style="width:' . $width . 'px">';
    if ("" != $first) {
        $str .= '<option value=0 ' . ((string)$default === "0" ? "selected" : "") . '>'.$first.'</option>';
    }
    foreach ($array as $key => $value) {
        $str .= '<option value=' . $key . ' ' . ((string)$default === (string)$key ? "selected" : "") . ' style="'.$value['css'].'">' . $value['str'] . '</option>';
    }
    $str .= '</select>';
    return $str;
}

function h_make_options($array, $default=0,$first="全部") {
    $str = "";
    if(!$default){$default = "0";}
    if ("" != $first) {
        $str .= '<option value=0 ' . ((string)$default === "0" ? "selected" : "") . '>'.$first.'</option>';
    }
    foreach ($array as $key => $value) {
        $str .= '<option value=' . $key . ' ' . ((string)$default === (string)$key ? "selected" : "") . '>' . $value . '</option>';
    }
    return $str;
}


function h_make_select($array, $name, $default = 0,$first="全部", $width = 100) {
    if(!$default){$default = "0";}
    $str = '<select id="' . $name . '" name="' . $name . '" value="' . $default . '" style="width:' . $width . 'px">';
    if ("" != $first) {
        $str .= '<option value=0 ' . ((string)$default === "0" ? "selected" : "") . '>'.$first.'</option>';
    }
    foreach ($array as $key => $value) {
        $str .= '<option value=' . $key . ' ' . ((string)$default === (string)$key ? "selected" : "") . '>' . $value . '</option>';
    }
    $str .= '</select>';
    return $str;
}



function h_in_objects($object,$objects){
    foreach($objects as $ob){
        if($object == $ob) return true;
    }
    return false;
}

function h_in_arrays($value,$datas,$key='id'){
    if(!$value || !is_array($datas) || !$key){
        return false;
    }
    $tmp = current($datas);
    if(!isset($tmp[$key])){
        return false;
    }
    foreach($datas as $data){
        if($data[$key] == $value){
            return true;
        }
    }
    return false;
}



function h_trigger_switch($on){
    if($on === 1) return 0;
    return 1;
}

function name_or_no_name($array,$type){
    if(isset($array[$type])){
        return $array[$type];
    }else{
        return "未知";
    }
}


function h_get_site_color($site){
    if($site == ESC_SITE__FRONTEND) return "#9cf";
    if($site == ESC_SITE__BACKEND) return "#f99";
}

function h_get_site_li_bg_css($site,$sitenow){
    if($site != $sitenow) return "color:#fff";
    return "color:#333;background-color:".h_get_site_color($site).";";
}


function h_alive_array(){
    $array[ESC_ONLINE] = "在线";
    $array[ESC_OFFLINE] = "不在线";
    return $array;
}
function h_alive_name_chn($type){
    return name_or_no_name(h_alive_array(),$type);
}
function h_alive_select($type=0,$default="",$width=60){
    return h_make_select(h_alive_array(),'alive',$type,"全部", $width);
}

function h_being_array(){
	$array[ESC_BEING] = "是";
	$array[ESC_BEINGLESS] = "否";
	return $array;
}
function h_being_select($name,$default=0,$first=""){
	return h_make_select(h_being_array(),$name,$default,$first);
}
function h_3g_module_array(){
    $array[1]="2g";
    $array[2]="新版2g";
    $array[3]="3g";
    return $array;
}
function h_3g_module_name($v){
    $array = h_3g_module_array();
    return name_or_no_name($array, $v);
}
function h_3g_module_select($array,$name,$default=0,$first="",$width=100){
    if(!$default){$default = "0";}
    $str = '<select id="' . $name . '" name="' . $name . '" value="' . $default . '" style="width:' . $width . 'px">';
    if ("" != $first) {
        $str .= '<option value=0 ' . ((string)$default === "0" ? "selected" : "") . '>'.$first.'</option>';
    }
    foreach ($array as $key => $value) {
        $str .= '<option value=' . $key . ' ' . ((string)$default === (string)$key ? "selected" : "") . '>' . $value . '</option>';
    }
    $str .= '</select>';
    return $str;
}
function h_have_box_select($name,$default=0,$first=""){
	return h_make_select(h_station_have_box_array(),$name,$default,$first);
}

function h_objects_array($objs){
    $array=array();
	foreach ($objs as $key => $obj) {
		$array[$obj->getId()] = $obj->getNameChn();
	}
	return $array;
}

function h_objects_array_new($arrs){
        $array = array();
        foreach ($arrs as $key => $arr) {
            $array[$arr['id']] = $arr['name_chn'];
        }
        return $array;
}


function h_objects_array_sql($objs){
	foreach ($objs as $key => $obj) {
		$array[$obj['id']] = $obj['name_chn'];
	}
	return $array;
}

function h_filter_num_str($total,$cur_page,$per_page){
    if(!$total){
        return "没有任何匹配数据!";
    }
    $first = ($cur_page-1)*$per_page+1;
    $last  = $cur_page*$per_page > $total ? $total:$cur_page*$per_page;
    return "第".$first."-".$last."个 共".$total."个";
}

function h_data_relative_select($name,$objects,$current=0,$first="全部",$width=200){
	return h_make_select(h_objects_array($objects),$name,$current,$first,$width);
    }

//获取来路IP地址
function h_getip() {
    $online_ip = "0.0.0.0";
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $online_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $online_ip = $_SERVER['HTTP_CLIENT_IP'];
    } else {
        $online_ip = $_SERVER['REMOTE_ADDR'];
    }
    return $online_ip;
}



function h_average_save_rate($save_rates,$color="false"){
    $total = 0;
    $nums = 0;
    foreach($save_rates as $save_rate){
        if($save_rate == 0){
            continue;
        }
        $total += $save_rate;
        $nums += 1;
    }
    if($nums){
        $total = round($total/$nums,2);
    }
    return $total;
}

function h_array_return_single_list($arr,$k="id"){
    if(!is_array($arr)){return array();}
        $data = current($arr);
        if(!isset($data[$k])){return array();}
    $result = array();
    foreach($arr as $v){
        $result[] = $v[$k];
    }
    return $result;
}


//二维数组按照里面某个字段排序，默认为升序，并保持索引关系
//有单元测试
function h_array_sort($arr,$keys,$type='asc'){
    $tmp_array = $new_array = array();
    foreach ($arr as $k=>$v){
        $tmp_array[$k] = $v[$keys];
    }
    if($type == 'asc'){
        asort($tmp_array);
    }else{
        arsort($tmp_array);
    }
    reset($tmp_array);
    foreach ($tmp_array as $k=>$v){
        $new_array[$k] = $arr[$k];
    }
    return $new_array;
}


function h_mid_energy($main_energy,$load_num){
    $mid_load = floor($load_num/10)*10 + 5;
    if($load_num<=0){
        return 0;
    }
    return $main_energy*$mid_load/$load_num;
}

function h_load_level_mid($load_num){
    if($load_num<20){
        return 15;
    }elseif($load_num>70){
        return 75;
    }else{
        return floor($load_num/10)*10 + 5;
    }
}


function h_power_to_month_energy($power,$datetime){
    if($power > 0){
        $days = date('t',strtotime($datetime));
        $energy = $power*24*$days/1000;  
        return $energy;
    }else{
        return 0;
    }
}

function object_to_array($obj) 
{ 
$_arr = is_object($obj) ? get_object_vars($obj) : $obj; 
foreach ($_arr as $key => $val) 
{ 
$val = (is_array($val) || is_object($val)) ? object_to_array($val) : $val; 
$arr[$key] = $val; 
} 
return $arr; 
}


function h_clean_array_null($arr){
    return array_diff($arr, array(null,'null','',' '));
}

/*1.弹出消息*/
function h_alert($msg) {
   header("Content-Type:text/html; charset=utf-8");
   echo "<script language=javascript>";
   echo "alert(\"$msg\");";
   echo "</script>";
}

/*2. 弹出消息后，返回之前页面或跳转到指定网页 */
function h_message_goto($msg,$goto='') {
      header("Content-Type:text/html; charset=utf-8");
      echo "<script language=javascript>";
      echo "alert(\"$msg\");";
      if(!empty($goto)) {
         echo "location=\"$goto\";";
      } else {
         echo "history.go(-1);";
      }
      echo "</script>";
  }
  
  /*3.延迟指定秒数后跳转到指定网页*/
function h_message_goto_delay($tim,$goto){
   header("Content-Type:text/html; charset=utf-8");
   echo "<meta http-equiv=\"Refresh\" content=".$tim.";URL=".$goto.">";
}
