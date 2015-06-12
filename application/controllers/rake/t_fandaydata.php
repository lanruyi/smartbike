<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class T_fandaydata_controller extends CI_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('station','data','project','area','t_fandaydata'));
    }
    
    public function one_day($time = '-1 day'){
        $start_time = h_dt_start_time_of_day($time);
        $fandaydatanum = $this->t_fandaydata->count(array('record_time'=> $start_time ));
        if($fandaydatanum){
            echo "本日已经算好[$fandaydatanum]个!\n";
            return; 
        }
        $this->db->select('id');
        $stations = $this->station->findAllBuiltStations($time);
        $sum = count($stations);
        $batch = ceil($sum/2);
        $result = array();
        for($i=0;$i<$batch;$i++){
            $tmp_stations = array_slice($stations,$i*2,2);
            $result += $this->some_station_one_day(h_array_to_id_array($tmp_stations),$start_time);
            echo ">";
        }
        echo "\n";
        echo "\n";
        $this->t_fandaydata->insert_array($result);
    }
    
    public function some_station_one_day($station_array,$time){
        $start = h_dt_start_time_of_day($time);
        $end   = h_dt_stop_time_of_day($time);
        $station_ids_str = implode(",",$station_array);
        $query = $this->db->query("select station_id,count(*) as sum from datas where station_id in (".$station_ids_str.") and create_time >=? and create_time<=? group by station_id",
                array($start,$end));
        $total_daydatas = $query->result_array();
        $query = $this->db->query("select station_id,count(*) as sum from datas where station_id in (".$station_ids_str.") and create_time >=? and create_time<=? and fan_0_on=1  group by station_id",
                array($start,$end));
        $fan_daydatas = $query->result_array();

        $total_hash = h_array_to_hash($total_daydatas,"station_id");
        $fan_hash = h_array_to_hash($fan_daydatas,"station_id");

        $params_array = array();
        foreach($total_hash as $station_id=>$total_daydata){
            $_params = array();
            $_params['station_id'] = $station_id;
            $_params['record_time'] = $start;
            $_params['fan_total'] = (isset($fan_hash[$station_id]))?$fan_hash[$station_id]['sum']:0;
            $_params['data_total'] = $total_daydata['sum'];
            $params_array[$station_id] = $_params;
        }
        return $params_array;
    }
    

}



