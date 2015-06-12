<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Esgconf extends ES_Model {

    var $ec_array;
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->table_name = "esgconfs";
        $this->load->helper('esgconf');
        $this->init_ec_array();
    }

    //初始化设置描述的数组
    private function init_ec_array(){
        $ec_array[1] = array("sid"=>"s01", "cn"=>"上传周期",        "dbc"=>"update_duration",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[2] = array("sid"=>"s02", "cn"=>"新风采样持续",    "dbc"=>"fan_sampling_last_time",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[3] = array("sid"=>"s03", "cn"=>"基准日空调设温",  "dbc"=>"base_day_ac_temp",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[4] = array("sid"=>"s04", "cn"=>"节能日空调设温",  "dbc"=>"energy_saving_ac_temp",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[5] = array("sid"=>"s05", "cn"=>"基本周期",        "dbc"=>"base_interval",
            "is_str"=>"","is_hide"=>"1","is_disable"=>"", "desc"=>"");
        $ec_array[6] = array("sid"=>"s06", "cn"=>"告警周期",        "dbc"=>"warning_period",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[7] = array("sid"=>"s07", "cn"=>"最低负压",        "dbc"=>"lowest_press",
            "is_str"=>"","is_hide"=>"1","is_disable"=>"", "desc"=>"");
        $ec_array[8] = array("sid"=>"s08", "cn"=>"最高出风口温度",  "dbc"=>"highest_colds_temp",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[9] = array("sid"=>"s09", "cn"=>"最高室内温度",    "dbc"=>"highest_indoor_tmp",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[10] = array("sid"=>"s10","cn"=>"最高室内湿度",    "dbc"=>"highest_indoor_hum",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[11] = array("sid"=>"s11","cn"=>"最高恒温柜温度",  "dbc"=>"highest_box_tmp",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[12] = array("sid"=>"s12","cn"=>"空调1启动温度",   "dbc"=>"ch_tmp",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[13] = array("sid"=>"s13","cn"=>"步进量",          "dbc"=>"cd_tmp",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[14] = array("sid"=>"s14","cn"=>"设备全关补偿因子", "dbc"=>"all_close_temp",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[15] = array("sid"=>"s15","cn"=>"新风启动补偿因子", "dbc"=>"temp_adjust_factor",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[16] = array("sid"=>"s16","cn"=>"新风最小开时间",   "dbc"=>"fan_min_time",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[17] = array("sid"=>"s17","cn"=>"系统模式",         "dbc"=>"sys_mode",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[18] = array("sid"=>"s18","cn"=>"简单控制",        "dbc"=>"simple_control",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[19] = array("sid"=>"s19","cn"=>"6+1节能日",        "dbc"=>"day_of_week",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[20] = array("sid"=>"s20","cn"=>"现在时间",        "dbc"=>"ctime",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[21] = array("sid"=>"s21","cn"=>"空调启动次序",        "dbc"=>"colds_order",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"0为正常顺序，1为交换顺序");
        $ec_array[22] = array("sid"=>"s22","cn"=>"空调最短时间",        "dbc"=>"colds_min_time",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"单位：分钟");
        $ec_array[23] = array("sid"=>"s23","cn"=>"恒温柜类型",        "dbc"=>"colds_box_type",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"0春兰 1榜样");
        $ec_array[24] = array("sid"=>"s24","cn"=>"智能电表类型",        "dbc"=>"smart_meter_type",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"0博欧 1雅达2060");
        $ec_array[25] = array("sid"=>"s25","cn"=>"空调1控制方式",        "dbc"=>"colds_0_ctrl_type",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"0继电器 1表示485 2脉冲");
        $ec_array[26] = array("sid"=>"s26","cn"=>"空调2控制方式",        "dbc"=>"colds_1_ctrl_type",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"0继电器 1表示485 2脉冲");
        $ec_array[27] = array("sid"=>"s27","cn"=>"新风延长开启时间",        "dbc"=>"fan_keep_on_time",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", 
            "desc"=>"到空调开的条件时,不立即关闭而继续开新风时间长度，单位是min，0表示不延长");
        $ec_array[28] = array("sid"=>"s28","cn"=>"风机调速",        "dbc"=>"fan_full_speed_duration",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", 
            "desc"=>"格式********,例07002100表示从早上7点到晚上21点全速运行，其余时段半速运行");
        $ec_array[29] = array("sid"=>"s29","cn"=>"空调开关温差",        "dbc"=>"colds_onoff_distance",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"浮点数，1位小数点;单位℃");
        $ec_array[30] = array("sid"=>"s30","cn"=>"新风启动内外温差",        "dbc"=>"in_out_distance",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[31] = array("sid"=>"s31","cn"=>"恒温柜空调制冷点",        "dbc"=>"colds_box_workpoint",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[32] = array("sid"=>"s32","cn"=>"制冷点灵敏度",        "dbc"=>"colds_box_worksens",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"");
        $ec_array[33] = array("sid"=>"s33","cn"=>"基站负载",        "dbc"=>"load_num",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"保留两位小数");
        $ec_array[34] = array("sid"=>"s34","cn"=>"上位机主机名",        "dbc"=>"host",
            "is_str"=>"","is_hide"=>"","is_disable"=>"", "desc"=>"形如jslt.s 出厂默认的应该是s");
        $this->ec_array = $ec_array;
    }
    //获取某个设置的中文名
    public function getEcArrayName($type){
        $ec_item = $this->ec_array[$type]; 
        return $ec_item["cn"];
    }
    public function getECString($post_array){
        $arg_str_array = array();
        foreach ($this->esgconf->ec_array as $ec_item) {
            if(array_key_exists($ec_item['dbc'],$post_array) && $post_array[$ec_item['dbc']]){
                $_post_value = $post_array[$ec_item['dbc']];
                if ($ec_item['is_str']) {
                    array_push($arg_str_array, "\"" . $_post_value . "\"");
                } else {
                    array_push($arg_str_array, $_post_value);
                }
            }else{
                array_push($arg_str_array, "\"\"");
            }
        }
        $_arg_str = "[" . implode(",", $arg_str_array) . "]";
        return $_arg_str;
    }
    public function getECIntro($post_array){
        return "introduction";
    }

    //v3版本是未来版本
    public function setJsonEsgConf_v3($station_id,$json){
        $_data = null;
        $_data = json_decode($json);
        $esgconf_array = array();
        if (empty($_data)) {
            log_message('error', 'json setting error:' . $json);
        } else {
            $esgconf = $this->findOneBy_sql(array("station_id"=>$station_id));
            if(!$esgconf){
                $esgconf_id = $this->new_sql(array("station_id"=>$station_id));
            }else{
                $esgconf_id = $esgconf['id'];
            }
            $esgconf_array = array();
            foreach(h_esgconf_array() as $_c => $_esgconf){
                //$sxx = h_num_to_sxx($i);
                if(isset($_data->$_c)){
                    $esgconf_array[$_esgconf['en']] = $_data->$_c;
                }
            }
            if($esgconf_array){
                $esgconf_array['last_update_time'] = h_dt_now();
                $this->esgconf->update_sql($esgconf_id,$esgconf_array);
            }
        }
        return $esgconf_array; 
    }

    //v2版仅仅是把设置拿到外面
    public function setJsonEsgConf_v2($station_id,$json){
        $_data = null;
        $_data = json_decode($json);
        $esgconf_array = array();
        $station = $this->station->find_sql($station_id);
        if (empty($_data)) {
            log_message('error', 'json setting error:' . $json);
            return false;
        } else {
            $esgconf = $this->findOneBy_sql(array("station_id"=>$station_id));
            if(!$esgconf){
                $esgconf_id = $this->new_sql(array("station_id"=>$station_id));
            }else{
                $esgconf_id = $esgconf['id'];
            }
            $esgconf_array = array();
            foreach($_data as $i => $value){
                if(h_esgconf_exist(h_num_to_sxx($i+1))){
                    $esgconf_array[h_esgconf_name_en(h_num_to_sxx($i+1))] = $value;
                }
            }
            if($esgconf_array){
                $esgconf_array['last_update_time'] = h_dt_now();
                $this->update_sql($esgconf_id,$esgconf_array);
            }

        }
        return $esgconf_array;
    }

    //获取设置和一部分基站属性 此处以后需要重构
    public function setJsonEsgConf($station_id,$json){
        $_data = null;
        $_data = json_decode($json);
        $esgconf_array = array();
        $property_array = array();
        $station = $this->station->find_sql($station_id);
        if (empty($_data)) {
            log_message('error', 'json setting error:' . $json);
            return false;
        } else {
            $esgconf = $this->findOneBy_sql(array("station_id"=>$station_id));
            if(!$esgconf){
                $esgconf_id = $this->new_sql(array("station_id"=>$station_id));
            }else{
                $esgconf_id = $esgconf['id'];
            }
            $esgconf_array = array();
            foreach($_data->s as $i => $value){
                if(h_esgconf_exist(h_num_to_sxx($i+1))){
                    $esgconf_array[h_esgconf_name_en(h_num_to_sxx($i+1))] = $value;
                }
            }
            if($esgconf_array){
                $esgconf_array['last_update_time'] = h_dt_now();
                $this->update_sql($esgconf_id,$esgconf_array);
            }

            //一些属性暂时放在这边处理了
            if (isset($_data->p) && count($_data->p) >= 1) {
                $esgconf_array['rom_version'] =  $_data->p[0];
            }
        }
        return $esgconf_array;
    }

}
