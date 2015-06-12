<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sav_std_average extends ES_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table_name = "sav_std_averages";
    }
    public function paramFormat($_params) {
        $_params['datetime']       = isset($_params['datetime'])       ? $_params['datetime']       : 0;
        $_params['project_id']     = isset($_params['project_id'])     ? $_params['project_id']     : 0;
        $_params['city_id']        = isset($_params['city_id'])        ? $_params['city_id']        : 0;
        $_params['building_type']  = isset($_params['building_type'])  ? $_params['building_type']  : 0;
        $_params['total_load']     = isset($_params['total_load'])     ? $_params['total_load']     : 0;
        $_params['average_main_energy'] = isset($_params['average_main_energy']) ? $_params['average_main_energy'] : null;
        return $_params;
    }


    public function setAverageMainEnergy($project_id, $city_id,$load_level, $building, $datetime,$average_main_energy){
        $params = array('project_id'=>$project_id,
            'city_id'=>$city_id,
            'total_load'=>$load_level,
            'building_type'=>$building,
            'datetime'=>$datetime);
        if($params['datetime'] && $params['project_id'] && $params['city_id'] 
            && $params['building_type'] && $params['total_load'] ){
                
                if($ssa = $this->findOneBy($params)){
                    $this->update($ssa['id'],array('average_main_energy'=>$average_main_energy));
                }else{
                    $this->insert($params+array('average_main_energy'=>$average_main_energy));
                } 
        }
    }

    public function getTotalLoadHash($project_id,$city_id,$building,$datetime){
        $params = array('project_id'=>$project_id,
            'city_id'=>$city_id,
            'building_type'=>$building,
            'datetime'=>$datetime);
        $sav_std_averages = $this->findBy_sql($params);
        $result = array();
        foreach($sav_std_averages as $sav_std_average){
            $result[$sav_std_average['total_load']] = $sav_std_average;
        }
        return $result;
    }

    public function getHash($project_id,$datetime){
        $params = array('project_id'=>$project_id,
            'datetime'=>$datetime);
        $sav_std_averages = $this->findBy_sql($params);
        $result = array();
        foreach($sav_std_averages as $sav_std_average){
            $result[$sav_std_average['city_id']][$sav_std_average['building_type']][$sav_std_average['total_load']] = $sav_std_average;
        }
        return $result;
    }


}

