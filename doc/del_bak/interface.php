
class Interface_controller extends CI_Controller{


    function __construct(){
        parent::__construct();
        $this->load->model(array('data','station'));
    }
//基站列表
    public function station_list(){
        echo $this->station->findNormalStations_json();
    }

    public function day_datas($station_id,$timestr){
        $t1 = h_dt_date_str_db(h_dt_start_time_of_day($timestr));
        $t2 = h_dt_date_str_db(h_dt_stop_time_of_day($timestr));
        echo $this->data->findByTime_JSON($station_id,$t1,$t2);
    }
    
    public function get_saving_percentage(){

        $station_id = $this->input->get('station_id');
        $d_station_id = $this->input->get('standard_station_id');
        $type = $this->input->get('type'); 
        $time = $this->input->get('time');

        $datetime = new DateTime($time);

        if("month" == $type || "last_30_days" == $type){
            $datetime->setTime(0,0,0);
            if("last_30_days" == $type){
                $datetime->sub(new DateInterval('P30D'));
            }
            $time_interval = new DateInterval('P30D');
        }
        if("day" == $type || "last_24_hours" == $type){
            $datetime->setTime($datetime->format('H'),0,0);
            if("last_24_hours" == $type){
                $datetime->sub(new DateInterval('P1D'));
            }
            $time_interval = new DateInterval('P1D');
        }

        $_prev_data_main = $this->energy->get_first_data(ESC_ENERGY_MAIN,$station_id,$datetime->format('YmdHis'));
        $_prev_data_dc = $this->energy->get_first_data(ESC_ENERGY_DC,$station_id,$datetime->format('YmdHis'));
        $_prev_d_data_main = $this->energy->get_first_data(ESC_ENERGY_MAIN,$d_station_id,$datetime->format('YmdHis'));
        $_prev_d_data_dc = $this->energy->get_first_data(ESC_ENERGY_DC,$d_station_id,$datetime->format('YmdHis'));
        $datetime->add($time_interval);
        $_next_data_main = $this->energy->get_first_data(ESC_ENERGY_MAIN,$station_id,$datetime->format('YmdHis'));
        $_next_data_dc = $this->energy->get_first_data(ESC_ENERGY_DC,$station_id,$datetime->format('YmdHis'));
        $_next_d_data_main = $this->energy->get_first_data(ESC_ENERGY_MAIN,$d_station_id,$datetime->format('YmdHis'));
        $_next_d_data_dc = $this->energy->get_first_data(ESC_ENERGY_DC,$d_station_id,$datetime->format('YmdHis'));

        if($_next_data_main && $_next_data_dc && $_prev_data_dc && $_prev_data_main &&
            $_next_d_data_main && $_next_d_data_dc && $_prev_d_data_dc && $_prev_d_data_main){
                $_ac = ($_next_data_main['num'] - $_prev_data_main['num'])
                    -($_next_data_dc['num'] - $_prev_data_dc['num']);
                $_d_ac = ($_next_d_data_main['num'] - $_prev_d_data_main['num'])
                    -($_next_d_data_dc['num'] - $_prev_d_data_dc['num']);
                $d1 = floor($_ac*100/$_d_ac);
                echo "[".$d1.",".(100-$d1)."]";
                //todo:一段时间节能图
            }else{
                echo "[0,0]";
            }
    }



    public function getdatalistv2(){
        if(!$this->input->get('station_id')){  echo 'no station id'; return; }
        $station = $this->station->find($this->input->get('station_id'));
        if($this->input->get('ex_station_id')){
            $ex_station = $this->station->find($this->input->get('ex_station_id'));
        }else{
            $ex_station = null;
        }

        $type = $this->input->get('type') ? $this->input->get('type'):"day";
        $time_str = $this->input->get('time') ? $this->input->get('time'):h_dt_now_str();
        $param = $this->input->get('param');
        $params = $this->input->get('params');
        
        
        if($param){
            echo $this->getdatalistv2_str($station,$ex_station,$param,$type,$time_str);
            return;
        }else if($params){
            $ps = explode(",", $params);
            $strarray = array();
            foreach ($ps as $param){
                array_push($strarray,'"'.$param.'":'.$this->getdatalistv2_str($station,$ex_station,$param,$type,$time_str));
            }
            echo '{'.implode(",",$strarray).'}';
            return;
        }
        echo "no param";
    }

