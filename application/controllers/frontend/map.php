<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/********************************
[Controller Analysis]
./../models/Entities/Station.php 
./../models/station.php
./../../tests/controllers/StationControllerTest.php

********************************/

class Map_controller extends Frontend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('station','map'));
        $this->load->model(array('project','data','station','warning','area'));
    }


    public function all(){
        $this->dt['title']="全国基站地图";
        $this->dt['correct_stations'] =  $this->station->findBy(array("recycle"=>ESC_NORMAL));
        $this->dt['wrong_stations'] =  array();
        $this->load->view('templates/frontend_header', $this->dt);
        $this->load->view('frontend/map/all');
        $this->load->view('templates/frontend_footer');
    }


    //基站地图显示
    //by qianlei
    //2013.1.20 
    public function index(){
        $this->dt['title']="地区基站地图";

        $this->input->set_cookie('map_url', $_SERVER["REQUEST_URI"], 86000);

        //搜索条件
        $conditions = array();
        $conditions['recycle ='] = ESC_NORMAL;
        $conditions['project_id ='] = $this->current_project['id'];
        $conditions['city_id ='] = $this->current_city['id'];
        $conditions['total_load ='] = $this->input->get('total_load');
        $conditions['building ='] = $this->input->get('building');
        $conditions['alive ='] = $this->input->get('alive');
        $conditions['district_id ='] = $this->input->get('district_id');
        $conditions['frontend_visible=']= ESC_FRONTEND_VISIBLE;
        if($this->input->get('search')){
            $conditions['name_chn like'] = '\'%'.trim($this->input->get('search')).'%\'';
        }
        $orders = array("total_load"=>"desc","building"=>"asc","station_type"=>"asc","id"=>"desc");
        $condition_array = array();
        $order_array = array();
        foreach($conditions as $k=>$v){
            if($v){
                array_push($condition_array,$k.$v);
            }
        }
        foreach($orders as $k=>$v){
            array_push($order_array,$k." ".$v);
        }
        $str = "";
        if(count($condition_array)){
            $str .= "where ".implode(" and ",$condition_array);
        }
        //类型
        if($this->input->get('station_type')){
            if($this->input->get('station_type')==ESC_STATION_TYPE_SAVING_OR_STANDARD){
                $str .= " and (station_type =".ESC_STATION_TYPE_SAVING." or station_type =".ESC_STATION_TYPE_STANDARD.") ";
            }else{
                $str .= " and station_type =".$this->input->get('station_type');
            }
        }
        if(count($order_array)){
            $str .= " order by ".implode(",",$order_array);
        }
        //满足条件的基站信息
        $query =  $this->db->query("select * from stations ".$str);
        $this->dt['stations'] = $query->result_array();
        //该城市的信息，地图需要用到经纬度
        $this->dt['city'] = $this->area->find_sql($this->current_city['id']);
        $this->dt['url'] = "/frontend/map/index";
        //过滤经纬度不正确的数据
        $this->dt['correct_stations'] = 
            h_filterBugs($this->dt['stations'],$this->dt['city']['lng'],$this->dt['city']['lat']);
        //负载
        $this->dt['total_load_types'] = h_station_total_load_array();
        //建筑
        $this->dt['building_types'] = h_station_building_array();
        //基站类型
        $this->dt['station_types'] = $this->get_station_types();
        //地区
        $this->dt['areas'] = $this->area->findDistricts($this->current_city['id']);
        //url拼装
        if($this->input->get('search')){
            $urls['search'] = trim($this->input->get('search'));
        }
        $urls['building'] = $this->input->get('building');
        $urls['station_type'] = $this->input->get('station_type');
        $urls['total_load'] = $this->input->get('total_load');
        $urls['district_id'] = $this->input->get('district_id');
        
        foreach($this->dt['total_load_types'] as $k=>$total_load){
            $urls['total_load'] = $k;
            $this->dt['total_loads'][$k]['url'] = h_url_param_str($urls);
            $this->dt['total_loads'][$k]['id'] = $k;
            $this->dt['total_loads'][$k]['name_chn'] = $total_load;
        }
        $urls['total_load'] = "";
        $this->dt['total_load_empty'] = h_url_param_str($urls);
        $urls['total_load'] = $this->input->get('total_load');

        foreach($this->dt['building_types'] as $k=>$building_type){
            $urls['building'] = $k;
            $this->dt['buildings'][$k]['url'] = h_url_param_str($urls);
            $this->dt['buildings'][$k]['id'] = $k;
            $this->dt['buildings'][$k]['name_chn'] = $building_type;
        }
        $urls['building'] = "";
        $this->dt['building_empty'] = h_url_param_str($urls);
        $urls['building'] = $this->input->get('building');

        foreach($this->dt['station_types'] as &$station_type){
            $urls['station_type'] = $station_type['station_type'];
            $station_type['url'] = h_url_param_str($urls);
        }
        $urls['station_type'] = "";
        $this->dt['station_type_empty'] = h_url_param_str($urls);
        
        foreach($this->dt['areas'] as &$area){
            $urls['district_id'] = $area['id'];
            $area['url'] = h_url_param_str($urls);
        }       
        $urls['district_id'] = "";
        $this->dt['district_id_empty'] = h_url_param_str($urls);
        
        
        //查出问题基站，分基站类型排列
        $this->dt['wrong_stations'] = $this->es_array_diff($this->dt['stations'],$this->dt['correct_stations']);  
        
        $this->load->view('templates/frontend_header', $this->dt);
        $this->load->view('frontend/map/citylist');
        $this->load->view('templates/frontend_footer');
    }

    private function es_array_diff($a,$b){
        $res[ESC_STATION_TYPE_SAVING] = array();
        $res[ESC_STATION_TYPE_STANDARD] = array();
        $res[ESC_STATION_TYPE_COMMON] = array();
        $res[ESC_STATION_TYPE_NPLUSONE] = array();
        foreach($a as $a_item){
            $has_same_item = false;
            foreach ($b as $b_item){
                if($a_item === $b_item){
                    $has_same_item = true;
                }
            }
            if(!$has_same_item){
                array_push($res[$a_item['station_type']],$a_item);
            }
        }
        //去除空数组
        foreach($res as $k=>$arr){
            if(!$arr){
                unset($res[$k]);
            }
        }
        return $res;
    }




    public function get_station_types(){
        //得到节能方式 1是基准标杆 2代表n+1
        $energy_saving_type = $this->current_project['type'];
        $station_types = array();
        if($energy_saving_type==ESC_PROJECT_TYPE_STANDARD_SAVING_COMMON){
            $station_types = array(array('station_type'=>ESC_STATION_TYPE_SAVING,'name_chn'=>'标杆站'),array('station_type'=>ESC_STATION_TYPE_STANDARD,'name_chn'=>'基准站'),array('station_type'=>ESC_STATION_TYPE_COMMON,'name_chn'=>'节能站'),array('station_type'=>ESC_STATION_TYPE_SAVING_OR_STANDARD,'name_chn'=>'标杆或基准站'));
        }elseif($energy_saving_type==ESC_PROJECT_TYPE_NPLUSONE){
            $station_types = array(array('station_type'=>ESC_STATION_TYPE_NPLUSONE,'name_chn'=>'n+1站'));
        }
        return $station_types;
    }

}
