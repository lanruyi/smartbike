<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MonthData extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "monthdatas";
        $this->load->helper("monthdata");
    }


    public function paramFormat($_params) {
        $_params['station_id']   = isset($_params['station_id'])    ? $_params['station_id']    : 0;
        $_params['datetime']     = isset($_params['datetime'])      ? $_params['datetime']      : "2013-01-01";
        $_params['main_energy']  = isset($_params['main_energy'])   ? $_params['main_energy']   : null;
        $_params['dc_energy']    = isset($_params['dc_energy'])     ? $_params['dc_energy']     : null;
        $_params['ac_energy']    = isset($_params['ac_energy'])     ? $_params['ac_energy']     : null;
        $_params['true_energy']  = isset($_params['true_energy'])   ? $_params['true_energy']   : null;
        $_params['calc_type']    = isset($_params['calc_type'])     ? $_params['calc_type']     : 0;
        $_params['reason']      = isset($_params['reason'])        ? $_params['reason']        : "";
        return $_params;
    }

    public function findStationMonthdata($station_id,$datetime){
        return $this->findOneBy_sql(array('station_id'=>$station_id,"datetime"=>$datetime));
    }

    public function findStationsMonthdataHash($station_ids,$datetime){
        if(!$station_ids) return array();
        $this->db->where("station_id in (".implode(",",$station_ids).")");
        $monthdatas = $this->findBy_sql(array("datetime"=>$datetime));
        $monthdatahash = array();
        foreach($monthdatas as $monthdata){
            $monthdatahash[$monthdata['station_id']] = $monthdata; 
        }
        return $monthdatahash;
    }

    public function getMainEnergy($station_id,$datetime){
        $month = h_dt_start_time_of_month($datetime);
        $monthdata = $this->findOneBy(array('station_id'=>$station_id,"datetime"=>$month));
        if($monthdata){
            return $monthdata['main_energy'];
        }
        return null;
    }
    
    public function getDCEnergy($station_id,$datetime){
        $month = h_dt_start_time_of_month($datetime);
        $monthdata = $this->findOneBy(array('station_id'=>$station_id,"datetime"=>$month));
        if($monthdata){
            return $monthdata['dc_energy'];
        }
        return null;
    }

    public function getTrueEnergy($station_id,$datetime){
        $station = $this->station->find($station_id);
        $monthdata = $this->findOneBy(array('station_id'=>$station_id,"datetime"=>$datetime));
        $result = null;
        if($monthdata){
            //有extra_ac则减去对应月能耗
            $monthdata['main_energy'] = $monthdata['main_energy'] 
                - h_power_to_month_energy($station['extra_ac'],$datetime);
            $result = $monthdata['true_energy']?$monthdata['true_energy']:$monthdata['main_energy'];
        }
        return $result;
    }

    public function newMonthdata($station_id,$datetime){
        $id = $this->insert(array("station_id"=>$station_id,"datetime"=>$datetime));
        return $this->find_sql($id);
    }

    public function isCalced($time_str){
        $query = $this->db->query("select count(*) n from monthdatas 
                where main_energy is not null and `datetime`= ? and calc_type=?",array(h_dt_start_time_of_month($time_str),3));
        $res = $query->row_array();
        if($res['n']){
            return true;
        }
        return false;
    }

    //该月的monthdata是否已初始化
    public function isInit($time_str){
        $query = $this->db->query("select count(*) n from monthdatas where `datetime`= ?",array(h_dt_start_time_of_month($time_str)));
        $res = $query->row_array();
        return $res['n'];
    }


    //获取某项目某城市某月某种建筑类型每个档位的 平均能耗
    public function getAverageMainEnergy($project_id,$city_id,$building,$datetime){
        $stations = $this->station->findBy(array("recycle" => ESC_NORMAL,
            "status <> "=>ESC_STATION_STATUS_REMOVE,"project_id"=>$project_id,
            "city_id"=>$city_id,"building"=>$building));
        $hash = array();
        foreach(h_station_total_load_array() as $total_load=>$name){
            $hash[$total_load]['all'] = 0;
            $hash[$total_load]['num'] = 0;
        }
        foreach($stations as $station){
            $energy = $this->monthdata->getTrueEnergy($station['id'],$datetime);
            if($energy>0){
                $hash[$station['total_load']]['all'] += $energy;
                $hash[$station['total_load']]['num'] ++ ;
            }
        }
        $result = array();
        foreach(h_station_total_load_array() as $total_load=>$name){
            if($hash[$total_load]['num']>0){
                $result[$total_load] = $hash[$total_load]['all']/$hash[$total_load]['num'];
            }else{
                $result[$total_load] = 0;
            }
        }
        return $result;

        //$hash = array();
        //$query = $this->db->query("SELECT total_load,count(*) num,sum(main_energy) sum 
            //FROM `monthdatas` left join stations on monthdatas.station_id = stations.id 
            //WHERE station_id in 
            //(select id from stations where project_id = ? and city_id=? and building=? and recycle = 1) 
            //and datetime=? and main_energy>0 group by stations.total_load",
            //array($project_id,$city_id,$building,$datetime));
        //foreach($query->result_array() as $load){
            //$hash[$load['total_load']] = $load['num']==0?0:$load['sum']/$load['num']; 
        //}
        //foreach(h_station_total_load_array() as $total_load => $name){
            //if(!isset($hash[$total_load])){
                //$hash[$total_load] = 0;
            //}
        //}
        //return $hash;
    }


}





