<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class T_fandaydata extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "t_fandaydatas";
        $this->load->helper(array());
    }

    public function paramFormat($_params) {
        $_params['station_id']      = isset($_params['station_id'])      ? $_params['station_id']       : null;
        $_params['record_time']     = isset($_params['record_time'])     ? $_params['record_time']      : h_dt_now();
        $_params['fan_total']       = isset($_params['fan_total'])       ? $_params['fan_total']        : 0;
        $_params['data_total']      = isset($_params['data_total'])      ? $_params['data_total']       : 0;
        return $_params;
    }


    public function getStationsFanTimeHash($station_ids,$month){
        if(!$station_ids){
            return array();
        }
        $days = h_dt_past_days_of_month($month);
        $this->db->where("station_id in (".join(",",$station_ids).")");
        $this->db->where("record_time >=".h_dt_start_time_of_month($month)." and record_time <=".h_dt_stop_time_of_month($month));
        $query = $this->db->get_where("t_fandaydatas",array());
        $hash = array();
        foreach($query->result_array() as $t_fandaydatas){
            $hash[$t_fandaydatas['station_id']][] = $t_fandaydatas; 
        }
        $result = array();
        foreach($hash as $station_id=>$dayfantimes){
            if(!count($dayfantimes)){
                $result[$station_id] = array("time"=> null);
            }else{
                $count = 0;
                $total_time = 0;
                foreach($dayfantimes as $dayfantime){
                    if($dayfantime['data_total']>720){
                        $total_time+=$dayfantime['fan_total'];
                        $count ++;
                    }
                }
                if($count>$days/2){
                    $average = round($total_time/$count,2); 
                    $result[$station_id] = array("time"=> $average * date("t",strtotime($month)));
                }else{
                    $result[$station_id] = array("time"=> null);
                }
            }
        }
        return $result;
    }

}













