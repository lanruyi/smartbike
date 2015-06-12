<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Energy_controller extends Backend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('mid/mid_energy','mid/mid_station','data','data_ext','station','daydata','monthdata'));
    }

    public function test_index(){
        $this->dt['station'] = $this->mid_station->onestation_detail(17);
        $daydatas  = array(
            array("day"=>"20130801","load_num"=>20,
                    "true_load_num"=>18,"main_energy"=>60,"calc_type"=>3),
            array("day"=>"20130802","load_num"=>20,
                    "true_load_num"=>null,"main_energy"=>null,"calc_type"=>1),
            array("day"=>"20130803","load_num"=>20,
                    "true_load_num"=>18,"main_energy"=>60,"calc_type"=>21),
            array("day"=>"20130804","load_num"=>20,
                    "true_load_num"=>18,"main_energy"=>60,"calc_type"=>3),
            array("day"=>"20130805","load_num"=>20,
                    "true_load_num"=>18,"main_energy"=>60,"calc_type"=>4)
        ); 

        $this->dt['daydatas']  =  $daydatas;
        $this->dt['monthdata']  = array("datetime"=>"20130801000000","main_energy"=>800,"calc_type"=>3);
        $datetime = $this->input->get('datetime')?$this->input->get('datetime'):"now";
        $this->dt['datetime'] = $datetime; 
        $datetime = $this->input->get('datetime')?$this->input->get('datetime'):"now";
        $this->dt['normal_sum'] = h_hash_sum($daydatas,array("calc_type"=>3),"main_energy")
            +h_hash_sum($daydatas,array("calc_type"=>4),"main_energy");
        $this->dt['normal_count'] = h_hash_count($daydatas,array("calc_type"=>3))
            +h_hash_count($daydatas,array("calc_type"=>4));

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/energy/index');
        $this->load->view('templates/backend_footer');
    }

    public function index() {
         if ($this->input->get('station_id')) {
            $this->dt['station'] = $this->mid_station->onestation_detail($this->input->get('station_id'));
            $station_id = $this->input->get('station_id');
            $this->dt['title'] =  $this->dt['station']['name_chn']." 能耗列表 ";
        } else {
            show_error("请指定基站ID"); 
        }

        $station = $this->station->find($station_id);
        $project = $this->project->find($station['project_id']);
        $datetime = $this->input->get('datetime')?$this->input->get('datetime'):"now";
        $datetime = h_dt_is_time_future_month($datetime)?"now":$datetime;
        $daydatas   = $this->daydata->findMonthdaydatas($station_id,$datetime);

        if($project['type'] == ESC_PROJECT_TYPE_STANDARD_SAVING && $station['station_type'] == ESC_STATION_TYPE_COMMON){
            foreach($daydatas as $key => $daydata){
                $daydatas[$key]['std_average'] = $this->mid_energy->getDayAverageMainEnergy(
                    $station['project_id'],
                    $station['city_id'],
                    $station['total_load'],
                    $station['building'],$daydata['day']);
            }
        }
        $monthdatas = $this->monthdata->findOneBy_sql(
            array("station_id"=>$station_id,"datetime"=>h_dt_start_time_of_month($datetime)));
        $this->dt['daydatas']  = $daydatas; 
        $this->dt['project']  = $project; 
        $this->dt['monthdata'] = $monthdatas; 
        $this->dt['datetime'] = $datetime; 
        $this->dt['normal_sum_total'] = h_hash_sum($daydatas,array("calc_type"=>3),"main_energy")
            +h_hash_sum($daydatas,array("calc_type"=>4),"main_energy");
        $this->dt['normal_sum_dc'] = h_hash_sum($daydatas,array("calc_type"=>3),"dc_energy")
            +h_hash_sum($daydatas,array("calc_type"=>4),"dc_energy");
        $this->dt['normal_count'] = h_hash_count($daydatas,array("calc_type"=>3))
            +h_hash_count($daydatas,array("calc_type"=>4));


        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/energy/index');
        $this->load->view('templates/backend_footer');
    }


}

