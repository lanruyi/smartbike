<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sav_std extends ES_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table_name = "sav_stds";
    }
    public function paramFormat($_params) {
        $_params['datetime']       = isset($_params['datetime'])       ? $_params['datetime']       : 0;
        $_params['project_id']     = isset($_params['project_id'])     ? $_params['project_id']     : 0;
        $_params['city_id']        = isset($_params['city_id'])        ? $_params['city_id']        : 0;
        $_params['building_type']  = isset($_params['building_type'])  ? $_params['building_type']  : 0;
        $_params['total_load']     = isset($_params['total_load'])     ? $_params['total_load']     : 0;
        $_params['std_station_id'] = isset($_params['std_station_id']) ? $_params['std_station_id'] : 0;
        return $_params;
    }

    //返回哈希结构如下： 某项目某天结果[城市ID][建筑类型][负载档位](基准站数组(1个或多个))
    function getHash($project_id,$datetime){
        $sav_stds = $this->findBy_sql(array(
            "project_id"=>$project_id,
            "datetime"=>$datetime
        ));
        $result = array();
        foreach($sav_stds as $sav_std){
            $result[$sav_std['city_id']][$sav_std['building_type']][$sav_std['total_load']][]=$sav_std;
        }
        return $result;
    }

    function getSavStds($project_id,$city_id,$building,$datetime,$total_load){
        $sav_stds = $this->findBy(array(
            "project_id"=>$project_id,
            "city_id"=>$city_id,
            "building_type"=>$building,
            "datetime"=>$datetime,
            "total_load"=>$total_load
        ));
        return $sav_stds;
    }
    //返回哈希结构如下： 某项目某月结果[负载档位](基准站数组(1个或多个))
    function getTotalLoadHash($project_id,$city_id,$building,$datetime){
        $sav_stds = $this->findBy(array(
            "project_id"=>$project_id,
            "city_id"=>$city_id,
            "building_type"=>$building,
            "datetime"=>$datetime
        ));
        $result = array();
        foreach($sav_stds as $sav_std){
            $result[$sav_std['total_load']][]=$sav_std;
        }
        return $result;
    }


    public function isInit($time,$project_id){
        $n = $this->sav_std->count(array(
                "datetime"=>h_dt_start_time_of_month($time),
                "project_id"=>$project_id));
        return $n;
    }

    public function init($time,$project_id){
        $time= h_dt_start_time_of_month($time);
        if(!$this->sav_std->isInit($time,$project_id)){
            $sav_stds = $this->sav_std->findBy(array(
                "datetime"=>h_dt_sub_month($time),
                "project_id"=>$project_id));
            $sav_std_array = array();
            foreach($sav_stds as $sav_std){
                unset($sav_std['id']);
                $sav_std['datetime'] = $time;
                $sav_std_array[] = $sav_std;  
            }
            $this->sav_std->insert_array($sav_std_array);
        }
    }



}

