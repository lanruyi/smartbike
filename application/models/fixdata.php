<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fixdata extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "fixdatas";
    }


    public function findStationFixdata($station_id,$from_time,$to_time){
        $query = $this->db->query("select * from fixdatas 
            where station_id=? and `time`>=? and `time`<=?",
            array($station_id,$from_time,$to_time));
        return $query->result_array();
    }

    public function findFixDatasHash($station_id,$start_str,$stop_str){
        $this->db->where("`time` >=".$start_str." and `time` <= ".$stop_str);
        $fixdatas = $this->fixdata->findBy_sql(array("station_id"=>$station_id),array("time asc"));
        $hash = array();
        foreach($fixdatas as  $fd){
            $hash[h_dt_format($fd['time'])] = $fd;
        }
        return $hash;
    } 


    public function isFixed($time){
        $query = $this->db->query("select count(*) n from fixdatas where `time`= ?",array($time));
        $res = $query->row_array();
        if($res['n']){
            return true;
        }
        return false;
    }

    public function getAllOneDayEnergyHash($time_str){
        $start_time = h_dt_start_time_of_day($time_str);
        $stop_time  = h_dt_start_time_of_day(h_dt_add_day($time_str,1));
        $start_array = $this->fixdata->findBy(array("time"=>$start_time));
        $stop_array = $this->fixdata->findBy(array("time"=>$stop_time));
        $start_hash = h_array_to_hash($start_array,"station_id");
        $energy_hash=array();
        foreach($stop_array as $stop_fixdata){
            $station_id = $stop_fixdata['station_id'];
            if(!isset($start_hash[$station_id])){
                continue;
            }
            $start_fixdata = $start_hash[$station_id];
            if($stop_fixdata['energy_main'] && $start_fixdata['energy_main']){
                $main_energy = $stop_fixdata['energy_main'] - $start_fixdata['energy_main'];
                $main_energy = ($main_energy > 0 && $main_energy < 500)? $main_energy : null;
                $dc_energy   = $stop_fixdata['energy_dc'] - $start_fixdata['energy_dc'];
                $dc_energy   = ($dc_energy > 0 && $dc_energy < 500)? $dc_energy : null;
                if($main_energy && $dc_energy){
                    $ac_energy = $main_energy - $dc_energy; 
                    $ac_energy = ($ac_energy > 0 && $ac_energy < 500)? $ac_energy : null;
                }else{
                    $ac_energy = null;
                }
                $energy_hash[$station_id] = array(
                    "main_energy"=>$main_energy,
                    "dc_energy"=>$dc_energy,
                    "ac_energy"=>$ac_energy);
            }
        }
        return $energy_hash;
    }

}
