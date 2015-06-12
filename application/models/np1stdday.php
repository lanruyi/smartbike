<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ../../tests/models/Np1stddayModelTest.php 

class Np1stdday extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "np1stddays";
    }

    public function isInit($time_str){
        $query = $this->db->query("select count(*) n from np1stddays where `datetime`= ?",array(h_dt_start_time_of_day($time_str)));
        $res = $query->row_array();
        return $res['n'];
    }

    public function findByStationAndPeriod($station_id,$start_time,$stop_time){
        $this->db->where("datetime>=".h_dt_format($start_time)." and datetime<=".h_dt_format($stop_time));
        return $this->findBy_sql(array("station_id"=>$station_id),array("datetime asc"));
    }
    
    public function findLastByTime($station_id,$time){
        $this->db->where("datetime <=".$time);
        return $this->findOneBy_sql(array("station_id"=>$station_id),array("datetime desc")); 
    }


    //一定要时间是昨天以前的 否则返回的都是false
    public function isStdday($station_id,$past_time){
        $res = $this->findOneBy_sql(array("station_id"=>$station_id,"datetime"=>h_dt_start_time_of_day($past_time)));
        return $res?true:false;
    }

}

