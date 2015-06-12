<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mid_data extends ES_Model {


    public function __construct()
    {
        $this->load->model(array('bug','data','station','daydata','monthdata','np1stdday','data_index'));
    }


    //找到某站最后一个数据
    //test
    public function findLast($station_id){
        $station = $this->station->find($station_id);
        if($station){
            if($this->mid_data->changeTable($station_id,$station['last_connect_time'])){
                return $this->data->findLast($station_id); 
            }else{
                return $this->data->findLastArchive($station_id); 
            }
        }
        return null;
    }

    //找到某站最后一个数据(10分钟内)
    public function findRecentLast($station_id,$p = 10){
        $station = $this->station->find($station_id);
        if($station){
            if($this->mid_data->changeTable($station_id,h_dt_sub_min('now',$p))){
                return $this->data->findOneBy(
                    array("station_id"=>$station_id, "create_time >= "=>h_dt_sub_min('now',$p)),
                    array("create_time desc"));
            }
        }
        return null;
    }
    
    //找到某站某个时刻最后一个数据(往后5分钟内)
    public function findSometimeData($station_id,$time,$p = 5){
        $station = $this->station->find($station_id);
        if($station){
            if($this->mid_data->changeTable($station_id,  h_dt_format($time))){
                return $this->data->findOneBy(
                    array("station_id"=>$station_id, "create_time >= "=>$time,"create_time <= "=>h_dt_add_min($time,$p)),
                    array("create_time asc"));
            }
        }
        return null;
    }

    /**
     * 室内温感坏 ESC_BUG__SENSOR_INDOOR_BROKEN 
     * tested
     */
    public function errorSensorIndoorBroken(){
        return $this->data->errorNormal("(indoor_tmp is null or indoor_hum is null)");
    }
    /**
     *室外温感坏 ESC_BUG__SENSOR_OUTDOOR_BROKEN
     * tested
     */
    public function errorSensorOutdoorBroken(){
        $bugs = $this->data->errorNormal("outdoor_tmp is null");
        // 去掉没有装室外温感的站点
        $no_outdoor_sensor_stations = $this->station->findAllNoOutdoorStations();
        $bugs = array_diff_key($bugs, h_array_to_id_hash($no_outdoor_sensor_stations));
        return $bugs;
    }
    /**
     *智能电表故障 ESC_BUG__SMART_METER_BROKEN
     * tested
     */
    public function errorSmartMeterBroken(){
        return  $this->data->errorNormal("(power_main is null or power_dc is null or energy_main is null or energy_dc is null)");
    }
    /*
     *停电 ESC_BUG__NO_POWER
     * tested
     */
    public function errorNoPower(){
        return  $this->data->errorNormal("(power_main is not null and power_main < 30 and power_main > -150)");
    }
    /*
     *电表反接 ESC_BUG__SMART_METER_REVERSE
     */
    public function errorSmartMeterReverse(){
        return  $this->data->errorNormal("(power_main is not null and power_main <= -150)");
    }

    /*
     * 柜温传感器坏 ESC_BUG__SENSOR_BOX_BROKEN
     * tested
     */
    public function errorSensorBoxBroken(){
        $bugs = $this->data->errorNormal("box_tmp is null");
        // 去掉没有装的
        $no_box_stations = $this->station->findAllNoBoxStations();     //没有安装恒温柜的基站id
        $bugs = array_diff_key($bugs, h_array_to_id_hash($no_box_stations));
        return $bugs;
    }
    /**
     * 空调0坏 ESC_BUG__SENSOR_COLDS0_BROKEN
     * tested
     */
    public function errorSensorColds0Broken(){
        return $this->data->errorNormal("colds_0_tmp is null");
    }
    /**
     * 空调1坏 ESC_BUG__SENSOR_COLDS1_BROKEN
     * tested
     */
    public function errorSensorColds1Broken(){
        $bugs = $this->data->errorNormal("colds_1_tmp is null");
        // 去掉没有装的 
        $one_colds_stations = $this->station->findAllOneColdsStations();   //只有一台空调的基站id
        $bugs = array_diff_key($bugs, h_array_to_id_hash($one_colds_stations));
        return $bugs;
    }
    /*
     * 485死机 ESC_BUG__485_DIE
     * tested
     */
    public function error485Die(){
        return $this->data->errorNormal("(indoor_tmp is null and indoor_hum is null and 
            outdoor_tmp is null and outdoor_hum is null and 
            colds_0_tmp is null and colds_1_tmp is null and 
            power_main is null and power_dc is null and energy_main is null and energy_dc is null)");

    }
    /*
     * 恒温柜高温 ESC_BUG__BOX_TMP_HIGH 
     * tested
     */
    public function errorBoxHighTemp(){
        return $this->data->errorNormal("box_tmp > 27.9");
    }
    /**
     * 分析电表故障2 ESC_BUG__SMART_METER_BROKEN_2
     * tested
     */
    public function errorSmartMeterBroken2(){
        //任何时候 总功率小于dc功率的（还小了100以上）
        //如果改成10分钟测试一次 故障的反复性会增加
        return $this->data->errorNormal("(power_main > 0 and power_dc > 0 
            and power_main < (power_dc - 100))");
    }
    /*
     * 室内高温 ESC_BUG__INDOOR_TMP_HIGH  
     * tested
     */
    public function errorIndoorHighTemp(){
        $standard_stations = $this->station->findAllStandardStations();    //基准站id
        $no_box_stations = $this->station->findAllNoBoxStations();     
        $bugs_36 = $this->data->errorNormal("indoor_tmp > 36.9","indoor_tmp");
        $bugs_30 = $this->data->errorNormal("indoor_tmp > 28.9","indoor_tmp");
        $bugs_3036 = array_diff_key($bugs_30,$bugs_36);
        $bugs = $bugs_36 + 
                array_intersect_key($bugs_3036,h_array_to_id_hash($no_box_stations))+
                array_intersect_key($bugs_3036,h_array_to_id_hash($standard_stations));
        return $bugs;
    }
    
    /*
     * 室内高温、空调出风口温度低站点，每30分钟重启一次
     *   
     */
     public function errorTempHighReboot(){
         $reboot_stations =$this->station->findAllRebootStations();
         if (!$reboot_stations) {
             return "No station need to check";
         }
        
         foreach($reboot_stations as $station){
            if($this->mid_data->changeTable($station['id'], 'now')) {
                if ($station['colds_num'] === 2) {
                    $ext = "station_id =".$station['id']." and indoor_tmp >= 35.0"
                            ." and colds_0_tmp >= 30.0 and colds_1_tmp >= 30.0";
                    $res = $this->data->countLastNError($ext);
                } else { // only one AC
                    $ext = "station_id =".$station['id']." and indoor_tmp >= 35.0"
                            ." and colds_0_tmp >= 30.0";
                    $res = $this->data->countLastNError($ext);
                }
                
                if($res && $res[0]["num"] >= 4) {
                    $this->command->newREBCommand($station['id'],199);  //高温远程重启帐号
                }
            }
        }
     }
     

    /**
     * 连接不稳定 ESC_BUG__CONNECT_WEAK
     * tested
     */
    public function errorConnectWeak(){
        $this->data->select("station_id,count(*) num");
        $this->data->where("create_time>date_sub(now(),interval 10 minute)");
        $this->data->group_by("station_id");
        $datas = $this->data->findBy();
        $bugs = array();      //记录连接不稳定的数据 
        foreach ($datas as $item) {
            if ($item['num'] < 5) {
                //连接不稳定参数是 10分钟内上传的包数目
                $bugs[$item['station_id']] = $item['num'];   
            }
        }
        return $bugs;
    }


    public function getBugs(){
        return $this->mid_data->cleanDupBugs($this->mid_data->getOriginBugs());
    }

    //有些故障互相重复
    //tested
    public function cleanDupBugs($bugs){
        //停电的不算在智能电表坏2里
        $bugs[ESC_BUG__SMART_METER_BROKEN_2]  = array_diff_key($bugs[ESC_BUG__SMART_METER_BROKEN_2],  $bugs[ESC_BUG__NO_POWER]);
        //485死机的都不算传感器坏
        $bugs[ESC_BUG__SENSOR_INDOOR_BROKEN]  = array_diff_key($bugs[ESC_BUG__SENSOR_INDOOR_BROKEN],  $bugs[ESC_BUG__485_DIE]);
        $bugs[ESC_BUG__SENSOR_OUTDOOR_BROKEN] = array_diff_key($bugs[ESC_BUG__SENSOR_OUTDOOR_BROKEN], $bugs[ESC_BUG__485_DIE]);
        $bugs[ESC_BUG__SMART_METER_BROKEN]    = array_diff_key($bugs[ESC_BUG__SMART_METER_BROKEN],    $bugs[ESC_BUG__485_DIE]);
        $bugs[ESC_BUG__SENSOR_BOX_BROKEN]     = array_diff_key($bugs[ESC_BUG__SENSOR_BOX_BROKEN],     $bugs[ESC_BUG__485_DIE]);
        $bugs[ESC_BUG__SENSOR_COLDS0_BROKEN]  = array_diff_key($bugs[ESC_BUG__SENSOR_COLDS0_BROKEN],  $bugs[ESC_BUG__485_DIE]);
        $bugs[ESC_BUG__SENSOR_COLDS1_BROKEN]  = array_diff_key($bugs[ESC_BUG__SENSOR_COLDS1_BROKEN],  $bugs[ESC_BUG__485_DIE]);
        return $bugs;
    }

    public function getOriginBugs(){
        
        $bugs[ESC_BUG__NO_POWER]              = array(); 
        $bugs[ESC_BUG__SMART_METER_REVERSE]    = array();
        $bugs[ESC_BUG__SMART_METER_BROKEN]    = array();
        $bugs[ESC_BUG__SMART_METER_BROKEN_2]  = array();
        $bugs[ESC_BUG__485_DIE]               = array();
        $bugs[ESC_BUG__SENSOR_BOX_BROKEN]     = array();
        $bugs[ESC_BUG__SENSOR_INDOOR_BROKEN]  = array();
        $bugs[ESC_BUG__SENSOR_OUTDOOR_BROKEN] = array();
        $bugs[ESC_BUG__SENSOR_COLDS0_BROKEN]  = array();
        $bugs[ESC_BUG__SENSOR_COLDS1_BROKEN]  = array();
        $bugs[ESC_BUG__BOX_TMP_HIGH]          = array();
        $bugs[ESC_BUG__INDOOR_TMP_HIGH]       = array();
        $bugs[ESC_BUG__CONNECT_WEAK]          = array();
        $data_tables = $this->data_index->getActiveTableNames(); 
        foreach($data_tables as $data_table){
            $this->data->changeTableName($data_table);
            $bugs[ESC_BUG__NO_POWER]              += $this->mid_data->errorNoPower();
            $bugs[ESC_BUG__SMART_METER_REVERSE]   += $this->mid_data->errorSmartMeterReverse();
            $bugs[ESC_BUG__SMART_METER_BROKEN]    += $this->mid_data->errorSmartMeterBroken();
            $bugs[ESC_BUG__SMART_METER_BROKEN_2]  += $this->mid_data->errorSmartMeterBroken2();
            $bugs[ESC_BUG__485_DIE]               += $this->mid_data->error485Die();
            $bugs[ESC_BUG__SENSOR_BOX_BROKEN]     += $this->mid_data->errorSensorBoxBroken();
            $bugs[ESC_BUG__SENSOR_INDOOR_BROKEN]  += $this->mid_data->errorSensorIndoorBroken();
            $bugs[ESC_BUG__SENSOR_OUTDOOR_BROKEN] += $this->mid_data->errorSensorOutdoorBroken();
            $bugs[ESC_BUG__SENSOR_COLDS0_BROKEN]  += $this->mid_data->errorSensorColds0Broken();
            $bugs[ESC_BUG__SENSOR_COLDS1_BROKEN]  += $this->mid_data->errorSensorColds1Broken();
            $bugs[ESC_BUG__BOX_TMP_HIGH]          += $this->mid_data->errorBoxHighTemp();
            $bugs[ESC_BUG__INDOOR_TMP_HIGH]       += $this->mid_data->errorIndoorHighTemp();
            $bugs[ESC_BUG__CONNECT_WEAK]          += $this->mid_data->errorConnectWeak();
        }
        return $bugs;
    }

    

    public function errorColdsOutCtrl($station_ids,$datas){
         $sta_dt_hash = array();
         $colds_on_flag = false;
         $colds_off_flag = false;
         $pass_num = 0;
         foreach($datas as $data){
            // 去除空调从开到关后3分钟的数据，以下算法假定数据是连续的，否则不准确
            if ($data['colds_0_on'] == 1 || $data['colds_1_on'] == 1) {
                 $colds_on_flag = true;
             }
             
             if ($colds_on_flag == true && $data['colds_0_on'] == 0 && $data['colds_1_on'] == 0) {
                 $colds_off_flag = true; 
             }
             
             if ($colds_on_flag == true && $colds_off_flag == true && $pass_num < 3) {
                 $pass_num++;
                 continue;
             } 
             
             if ($pass_num == 3) {
                 $colds_on_flag = false;
                 $colds_off_flag = false;
                 $pass_num = 0;
             }
             
             $sta_dt_hash[$data['station_id']][$data['create_time']]=$data;
         }
         $bugs = array();
         foreach($station_ids as $station_id){
             if(!isset($sta_dt_hash[$station_id])){
                 continue;
             }
             $bug = $this->mid_data->singleColdsOutCtrl($station_id,$sta_dt_hash[$station_id]);
             if($bug){
                 $bugs[$bug['type']][$station_id] = $bug['arg'];
             }
         }
         return $bugs;
    }

    public function lastStepSingleColdsOutCtrl($station_id,$datas){
        $average = h_datas_average_power($datas);
        $num = 0;
        foreach($datas as $data){
            if($data['power_main'] - $average['main'] > 1000){
                $num ++;
            }
        }
        if($num >= 5){
            return ESC_BUG__COLDS_OUT_CTRL;
        }else{
            return ESC_BUG__HAS_OTHER_EQP;
        }
    }

    public function singleColdsOutCtrl($station_id,$datas){
        $station = $this->station->find($station_id);
        if(!$station){
            return 0;
        }
        $off_datas = array();
        $fan_datas = array();
        foreach($datas as $data){
            if($data['colds_0_on'] == 0 && $data['colds_1_on'] == 0){
                if($data['fan_0_on'] == 1){
                    $fan_datas[] = $data;
                }else{
                    $off_datas[] = $data;
                }
            }   
        }
        if($off_datas){ 
            $average = h_datas_average_power($off_datas);
            if($station['have_box'] == ESC_HAVE_BOX){
                if($average['main'] - $average['dc'] > 300){ 
                    $_type = $this->lastStepSingleColdsOutCtrl($station_id,$off_datas);
                    $_arg = $average['main'] - $average['dc'];
                    return array("type"=>$_type,"arg"=>$_arg);
                }
            }else{
                if($average['main'] - $average['dc'] > 100){ 
                    $_type = $this->lastStepSingleColdsOutCtrl($station_id,$off_datas);
                    $_arg = $average['main'] - $average['dc'];
                    return array("type"=>$_type,"arg"=>$_arg);
                }
            }
        }
        if($fan_datas){
            $average = h_datas_average_power($fan_datas);
            if($station['have_box'] == ESC_HAVE_BOX){
                if($station['air_volume'] == ESC_STATION_VOLUME_1700){
                    if($average['main'] - $average['dc'] > 500){ 
                        $_type = $this->lastStepSingleColdsOutCtrl($station_id,$fan_datas);
                        $_arg = $average['main'] - $average['dc'];
                        return array("type"=>$_type,"arg"=>$_arg);
                    }
                }
                if($station['air_volume'] == ESC_STATION_VOLUME_3000){
                    if($average['main'] - $average['dc'] > 700){ 
                        $_type = $this->lastStepSingleColdsOutCtrl($station_id,$fan_datas);
                        $_arg = $average['main'] - $average['dc'];
                        return array("type"=>$_type,"arg"=>$_arg);
                    }
                }
            }else{
                if($station['air_volume'] == ESC_STATION_VOLUME_1700){
                    if($average['main'] - $average['dc'] > 300){ 
                        $_type = $this->lastStepSingleColdsOutCtrl($station_id,$fan_datas);
                        $_arg = $average['main'] - $average['dc'];
                        return array("type"=>$_type,"arg"=>$_arg);
                    }
                }
                if($station['air_volume'] == ESC_STATION_VOLUME_3000){
                    if($average['main'] - $average['dc'] > 500){ 
                        $_type = $this->lastStepSingleColdsOutCtrl($station_id,$fan_datas);
                        $_arg = $average['main'] - $average['dc'];
                        return array("type"=>$_type,"arg"=>$_arg);
                    }
                }
            }
        }
        return 0;
    }

    //如果是本站的数据返回 true 外源返回 false 同时切换数据表
    public function changeTable($station_id,$time){
        $day = h_dt_start_time_of_day($time);
        $di = $this->data_index->findStationIndex($station_id,$day);
        if($di["archive"] == 1){
            $this->data->changeTableName($di["table"]);
            return true; 
        }else{
            $this->data->changeArchiveName($di["table"]);
            return false;
        }
    }



    //获取某基站最新上传上来的数据
    public function findRecentDatas($station_id,$num=60){
        $station = $this->station->find($station_id);
        if($station){
            if($this->mid_data->changeTable($station_id,$station['last_connect_time'])){
                return $this->data->findLastN($station_id,$num);
            }else{
                return $this->data->findLastNArchive($station_id,$num);
            }
        }
        return array();
    }
    
    public function findOneData($station_id,$datetime=null,$params=array(),$order_array=array()) {
        $station = $this->station->find($station_id);        
        if($station && $params && $datetime){
            if($this->mid_data->changeTable($station_id,$datetime)){
                $datas = $this->data->findOneBy($params, $order_array);
            }else{
              //  $datas = $this->data->findPeriodDatasArchive($station_id,$start_time,$stop_time);
            }
            return $datas;
        }else{
            return "[]";
        }
    }

    //获取当前往前60个数据
    public function find60Datas($station_id,$datetime="now"){
        $station = $this->station->find($station_id);
        if($station && $datetime){
            $stop_time  = h_dt_format($datetime);
            $start_time = h_dt_sub_hour($datetime);
            if($this->mid_data->changeTable($station_id,$datetime)){
                $datas = $this->data->findPeriodDatas($station_id,$start_time,$stop_time);
            }else{
                $datas = $this->data->findPeriodDatasArchive($station_id,$start_time,$stop_time);
            }
            return json_encode($datas);
        }else{
            return "[]";
        }
    }

    //获取某基站某小时的数据
    public function findHourDatas($station_id,$datetime){
        $hour = h_dt_start_time_of_hour($datetime);
        $start_time  = $hour;
        $stop_time = h_dt_stop_time_of_hour($hour);
        if($this->mid_data->changeTable($station_id,$datetime)){ 
            return $this->data->findPeriodDatas($station_id,$start_time,$stop_time);
        }else{
            return $this->data->findPeriodDatasArchive($station_id,$start_time,$stop_time);
        }
    }
    
    //获取某基站一天的数据
    public function findDayDatas($station_id,$datetime,$order = "asc"){
        if (h_dt_is_future_day($datetime)) {
            return array();
        }
        $day = h_dt_start_time_of_day($datetime);
        $start_time  = $day;
        $stop_time = h_dt_stop_time_of_day($day);
        if($this->mid_data->changeTable($station_id,$day)){
            return $this->data->findPeriodDatas($station_id,$start_time,$stop_time,$order);
        }else{
            return $this->data->findPeriodDatasArchive($station_id,$start_time,$stop_time,$order);
        }
        return $datas;
    }

    //获取一段时间数据
    public function findSomeDatas($station_id,$start_time,$stop_time,$order="asc"){
        $day = h_dt_start_time_of_day($start_time);
        if($this->mid_data->changeTable($station_id,$day)){
            return $this->data->findPeriodDatas($station_id,$start_time,$stop_time,$order);
        }else{
            return $this->data->findPeriodDatasArchive($station_id,$start_time,$stop_time,$order);
        }
        return $datas;
    }


    //////// 以上为白银 ///////////////////////////////////////////////////


    private function generateDayDataList_energy($_datas){

        $current_energy_main = 0;
        $current_energy_dc   = 0;
        $current_time_energy_main = 0;
        $current_time_energy_dc   = 0;
        $key_energy_main = 0;
        $key_energy_dc   = 0;
        $array_energy_main = array(0,0,0,0,0,0, 0,0,0,0,0,0, 0,0,0,0,0,0, 0,0,0,0,0,0,0);
        $array_energy_dc   = array(0,0,0,0,0,0, 0,0,0,0,0,0, 0,0,0,0,0,0, 0,0,0,0,0,0,0);

        foreach ($_datas as $key => $_data) {

            if( $_data['energy_main'] > $current_energy_main ){
                $new_current_time_energy_main = (strtotime($_data['create_time'])+8*3600)%86400;
                if($current_energy_main == 0){
                    $key_energy_main = $new_current_time_energy_main/3600;   
                    $array_energy_main[$key_energy_main]=$_data['energy_main'];
                }
                if($_data['energy_main'] > $array_energy_main[24]){$array_energy_main[24]=$_data['energy_main'];}
                $new_current_energy_main = $_data['energy_main'];
                if($new_current_time_energy_main > $key_energy_main*3600){
                    for($i = $key_energy_main;$new_current_time_energy_main>$i*3600;$i++){
                        $array_energy_main[$i] = round(($new_current_energy_main - $current_energy_main)*($i*3600-$current_time_energy_main)
                            /($new_current_time_energy_main - $current_time_energy_main) + $current_energy_main,2);
                    }
                    $key_energy_main = $i;
                }
                $current_time_energy_main = $new_current_time_energy_main;
                $current_energy_main = $new_current_energy_main;
            }

            if( $_data['energy_dc'] > $current_energy_dc ){

                $new_current_time_energy_dc = (strtotime($_data['create_time'])+8*3600)%86400;
                if($current_energy_dc == 0){
                    $key_energy_dc = $new_current_time_energy_dc/3600;   
                    $array_energy_dc[$key_energy_dc]=$_data['energy_dc'];
                }

                if($_data['energy_dc'] > $array_energy_dc[24]){$array_energy_dc[24]=$_data['energy_dc'];}
                $new_current_time_energy_dc = (strtotime($_data['create_time'])+8*3600)%86400;
                $new_current_energy_dc =  $_data['energy_dc'];
                if($new_current_time_energy_dc > $key_energy_dc*3600){
                    for($i = $key_energy_dc;$new_current_time_energy_dc>$i*3600;$i++){
                        $array_energy_dc[$i] = round(($new_current_energy_dc - $current_energy_dc)*($i*3600-$current_time_energy_dc)
                            /($new_current_time_energy_dc - $current_time_energy_dc) + $current_energy_dc,2);
                    }
                    $key_energy_dc = $i;
                }
                $current_time_energy_dc = $new_current_time_energy_dc;
                $current_energy_dc = $new_current_energy_dc;
            }

        }
        return array('energy_main'=>h_data_change_energy_array($array_energy_main),
                    'energy_dc'=>h_data_change_energy_array($array_energy_dc));
    }


    public function generateDayDataList($station_id, $_time_str, $dis_str) {

        $level = explode('-', $dis_str);

        $if_need_power  = (!$level[0] == 0) ; 
        $if_need_temp   = (!$level[1] == 0) ; 
        $if_need_colds  = (!$level[2] == 0) ; 
        $if_need_box    = (!$level[3] == 0) ;
        $if_need_hum    = (!$level[4] == 0) ;

        $params_chart = array("colds_0_on", "colds_1_on", "fan_0_on");
        $params = array("indoor_tmp", "outdoor_tmp", "box_tmp", "colds_0_tmp", "colds_1_tmp", 
            "indoor_hum", "outdoor_hum", "power_main", "power_dc", "energy_main","energy_dc");

        $level_jumps = array(0, 16, 8, 4);
        $_datas = $this->mid_data->findDayDatas($station_id, $_time_str, 'asc');

        foreach ($params as $param) {
            $data_array[$param] = array(h_make_highchart_str($_time_str,null));
        }
        foreach ($params_chart as $param) {
            $data_array[$param] = array(array(strtotime(h_dt_start_time_of_day($_time_str)), 0));
        }
        $tmp_on = array("colds_0_on" => null, "colds_1_on" => null, "fan_0_on" => null);
        $cache_on = array("colds_0_on" => array(), "colds_1_on" => array(), "fan_0_on" => array());

        foreach ($_datas as $key => $_data) {

            if ($key == 0) {
                $cache_on['fan_0_on'][]   = array(strtotime($_data['create_time']), $_data['fan_0_on']);
                $cache_on['colds_0_on'][] = array(strtotime($_data['create_time']), $_data['colds_0_on']);
                $cache_on['colds_1_on'][] = array(strtotime($_data['create_time']), $_data['colds_1_on']);
            } else {
                if ($_data['colds_0_on'] != $tmp_on['colds_0_on']) {
                    $cache_on['colds_0_on'][] = array(strtotime($_data['create_time']), $tmp_on['colds_0_on']);
                    $cache_on['colds_0_on'][] = array(strtotime($_data['create_time']), $_data['colds_0_on']);
                }
                if ($_data['colds_1_on'] != $tmp_on['colds_1_on']) {
                    $cache_on['colds_1_on'][] = array(strtotime($_data['create_time']), $tmp_on['colds_1_on']);
                    $cache_on['colds_1_on'][] = array(strtotime($_data['create_time']), $_data['colds_1_on']);
                }
                if ($_data['fan_0_on'] != $tmp_on['fan_0_on']) {
                    $cache_on['fan_0_on'][] = array(strtotime($_data['create_time']), $tmp_on['fan_0_on']);
                    $cache_on['fan_0_on'][] = array(strtotime($_data['create_time']), $_data['fan_0_on']);
                }
            }
            $tmp_on['fan_0_on'] = $_data['fan_0_on'];
            $tmp_on['colds_0_on'] = $_data['colds_0_on'];
            $tmp_on['colds_1_on'] = $_data['colds_1_on'];
            ///////////////////////
            if ($if_need_power && $key % $level_jumps[ $level[0] ] == 0) {
                $data_array['power_main'][] = h_make_highchart_str($_data['create_time'],$_data['power_main']);
                $data_array['power_dc'][] = h_make_highchart_str($_data['create_time'],$_data['power_dc']);
            }
            if ($if_need_temp && $key % $level_jumps[$level[1]] == 0) {
                $data_array['indoor_tmp'][] = h_make_highchart_str($_data['create_time'],$_data['indoor_tmp']);
                $data_array['outdoor_tmp'][] = h_make_highchart_str($_data['create_time'],$_data['outdoor_tmp'] );
            }
            if ($if_need_colds && $key % $level_jumps[$level[2]] == 0) {
                $data_array['colds_0_tmp'][] = h_make_highchart_str($_data['create_time'],$_data['colds_0_tmp']);
                $data_array['colds_1_tmp'][] = h_make_highchart_str($_data['create_time'],$_data['colds_1_tmp']);
            }

            if ($if_need_box && $key % $level_jumps[$level[3]] == 0) {
                $data_array['box_tmp'][] = h_make_highchart_str($_data['create_time'],$_data['box_tmp']);
            }

            if ($if_need_hum && $key % $level_jumps[$level[4]] == 0) {
                $data_array['indoor_hum'][] = h_make_highchart_str($_data['create_time'],$_data['indoor_hum']);
                $data_array['outdoor_hum'][] = h_make_highchart_str($_data['create_time'],$_data['outdoor_hum']);
            }
        }

        //增加尾巴
        foreach ($params as $param) {
            $data_array[$param][] = h_make_highchart_str(h_dt_stop_time_of_day($_time_str),null);
        }

        if($_datas){
            $cache_on['colds_0_on'][] = array(strtotime($_data['create_time']), $_data['colds_0_on']);
            $cache_on['colds_1_on'][] = array(strtotime($_data['create_time']), $_data['colds_1_on']);
            $cache_on['fan_0_on'][]   = array(strtotime($_data['create_time']), $_data['fan_0_on']);
        }

        $newresult = $cache_on;

        if ($if_need_power) {
            $cache_power['power_main'] = '[' . implode(',', $data_array['power_main']) . ']';
            $cache_power['power_dc'] = '[' . implode(',', $data_array['power_dc']) . ']';
            $newresult += $cache_power;
        }
        if ($if_need_temp) {
            $cache_temp['indoor_tmp'] = '[' . implode(',', $data_array['indoor_tmp']) . ']';
            $cache_temp['outdoor_tmp'] = '[' . implode(',', $data_array['outdoor_tmp']) . ']';
            $newresult += $cache_temp;
        }
        if ($if_need_colds) {
            $cache_colds['colds_0_tmp'] = '[' . implode(',', $data_array['colds_0_tmp']) . ']';
            $cache_colds['colds_1_tmp'] = '[' . implode(',', $data_array['colds_1_tmp']) . ']';
            $newresult += $cache_colds;
        }
        if ($if_need_box) {
            $cache_box['box_tmp'] =     '[' . implode(',', $data_array['box_tmp']) . ']';
            $newresult += $cache_box;
        }
        if ($if_need_hum) {
            $cache_hum['indoor_hum'] =  '[' . implode(',', $data_array['indoor_hum']) . ']';
            $cache_hum['outdoor_hum'] = '[' . implode(',', $data_array['outdoor_hum']) . ']';
            $newresult += $cache_hum;
        }

        $newresult += $this->generateDayDataList_energy($_datas);

        return $newresult;
    }





    public function dataXtimeHash($datas,$num=10){
        $hash = array();
        foreach($datas as $data){
            // +8*3600 因为时区为东8
            $t = (strtotime($data['create_time'])+8*3600) % 86400;
            $hash[floor($t/(60*$num))*$num] = $data;
        } 
        return $hash;
    }


    public function reCheck($auto_check_id){
        if($auto_check_id){
            $auto_check = $this->autocheck->find($auto_check_id);
            $start_time = $auto_check['datetime'];
            $station_id = $auto_check['station_id'];
            $result = $this->mid_data->autocheck($station_id,$start_time);        
            $this->autocheck->updateBy(array("report"=>$result),array("id"=>$auto_check_id));
        }
    }

    public function autocheck($station_id,$time='now'){
        $station = $this->station->find($station_id);
        $datas = $this->mid_data->findSomeDatas($station_id,h_dt_sub_min($time,7),h_dt_format($time));
        if(count($datas)<2){
            return '["no_data"]';
        }
        $alloffs = array();
        foreach($datas as $data){
            if($data['fan_0_on'] == 0 && $data['colds_0_on'] == 0 && $data['colds_1_on'] == 0){
                $alloffs[] = $data;
            }
        }
        if(count($alloffs)<2){
            return '["no_alloff"]';
        }
        $alloffs = h_array_sort($alloffs,"create_time");
        foreach($alloffs as $key => $alloff){
            if($key == 0){
                continue;
            }
            if(h_power_dc_out_range($alloff['power_dc'],$station['load_num'])){
                return '["dc_wrong"]';
            }
            //因为设备全关 总能耗和直流能耗应该差不多
            if(h_power_main_out_range($alloff['power_main'],$station['load_num'])){
                return '["main_wrong"]';
            }
            //main不能比dc大太多
            if($alloff['power_dc'] > $alloff['power_main'] + 50){
                return '["main_wrong"]';
            }
        }

        return null;
    }



    public function findLastStdDaydata($station_id,$time){
        $lastday = $this->np1stdday->findLastByTime($station_id,$time);
        if(!$lastday){
            return null;
        }
        $daydata = $this->daydata->findOneBy(
            array("station_id"=>$station_id,"day"=>$lastday['datetime']));
        return $daydata;
    } 


    public function findNp1StationDaydatas($station_id,$start_str,$stop_str){
        $daydatas = $this->daydata->findByStationAndPeriod($station_id,$start_str,$stop_str);
        //$np1stddays = $this->np1stdday->findBystationAndPeriod($station_id,$start_str,$stop_str);
        //$np1stddayhash = h_array_to_hash($np1stddays,"datetime");
        if( !$this->np1stdday->isStdday($station_id,$start_str) ){
            $last_std_daydata = $this->findLastStdDaydata($station_id,$start_str);
            if($last_std_daydata){
                array_unshift($daydatas,$last_std_daydata);    
            }
        }
        $std = null;
        $result = array();
        foreach($daydatas as $daydata){
            $daydata['err'] = ""; 
            $daydata['time'] = h_dt_format($daydata['day']); 
            $daydata['is_standard'] = $this->np1stdday->isStdday($station_id,$daydata['day']); 
            $daydata['ac_save'] = null; 
            $daydata['ac_save_p'] = null; 
            if($daydata['is_standard']){
                $std = $daydata;
                if(!h_av_day_energy($std['ac_energy'])){
                    $daydata['err'] .= " 基准日能耗统计有误"; 
                }
            }else{
                if(!$std){
                    $daydata['err'] .= " 无对应基准日"; 
                }elseif(!h_av_day_energy($std['ac_energy'])){
                    $daydata['err'] .= " 基准日能耗统计有误"; 
                }

                if(!$daydata['ac_energy']){
                    $daydata['err'] .= " 本日能耗统计有误"; 
                }

                if(!$daydata['err']){
                    $daydata['ac_save'] = $std['ac_energy'] - $daydata['ac_energy'];
                    $daydata['ac_save_p'] = $daydata['ac_save']*100/$std['ac_energy'];
                }
            }
            $result['days'][] = $daydata; 
        }

        $sum['err'] = "N+1统计开发中";
        $result['total'] = $sum; 
        return $result;
    }

    public function findSavingDaydata_sql($station_id,$day){
        $station = $this->station->find_sql($station_id);
        $day = h_dt_start_time_of_day($day);

        $err = "";
        $result = array();
        if(ESC_STATION_TYPE_STANDARD == $station["station_type"]){
            $result['err'] = "本站为基准站";
            return $result;
        }
        if(h_dt_is_today_or_future($day)){
            $result['err'] = "本日数据暂未统计";
            return $result;
        }

        $daydatas = $this->daydata->findBy_sql(array("station_id"=>$station_id,"day"=>$day));

        if(!$daydatas){
            $result['err'] = "本日无数据(未建设)";
            return $result;
        }else{
            $result = $daydatas[0];
            if(!h_av_day_energy($result['ac_energy'])){
                $result['err'] = " 本日数据统计有误";
                return $result;
            }
        }
        if (ESC_STATION_TYPE_NPLUSONE == $station["station_type"]){
            if($this->np1stdday->isStdday($station_id,$day)){
                $err .= " 本日为基准日";
            }else{
                $last_std_daydata = $this->findLastStdDaydata($station_id,$day);
                if(!$last_std_daydata){ 
                    $err .= " 往前找不到基准日";
                }elseif(!h_av_day_energy($last_std_daydata['ac_energy'])){
                    $err .= " 基准日统计数据有误";
                }else{
                    $result['std_ac_energy'] = $last_std_daydata['ac_energy'];
                    $result['saving'] = $result['std_ac_energy'] - $result['ac_energy'];
                    $result['saving_p'] = $result['saving']*100/$result['std_ac_energy'];
                }
            } 
        }else{
            $std_station = $this->station->find_single_standard_station_sql($station);
            if(!$std_station){
                $err .= " 无可对比基准站";
            }else{
                $query = $this->db->query("select * from daydatas where station_id = ? and day=?",
                    array($std_station["id"],$day));
                $res = $query->result_array();

                if(!$res){ 
                    $err .= " 找不到基准站当天数据";
                }elseif(!h_av_day_energy($res[0]['ac_energy'])){
                    $err .= " 基准站当天数据统计有误";
                }else{
                    $result['std_ac_energy'] = $res[0]['ac_energy'];
                    $result['std_dc_energy'] = $res[0]['dc_energy'];
                    $result['saving'] = $result['std_ac_energy'] - $result['ac_energy'];
                    $result['saving_p'] = $result['saving']*100/$result['std_ac_energy'];
                    $result['contract_energy_saving_rate'] = $this->contract_energy_saving_rate_v0(
                        $res[0]['main_energy'],$result['main_energy'],$res[0]['dc_energy'],$result['dc_energy']);         

                    $result['contract_energy_saving_rate1'] = $this->contract_energy_saving_rate_v0(
                        $res[0]['main_energy'],$result['main_energy'],$std_station["load_num"],$station["load_num"]);
                }
            }
        }

        $result['err'] = $err;

        return $result;
    }

    //根据节能合同的计算公式计算基站的节能率
    //$energy_base 基准站能耗
    //$energy_test 标杆站能耗
    //$load_base 基准站负载 
    //$load_test 标杆站负载 
    //返回单站节能率
    //=====单元测试=====
    public function contract_energy_saving_rate_v0($energy_base, $energy_test, $load_base, $load_test) {
        if ($load_base ==0 || $load_test == 0 || $energy_base == 0){
            return 0;
        }
        $rate = round(($energy_base - $energy_test * $load_base / $load_test) / $energy_base, 4);
        return $rate;
    }




    public function checkDataTables(){
        $data_indexs = $this->data_index->findBy(array("archive"=>1));
        foreach($data_indexs as $data_index){
            $this->mid_data->createDataTable($data_index['table']);
        }
    }


    public function createDataTable($name){
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `".$name."` (
              `station_id` int(10) unsigned NOT NULL DEFAULT '0',
              `indoor_tmp` decimal(3,1) DEFAULT NULL,
              `outdoor_tmp` decimal(3,1) DEFAULT NULL,
              `box_tmp` decimal(3,1) DEFAULT NULL,
              `colds_0_tmp` decimal(3,1) DEFAULT NULL,
              `colds_1_tmp` decimal(3,1) DEFAULT NULL,
              `indoor_hum` tinyint(3) DEFAULT NULL,
              `outdoor_hum` tinyint(3) DEFAULT NULL,
              `colds_0_on` tinyint(1) DEFAULT NULL,
              `colds_1_on` tinyint(1) DEFAULT NULL,
              `fan_0_on` tinyint(1) DEFAULT NULL,
              `colds_box_on` tinyint(1) DEFAULT NULL,
              `power_main` int(4) DEFAULT NULL,
              `power_dc` int(4) DEFAULT NULL,
              `energy_main` decimal(10,2) DEFAULT NULL,
              `energy_dc` decimal(10,2) DEFAULT NULL,
              `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `true_out_tmp` decimal(3,1) DEFAULT NULL,
              `box_tmp_1` decimal(3,1) DEFAULT NULL,
              `box_tmp_2` decimal(3,1) DEFAULT NULL,
              PRIMARY KEY (`station_id`,`create_time`),
              KEY `create_time` (`create_time`)
            )
        ");
    }


}
