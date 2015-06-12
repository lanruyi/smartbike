<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Savpair_controller extends Backend_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('mid/mid_energy','area','project','station','savpair'));
        $this->load->helper(array('date','project','station','report'));        
    }
    
    
    public function index(){
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

        $this->dt['savpairs_info'] = $this->savpair->getSavpairsInfo($project_id,$month);

        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('reporting/submenu'); 
        $this->load->view('reporting/savpair/main_savpairs'); 
        $this->load->view('templates/backend_footer');   
    }  

    public function savpair_detail(){
        $this->dt['title'] = "报表系统 节能对 编辑";
        $project_id = $this->input->get('project_id');
        $city_id    = $this->input->get('city_id');
        $building   = $this->input->get('building');
        $datetime   = $this->input->get('datetime');
        $backurl    = urlencode($this->input->get('backurl'));
        $this->dt['datetime']  = $datetime; 
        $this->dt['building']  = $building;
        $this->dt['backurl']   = $backurl;
        
        $this->dt['project']  = $this->project->find_sql($this->input->get('project_id'));
        $this->dt['city']     = $this->area->find_sql($this->input->get('city_id'));
        $this->dt['stations'] = $this->mid_energy->getStanardSavingStationsHash($project_id,$city_id,$building,$datetime);
        $savpairs    = $this->savpair->getSavpairsHash($project_id,$city_id,$building,$datetime);
        foreach ($savpairs as $load_level=>$savpairs_load_level){
            foreach ($savpairs_load_level as $key=>$savpair){
                $savpairs[$load_level][$key]['std_station']   = $this->station->find_sql($savpair['std_station_id']);
                $savpairs[$load_level][$key]['sav_station'] = $this->station->find_sql($savpair['sav_station_id']);
            }
        }
        $this->dt['savpairs']    = $savpairs;

        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('reporting/submenu'); 
        $this->load->view('reporting/savpair/savpair_detail'); 
        $this->load->view('templates/backend_footer');   
    }  


    public function add_savpairs(){
        $project_id = $this->input->get('project_id');
        $city_id    = $this->input->get('city_id');
        $building   = $this->input->get('building');
        $datetime   = $this->input->get('datetime');
        $backurl    = urlencode($this->input->get('backurl'));

        $reasons = $this->input->post('reason'); 
        $bookmark = $this->input->post('bookmark');

        foreach($this->input->post('true_energies') as  $monthdata_id => $true_energy){
            if($true_energy == "")$true_energy = null;
            $this->monthdata->update_sql($monthdata_id,array(
                'true_energy'=>$true_energy,
                'reason'=>$reasons[$monthdata_id]));
        }

        foreach($this->input->post('add_stations') as $load_level => $stations){
            if($stations[ESC_STATION_TYPE_STANDARD] && $stations[ESC_STATION_TYPE_SAVING]){
                $save_rate = $this->mid_energy->calcSinglePairSaveRate(
                    $stations[ESC_STATION_TYPE_STANDARD],
                    $stations[ESC_STATION_TYPE_SAVING],
                    $datetime);
                $this->savpair->insert(array(
                    'project_id'=>$project_id,
                    'city_id'=>$city_id,
                    'total_load'=>$load_level,
                    'building_type'=>$building,
                    'datetime'=>$datetime,
                    'save_rate'=>$save_rate,
                    'std_station_id'=>$stations[ESC_STATION_TYPE_STANDARD],
                    'sav_station_id'=>$stations[ESC_STATION_TYPE_SAVING]));
            }
        }
        redirect(h_url_report_set_savpair($project_id,$city_id,$building,$datetime,$backurl,$bookmark),'local');
    }  

    public function recalc_savpairs(){
        $project_id = $this->input->get('project_id');
        $city_id    = $this->input->get('city_id');
        $building   = $this->input->get('building');
        $datetime   = $this->input->get('datetime');
        $backurl    = urlencode($this->input->get('backurl'));
        $this->mid_energy->calcSomePairSaveRate($datetime,$project_id,$city_id,$building);
        redirect(h_url_report_set_savpair($project_id,$city_id,$building,$datetime,$backurl),'local');
    }  

    //public function update_true_energy(){
        //$project_id = $this->input->get('project_id');
        //$city_id    = $this->input->get('city_id');
        //$building   = $this->input->get('building');
        //$datetime   = $this->input->get('datetime');
        //$backurl    = urlencode($this->input->get('backurl'));

        //foreach($this->input->post('true_energies') as  $monthdata_id => $true_energy){
            //$this->monthdata->update_sql($monthdata_id,array('true_energy'=>$energy));
        //}
        //redirect(h_url_report_set_savpair($project_id,$city_id,$building,$datetime,$backurl),'local');
    //}

    public function del_savpair($savpair_id){
        $project_id = $this->input->get('project_id');
        $city_id    = $this->input->get('city_id');
        $building   = $this->input->get('building');
        $datetime   = $this->input->get('datetime');
        $backurl    = urlencode($this->input->get('backurl'));
        $this->savpair->del_sql($savpair_id);
        redirect(h_url_report_set_savpair($project_id,$city_id,$building,$datetime,$backurl),'local');
    }  


    //public function auto_config_all(){
        //$project_id = $this->input->get('project_id');
        //$city_id    = $this->input->get('city_id');
        //$building   = $this->input->get('building');
        //$datetime   = $this->input->get('datetime');

        //$stations = $this->station->getStanardSavingStationsHash($project_id,$city_id,$building,$datetime);
        //$this->savpair->delSavpairs($project_id,$city_id,$building,$datetime);
        //foreach ($stations as $load_level => $type_stations){
            //$std_station_num = count($type_stations[ESC_STATION_TYPE_STANDARD]);
            //$sav_station_num = count($type_stations[ESC_STATION_TYPE_SAVING]);
            //$pair_num = $std_station_num<$sav_station_num?$std_station_num:$sav_station_num;
            //if($pair_num){
                //for($i=0;$i<$pair_num; $i++){
                    //$std_id = $type_stations[ESC_STATION_TYPE_STANDARD][$i]['id'];
                    //$sav_id = $type_stations[ESC_STATION_TYPE_SAVING][$i]['id'];
                    //$this->savpair->insert(array(
                        //'project_id'=>$project_id,
                        //'city_id'=>$city_id,
                        //'total_load'=>$load_level,
                        //'building_type'=>$building,
                        //'datetime'=>$datetime,
                        //'std_station_id'=>$std_id,
                        //'sav_station_id'=>$sav_id));
                //}
            //}
        //}
        //redirect($this->input->get('backurl'),'local');
    //}


  
}
