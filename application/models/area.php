<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('ESC_AREA_TYPE_CITY',0);
define('ESC_AREA_TYPE_DISTRICT',3);

class Area extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "areas";
    }

    public function whereTypeIsCity(){
        $this->area->where(array("type"=>ESC_AREA_TYPE_CITY));
    }

    //查询所有城市
    public function findAllCities(){
        $this->area->whereTypeIsCity();
        $this->area->order_by("id");
        return $this->area->findBy();
    }

    //根据基站ID返回城市名 
    public function getCityNameChn($city_id){
        if(!$city_id) return "无";
        $city = $this->find($city_id);
        return $city? $city['name_chn']:"无"; 
    }

    //返回一个项目的城市
    public function findProjectCities($project_id){
        $project = $this->project->find($project_id);  
        $cities  = array();
        if($project && $project['city_list']){
            $this->area->where("id in (".$project['city_list'].")");
            $cities = $this->area->findBy();
        }
        return $cities;
    }

    //返回所有项目的所有城市
    public function findProjectCitiesHash(){
        $projects = $this->project->findProductProjects();  
        $hash = array();
        foreach($projects as $project){
            if($project['city_list']){
                $this->area->select("id,name_chn");
                $this->area->where("id in (".$project['city_list'].")");
                $hash[$project['id']] = $this->area->findBy();
            }
        }
        return $hash;
    }


    //返回一个城市的地区
    public function findDistricts($father_id =0){
        $_params['type'] = ESC_AREA_TYPE_DISTRICT;
        if($father_id){
            $_params['father_id'] = $father_id;
        }
        return $this->findBy($_params);  
    }
    
    private function getDistrictsName_sql($father_id = 0){
        $disctricts =  $this->findDistricts($father_id);
        
        $districts_list = array();
        foreach ($disctricts as $disctrict) {
            $districts_list[$disctrict['id']] = $this->area->getCityNameChn($disctrict['id']);
        }
        return $districts_list;
    }
    
    public function getEachCityDistricts_sql(){
        $cities =$this->findAllCities();
        
        $city_districts = array();
        foreach($cities as $city){
            $districts_array = $this->getDistrictsName_sql($city['id']);
            $city_districts[$city['id']] = $districts_array;
        }
        return $city_districts;
    }


}
