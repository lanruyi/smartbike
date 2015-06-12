<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_controller extends Statistic_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('mid/mid_station','area','contract','station','project'));
        $this->load->helper(array('chart'));
    }
    

    public function index(){
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
            $show_prjs[]   = $prj;
            $system['total'] += $num;
            $system['total_online'] += $online_num;
        }

        $this->dt['projects']  =  h_array_sort($show_prjs, 'num', 'desc');; 
        $this->dt['system']  = $system; 


        $contracted['total'] = $this->station->count(
            array("recycle"=>ESC_NORMAL,"status !="=>ESC_STATION_STATUS_REMOVE,"batch_id >"=>0));
        $contracted['total_online'] = $this->station->count(
            array("recycle"=>ESC_NORMAL,"status !="=>ESC_STATION_STATUS_REMOVE,"batch_id >"=>0,"alive"=>ESC_ONLINE));
        $this->dt['contracted']  = $contracted; 

        $this->load->view('templates/statistic_header',$this->dt);
        $this->load->view('statistic/menu');
        $this->load->view('statistic/system/index');
        $this->load->view('templates/statistic_footer'); 
    }


} 
