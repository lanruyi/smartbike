<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contract_controller extends Statistic_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('mid/mid_station','area','contract','station','project'));
        $this->load->helper(array('chart'));
    }


    public function index(){
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


        $this->load->view('templates/statistic_header',$this->dt);
        $this->load->view('statistic/menu');
        $this->load->view('statistic/contract/index');
        $this->load->view('templates/statistic_footer'); 
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
