<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Station_controller extends Ajax_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('mid/mid_station','mid/mid_data','data_ext','daydata','area'));
        $this->load->helper('chart','single','datetime');
    }

    public function single_json($station_id,$datetime="now",$hour="all"){
        if(!$station_id){ return ""; }
        if( $hour == "all"){
            $datas = $this->mid_data->findDayDatas($station_id,$datetime);
        }else{
            $datas = $this->mid_data->findHourDatas($station_id,h_dt_format($datetime,"Ymd".sprintf('%02d',$hour)."0000"));
        }
        echo json_encode($datas);
    }

    public function back_single($station_id,$datetime="now",$hour="all"){
        if(!$station_id){ return ""; }
        if( $hour == "all"){
            $datas = $this->mid_data->findDayDatas($station_id,$datetime);
        }else{
            $datas = $this->mid_data->findHourDatas($station_id,h_dt_format($datetime,"Ymd".sprintf('%02d',$hour)."0000"));
        }
        $this->load->view("ajax/data/back_single",$this->dt);
    }


    //多站点 批量设置modal
    public function mulit(){
        $station_ids = $this->input->post('station_ids');
        $this->dt['station_ids_str'] = implode(",",$station_ids);
        $stations = array();
        foreach ($station_ids as $id) {
            $stations[$id] = $this->station->find($id); 
        }
        $this->dt['creators']   = $this->user->findBy(array('department_id'=>4));
        $this->dt['cities']     = $this->area->findBy(array('type'=>ESC_AREA_TYPE_CITY));
        $this->dt['districts']  = $this->input->get('city_id')?$this->area->findDistricts($this->input->get('city_id')):$this->area->findDistricts();
        $this->dt['projects']   = $this->project->findBy(array());
        $this->dt['roms']       = $this->rom->findBy(array("station_num > "=>0),array("id desc"));
        $this->dt['batches']    = $this->batch->findBy(array(),array("city_id asc"));
        $this->dt['stations']   = $stations;
        $this->load->view("ajax/station/mulit",$this->dt);
    }

    public function mulit_update_process(){
        $mod_strs = $this->input->post("mod_strs");
        if($mod_strs){
            $mods = array();
            foreach($mod_strs as $mod_str){
                if($mod_str == "ns_start"){
                    $mods['ns_start'] = date('Y-m-d 00:00:00',strtotime($_params['ns_start']));
                }else if($mod_str == "load_num"){
                    $mods['total_load'] = h_get_total_load_by_load_num($this->input->post("load_num"));
                    $mods[$mod_str] = $this->input->post($mod_str);
                }else if($mod_str == "colds_1_func"){
                    $mods['colds_num'] = $this->input->post('colds_1_func')==ESC_STATION_COLDS_FUNC_NONE?1:2;;
                    $mods[$mod_str] = $this->input->post($mod_str);
                }else if($mod_str == "box_type"){
                    $mods['have_box'] = $this->input->post('box_type')==ESC_STATION_BOX_TYPE_NONE?
                        ESC_HAVE_BOX_NONE:ESC_HAVE_BOX;
                    $mods[$mod_str] = $this->input->post($mod_str);
                }else{
                    $mods[$mod_str] = $this->input->post($mod_str);
                }
            }
            $station_ids = explode(',',$this->input->post('station_ids_str'));
            foreach($station_ids as $station_id){
                $this->station->update($station_id,$mods);
            }
            echo "[".count($station_ids)."]";
        }
        //$this->output->enable_profiler();
        //$this->load->view("blank");
    }

}



