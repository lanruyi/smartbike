<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Daydata_controller extends CI_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('date'));
        $this->load->database();
        $this->load->model(array('daydata','station'));
    }


    function __destruct() {
    }



    public function go_daydata(){
        //统计昨天的数据
        $this->analysisDaydata();
        //初始化今天的数据
        $this->init_one_day();
    }


    public function analysisDaydata($time_str="-1 day"){
        $t = new DateTime($time_str);

        //$_temp = h_dt_datetime_is_same_day($t->format("Ymd"),h_dt_start_time_of_day("now"));
        //if($_temp>=0){
        if(h_dt_is_today_or_future($time_str)){
            echo "no need for analysis!";
            return;
        }

        $start_time = $t->format("Ymd000000");
        $stop_time  = $t->format("Ymd235959");
        
        $query = $this->db->query("select station_id,count(*) as packets from datas where create_time>? and create_time<? group by station_id",array($start_time,$stop_time));
        $res = $query->result_array();
        foreach($res as $station){
            $this->db->query("update daydatas set packets = ? where station_id = ? and day = ?",
                array($station['packets'],$station['station_id'],$start_time)); 
        }

        $mt = new DateTime($start_time);
        $mt->sub(new DateInterval("PT15M"));
        $t1 = $mt->format("YmdHis");
        $mt->add(new DateInterval("PT30M"));
        $t2 = $mt->format("YmdHis");
        $mt = new DateTime($stop_time);
        $mt->sub(new DateInterval("PT15M"));
        $t3 = $mt->format("YmdHis");
        $mt->add(new DateInterval("PT30M"));
        $t4 = $mt->format("YmdHis");

        $start_energy_hash = array(); 
        $query = $this->db->query("select station_id,energy_main,energy_dc from datas where create_time>? and create_time<? group by station_id",array($t1,$t2));
        $res = $query->result_array();
        foreach ($res as $station){
            $start_energy_hash[$station['station_id']]=$station;
        }
        //var_dump($start_energy_hash);

        $query = $this->db->query("select station_id,energy_main,energy_dc from datas where create_time>? and create_time<? group by station_id",array($t3,$t4));
        $res = $query->result_array();

        foreach($res as $key => $station){
            if(array_key_exists($station['station_id'], $start_energy_hash)){
                $main_energy = null;
                $dc_energy   = null;
                $ac_energy   = null;
                if($station['energy_main'] && $start_energy_hash[$station['station_id']]['energy_main']){
                    $main_energy = $station['energy_main'] - $start_energy_hash[$station['station_id']]['energy_main'];
                    if($main_energy < 0) $main_energy = null;
                    if($main_energy > 300) $main_energy = null;
                }
                if($station['energy_dc'] && $start_energy_hash[$station['station_id']]['energy_dc']){
                    $dc_energy = $station['energy_dc'] - $start_energy_hash[$station['station_id']]['energy_dc'];
                    if($dc_energy < 0) $dc_energy = null;
                    if($dc_energy > 300) $dc_energy = null;
                }
                if($main_energy && $dc_energy){
                    $ac_energy = round($main_energy - $dc_energy,2); 
                    if($ac_energy < 0) $ac_energy = null;
                    if($ac_energy > 300) $ac_energy = null;
                }
                $this->db->query("update daydatas set main_energy = ?,dc_energy = ?,ac_energy = ?,calc_type=? where station_id = ? and day = ?",
                    array($main_energy,$dc_energy,$ac_energy,ESC_DAYDATA_CALC_TYPE_NORMAL,$station['station_id'],$start_time)); 
            }
        }
    }

    public function init_one_day($time_str = ""){
        $t = new DateTime($time_str);
        $query = $this->db->query("select id,create_time,station_type,ns,ns_start from stations where recycle = ? ",array(ESC_NORMAL)); 
        $res = $query->result_array();
        foreach($res as $station){
           if($station['station_type'] == ESC_STATION_TYPE_NPLUSONE  
               && h_dt_np1_day_sql($t->format("Ymd"),$station['ns'],$station['ns_start']) == 0){
               $day_type = 2;
           }else{
               $day_type = 1;
           }
           $_temp = h_dt_datetime_is_same_day($t->format("Ymd"),h_dt_start_time_of_day($station['create_time']));
           if($_temp < 0){
               continue;
           }elseif($_temp == 0){
               $is_first = 2;
           }else{
               $is_first = 1;
           }
           $query = $this->db->query("select * from daydatas where station_id=? and day=?",array($station['id'],$t->format("Ymd")));
           if(!$query->result_array()){
               $this->db->query("insert into daydatas (station_id,day,day_type,is_first_day) values ("
                   .$station['id'].",".$t->format("YmdHis").",".$day_type.",".$is_first.")");
           }
        }
    }

    public function init_data(){
        $t = new DateTime("20120501000000");
        $last = new DateTime("-1 day");
        while($t<$last){
            echo "analysis Day ".$t->format("Y-m-d")."\n";
            $this->analysisDaydata($t->format("Ymd000000"));
            $t->add(new DateInterval("P1D"));
        }
    }

    public function init(){
        $query = $this->db->query("select id,create_time,station_type,ns,ns_start from stations where recycle = ? ",array(ESC_NORMAL)); 
        $res = $query->result_array();
        $now = new DateTime();
        foreach($res as $station){
            $time_start = h_dt_start_time_of_day($station['create_time']);
            $t = new DateTime($time_start);
            $values = array(); 
            $is_first = "2";
            while($t<$now){
                if($station['station_type'] == ESC_STATION_TYPE_NPLUSONE  
                    && h_dt_np1_day_sql($t->format("YmdHis"),$station['ns'],$station['ns_start']) == 0){
                    $day_type = 2;
                }else{
                    $day_type = 1;
                }
                $str = "(".$station['id'].",".$t->format("YmdHis").",".$day_type.",".$is_first.")";
                array_push($values,$str );
                $t->add(new DateInterval('P1D'));
                $is_first = "1";
            }
            if($values){
                $this->db->query("insert into daydatas (station_id,day,day_type,is_first_day) values ".implode(",",$values));
            }
        }
    }




}












