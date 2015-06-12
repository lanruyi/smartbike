<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stdtable_controller extends Backend_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('batch','mid/mid_energy','area','station','project','savpair','monthdata'));
    }

    function save_true_energy(){
        $datetime=$this->input->get('datetime');
        $true_energys =  $this->input->post('true_energy');
        $reasons =  $this->input->post('reason');
        foreach($true_energys as $station_id=>$true_energy){
            if($true_energy){
                $this->monthdata->updateBy(
                    array("true_energy"=>$true_energy,"reason"=>$reasons[$station_id]),
                    array("station_id"=>$station_id));
            }
        }
        redirect($this->input->get('backurl'),'local');
    }

    function index(){
        $project_id = $this->input->get('project_id')?$this->input->get('project_id'):"104";
        $this->dt['backurl'] = urlencode($_SERVER["REQUEST_URI"]);
        $this->dt['project']  = $this->project->find_sql($project_id);
        $this->dt['projects'] = $this->project->getSelectProjects(ESC_PROJECT_TYPE_STANDARD_SAVING);
        $this->dt['cities'] = $this->area->findProjectCities($project_id);

        $month_array = h_dt_month_array("20121201000000","now");
        arsort($month_array);
        $this->dt['month_array'] = $month_array;

        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('reporting/submenu'); 
        $this->load->view('reporting/stdtable/tables'); 
        $this->load->view('templates/backend_footer');   
    }


    //todo 重构此函数 太长！
    public function stage($building){
        $this->dt['title'] = "节能月报表";
        $project_id = $this->input->get('project_id');
        $city_id    = $this->input->get('city_id');
        $datetime   = $this->input->get('datetime');
        $this->dt['building'] = $building;
        $this->dt['datetime'] = $datetime;
        $this->dt['backurl']  = $this->input->get('backurl');
        $this->dt['project']  = $this->project->find($project_id);
        $this->dt['city']     = $this->area->find($city_id);

        $sav_std_average_hash = $this->sav_std_average->getTotalLoadHash($project_id,$city_id,$building,$datetime);
        $this->dt['sav_std_average_hash'] = $sav_std_average_hash;
        $station_hash = $this->mid_energy->getCommonStationsbatchHash($project_id,$city_id,$building,$datetime);

        $sav_stds = $this->sav_std->getTotalLoadHash($project_id,$city_id,$building,$datetime);
        foreach($sav_stds as $load_level=>$stations){
            foreach($stations as $key=>$sav_std){
                $sav_stds[$load_level][$key]['station'] = $this->station->find($sav_std['std_station_id']);
                $sav_stds[$load_level][$key]['monthdata'] = $this->monthdata->findStationMonthdata($sav_std['std_station_id'],$datetime);
            }
        }
        ksort($sav_stds);
        $this->dt['sav_stds'] = $sav_stds; 


        $level_average_savs = array();
        foreach($station_hash as $batch_id => $station_level_hash){
            foreach(h_station_total_load_array() as $total_load => $name){ 
                $stations = isset($station_level_hash[$total_load])?$station_level_hash[$total_load]:array(); 
                foreach($stations as $key => $station){ 

                    $main_energy = $this->monthdata->getMainEnergy($station['id'],$datetime);
                    $dc_energy = $this->monthdata->getDCEnergy($station['id'],$datetime);
                    $err = h_station_month_main_energy_err($main_energy,$station['load_num']);
                    $average_std = isset($sav_std_average_hash[$station['total_load']]['average_main_energy'])?
                        $sav_std_average_hash[$station['total_load']]['average_main_energy']:null;
                    $sav = null;
                    if(!isset($level_average_savs[$total_load])){
                        $level_average_savs[$total_load]['total'] = 0;
                        $level_average_savs[$total_load]['num'] = 0;
                    }
                    if($average_std){
                        if(!$err){
                            $sav = $average_std - $main_energy;
                            if($sav<=0) { $sav=0;}
                            $level_average_savs[$total_load]['total'] += $main_energy;
                            $level_average_savs[$total_load]['num'] += 1;
                        }
                    }
                    $rate = $average_std>0?$sav*100/$average_std:null;
                    $station_hash[$batch_id][$total_load][$key]['err'] = $err; 
                    $station_hash[$batch_id][$total_load][$key]['sav'] = $sav; 
                    $station_hash[$batch_id][$total_load][$key]['rate'] = $rate; 
                    $station_hash[$batch_id][$total_load][$key]['sav_average_dis'] = $main_energy;
                    $station_hash[$batch_id][$total_load][$key]['sav_dc_energy'] = $dc_energy;
                    $station_hash[$batch_id][$total_load][$key]['std_average'] = $average_std; 
                }
            }
        }

        foreach($station_hash as $batch_id => $station_level_hash){
            foreach(h_station_total_load_array() as $total_load => $name){ 
                $stations = isset($station_level_hash[$total_load])?$station_level_hash[$total_load]:array(); 
                foreach($stations as $key => $station){ 
                    if($station['err']){
                        if(isset($level_average_savs[$total_load]['num']) && $level_average_savs[$total_load]['num']>0){
                            $sav_average_main = $level_average_savs[$total_load]['total']/$level_average_savs[$total_load]['num'];
                            $station_hash[$batch_id][$total_load][$key]['sav_average_dis'] = "<font style='color:#f33'>".h_round2($sav_average_main)."</font>"; 
                            $sav = $station['std_average'] - $sav_average_main; 
                            $station_hash[$batch_id][$total_load][$key]['sav'] = $sav;
                            $rate = $station['std_average']>0 ? $sav*100/$station['std_average']:null;
                            $station_hash[$batch_id][$total_load][$key]['rate'] = $rate; 
                        }
                    }
                }
            }
        }
        $this->dt['station_hash'] = $station_hash;
        $this->dt['batch_name_chn_hash'] = h_array_2_select($this->batch->findBy());


        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('reporting/submenu'); 
        $this->load->view('reporting/stdtable/stage'); 
        $this->load->view('templates/backend_footer');   
    }



}










