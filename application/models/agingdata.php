<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agingdata extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "agingdatas";
    }


    //插入来自开发板的JSON数据
    //====单元测试====
    public function insertJsonData($esg_id,$json_str){
        $_data = json_decode($json_str);
        if (empty($_data)) {
            log_message('error', 'json data error:' . $json_str);
        } else {
            foreach ($_data as $_dataitem) {
                $sqldata = array();
                //1.	indoor_tmp
                if ($_dataitem[0] !== "" && $_dataitem[0] > -20 && $_dataitem[0] < 70) {
                    $sqldata["indoor_tmp"] =$_dataitem[0];
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
                //6.	colds_0_on
                //7.	colds_1_on
                //8.	colds_2_on
                //9.	fan_0_on
                //10.	fan_1_on
                //11.	colds_0_tmp
                if ($_dataitem[10] !== "" && $_dataitem[10] > -20 && $_dataitem[10] < 70) {
                    $sqldata["colds_0_tmp"] = $_dataitem[10];
                }
                //12.	colds_1_tmp
                if ($_dataitem[11] !== "" && $_dataitem[11] > -20 && $_dataitem[11] < 70) {
                    $sqldata["colds_1_tmp"] = $_dataitem[11];
                }
                //13. colds_2_tmp
                //14. fan_0_press
                //15. fan_1_press
                //16. colds_box_on
                //17. power_main
                //18. energy_main
                //19. power_dc
                //20. energy_dc
                //21. power_colds_0
                //22. energy_colds_0
                //23. power_colds_1
                //24. energy_colds_1
                //25. power_colds_2
                //26. energy_colds_2
                //27. power_fan
                //28. energy_fan
                $sqldata['esg_id'] = $esg_id;
                $sqldata['create_time'] = h_dt_now();
                return parent::new_sql($sqldata); 
            }
        }
        return null;
    }



    //插入来自开发板的JSON数据
    public function insertJsonData_v3($esg_id, $json_str) {
        $_data = json_decode($json_str);
        if (empty($_data)) {
            log_message('error', 'json data error:' . $json_str);
        } else {
            
            foreach ($_data as $_dataitem) {
                $sqldata = array();


                //1.    indoor_tmp
                if ($_dataitem[0] !== "" && $_dataitem[0] > -20 && $_dataitem[0] < 70) {
                    $sqldata["indoor_tmp"] = $_dataitem[0];
                }
                //2.    outdoor_tmp
                if ($_dataitem[1] !== "" && $_dataitem[1] > -20 && $_dataitem[1] < 70) {
                    $sqldata["outdoor_tmp"] = $_dataitem[1];
                }
                //3.    indoor_hum
                if ($_dataitem[2] !== "" && $_dataitem[2] >= 0 && $_dataitem[2] <= 100) {
                    $sqldata["indoor_hum"] = $_dataitem[2];
                }
                //4.    outdoor_hum
                if ($_dataitem[3] !== "" && $_dataitem[3] >= 0 && $_dataitem[3] <= 100) {
                    $sqldata["outdoor_hum"] = $_dataitem[3];
                }
                //5.    box_tmp
                if ($_dataitem[4] !== "" && $_dataitem[4] > -20 && $_dataitem[4] < 70) {
                    $sqldata["box_tmp"] = $_dataitem[4];
                }
                //6.    box_tmp_1
                if ($_dataitem[5] !== "" && $_dataitem[5] > -20 && $_dataitem[5] < 70) {
                    $sqldata["box_tmp_1"] = $_dataitem[5];
                }
                //7.    box_tmp_2
                if ($_dataitem[6] !== "" && $_dataitem[6] > -20 && $_dataitem[6] < 70) {
                    $sqldata["box_tmp_2"] = $_dataitem[6];
                }
                //8.    colds_0_on
                if ($_dataitem[7] !== "" && ($_dataitem[7] == 1 or $_dataitem[7] == 0)) {
                    $sqldata["colds_0_on"] = $_dataitem[7];
                }
                //9.    colds_1_on
                if ($_dataitem[8] !== "" && ($_dataitem[8] == 1 or $_dataitem[8] == 0)) {
                    $sqldata["colds_1_on"] = $_dataitem[8];
                }

                //10.   fan_0_on
                if ($_dataitem[9] !== "" && ($_dataitem[9] == 1 or $_dataitem[9] == 0)) {
                    $sqldata["fan_0_on"] = $_dataitem[9];
                }
                //11.   fan_1_on
                //if ($_dataitem[10] !== "" && ($_dataitem[10] == 1 or $_dataitem[10] == 0)) {
                    //$sqldata["fan_1_on"] = $_dataitem[10];
                //}

                //12.   colds_0_tmp
                if ($_dataitem[11] !== "" && $_dataitem[11] > -20 && $_dataitem[11] < 70) {
                    $sqldata["colds_0_tmp"] = $_dataitem[11];
                }
                //13.   colds_1_tmp
                if ($_dataitem[12] !== "" && $_dataitem[12] > -20 && $_dataitem[12] < 70) {
                    $sqldata["colds_1_tmp"] = $_dataitem[12];
                }
                $sqldata['esg_id'] = $esg_id;
                $sqldata['create_time'] = h_dt_now();

                parent::new_sql($sqldata);
                return;
            }
        }
        return null;
    }


    
    //插入来自开发板的JSON数据
    public function insertJsonData_v2($esg_id, $json_str) {
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
                $sqldata['esg_id'] = $esg_id;
                $sqldata['create_time'] = h_dt_now();

                parent::new_sql($sqldata);
                return;
            }
        }
        return null;
    }
    
    public function findDayDatas($esg_id, $datetime) {
        $day = h_dt_start_time_of_day($datetime);
        $start_time  = $day;
        $stop_time = h_dt_stop_time_of_day($day);
        
        //$this->db->where("( create_time > ".$start_time." and create_time <= ".$stop_time.")");
        return $this->findBy(array("esg_id"=>$esg_id, "create_time > "=>$start_time ,"create_time <= "=>$stop_time));
    }

    public function findList($esg_id,$start_str,$stop_str){
        $this->db->where("create_time < ".h_dt_date_str_db($stop_str).
            " and create_time > ".h_dt_date_str_db($start_str));
        return $this->findBy_sql(array("esg_id"=>$esg_id));
    }
    
    public function findList_hc($datas,$param){
        $res = array();
        foreach ($datas as $key => $data) {
            array_push($res,'['.(h_dt_JS_unix($data['create_time'])).','
                .($data[$param]?$data[$param]:"null").']');
        }
        return '['.implode(',',$res).']';
    }

	//public function generateUnconnectedCountTime($datas,$esg){
		//$total_nums = 0;
		//$total_time = 0;   // s
		//$unconnected = array();
		//$info = array();
		//$first = null;
		//foreach ($datas as $key => $data) {
			//$next = strtotime($data->getCreateTime()->format('r'));
			//if(!$first){ $first = strtotime($data->getCreateTime()->format('r')); continue; }
			//$last_time = $next-$first;
			//if($last_time >= 660){ // 11 mins
				//$total_nums++;
				//$total_time += $last_time;
				//array_push($info,array('unconnected_time'=>date("Y-m-d H:i:s",$first),'last_time'=>$last_time));
			//}
			//$first = $next;
		//}
		//if(count($datas)){
			//if(ESC_ESG_AGING_ING === $esg->getAgingStatus()){
				//$last_time = strtotime("now")-$first;
				//if($last_time >= 660){ // 11 mins
					//$total_nums++;
					//$total_time += $last_time;
					//array_push($info,array('unconnected_time'=>date("Y-m-d H:i:s",$first),'last_time'=>$last_time));
				//}
			//}			
		//}
		//$unconnected = array('total_nums'=>$total_nums,'total_time'=>$total_time,'info'=>$info);
		//return $unconnected;
	//}


	
}
