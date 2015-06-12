<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data extends ES_Model {

    public $archive_table_name;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table_name = "datas";
        $this->archive_table_name = "datas";
        $this->load->helper('data');
    }

    public function findLast($station_id){
        return $this->data->findOneBy(
                array("station_id"=>$station_id),
                array("create_time desc"));
    }
    public function findLastArchive($station_id){
        $json = $this->data->getArchiveWs("/archive/home/findLast/".
            $this->archive_table_name."/".$station_id);
        return json_decode($json,true);
    }
    public function findLastN($station_id,$n){
        return $this->data->findBy(array("station_id"=>$station_id),array("create_time desc"),$n);
    }
    public function findLastNArchive($station_id,$n){
        $json = $this->data->getArchiveWs("/archive/home/findLastN/".
            $this->archive_table_name."/".$station_id."/".$n);
        return json_decode($json,true);
    }
    public function findPeriodDatas($station_id,$start_time,$stop_time,$order="asc"){
        $this->data->where("( create_time > ".$start_time." and create_time <= ".$stop_time.")");
        return $this->data->findBy(array("station_id"=>$station_id));
    }
    public function findPeriodDatasArchive($station_id,$start_time,$stop_time,$order="asc"){
        $json = $this->data->getArchiveWs("/archive/home/findPeriodDatas/".
            $this->archive_table_name."/".$station_id."/".$start_time."/".$stop_time."/".$order);
        return json_decode($json,true);
    }







    public function daydata($time_str) {
    }

    public function changeTableName($table){
        $this->table_name = $table;
    }
    public function changeArchiveName($table){
        $this->archive_table_name = $table;
    }


    public function insertJsonData_new($station_id, $json_str, $version) {
        $_data = json_decode($json_str);
        if (empty($_data)) {
            log_message('error', 'json data error:' . $json_str);
        } else {
            foreach ($_data as $_dataitem) {
                $sqldata = array();
                $sqldata_ext = array();
                //1.	indoor_tmp
                if ($_dataitem[0] !== "" && $_dataitem[0] > -20 && $_dataitem[0] < 70) {
                    $sqldata["indoor_tmp"] = $_dataitem[0];
                }
                //2.	outdoor_tmp
                if ($_dataitem[1] !== "" && $_dataitem[1] > -20 && $_dataitem[1] < 70) {
                    $sqldata["outdoor_tmp"] = $_dataitem[1];
                }
                //3.	indoor_hum
                if ($_dataitem[2] !== "" && $_dataitem[2] >= 0 && $_dataitem[2] <= 100) {
                    $sqldata["indoor_hum"] = $_dataitem[2];
                }
                //4.	outdoor_hum
                if ($_dataitem[3] !== "" && $_dataitem[3] >= 0 && $_dataitem[3] <= 100) {
                    $sqldata["outdoor_hum"] = $_dataitem[3];
                }
                //5.	box_tmp
                if($version == 2){
                    $box_tmp = h_data_min_box_tmp($_dataitem[4],$_dataitem[21],$_dataitem[22]);
                }else{
                    $box_tmp = $_dataitem[4];
                }
                if ($box_tmp !== "" && $box_tmp > -20 && $box_tmp < 70) {
                    $sqldata["box_tmp"] = $box_tmp;
                }
                //6.	colds_0_on
                if ($_dataitem[5] !== "" && ($_dataitem[5] == 1 or $_dataitem[5] == 0)) {
                    $sqldata["colds_0_on"] = $_dataitem[5];
                }
                //7.	colds_1_on
                if ($_dataitem[6] !== "" && ($_dataitem[6] == 1 or $_dataitem[6] == 0)) {
                    $sqldata["colds_1_on"] = $_dataitem[6];
                }
                //8.	colds_2_on
                //9.	fan_0_on
                if ($_dataitem[8] !== "" && ($_dataitem[8] == 1 or $_dataitem[8] == 0)) {
                    $sqldata["fan_0_on"] = $_dataitem[8];
                }
                //10.	fan_1_on
                //11.	colds_0_tmp
                if ($_dataitem[10] !== "" && $_dataitem[10] > -20 && $_dataitem[10] < 70) {
                    $sqldata["colds_0_tmp"] = $_dataitem[10];
                }
                //12.	colds_1_tmp
                if ($_dataitem[11] !== "" && $_dataitem[11] > -20 && $_dataitem[11] < 70) {
                    $sqldata["colds_1_tmp"] = $_dataitem[11];
                }
                //13.	colds_2_tmp
                //14.	fan_0_press
                //15.	fan_1_press
                //16.   colds_box_on
                if ($_dataitem[15] !== "" && ($_dataitem[15] == 1 or $_dataitem[15] == 0)) {
                    $sqldata["colds_box_on"] = $_dataitem[15];
                }
                //17. power_main
                if ($_dataitem[16] !== "" ) {
                    $p = $_dataitem[16];
                    if($p>=80000){ $p = -($p - 80000); }
                    $sqldata["power_main"] = $p;
                }
                //18. energy_main
                if ($_dataitem[17] !== "" && $_dataitem[17] > 0) {
                    $sqldata["energy_main"] = $_dataitem[17];
                }
                //19. power_dc
                if ($_dataitem[18] !== "" ) {
                    $p = $_dataitem[18];
                    if($p>=80000){ $p = -($p - 80000); }
                    $sqldata["power_dc"] = $p;
                }
                //20. energy_dc
                if ($_dataitem[19] !== "" && $_dataitem[19] > 0) {
                    $sqldata["energy_dc"] = $_dataitem[19];
                }
                if($version == 2 && $this->table_name != "datas"){
                    //21. true_out_tmp
                    if ($_dataitem[20] !== "" && $_dataitem[20] > -20 && $_dataitem[20] < 70) {
                        $sqldata["true_out_tmp"] = $_dataitem[20];
                    }
                    //22. box_tmp_1
                    if ($_dataitem[21] !== "" && $_dataitem[21] > -20 && $_dataitem[4] < 70) {
                        $sqldata["box_tmp_1"] = $_dataitem[21];
                    }
                    //23. box_tmp_2 
                    if ($_dataitem[22] !== "" && $_dataitem[22] > -20 && $_dataitem[4] < 70) {
                        $sqldata["box_tmp_2"] = $_dataitem[22];
                    }
                }
                $sqldata['station_id'] = $station_id;
                $sqldata['create_time'] = h_dt_now();
                parent::new_sql($sqldata);
                return;
            }
        }
        return null;
    }


    //插入来自开发板的JSON数据
    //====单元测试====
    public function insertJsonData($station_id, $json_str) {
        $_data = json_decode($json_str);
        if (empty($_data)) {
            log_message('error', 'json data error:' . $json_str);
        } else {
            foreach ($_data as $_dataitem) {
                $sqldata = array();
                //1.	indoor_tmp
                if ($_dataitem[0] !== "" && $_dataitem[0] > -20 && $_dataitem[0] < 70) {
                    $sqldata["indoor_tmp"] = $_dataitem[0];
                }
                //2.	outdoor_tmp
                if ($_dataitem[1] !== "" && $_dataitem[1] > -20 && $_dataitem[1] < 70) {
                    $sqldata["outdoor_tmp"] = $_dataitem[1];
                }
                //3.	indoor_hum
                if ($_dataitem[2] !== "" && $_dataitem[2] >= 0 && $_dataitem[2] <= 100) {
                    $sqldata["indoor_hum"] = $_dataitem[2];
                }
                //4.	outdoor_hum
                if ($_dataitem[3] !== "" && $_dataitem[3] >= 0 && $_dataitem[3] <= 100) {
                    $sqldata["outdoor_hum"] = $_dataitem[3];
                }
                //5.	box_tmp
                if ($_dataitem[4] !== "" && $_dataitem[4] > -20 && $_dataitem[4] < 70) {
                    $sqldata["box_tmp"] = $_dataitem[4];
                }
                //6.	colds_0_on
                if ($_dataitem[5] !== "" && ($_dataitem[5] == 1 or $_dataitem[5] == 0)) {
                    $sqldata["colds_0_on"] = $_dataitem[5];
                }
                //7.	colds_1_on
                if ($_dataitem[6] !== "" && ($_dataitem[6] == 1 or $_dataitem[6] == 0)) {
                    $sqldata["colds_1_on"] = $_dataitem[6];
                }
                //8.	colds_2_on
                //9.	fan_0_on
                if ($_dataitem[8] !== "" && ($_dataitem[8] == 1 or $_dataitem[8] == 0)) {
                    $sqldata["fan_0_on"] = $_dataitem[8];
                }
                //10.	fan_1_on
                //11.	colds_0_tmp
                if ($_dataitem[10] !== "" && $_dataitem[10] > -20 && $_dataitem[10] < 70) {
                    $sqldata["colds_0_tmp"] = $_dataitem[10];
                }
                //12.	colds_1_tmp
                if ($_dataitem[11] !== "" && $_dataitem[11] > -20 && $_dataitem[11] < 70) {
                    $sqldata["colds_1_tmp"] = $_dataitem[11];
                }
                //13.	colds_2_tmp
                //14.	fan_0_press
                //15.	fan_1_press
                //16.   colds_box_on
                if ($_dataitem[15] !== "" && ($_dataitem[15] == 1 or $_dataitem[15] == 0)) {
                    $sqldata["colds_box_on"] = $_dataitem[15];
                }
                //17. power_main
                if ($_dataitem[16] !== "" && $_dataitem[16] >= 0 && $_dataitem[16] <= 20000) {
                    $sqldata["power_main"] = $_dataitem[16];
                }
                //18. energy_main
                if ($_dataitem[17] !== "" && $_dataitem[17] > 0) {
                    $sqldata["energy_main"] = $_dataitem[17];
                }
                //19. power_dc
                if ($_dataitem[18] !== "" && $_dataitem[18] >= 0 && $_dataitem[18] <= 20000) {
                    $sqldata["power_dc"] = $_dataitem[18];
                }
                //20. energy_dc
                if ($_dataitem[19] !== "" && $_dataitem[19] > 0) {
                    $sqldata["energy_dc"] = $_dataitem[19];
                }
                //21. power_colds_0
                //22. energy_colds_0
                //23. power_colds_1
                //24. energy_colds_1
                //25. power_colds_2
                //26. energy_colds_2
                //27. power_fan
                //28. energy_fan
                $sqldata['station_id'] = $station_id;
                $sqldata['create_time'] = h_dt_now();
                return parent::new_sql($sqldata);
            }
        }
        return null;
    }


    public function insertJsonData_v2($station_id, $json_str) {
        $_data = json_decode($json_str);
        if (empty($_data)) {
            log_message('error', 'json data error:' . $json_str);
        } else {
            foreach ($_data as $_dataitem) {
                $sqldata = array();
                $sqldata_ext = array();
                //1.	indoor_tmp
                if ($_dataitem[0] !== "" && $_dataitem[0] > -20 && $_dataitem[0] < 70) {
                    $sqldata["indoor_tmp"] = $_dataitem[0];
                }
                //2.	outdoor_tmp
                if ($_dataitem[1] !== "" && $_dataitem[1] > -20 && $_dataitem[1] < 70) {
                    $sqldata["outdoor_tmp"] = $_dataitem[1];
                }
                //3.	indoor_hum
                if ($_dataitem[2] !== "" && $_dataitem[2] >= 0 && $_dataitem[2] <= 100) {
                    $sqldata["indoor_hum"] = $_dataitem[2];
                }
                //4.	outdoor_hum
                if ($_dataitem[3] !== "" && $_dataitem[3] >= 0 && $_dataitem[3] <= 100) {
                    $sqldata["outdoor_hum"] = $_dataitem[3];
                }
                //5.	box_tmp
                $box_tmp = h_data_min_box_tmp($_dataitem[4],$_dataitem[21],$_dataitem[22]);
                if ($box_tmp !== "" && $box_tmp > -20 && $box_tmp < 70) {
                    $sqldata["box_tmp"] = $box_tmp;
                }
                //6.	colds_0_on
                if ($_dataitem[5] !== "" && ($_dataitem[5] == 1 or $_dataitem[5] == 0)) {
                    $sqldata["colds_0_on"] = $_dataitem[5];
                }
                //7.	colds_1_on
                if ($_dataitem[6] !== "" && ($_dataitem[6] == 1 or $_dataitem[6] == 0)) {
                    $sqldata["colds_1_on"] = $_dataitem[6];
                }
                //8.	colds_2_on
                //9.	fan_0_on
                if ($_dataitem[8] !== "" && ($_dataitem[8] == 1 or $_dataitem[8] == 0)) {
                    $sqldata["fan_0_on"] = $_dataitem[8];
                }
                //10.	fan_1_on
                //11.	colds_0_tmp
                if ($_dataitem[10] !== "" && $_dataitem[10] > -20 && $_dataitem[10] < 70) {
                    $sqldata["colds_0_tmp"] = $_dataitem[10];
                }
                //12.	colds_1_tmp
                if ($_dataitem[11] !== "" && $_dataitem[11] > -20 && $_dataitem[11] < 70) {
                    $sqldata["colds_1_tmp"] = $_dataitem[11];
                }
                //13.	colds_2_tmp
                //14.	fan_0_press
                //15.	fan_1_press
                //16.   colds_box_on
                if ($_dataitem[15] !== "" && ($_dataitem[15] == 1 or $_dataitem[15] == 0)) {
                    $sqldata["colds_box_on"] = $_dataitem[15];
                }
                //17. power_main
                if ($_dataitem[16] !== "" && $_dataitem[16] >= 0 && $_dataitem[16] <= 20000) {
                    $sqldata["power_main"] = $_dataitem[16];
                }
                //18. energy_main
                if ($_dataitem[17] !== "" && $_dataitem[17] > 0) {
                    $sqldata["energy_main"] = $_dataitem[17];
                }
                //19. power_dc
                if ($_dataitem[18] !== "" && $_dataitem[18] >= 0 && $_dataitem[18] <= 20000) {
                    $sqldata["power_dc"] = $_dataitem[18];
                }
                //20. energy_dc
                if ($_dataitem[19] !== "" && $_dataitem[19] > 0) {
                    $sqldata["energy_dc"] = $_dataitem[19];
                }
                //21. true_out_tmp
                if ($_dataitem[20] !== "" && $_dataitem[20] > -20 && $_dataitem[20] < 70) {
                    $sqldata_ext["true_out_tmp"] = $_dataitem[20];
                }
                //22. box_tmp_1
                if ($_dataitem[21] !== "" && $_dataitem[21] > -20 && $_dataitem[4] < 70) {
                    $sqldata_ext["box_tmp_1"] = $_dataitem[21];
                }
                //23. box_tmp_2 
                if ($_dataitem[22] !== "" && $_dataitem[22] > -20 && $_dataitem[4] < 70) {
                    $sqldata_ext["box_tmp_2"] = $_dataitem[22];
                }
                $sqldata['station_id'] = $station_id;
                $sqldata['create_time'] = h_dt_now();

                parent::new_sql($sqldata);
                //$sqldata_ext['data_id']=$this->db->insert_id();
                //$this->db->insert('data_exts',$sqldata_ext);

                return;
            }
        }
        return null;
    }

    public function countLastNError($ext_where,$arg = null) {
        $this->db->select("station_id,count(*) num");
        $this->db->where(array("create_time >= "=>h_dt_sub_min('now',10)));
        $this->db->where($ext_where);
        $datas = $this->data->findBy();
        return $datas;
    } 

    

    public function errorNormal($ext_where,$arg = null){
        if($arg){
            $this->db->select("station_id,count(*) num,".$arg);
        }else{
            $this->db->select("station_id,count(*) num");
        }
        $this->db->where(array("create_time >= "=>h_dt_sub_min('now',10)));
        $this->db->where($ext_where);
        $this->db->group_by("station_id");
        $datas = $this->data->findBy();
        $bugs = array();
        foreach ($datas as $item) {
            //10分钟内有3个错误才报错
            if ($item['num'] > 2) {                
                if($arg){
                    $bugs[$item['station_id']] = $item[$arg];
                }else{
                    $bugs[$item['station_id']] = "";
                }
            }
        }
        return $bugs;
    }



/************************************************************************
 ** calc errors from datas **                                           
 ************************************************************************/





}














