<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Table_controller extends Backend_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('batch','mid/mid_energy','area','station','project','savpair','monthdata'));
    }

    function index(){
        $project_id = $this->input->get('project_id')?$this->input->get('project_id'):"4";
        $time = $this->input->get("time")?$this->input->get("time"):"now";
        $month = h_dt_start_time_of_month($time);
        $this->dt['project']  = $this->project->find_sql($project_id);
        $this->dt['month'] = $month;

        $this->dt['backurl'] = urlencode($_SERVER["REQUEST_URI"]);
        $this->dt['projects'] = $this->project->getSelectProjects(ESC_PROJECT_TYPE_STANDARD_SAVING_COMMON);
        $this->dt['cities'] = $this->area->findProjectCities($project_id);

        $month_array = h_dt_month_array("20130101000000","now");
        krsort($month_array);
        $this->dt['months'] = $month_array;

        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('reporting/submenu'); 
        $this->load->view('reporting/table/tables'); 
        $this->load->view('templates/backend_footer');   
    }

    public function common_stage_table($building){
        $this->dt['title'] = "节能月报表";
        $project_id = $this->input->get('project_id');
        $city_id    = $this->input->get('city_id');
        $datetime   = $this->input->get('datetime');
        $this->dt['building'] = $building;
        $this->dt['datetime'] = $datetime;
        $this->dt['disp_time'] = h_dt_r_day($datetime);
        $this->dt['backurl'] = $this->input->get('backurl');
        $this->dt['project'] = $this->project->find_sql($project_id);
        $this->dt['city'] = $this->area->find_sql($city_id);

        $this->dt['average_rate'] = $this->savpair->getAverageSavingRate($project_id,$city_id,$building,$datetime);

        $station_hash = $this->mid_energy->getCommonStationsBatchHash($project_id,$city_id,$building,$datetime);
        $this->dt['station_hash'] = $station_hash;
        $this->dt['batch_name_chn_hash'] = h_array_2_select($this->batch->findBy());
        //再在这里算个平均能耗
        $this->dt['average_energy_hash'] = $this->monthdata->getAverageMainEnergy($project_id,$city_id,$building,$datetime);

        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('reporting/submenu'); 
        $this->load->view('reporting/table/common_stage_table'); 
        $this->load->view('templates/backend_footer');   
    }

    public function saving_table($building){
        $this->dt['title'] = "节能月报表";

        $project_id = $this->input->get('project_id');
        $city_id    = $this->input->get('city_id');
        //$building   = $this->input->get('building');
        $datetime   = $this->input->get('datetime');
        $this->dt['disp_time'] = h_dt_r_day($datetime);
        $this->dt['backurl'] = $this->input->get('backurl');
        $this->dt['project'] = $this->project->find_sql($project_id);
        $this->dt['city'] = $this->area->find_sql($city_id);
        
        $this->dt['average_rate'] = $this->savpair->getAverageSavingRate($project_id,$city_id,$building,$datetime);
        $savpairs = $this->savpair->findBy(array(
            "project_id"=>$project_id,
            "city_id"=>$city_id,
            "building_type"=>$building,
            "datetime"=>$datetime
        ));    
        $savpair_hash =array();
        foreach($savpairs as $savpair){
            $savpair[ESC_STATION_TYPE_SAVING] = $this->station->find($savpair['sav_station_id']);
            $savpair[ESC_STATION_TYPE_SAVING]['main_energy'] = $this->monthdata->getTrueEnergy($savpair['sav_station_id'],$datetime);
            $savpair[ESC_STATION_TYPE_SAVING]['dc_energy'] = $this->monthdata->getDCEnergy($savpair['sav_station_id'],$datetime);
            $savpair[ESC_STATION_TYPE_STANDARD] = $this->station->find($savpair['std_station_id']);
            $savpair[ESC_STATION_TYPE_STANDARD]['main_energy'] = $this->monthdata->getTrueEnergy($savpair['std_station_id'],$datetime);
            $savpair[ESC_STATION_TYPE_STANDARD]['dc_energy'] = $this->monthdata->getDCEnergy($savpair['std_station_id'],$datetime);
            $savpair_hash[$savpair['total_load']][]=$savpair;
        }
        ksort($savpair_hash);
        $this->dt['savpair_hash'] = $savpair_hash;


        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('reporting/submenu'); 
        $this->load->view('reporting/table/saving_table'); 
        $this->load->view('templates/backend_footer');   
        //$this->output->enable_profiler();
    }

    public function common_table_all(){
        $this->dt['title'] = "节能月报表";
        $project_id = $this->input->get('project_id');
        $datetime   = $this->input->get('datetime');
        $this->dt['datetime'] = $datetime;
        $this->dt['backurl'] = $this->input->get('backurl');
        $this->dt['project'] = $this->project->find_sql($project_id);
        $cities = $this->area->findProjectCities($project_id);
        $this->dt['cities'] = h_array_to_id_hash($cities);

        foreach($cities as $city){
            foreach(h_station_building_array() as $building=>$name){
                $city_id = $city['id'];
                $this->dt['average_rate'][$city_id][$building] = $this->savpair->getAverageSavingRate($project_id,$city_id,$building,$datetime);
                $station_hash = $this->mid_energy->getCommonStationsStageHash($project_id,$city_id,$building,$datetime);
                $this->dt['station_hash'][$city_id][$building] = $station_hash;
                $this->dt['average_energy_hash'][$city_id][$building] = $this->monthdata->getAverageMainEnergy($project_id,$city_id,$building,$datetime);
            }
        }

        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('reporting/submenu'); 
        $this->load->view('reporting/table/common_table_all'); 
        $this->load->view('templates/backend_footer');   
    }



}