    public function getdatalistv2_str($station,$ex_station,$param,$type,$time_str){

        if( 'day' === $type ){
            $_start_str = h_dt_start_time_of_day($time_str);
            $_stop_str = h_dt_stop_time_of_day($time_str);
        }else if( 'month' === $type ){
            $_start_str = h_dt_start_time_of_month($time_str);
            $_stop_str = h_dt_last_day_of_month($time_str);
        }

        //ac dc 占比
        if($param === "ac_dc_energy_percentage"){
            if("day" === $type){
                $_s = $this->statistics->findStatistics($station,$time_str,ESC_STATISTICS_TYPE__DAY);
            }else if("month" === $type){
                $_s = $this->statistics->findStatistics($station,$time_str,ESC_STATISTICS_TYPE__MONTH);
            }else return "[]";
            if(!$_s) return "[]";
            if($_s->getMainEnergy() == 0){
                $_pie = array(0,0);
            }else{
                $_pie = array(
                    round($_s->getAcEnergy()*100/$_s->getMainEnergy(),2),
                    round($_s->getDcEnergy()*100/$_s->getMainEnergy(),2));
            }
            return "[".implode(",",$_pie)."]";
        }

        //站点AC能耗
        if($param === "energy_ac_column" || $param === "energy_dc_column" || $param === "energy_main_column" || $param === "packets_num"){

            if("day" === $type){
                $ptime = new DateTime(h_dt_start_time_of_day($time_str));
                $loops = 24;
                $time_interval = new DateInterval('PT1H');
            }else if("month" === $type){
                $ptime = new DateTime(h_dt_start_time_of_month($time_str));
                $loops = date('t',h_dt_date_str_timestamp($time_str));
                $time_interval = new DateInterval('P1D');
            }else return "[]";
            $res = array();
            for ($i = 0;$i<$loops;$i++){
                if("day" === $type){
                    $_s = $this->statistics->findStatistics($station,$ptime->format('r'),ESC_STATISTICS_TYPE__HOUR);
                }else if("month" === $type){
                    $_s = $this->statistics->findStatistics($station,$ptime->format('r'),ESC_STATISTICS_TYPE__DAY);
                }
                $_time = $ptime->getTimestamp()*1000;
                if(!$_s){
                    $_num = "null";
                }else{
                    if( "energy_ac_column" === $param ){
                        $_num = (($_s)&&($_s->getAcEnergy()))?$_s->getAcEnergy():"null";
                    }else if( "energy_dc_column" === $param ){
                        $_num = (($_s)&&($_s->getDcEnergy()))?$_s->getDcEnergy():"null";
                    }else if( "energy_main_column" === $param ){
                        $_num = (($_s)&&($_s->getMainEnergy()))?$_s->getMainEnergy():"null";
                    }else if( "packets_num" === $param ){
                    	$_num = (($_s)&&($_s->getPackets()))?$_s->getPackets():0;
					}
                    if($_num < 0) $_num = 0; //这是一个补丁 
                }
                array_push($res,'['.$_time.','.$_num.']');
                $ptime->add($time_interval);
            }
            return "[".implode(",",$res)."]";
        }

        if($param === "switch_percentage"){

            if("day" === $type){
                $_s = $this->statistics->findStatistics($station,$time_str,ESC_STATISTICS_TYPE__DAY);
            }else if("month" === $type){
                $_s = $this->statistics->findStatistics($station,$time_str,ESC_STATISTICS_TYPE__MONTH);
            }else return "[]";
            if(!$_s) return "[]";
            $fan_on_time = $_s->getFanTime();
            $colds_0_on_time = $_s->getColds0Time();
            $colds_1_on_time = $_s->getColds1Time();
            $all_off_time = $_s->getAllOffTime();

            $_all = $fan_on_time + $colds_0_on_time + $colds_1_on_time + $all_off_time;
            if($_all === 0){
                $_switch_on_pie = array(0,0,0,0);
            }else{
                $_switch_on_pie = array(
                    round($all_off_time*100/$_all,1),
                    round($fan_on_time*100/$_all,1),
                    round($colds_0_on_time*100/$_all,1),
                    round($colds_1_on_time*100/$_all,1));
            }
            return "[".implode(",",$_switch_on_pie)."]";
        }


        if($param === "saving_pie"){
            if("day" === $type){
                $_s = $this->statistics->findStatistics($station,$time_str,ESC_STATISTICS_TYPE__DAY);
                $_xs = $this->statistics->findStatistics($ex_station,$time_str,ESC_STATISTICS_TYPE__DAY);
            }else if("month" === $type){
                $_s = $this->statistics->findStatistics($station,$time_str,ESC_STATISTICS_TYPE__MONTH);
                $_xs = $this->statistics->findStatistics($ex_station,$time_str,ESC_STATISTICS_TYPE__MONTH);
            }
            if((!$_s)||(!$_xs)) return "[]";
            if($_xs->getAcEnergy() == 0){
                $_pie = array(0,0);
            }else{
                $_a = round($_s->getAcEnergy()*100/$_xs->getAcEnergy(),2); 
                $_pie = array($_a,100-$_a);
            }
            return "[".implode(",",$_pie)."]";
        }


        if($param=="colds_0_on" || $param=="colds_1_on" || $param=="colds_2_on" || $param=="fan_0_on" || $param=="fan_1_on"){
            if($param == "colds_0_on") $data_type = 1;
            if($param == "colds_1_on") $data_type = 2;
            if($param == "colds_2_on") $data_type = 3;
            if($param == "fan_0_on") $data_type = 4;
            if($param == "fan_1_on") $data_type = 5;

            if( 'day' === $type ){
                $switchons = $this->switchon->findDayStationdatalist($data_type,$station,$time_str);
            }else if( 'month' === $type ){
                $switchons = $this->switchon->findMonthStationdatalist($data_type,$station,$time_str);
            }
            if(count($switchons)>0){
                $strarray = array();
                array_push($strarray,'['.h_dt_str_to_js_unix_time($_start_str).',null]');
                foreach ($switchons as $switchon){
                    array_push($strarray,'['.h_dt_str_to_js_unix_time($switchon->getCreateTime()->format('r')).','.h_trigger_switch($switchon->getNum()).']');
                    array_push($strarray,'['.h_dt_str_to_js_unix_time($switchon->getCreateTime()->format('r')).','.$switchon->getNum().']');
                }
                array_push($strarray,'['.h_dt_str_to_js_unix_time($_stop_str).',null]');
                return '['.implode(",",$strarray).']';
            }else{
                return '[]';
            }


        }


        if( $param == "indoor_hum" || $param == "outdoor_hum" ){
            if($param == "indoor_hum") $data_type = 1;
            if($param == "outdoor_hum") $data_type = 2;

            $datas = $this->humidity->findDayStationdatalist($data_type,$station,$time_str);
            $strarray = array();
            array_push($strarray,'['.h_dt_str_to_js_unix_time($_start_str).',null]');
            foreach ($datas as $key => $item){
                array_push($strarray,'['.h_dt_str_to_js_unix_time($item->getCreateTime()->format('r')).','.$item->getNum().']');
            }
            array_push($strarray,'['.h_dt_str_to_js_unix_time($_stop_str).',null]');
            return '['.implode(",",$strarray).']';
        }

        if( $param=="box_tmp" || $param=="indoor_tmp" || $param=="outdoor_tmp" || 
            $param == "colds_0_tmp" || $param == "colds_0_tmp" || $param == "colds_1_tmp"){

                if($param == "indoor_tmp") $data_type = 1;
                if($param == "outdoor_tmp") $data_type = 2;
                if($param == "box_tmp") $data_type = 3;
                if($param == "colds_0_tmp") $data_type = 4;
                if($param == "colds_1_tmp") $data_type = 5;
                if($param == "colds_2_tmp") $data_type = 6;


                $datas = $this->temperature->findDayStationdatalist($data_type,$station,$time_str);
                $strarray = array();
                array_push($strarray,'['.h_dt_str_to_js_unix_time($_start_str).',null]');
                foreach ($datas as  $item){
                    array_push($strarray,'['.h_dt_str_to_js_unix_time($item->getCreateTime()->format('r')).','.$item->getNum().']');
                }
                array_push($strarray,'['.h_dt_str_to_js_unix_time($_stop_str).',null]');
                return '['.implode(",",$strarray).']';


            }


        if( $param=="energy_main" || $param=="energy_dc"){

            if($param === "energy_main") $data_type = ESC_ENERGY_MAIN;
            if($param === "energy_dc") $data_type = ESC_ENERGY_DC;
            if($param === "energy_colds_0") $data_type = ESC_ENERGY_COLDS_0;
            if($param === "energy_colds_1") $data_type = ESC_ENERGY_COLDS_1;
            if($param === "energy_colds_2") $data_type = ESC_ENERGY_COLDS_2;
            if($param === "energy_fan") $data_type = ESC_ENERGY_FAN;

            $datas = $this->energy->get_by_id_type_time($data_type,$station_id,$_start_time,$_stop_time);
            $strarray = array();
            array_push($strarray,'['.$this->strtojstime($_start_time).',null]');
            foreach ($datas as $key => $item){
                if($key%8 !== 0 && $dur === "1_day") continue;
                if($key%24 !== 0 && $dur === "3_days") continue;
                if($key%48 !== 0 && $dur === "7_days") continue;
                array_push($strarray,'['.$this->strtojstime($item["create_time"]).','.$item['num'].']');
            }
            array_push($strarray,'['.$this->strtojstime($_stop_time).',null]');
            return '['.implode(",",$strarray).']';
        }

        if( $param=="power_main" || $param=="power_dc" ){

            if($param === "power_main") $data_type = ESC_POWER_MAIN;
            if($param === "power_dc") $data_type = ESC_POWER_DC; 
            if($param === "power_colds_0") $data_type = ESC_POWER_COLDS_0;
            if($param === "power_colds_1") $data_type = ESC_POWER_COLDS_1;
            if($param === "power_colds_2") $data_type = ESC_POWER_COLDS_2;
            if($param === "power_fan") $data_type = ESC_POWER_FAN;

                $datas = $this->power->findDayStationdatalist($data_type,$station,$time_str);
                $strarray = array();
                array_push($strarray,'['.h_dt_str_to_js_unix_time($_start_str).',null]');
                foreach ($datas as  $item){
                    array_push($strarray,'['.h_dt_str_to_js_unix_time($item->getCreateTime()->format('r')).','.$item->getNum().']');
                }
                array_push($strarray,'['.h_dt_str_to_js_unix_time($_stop_str).',null]');
                return '['.implode(",",$strarray).']';


        }




        if($param === "high_temperature" || $param === "low_temperature"){
            $weathers = $this->weather->findMonthTemplist($station,$time_str);            
            $strarray = array();
            array_push($strarray,'['.h_dt_str_to_js_unix_time($_start_str).',null]');
            foreach ($weathers as  $weather){
                if($param === "high_temperature"){
                    array_push($strarray,'['.h_dt_str_to_js_unix_time($weather->getDay()->format('r')).','.$weather->getHighTmp().']');
                }else if($param === "low_temperature"){
                    array_push($strarray,'['.h_dt_str_to_js_unix_time($weather->getDay()->format('r')).','.$weather->getLowTmp().']');
                }
            }
            array_push($strarray,'['.h_dt_str_to_js_unix_time($_stop_str).',null]');
            return '['.implode(",",$strarray).']';
        }



        if($param === "fan_switchon_num" || $param === "colds_0_switchon_num" || $param === "colds_1_switchon_num" ||
            $param === "fan_switchon_time" || $param === "colds_0_switchon_time" || $param === "colds_1_switchon_time"){
            $statisticses = $this->statistics->findMonthStatisticslist_hc($station,$time_str,FALSE);
            $strarray = array();
            array_push($strarray,'['.h_dt_str_to_js_unix_time($_start_str).',null]');
            foreach ($statisticses as  $s){
                if(!$s['statistics']){
                    array_push($strarray,'['.h_dt_str_to_js_unix_time($s['time']).',null]');
                }else if($param === "fan_switchon_num"){
                    array_push($strarray,'['.h_dt_str_to_js_unix_time($s['time']).','.$s['statistics']->getFanSwitchNum().']');
                }else if($param === "colds_0_switchon_num"){
                    array_push($strarray,'['.h_dt_str_to_js_unix_time($s['time']).','.$s['statistics']->getColds0SwitchNum().']');
                }else if($param === "colds_1_switchon_num"){
                    array_push($strarray,'['.h_dt_str_to_js_unix_time($s['time']).','.$s['statistics']->getColds1SwitchNum().']');
                }else if($param === "fan_switchon_time"){
                    array_push($strarray,'['.h_dt_str_to_js_unix_time($s['time']).','.$s['statistics']->getFanTime().']');
                }else if($param === "colds_0_switchon_time"){
                    array_push($strarray,'['.h_dt_str_to_js_unix_time($s['time']).','.$s['statistics']->getColds0Time().']');
                }else if($param === "colds_1_switchon_time"){
                    array_push($strarray,'['.h_dt_str_to_js_unix_time($s['time']).','.$s['statistics']->getColds1Time().']');
                }
            }
            array_push($strarray,'['.h_dt_str_to_js_unix_time($_stop_str).',null]');
            return '['.implode(",",$strarray).']';
        }

    }
    
}



