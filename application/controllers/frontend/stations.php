<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/********************************
[Controller Station]
./../models/station.php
./../../tests/controllers/StationControllerTest.php

********************************/

class Stations_controller extends Frontend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('station'));
        $this->load->model(array('daydata','data','station','warning','area'));
        $this->load->model(array('mid/mid_energy','mid/mid_data'));
    }

    public function index(){
        redirect(h_project_url("station_list",$this->current_project['type']), 'location');
    }


    public function change_city($city_id){
        $this->input->set_cookie('current_city_id',$city_id,86400);
        if($this->input->get('url')){
            redirect($this->input->get('url'),'location');            
        }else{
            redirect(h_project_url("station_list",$this->current_project['type']), 'location');
        }
    }

    public function slist($cur_page = 1){
        $this->dt['title']="多站视图";

        $total_load = $this->make_cookies("total_load",$this->input->get('total_load'));
        $building   = $this->make_cookies("building",$this->input->get('building'));
        $this->dt['total_load']=$total_load;
        $this->dt['building']=$building;

        //$this->input->set_cookie('slist_url', $_SERVER["REQUEST_URI"], 86000);

        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;	
        $conditions = array();
        $conditions['recycle ='] = ESC_NORMAL;
        $conditions['project_id ='] = $this->current_project['id'];
        $conditions['city_id ='] = $this->current_city['id'];
        $conditions['total_load ='] = $total_load;
        $conditions['building ='] = $building;
        $conditions['station_type ='] = $this->input->get('station_type');
        $conditions['alive ='] = $this->input->get('alive');
        $conditions['frontend_visible ='] = ESC_FRONTEND_VISIBLE;
        
        if($this->input->get('search')){
            $conditions['name_chn like'] = '\'%'.trim($this->input->get('search')).'%\'';
        }
        $orders = array("alive"=>"asc","total_load"=>"desc","building"=>"asc");
        $paginator =  $this->station->pagination_sql($conditions,$orders,$per_page,$cur_page);
        $config['base_url'] = '/frontend/stations/slist/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page'] = $per_page; 
        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();
        $this->dt['stations'] = $paginator['res'];
        
        $_time_str = $this->input->get('time')?$this->input->get('time'):"-1 day";
        $saving_daydata_array = array();
        foreach($paginator['res'] as $station){
            $saving_daydata_array[$station['id']] = $this->mid_data->findSavingDaydata_sql($station['id'],h_dt_date_str_db($_time_str));;
        }
        $this->dt['saving_daydata_array'] = $saving_daydata_array;

        $this->load->view('templates/frontend_header', $this->dt);
        $this->load->view('frontend/stations/slist');
        $this->load->view('templates/frontend_footer');
    }



    public function newlist($cur_page = 1){
        $this->dt['title']="多站视图";

        //make_cookies 三个参数的意思： 1.cookies名 2.值 3.如果都是空的话默认值
        $load_level = $this->make_cookies("load_level",$this->input->get('load_level'),ESC_TOTAL_LOAD_20A30A);
        $building   = $this->make_cookies("building",$this->input->get('building'),ESC_BUILDING_ZHUAN);

        $this->dt['load_level'] = $load_level;
        $this->dt['building'] = $building;

        $project_id=$this->current_project['id'];
        $city_id=$this->current_city['id'];
        $this->dt['standard_stations'] = 
            $this->station->getStandardStations($project_id,$city_id,$load_level,$building);
        $this->dt['saving_stations'] = 
            $this->station->getSavingStations($project_id,$city_id,$load_level,$building);
        $this->dt['station_nums'] = 
            $this->station->getCityStationNums($project_id,$city_id);
        $this->dt['last_day_rates'] = 
            $this->mid_energy->getLastDaySavingRate($project_id,$city_id,$load_level,$building);

        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):10;	
        $paginator =  $this->station->getCommonStationsPagination(
            $project_id,$city_id,$load_level,$building,$per_page,$cur_page);
        $config['base_url']   = "/frontend/stations/newlist/";
        $config['suffix']     = "?".$_SERVER['QUERY_STRING'];
        $config['first_url']  = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page']   = $per_page; 
        $this->pagination->initialize($config); 
        $this->dt['common_pagination'] = $this->pagination->create_links();
        $this->dt['common_stations'] = $paginator['res'];

        foreach(array('standard_stations','saving_stations','common_stations') as $station_type){
            foreach($this->dt[$station_type] as $key=>$station){
                $this->dt[$station_type][$key]['last_day_energy'] = 
                    $this->daydata->getDayMainEnergy($station['id'],"-1 day");
            }
        }

        $this->load->view('templates/frontend_header', $this->dt);
		$this->load->view('frontend/stations/newlist');
        $this->load->view('templates/frontend_footer');
    }



    public function stdlist($cur_page = 1){
        $this->dt['title']="多站视图";

        //make_cookies 三个参数的意思： 1.cookies名 2.值 3.如果都是空的话默认值
        $load_level = $this->make_cookies("load_level",$this->input->get('load_level'),ESC_TOTAL_LOAD_20A30A);
        $building   = $this->make_cookies("building",$this->input->get('building'),ESC_BUILDING_ZHUAN);

        $datetime = $this->input->get("datetime")?$this->input->get("datetime"):"-1 day";
        $this->dt['load_level'] = $load_level;
        $this->dt['building'] = $building;
        $this->dt['datetime'] = $datetime;

        $project_id=$this->current_project['id'];
        $city_id=$this->current_city['id'];
        $this->dt['standard_stations'] = 
            $this->station->getStandardStations($project_id,$city_id,$load_level,$building);
        //人工设置的基准站id
        $sav_stds = $this->sav_std->getSavStds($project_id,$city_id,$load_level,$building,$load_level);
        $this->dt['std_station_ids'] = h_array_to_array($sav_stds,"std_station_id"); 
        $this->dt['station_nums'] = 
            $this->station->getCityStationNums($project_id,$city_id);
        $this->dt['day_average_main_energy'] = 
            $this->mid_energy->getDayAverageMainEnergy($project_id,$city_id,$load_level,$building,$datetime);
        $this->dt['month_average_main_energy'] = 
            $this->mid_energy->getMonthAverageMainEnergy($project_id,$city_id,$load_level,$building,$datetime);

        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):10;	
        $paginator =  $this->station->getCommonStationsPagination(
            $project_id,$city_id,$load_level,$building,$per_page,$cur_page);
        $config['base_url']   = "/frontend/stations/stdlist/";
        $config['suffix']     = "?".$_SERVER['QUERY_STRING'];
        $config['first_url']  = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page']   = $per_page; 
        $this->pagination->initialize($config); 
        $this->dt['common_pagination'] = $this->pagination->create_links();
        $this->dt['common_stations'] = $paginator['res'];

        foreach(array('standard_stations','common_stations') as $station_type){
            foreach($this->dt[$station_type] as $key=>$station){
                $this->dt[$station_type][$key]['day_energy'] = 
                    $this->daydata->getDayMainEnergy($station['id'],$datetime);
                $this->dt[$station_type][$key]['month_energy'] = 
                    $this->monthdata->getMainEnergy($station['id'],$datetime);
            }
        }


        $this->load->view('templates/frontend_header', $this->dt);
		$this->load->view('frontend/stations/stdlist');
        $this->load->view('templates/frontend_footer');
    }
    
     public function stdlist_sh($cur_page = 1){
        $this->dt['title']="多站视图";

        //make_cookies 三个参数的意思： 1.cookies名 2.值 3.如果都是空的话默认值
        $load_level = $this->make_cookies("load_level",$this->input->get('load_level'),ESC_TOTAL_LOAD_20A30A);
        $building   = $this->make_cookies("building",$this->input->get('building'),ESC_BUILDING_ZHUAN);

        $datetime = $this->input->get("datetime")?$this->input->get("datetime"):"-1 day";
        $this->dt['load_level'] = $load_level;
        $this->dt['building'] = $building;
        $this->dt['datetime'] = $datetime;

        $project_id=$this->current_project['id'];
        $city_id=$this->current_city['id'];
        $this->dt['standard_stations'] = 
            $this->station->getStandardStations($project_id,$city_id,$load_level,$building);
        //人工设置的基准站id
        $sav_stds = $this->sav_std->getSavStds($project_id,$city_id,$load_level,$building,$load_level);
        $this->dt['std_station_ids'] = h_array_to_array($sav_stds,"std_station_id"); 
        $this->dt['station_nums'] = 
            $this->station->getCityStationNums($project_id,$city_id);
//        $this->dt['day_average_main_energy'] = 
//            $this->mid_energy->getDayAverageMainEnergy($project_id,$city_id,$load_level,$building,$datetime);
//        $this->dt['month_average_main_energy'] = 
//            $this->mid_energy->getMonthAverageMainEnergy($project_id,$city_id,$load_level,$building,$datetime);

        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):200;	
        $paginator =  $this->station->getCommonStationsPagination(
            $project_id,$city_id,$load_level,$building,$per_page,$cur_page);
        $config['base_url']   = "/frontend/stations/stdlist_sh/";
        $config['suffix']     = "?".$_SERVER['QUERY_STRING'];
        $config['first_url']  = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page']   = $per_page; 
        $this->pagination->initialize($config); 
        $this->dt['common_pagination'] = $this->pagination->create_links();
        $this->dt['common_stations'] = $paginator['res'];

        foreach(array('standard_stations','common_stations') as $station_type){
            foreach($this->dt[$station_type] as $key=>$station){
                $this->dt[$station_type][$key]['day_energy'] = 
                    $this->daydata->getDayMainEnergy($station['id'],$datetime);
            }
        }


        $this->load->view('templates/frontend_header', $this->dt);
		$this->load->view('frontend/stations/stdlist_sh');
        $this->load->view('templates/frontend_footer');
    }
   
}
