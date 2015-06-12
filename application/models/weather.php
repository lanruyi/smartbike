<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Weather extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "weathers";
        $this->load->helper(array());
    }

    public function get_future_6_days_weather($city_id){
        $_sql = "select * from weathers where city_id=".$city_id." and day>=".  h_dt_now()." order by day";
        $_query = $this->db->query($_sql);
        $items = $_query->result_array();
        return $items;
    }


    //返回某个基站 对应城市 某月的天气预报温度
    public function findMonthTemplist($station_id,$time_str){
        $station = $this->station->find_sql($station_id);
        if (h_dt_is_time_future_month($time_str)){ return array(); }
        $_start_time_str = h_dt_start_time_of_month($time_str);
        if (h_dt_is_time_this_month($time_str)){
            $_now = new DateTime();
            $_end_time_str = $_now->format('r');
        }else{
            $update=TRUE;
            $_end_time_str = h_dt_stop_time_of_month($time_str);
        }
        $_t1 = h_dt_date_str_db($_start_time_str);
        $_t2 = h_dt_date_str_db($_end_time_str);
        $_sql = "select * from weathers where city_id=".$station['city_id']." and day<=".$_t2." and day>=".$_t1." order by day";
        $_query = $this->db->query($_sql);
        $items = $_query->result_array();
        return $items;
    }


}













