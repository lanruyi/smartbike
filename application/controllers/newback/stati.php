<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stati_controller extends Backend_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('mid/mid_station','area','contract','station','project'));
        $this->load->helper(array('chart'));
    }


    public function system(){
        $this->dt['title'] = '系统统计';

        $station_groups = $this->station->count_group(
            array("recycle"=>ESC_NORMAL,"status !="=>ESC_STATION_STATUS_REMOVE),array("project_id"));
        $sta_prj_hash = h_array_to_hash($station_groups,"project_id");
        $online_station_groups = $this->station->count_group(
            array("recycle"=>ESC_NORMAL,"status !="=>ESC_STATION_STATUS_REMOVE,"alive"=>ESC_ONLINE),array("project_id"));
        $online_sta_prj_hash = h_array_to_hash($online_station_groups,"project_id");

        $show_prjs = array();
        $prjs = $this->project->findBy(array("is_product"=>1));
        $system = array("total"=>0,"total_online"=>0);
        foreach($prjs as $prj){
            $num        = isset($sta_prj_hash[$prj['id']])?$sta_prj_hash[$prj['id']]['count_num']:0;
            $online_num = isset($online_sta_prj_hash[$prj['id']])?$online_sta_prj_hash[$prj['id']]['count_num']:0;
            $prj['num'] = $num;
            $prj['online_num'] = $online_num;
            $show_prjs[$num]   = $prj;
            $system['total'] += $num;
            $system['total_online'] += $online_num;
        }
        krsort($show_prjs);

        $this->dt['projects']  = $show_prjs; 
        $this->dt['system']  = $system; 


        $contracted['total'] = $this->station->count(
            array("recycle"=>ESC_NORMAL,"status !="=>ESC_STATION_STATUS_REMOVE,"batch_id >"=>0));
        $contracted['total_online'] = $this->station->count(
            array("recycle"=>ESC_NORMAL,"status !="=>ESC_STATION_STATUS_REMOVE,"batch_id >"=>0,"alive"=>ESC_ONLINE));
        $this->dt['contracted']  = $contracted; 

        $this->load->view('newback/statistic/system',$this->dt);
    }




    public function contract(){
        $this->dt['title'] = '站点统计';


        $contracts = $this->contract->findBy(array(),array("project_id asc"));
        foreach($contracts as $key=>$contract){
            $contracts[$key]['project'] = $this->project->find($contract['project_id']);
            $contracts[$key]['count']  = $this->mid_station->countContractStations($contract['id']);
            $batches = $this->batch->findBy(array("contract_id"=>$contract['id']),array("city_id asc"));
            foreach($batches as $b_key=>$batch){
            }
            $contracts[$key]['batches'] = $batches;
            $count_array[] = $contracts[$key]['count'];
            //$contracts[$key]['cities'] = $this->area->findProjectCities($contract['project_id']);
        }
        $this->dt['contracts'] = $contracts;
        $this->dt['all_count'] = $this->add_all_count($count_array);
        $this->dt['projects']  = $this->project_station_count();


        $this->load->view('newback/statistic/contract',$this->dt);

    }

    public function add_all_count($counts){
        $all_count = array();
        foreach($counts as $count){
            isset($all_count["removed"])?"":$all_count["removed"] = 0;
            $all_count["removed"]+=$count["removed"];
            isset($all_count["normal"])?"":$all_count["normal"] = 0;
            $all_count["normal"]+=$count["normal"];
            foreach(array("batch","building","load_level","station_type","city") as $count_type){
                isset($all_count[$count_type])?"":$all_count[$count_type]=array();
                foreach($count[$count_type] as $key=> $num){
                    isset($all_count[$count_type][$key])?"":$all_count[$count_type][$key]=0;
                    $all_count[$count_type][$key]+=$num;
                }
            }
        }
        return $all_count;
    }

    public function project_station_count(){
        $projects = array();
        $projects[] = $this->project->find(4);
        $projects[] = $this->project->find(104);
        foreach($projects as $key => $project){
            $this->db->where(array("recycle"=>ESC_NORMAL,"status != "=>ESC_STATION_STATUS_REMOVE));
            $this->db->where("(batch_id is null or batch_id = 0)");
            $projects[$key]["out_num"] = $this->station->count(array("project_id"=>$project['id']));
        }
        return $projects;
    }





} 
