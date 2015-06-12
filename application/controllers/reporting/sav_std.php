<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sav_std_controller extends Backend_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('mid/mid_energy','area','project','station','savpair','sav_std','sav_std_average'));
    }
    
    
    public function index(){
        $this->dt['backurl'] = urlencode($_SERVER["REQUEST_URI"]);
        $this->dt['projects'] = $this->project->getSelectProjects(ESC_PROJECT_TYPE_STANDARD_SAVING);
        $this->dt['projects'] = array_merge($this->dt['projects'],$this->project->getSelectProjects(ESC_PROJECT_TYPE_STANDARD_SAVING_SH));
        $project_id = $this->input->get('project_id')?$this->input->get('project_id')
            :$this->dt['projects'][0]['id'];
        $this->dt['project']  = $this->project->find($project_id);
        $this->dt['cities'] = $this->area->findProjectCities($project_id);
        
        if ($project_id == 112) {   //针对上海项目特殊处理
             $month_array = h_dt_month_array("20141001000000","now");
        } else {
            $month_array = h_dt_month_array("20121201000000","now");
        }
        arsort($month_array);
        $this->dt['month_array'] = $month_array;
        foreach($month_array as $month){
            $this->dt['sav_std_hash'][$month] = $this->sav_std->getHash($project_id,$month);
            $this->dt['sav_std_average_hash'][$month] = $this->sav_std_average->getHash($project_id,$month);

        }

        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('reporting/submenu'); 
        $this->load->view('reporting/sav_std/main'); 
        $this->load->view('templates/backend_footer');   
    }  


    public function detail(){
        $this->dt['title'] = "报表系统 基准站 编辑";
        $project_id = $this->input->get('project_id');
        $city_id    = $this->input->get('city_id');
        $building   = $this->input->get('building');
        $datetime   = $this->input->get('datetime');
        $backurl    = urlencode($this->input->get('backurl'));
        $this->dt['datetime']  = $datetime; 
        $this->dt['building']  = $building;
        $this->dt['backurl']   = $backurl;
        
        $this->dt['project']  = $this->project->find($this->input->get('project_id'));
        $this->dt['city']     = $this->area->find($this->input->get('city_id'));
        $this->dt['stations'] = $this->mid_energy->getSavStdStationsHash($project_id,$city_id,$building,$datetime);


        $sav_stds = $this->sav_std->getTotalLoadHash($project_id,$city_id,$building,$datetime);
        foreach ($sav_stds as $load_level=>$sav_stds_load_level){
            foreach ($sav_stds_load_level as $key=>$sav_std){
                $sav_stds[$load_level][$key]['std'] = $this->station->find($sav_std['std_station_id']);
            }
        }
        $this->dt['sav_stds'] = $sav_stds;
        $this->dt['sav_std_averages'] = $this->sav_std_average->getTotalLoadHash($project_id,$city_id,$building,$datetime);


        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('reporting/submenu'); 
        $this->load->view('reporting/sav_std/detail'); 
        $this->load->view('templates/backend_footer');   
    }  


    public function add_sav_stds(){
        $project_id = $this->input->get('project_id');
        $city_id    = $this->input->get('city_id');
        $building   = $this->input->get('building');
        $datetime   = $this->input->get('datetime');

        $reasons = $this->input->post('reason'); 
        $bookmark = $this->input->post('bookmark');

        foreach($this->input->post('true_energies') as  $monthdata_id => $true_energy){
            if($true_energy == "")$true_energy = null;
            $this->monthdata->update_sql($monthdata_id,array(
                'true_energy'=>$true_energy,
                'reason'=>$reasons[$monthdata_id]));
        }

        foreach($this->input->post('add_stations') as $load_level => $station){
            if($station){
                $params = array(
                    'project_id'=>$project_id,
                    'city_id'=>$city_id,
                    'total_load'=>$load_level,
                    'building_type'=>$building,
                    'datetime'=>$datetime,
                    'std_station_id'=>$station);
                if(!$this->sav_std->findBy_sql($params)){
                    $this->sav_std->insert($params);
                }
            }
        }
        $this->mid_energy->cale_average_main_energy($project_id, $city_id, $building, $datetime);
        redirect("/reporting/sav_std/detail?project_id=".$project_id."&city_id=".$city_id."&building=".$building."&datetime=".$datetime."#".$bookmark,'local');
    }  


    public function del($sav_std_id){
        $project_id = $this->input->get('project_id');
        $city_id    = $this->input->get('city_id');
        $building   = $this->input->get('building');
        $datetime   = $this->input->get('datetime');
        $bookmark   = $this->input->get('bookmark');
        $this->sav_std->del_sql($sav_std_id);
        $this->mid_energy->cale_average_main_energy($project_id, $city_id, $building, $datetime);
        redirect("/reporting/sav_std/detail?project_id=".$project_id."&city_id=".$city_id."&building=".$building."&datetime=".$datetime."#".$bookmark,'local');
    }


  
}
