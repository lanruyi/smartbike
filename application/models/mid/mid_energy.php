<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mid_energy extends ES_Model {

    public function __construct()
    {
        $this->load->model(array('area','station','daydata','monthdata','savpair','sav_std','sav_std_average','bug'));
        $this->load->helper('energy');
    }


////sav_fun 000 通用 ///////////////////////////////////////////////////////////////////////////


////sav_fun 001 stdsav 江苏节能方式 ///////////////////////////////////////////////////////////////////////////

    public function getLastDaySavingRate($project_id,$city_id,$load_level,$building_type){
        $last_day = h_dt_sub_day(h_dt_start_time_of_day('now'));
        return $this->getDaySavingRate($project_id,$city_id,$load_level,$building_type,$last_day);
    }

    public function getStationMonthSavingRate($station_id,$month){
        $station = $this->station->find_sql($station_id);
        $building_type = $station['building'];
        $project_id    = $station['project_id'];
        $city_id       = $station['city_id'];
        $load_level    = $station['total_load'];
        $this->db->select("datetime,has_".
            h_building_stcache_common($building_type).",".
            h_building_stcache_common($building_type));
        $savtablecache = $this->savtablecache->findOneBy(array(
            "project_id"=>$project_id,
            "city_id"=>$city_id,
            "datetime"=>$month));
        if($savtablecache["has_".h_building_stcache_common($building_type)]){
            $sav = json_decode(
                $savtablecache[h_building_stcache_common($building_type)],true);
            if(isset($sav[$load_level])){
                return array("average_energy"=>$sav[$load_level]['average_energy'],
                    "average_rate"=>$sav[$load_level]['average_rate'],
                    "average_save_energy"=>$sav[$load_level]['average_save_energy']);
            }else{
                return null;
            }
        }else{
            return null;
        }

    }

    public function getMonthSavingRate($project_id,$city_id,$load_level,$building_type,$month){
        $this->db->select("datetime,has_".
            h_building_stcache_saving($building_type).",".
            h_building_stcache_saving($building_type));
        $savtablecache = $this->savtablecache->findOneBy_sql(array(
            "project_id"=>$project_id,
            "city_id"=>$city_id,
            "datetime"=>$month));
        if($savtablecache["has_".h_building_stcache_saving($building_type)]){
            $sav = json_decode(
                $savtablecache[h_building_stcache_saving($building_type)],true);
            if(isset($sav[$load_level])){
                return  $sav[$load_level];
            }else{
                return null;
            }
        }else{
            return null;
        }
    }

    public function getMonthAverageMainEnergy($project_id,$city_id,$load_level,$building_type,$datetime){
        $month = h_dt_start_time_of_month($datetime);
        $sav_std_hash = $this->sav_std->getTotalLoadHash($project_id,$city_id,$building_type,$month);
        if(!$sav_std_hash || !isset($sav_std_hash[$load_level])){ return 0; }
        $all = 0;
        $num = 0;
        foreach($sav_std_hash[$load_level] as $sav_std){
            $e = $this->monthdata->getTrueEnergy($sav_std['std_station_id'],$month);
            if($e > 0){
                $all += $e;
                $num ++;
            }
        }
        if($num){
            return $all/$num;
        }else{
            return 0;
        }
    }

    //某天某项目某城市某建筑某负载档位 平均总能耗
    public function getDayAverageMainEnergy($project_id,$city_id,$load_level,$building_type,$day){
        $month = h_dt_start_time_of_month($day);
        $sav_std_hash = $this->sav_std->getTotalLoadHash($project_id,$city_id,$building_type,$month);
        if(!$sav_std_hash || !isset($sav_std_hash[$load_level])){ return 0; }
        $all = 0;
        $num = 0;
        foreach($sav_std_hash[$load_level] as $sav_std){
            $e = $this->daydata->getDayMainEnergy($sav_std['std_station_id'],$day);
            if($e > 0){
                $all += $e;
                $num ++;
            }
        }
        if($num){
            return $all/$num;
        }else{
            return 0;
        }

    }

    public function getDaySavingRate($project_id,$city_id,$load_level,$building_type,$day){
        $month = h_dt_start_time_of_month($day);
        $savpair_hash = $this->savpair->getSavpairsHash($project_id,$city_id,$building_type,$month);

        if(!$savpair_hash || !isset($savpair_hash[$load_level])){
            return array('rate'=>0);
        }
        $rates = array();
        foreach($savpair_hash[$load_level] as $savpair){
            $std_station = $this->station->find_sql($savpair['std_station_id']);
            $std_e = $this->daydata->getDayMainEnergy($savpair['std_station_id'],$day);
            $sav_station = $this->station->find_sql($savpair['sav_station_id']);
            $sav_e = $this->daydata->getDayMainEnergy($savpair['sav_station_id'],$day);
            $rates[$savpair['sav_station_id']] = 
                h_saving_fun($std_e,$sav_e,$std_station['load_num'],$sav_station['load_num']);
        }
        $final_rate = 0;
        $num = 0;
        foreach($rates as $rate){
            if($rate > 0){
                $final_rate += $rate;
                $num ++;
            }
        }
        $rates['rate'] = $num?round($final_rate/$num,1):0;
        return $rates;
    }


    public function getStationEnergyInfo($station_id){
        $station = $this->station->find_sql($station_id);
        $this_month_time = h_dt_start_time_of_month('now'); 
        $last_month_time = h_dt_sub_month($this_month_time);
        $last_day_time   = h_dt_sub_day(h_dt_start_time_of_day('now'));
        $last_month_data = $this->monthdata->findStationMonthdata($station_id,$last_month_time);
        $this_month_data = $this->monthdata->findStationMonthdata($station_id,$this_month_time);
        $last_day_data =   $this->daydata->findStationDaydata($station_id,$last_day_time);
        $last_month_day_num =  h_dt_days_of_month($last_month_time);
        $this_month_day_num =  date("d",strtotime('now')) - 1;
        $ggh = h_get_ggh($station['load_num']);

        $result['energy_last_month'] = 0;
        $result['energy_last_month_pday'] = 0;
        $result['energy_last_month_ggh'] = 0;
        $result['energy_this_month'] = 0;
        $result['energy_this_month_pday'] = 0;
        $result['energy_this_month_ggh'] = 0;
        $result['energy_last_day'] = 0;
        $result['energy_last_day_ggh'] = 0;

        if($last_month_data && $last_month_data['main_energy']){
            $result['energy_last_month'] = $last_month_data['main_energy'];
            $result['energy_last_month_pday'] = round($last_month_data['main_energy']/$last_month_day_num,2);
            $result['energy_last_month_ggh'] = round($result['energy_last_month_pday'] * $ggh,2);
        }
        if($this_month_data && $this_month_data['main_energy'] && $this_month_day_num){
            $result['energy_this_month'] = $this_month_data['main_energy'];
            $result['energy_this_month_pday'] = round($this_month_data['main_energy']/$this_month_day_num,2);
            $result['energy_this_month_ggh'] = round($result['energy_this_month_pday'] * $ggh,2);
        }
        if($last_day_data && $last_day_data['main_energy']){
            $result['energy_last_day'] = $last_day_data['main_energy'];
            $result['energy_last_day_ggh'] = round($result['energy_last_day'] * $ggh,2);
        }
        return $result;

    }


    function calcAllPairSaveRate($datetime){
        $datetime = h_dt_start_time_of_month($datetime);
        $sav_pairs = $this->savpair->findBy(array('datetime'=>$datetime));
        foreach($sav_pairs as $sav_pair){
            $save_rate = $this->calcSinglePairSaveRate($sav_pair['std_station_id'],$sav_pair['sav_station_id'],$datetime);
            $this->db->query("update savpairs set save_rate=? where 
                std_station_id = ? and sav_station_id = ? and datetime = ?",
                array($save_rate,$sav_pair['std_station_id'],$sav_pair['sav_station_id'],$datetime));
        }
    }

    function calcSomePairSaveRate($datetime,$project_id,$city_id,$building){
        $sav_pairs = $this->savpair->findBy_sql(array(
            'building_type'=>$building,
            'datetime'=>$datetime,
            'project_id'=>$project_id,
            'city_id'=>$city_id
        ));
        foreach($sav_pairs as $sav_pair){
            $save_rate = $this->calcSinglePairSaveRate($sav_pair['std_station_id'],$sav_pair['sav_station_id'],$datetime);
            $this->db->query("update savpairs set save_rate=? where 
                std_station_id = ? and sav_station_id = ? and datetime = ?",
                array($save_rate,$sav_pair['std_station_id'],$sav_pair['sav_station_id'],$datetime));
        }
    }



    //算一对站点*日*节能率（补齐以后的）
    function calcDaySaveRate_JiangSu($std_station_id,$sav_station_id,$datetime){
        $std_station = $this->station->find_sql($std_station_id);
        $sav_station = $this->station->find_sql($sav_station_id);
        $std_daydata = $this->daydata->findOneBy(array(
            "station_id"=>$std_station_id, "day"=>$datetime));
        $sav_daydata = $this->daydata->findOneBy(array(
            "station_id"=>$sav_station_id, "day"=>$datetime));
        $std_day_energy = $std_daydata?$std_daydata['main_energy']:null;
        $sav_day_energy = $sav_daydata?$sav_daydata['main_energy']:null;
        return h_e_jiangsu_save_rate(
            $std_day_energy,$sav_day_energy,$std_station['load_num'],$sav_station['load_num']);
    }

    //算一对站点*月*节能率（补齐以后的）
    function calcSinglePairSaveRate($std_station_id,$sav_station_id,$datetime){
        $std_station = $this->station->find($std_station_id);
        $sav_station = $this->station->find($sav_station_id);
        $std_monthdata = $this->monthdata->findOneBy(array(
            "station_id"=>$std_station_id, "datetime"=>$datetime));
        $sav_monthdata = $this->monthdata->findOneBy(array(
            "station_id"=>$sav_station_id, "datetime"=>$datetime));

        $std_month_energy = $this->monthdata->getTrueEnergy($std_station['id'],$datetime);
        $sav_month_energy = $this->monthdata->getTrueEnergy($sav_station['id'],$datetime);

        return h_e_jiangsu_save_rate(
            $std_month_energy,$sav_month_energy,$std_station['load_num'],$sav_station['load_num']);
    }




    public function getStanardSavingStationsHash($project_id,$city_id,$building,$datetime){
        //陈靖的需求 让去掉基准站的时间限制 
        //$this->db->where("create_time < ".h_dt_format($datetime));
        $this->db->where("(station_type = ".ESC_STATION_TYPE_STANDARD." or station_type = ".ESC_STATION_TYPE_SAVING.")");
        $stations = $this->station->findBy_sql(array(
            "project_id"=>$project_id,
            "recycle"=>ESC_NORMAL,
            "city_id"=>$city_id,
            "building"=>$building
        ));
        $result = array();
        foreach($stations as $station){
            $monthdata = $this->monthdata->findStationMonthdata($station['id'],$datetime);
            if(!$monthdata) $monthdata = $this->monthdata->newMonthdata($station['id'],$datetime);
            $station['monthdata'] = $monthdata;
            $result[$station['total_load']][$station['station_type']][] = $station;
        }
        return $result;
    }


    public function getSavStdStationsHash($project_id,$city_id,$building,$datetime){
        $this->db->where("station_type = ".ESC_STATION_TYPE_STANDARD );
        $stations = $this->station->findBy_sql(array(
            "project_id"=>$project_id,
            "recycle"=>ESC_NORMAL,
            "city_id"=>$city_id,
            "building"=>$building
        ));
        $result = array();
        foreach($stations as $station){
            $monthdata = $this->monthdata->findStationMonthdata($station['id'],$datetime);
            if(!$monthdata) $monthdata = $this->monthdata->newMonthdata($station['id'],$datetime);
            $station['monthdata'] = $monthdata;
            $result[$station['total_load']][] = $station;
        }
        return $result;
    }

    //todo 加个注释
    public function getCommonStationsHash($project_id,$city_id,$building,$datetime){
        $this->db->where("create_time < ".h_dt_format($datetime));
        $this->db->where("station_type = ".ESC_STATION_TYPE_COMMON);
        $stations = $this->station->findBy_sql(array(
            "project_id"=>$project_id,
            "recycle"=>ESC_NORMAL,
            "city_id"=>$city_id,
            "building"=>$building
        ));
        $monthdatahash = $this->monthdata->findStationsMonthdataHash(h_station_ids($stations),$datetime);
        $result = array();
        foreach($stations as $station){
            if(!isset($monthdatahash[$station['id']])){ 
                $station['monthdata'] = $this->monthdata->newMonthdata($station['id'],$datetime);
            }else{
                $station['monthdata'] = $monthdatahash[$station['id']];
            }
            $result[$station['total_load']][] = $station;
        }
        return $result;
    }

    //某项目 某城市 某建筑类型 某天的 所有站点(不包括被拆除的)（按批次分组）
    public function getCommonStationsBatchHash($project_id,$city_id,$building,$datetime){
        $this->db->where("create_time < ".h_dt_format($datetime));
        $this->db->where("station_type = ".ESC_STATION_TYPE_COMMON);
        $this->db->where("status != ".ESC_STATION_STATUS_REMOVE);
        $this->db->select("id,name_chn,batch_id,total_load,load_num,price,extra_ac");
        $stations = $this->station->findBy_sql(array(
            "project_id"=>$project_id,
            "recycle"=>ESC_NORMAL,
            "city_id"=>$city_id,
            "building"=>$building
        ),array("load_num asc"));
        $monthdatahash = $this->monthdata->findStationsMonthdataHash(h_station_ids($stations),$datetime);
        $result = array();
        foreach($stations as $station){
            if(!isset($monthdatahash[$station['id']])){ 
                $station['monthdata'] = $this->monthdata->newMonthdata($station['id'],$datetime);
            }else{
                $station['monthdata'] = $monthdatahash[$station['id']];
            }
            $result[$station['batch_id']][$station['total_load']][] = $station;
        }
        return $result;
    }

    public function cale_all_month_average_main_energy($datetime){
        $projects = $this->project->findBy(array("type"=>ESC_PROJECT_TYPE_STANDARD_SAVING));
        foreach($projects as $project){
            $cities = $this->area->findProjectCities($project['id']); 
            foreach($cities as $city){
                $this->mid_energy->cale_average_main_energy($project['id'], $city['id'], ESC_BUILDING_ZHUAN, $datetime);
                $this->mid_energy->cale_average_main_energy($project['id'], $city['id'], ESC_BUILDING_BAN, $datetime);
            }
        }
    }

    public function cale_average_main_energy($project_id, $city_id, $building, $datetime){
        $sav_std_hash = $this->sav_std->getTotalLoadHash($project_id, $city_id, $building, $datetime);
        foreach($sav_std_hash as $load_level => $sav_stds){
            $all = 0;
            $num = 0;
            foreach($sav_stds as $sav_std){
                $e = $this->monthdata->getTrueEnergy($sav_std['std_station_id'],$datetime);
                if($e){
                    $all += $e;
                    $num ++;
                }
            }
            if($num){
                $average_main_energy = $all/$num;
            }else{
                $average_main_energy = 0;
            }
            $this->sav_std_average->setAverageMainEnergy($project_id, $city_id,$load_level, $building, $datetime,$average_main_energy);
        }
    }

    //// BUG 相关函数 ///////////////////////////////////////////////////////////////////////////////////////////////

    public function analysisMainEnergy(){
        $b42_config_str = $this->sysconfig->getByName("b42_config");
        $b42_configs = json_decode($b42_config_str); 
        $daydatas = $this->daydata->findBy(array("day"=>h_dt_start_time_of_day('-1 day')));
        $dd_hash = array();
        foreach($daydatas as $daydata){
            $dd_hash[$daydata['station_id']] = $daydata;
        }
        $station_bugs = array();
        foreach($b42_configs as $project_id => $project_configs){
            $this->station->where("(station_type <> ".ESC_STATION_TYPE_STANDARD.")");
            $stations = $this->station->findAllStations($project_id);
            $sta_hash = array();
            foreach($stations as $station){
                $sta_hash[$station['total_load']][$station['building']][] = $station;
            }
            foreach($project_configs as $load_level => $level_configs){
                foreach($level_configs as $building => $config){
                    if($config !== ""){
                        $stas = h_array_safe(h_array_safe($sta_hash,$load_level),$building);
                        if($stas){
                            foreach($stas as $sta){
                                $daydata = h_array_safe($dd_hash,$sta['id']);
                                $mid_load = h_load_level_mid($daydata['load_num']);
                                if(h_array_safe($daydata,'main_energy')*$mid_load/$daydata['load_num']
                                    > ($mid_load*53.5/0.85*24/1000+$config)){
                                    $station_bugs[$sta['id']] = "";
                                }
                            }
                        }
                    }
                }                
            }
        }
        $this->bug->openAndCloseBugs($station_bugs,42);
    }


}
