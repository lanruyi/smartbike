<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alltab_controller extends Backend_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('batch','mid/mid_energy','area','station','project','savpair','monthdata'));
    }

    public function index(){
        redirect('/reporting/alltab/stdsav_day', 'location');
    }

    function stdsav_day(){
        $start_time = $this->input->get('start_time')?$this->input->get('start_time'):h_dt_format("-3 days","Y-m-d H:i:s");
        $stop_time  = $this->input->get('stop_time')?$this->input->get('stop_time'):h_dt_format("-1 days","Y-m-d H:i:s");
        $project_id = $this->input->get('project_id')?$this->input->get('project_id'):"4";
        $building   = $this->input->get('building')?$this->input->get('building'):ESC_BUILDING_ZHUAN;
        $city_id    = $this->input->get('city_id');
        $this->dt['start_time'] = $start_time;
        $this->dt['stop_time'] = $stop_time;
        $this->dt['project']  = $this->project->find($project_id);
        $this->dt['projects'] = $this->project->getSelectProjects(ESC_PROJECT_TYPE_STANDARD_SAVING_COMMON);
        $this->dt['cities'] = $this->area->findProjectCities($project_id);
        $project_cities_hash = $this->area->findProjectCitiesHash();
        $this->dt['project_cities_hash'] = $project_cities_hash;

        //获取该类别（项目 城市 建筑类型）所有基站这些天的能耗信息
        $this->station->whereAllStations();
        $stations = $this->station->findBy(array("project_id"=>$project_id,"city_id"=>$city_id,"building"=>$building));
        $station_ids = h_array_to_id_array($stations);
        $main_hash = $this->daydata->getStationsNDaysAverageMain($station_ids,$start_time,$stop_time);
        
        //获取基准标杆站的基本信息
        $savpairs = $this->savpair->findBy(array(
            "project_id"=>$project_id,
            "city_id"=>$city_id,
            "building_type"=>$building,
            "datetime"=>h_dt_start_time_of_month($start_time)
        ));    
        $savpair_hash =array();

        foreach(h_station_total_load_array() as $total_load => $name){
            $average_rate[$total_load]['total_rate'] = 0; 
            $average_rate[$total_load]['num'] = 0; 
        }
        foreach($savpairs as $savpair){
            $savpair[ESC_STATION_TYPE_SAVING] = $this->station->find($savpair['sav_station_id']);
            $savpair[ESC_STATION_TYPE_SAVING]['energy'] = h_array_safe($main_hash,$savpair['sav_station_id']);
            $savpair[ESC_STATION_TYPE_STANDARD] = $this->station->find($savpair['std_station_id']);
            $savpair[ESC_STATION_TYPE_STANDARD]['energy'] = h_array_safe($main_hash,$savpair['std_station_id']);
            $savpair["save_rate"] = h_e_jiangsu_save_rate(
                $savpair[ESC_STATION_TYPE_STANDARD]['energy']["main_energy"], 
                $savpair[ESC_STATION_TYPE_SAVING]['energy']["main_energy"], 
                $savpair[ESC_STATION_TYPE_STANDARD]["load_num"],
                $savpair[ESC_STATION_TYPE_SAVING]["load_num"]);
            $savpair_hash[$savpair['total_load']][]=$savpair;
            if($savpair["save_rate"] > 0){
                $average_rate[$savpair[ESC_STATION_TYPE_STANDARD]['total_load']]['total_rate'] += $savpair["save_rate"]; 
                $average_rate[$savpair[ESC_STATION_TYPE_STANDARD]['total_load']]['num'] ++; 
            }
        }

        foreach(h_station_total_load_array() as $total_load => $name){
            if($average_rate[$total_load]['num'] > 0){
                $_r = $average_rate[$total_load]['total_rate'] / $average_rate[$total_load]['num']; 
                $average_rate[$total_load]['rate'] = $_r; 
            }else{
                $average_rate[$total_load]['rate'] = 0; 
            } 
        }
        ksort($savpair_hash);
        $this->dt['savpair_hash'] = $savpair_hash;
        $this->dt['average_rate'] = $average_rate;
        $this->dt['stations'] = h_array_order_by($stations,"total_load");
        $this->dt['city'] = $this->area->find($city_id);
        $this->dt['main_hash'] = $main_hash;
        $this->dt['days'] = h_dt_diff_day($start_time,$stop_time);



        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('reporting/submenu'); 
        $this->load->view('reporting/alltab/menu'); 
        $this->load->view('reporting/alltab/stdsav_day'); 
        $this->load->view('templates/backend_footer');   
    }



    function stdcom_day(){
        $start_time = $this->input->get('start_time')?$this->input->get('start_time'):h_dt_format("-3 days","Y-m-d H:i:s");
        $stop_time  = $this->input->get('stop_time')?$this->input->get('stop_time'):h_dt_format("-1 days","Y-m-d H:i:s");
        $project_id = $this->input->get('project_id')?$this->input->get('project_id'):"104";
        $building   = $this->input->get('building')?$this->input->get('building'):ESC_BUILDING_ZHUAN;
        $city_id    = $this->input->get('city_id');
        $this->dt['building'] = $building;
        $this->dt['start_time'] = $start_time;
        $this->dt['stop_time'] = $stop_time;
        $this->dt['project']  = $this->project->find($project_id);
        $this->dt['projects'] = $this->project->getSelectProjects(ESC_PROJECT_TYPE_STANDARD_SAVING);
        $this->dt['projects'] = array_merge($this->dt['projects'],$this->project->getSelectProjects(ESC_PROJECT_TYPE_STANDARD_SAVING_SH));
        $this->dt['cities'] = $this->area->findProjectCities($project_id);
        $project_cities_hash = $this->area->findProjectCitiesHash();
        $this->dt['project_cities_hash'] = $project_cities_hash;

        //获取该类别（项目 城市 建筑类型）所有基站这些天的能耗信息
        $this->station->whereAllStations();
        $stations = $this->station->findBy(array("project_id"=>$project_id,"city_id"=>$city_id,"building"=>$building));
        $station_ids = h_array_to_id_array($stations);
        $main_hash = $this->daydata->getStationsNDaysAverageMain($station_ids,$start_time,$stop_time);
        foreach(h_station_total_load_array() as $total_load => $name){
            $average_main[$total_load]['total_main'] = 0; 
            $average_main[$total_load]['num'] = 0; 
        }
        $sav_stds = $this->sav_std->getTotalLoadHash($project_id,$city_id,$building,
            h_dt_start_time_of_month($start_time));
        foreach($sav_stds as $load_level=>$stas){
            foreach($stas as $key=>$sav_std){
                $sav_stds[$load_level][$key]['station'] = $this->station->find($sav_std['std_station_id']);
                $sav_stds[$load_level][$key]['energy'] = h_array_safe($main_hash,$sav_std['std_station_id']);
                if($sav_stds[$load_level][$key]['energy']['main_energy']>0.1){
                    $average_main[$load_level]['total_main'] += $sav_stds[$load_level][$key]['energy']['main_energy']; 
                    $average_main[$load_level]['num'] ++; 
                }
            }
        }
        ksort($sav_stds);
        $this->dt['sav_stds'] = $sav_stds; 
        foreach(h_station_total_load_array() as $total_load => $name){
            if($average_main[$total_load]['num'] > 0){
                $_r = $average_main[$total_load]['total_main'] / $average_main[$total_load]['num']; 
                $average_main[$total_load]['main'] = $_r; 
            }else{
                $average_main[$total_load]['main'] = 0; 
            } 
        }
        $this->dt['average_main'] = $average_main; 
        $this->dt['stations'] = h_array_order_by($stations,"total_load");
        $this->dt['city'] = $this->area->find($city_id);
        $this->dt['main_hash'] = $main_hash;
        $this->dt['days'] = h_dt_diff_day($start_time,$stop_time);
        //汇总
        foreach(h_station_total_load_array() as $total_load => $name){
            $total_sta_hash[$total_load]['total_main'] = 0;
            $total_sta_hash[$total_load]['num'] = 0;
            $total_sta_hash[$total_load]['average_main'] = 0;
            $total_sta_hash[$total_load]['total_load_num'] = 0;
            $total_sta_hash[$total_load]['average_load_num'] = 0;
        }
        foreach($stations as $station){
            if($station['station_type'] != ESC_STATION_TYPE_COMMON){
                continue;
            }
            if(!$station['batch_id']){
                continue;
            }
            $main = h_array_safe($main_hash,$station['id']);
            $main = h_array_safe($main,"main_energy");
            if($main > 5){
                $total_sta_hash[$station['total_load']]['total_main'] += $main;
                $total_sta_hash[$station['total_load']]['num'] ++ ;
                $total_sta_hash[$station['total_load']]['total_load_num'] += $station['load_num'];
                $total_main = $total_sta_hash[$station['total_load']]['total_main']; 
                $total_load_num = $total_sta_hash[$station['total_load']]['total_load_num']; 
                $num        = $total_sta_hash[$station['total_load']]['num']; 
                $total_sta_hash[$station['total_load']]['average_main'] = $total_main / $num;
                $total_sta_hash[$station['total_load']]['average_load_num'] = $total_load_num / $num;
            }
        }
        $this->dt['total_sta_hash'] = $total_sta_hash;



        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('reporting/submenu'); 
        $this->load->view('reporting/alltab/menu'); 
        $this->load->view('reporting/alltab/stdcom_day'); 
        $this->load->view('templates/footer');   
    }


}
