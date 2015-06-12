<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Esgconf_controller extends Backend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('mid/mid_station','esgconf', 'station', 'command'));
    }

    public function index($cur_page = 1) {
        $this->dt['title'] = "设置列表";

        $per_page = 20;
        $order = array("station_id" => "asc");
        $paginator = $this->esgconf->pagination_sql(array(), $order, $per_page, $cur_page); 
        $config['base_url'] = '/backend/esgconf/index/';
        $config['total_rows'] = $paginator['num'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $this->dt['pagination'] = $this->pagination->create_links();
        $this->dt['esgconfs'] = $paginator['res'];

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/esgconf/index');
        $this->load->view('templates/backend_footer');
    }

    public function station_esgconf_go() {
        $station_id = $this->input->post('station_id');
        $station = $this->station->find_sql($station_id);
        if ($station['setting_lock'] == ESC_STATION_SETTING_LOCK) {
            $this->session->set_flashdata('flash_err',"基站设置被锁定，请在'修改属性'中先解除！");
            redirect(urldecode($this->input->get('backurl')), 'location');
            return;
        }
        
        $arg_str_array = array();
        foreach (h_esgconf_array() as $_c => $_esgconf) {
            $_post_value = $this->input->post($_esgconf['en']);
            if ($_post_value === false || $_post_value === "") {
                array_push($arg_str_array, "\"\"");
            } else {
                if (h_esgconf_is_str($_c)) {
                    array_push($arg_str_array, "\"" . $_post_value . "\"");
                } else {
                    array_push($arg_str_array, $_post_value);
                }
            }
        }
        $_arg_str = "[" . implode(",", $arg_str_array) . "]";
        $command_id = $this->command->newStCommand($station_id,$_arg_str,$this->curr_user['id']);
        redirect(urldecode($this->input->get('backurl')), 'location');
    }

    public function station_esgconf_get($station_id) {
        $this->command->newGSCommand($station_id,$this->curr_user['id']);
        redirect('/backend/esgconf/set_setting/' . $station_id, 'location');
    }

    public function set_setting($station_id) {
        $this->dt['station'] = $this->mid_station->onestation_detail($station_id);
        $this->dt['title'] = $this->dt['station']['name_chn']." 基站设置 ";
        $this->dt['gs_command'] = $this->command->findActiveGSCommand($station_id);
        $this->dt['esgconf'] = $this->esgconf->findOneBy_sql(array("station_id" => $station_id));
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/esgconf/set_setting');
        $this->load->view('templates/backend_footer');
    }

    public function batch_setting(){
        $this->dt['title'] = "基站批量设置";
        $stations = array();
        $station_ids = $this->input->post('station_ids');
        $this->dt['station_ids_str'] = implode(",",$station_ids);
        if(!$station_ids){
            $this->session->set_flashdata('flash_err', '未选择基站！');
            redirect('/backend/station/slist', 'location');
        }
        foreach ($station_ids as $id) {
            $esgconf = $this->esgconf->findOneBy_sql(array("station_id"=>$id));
            $station = $this->station->find_sql($id);
            $station['esgconf'] = $esgconf;
            array_push($stations, $station);
        }
        $this->dt['stations'] = $stations;
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/esgconf/batch_setting');
        $this->load->view('templates/backend_footer');        
    }
    
    public function batch_setting_process(){
        $this->dt['title'] = "批量设置报告";
        $arg_str_array = array();
        foreach (h_esgconf_array() as $_c => $_esgconf) {
            $_post_value = $this->input->post($_esgconf['en']);
            if ($_post_value === false || $_post_value === "") {
                array_push($arg_str_array, "\"\"");
            } else {
                if (h_esgconf_is_str($_c)) {
                    array_push($arg_str_array, "\"" . $_post_value . "\"");
                } else {
                    array_push($arg_str_array, $_post_value);
                }
            }
        }
        $_arg_str = "[" . implode(",", $arg_str_array) . "]";
        $station_ids = explode(',',$this->input->post('station_ids_str'));
        $commands = array();
        foreach($station_ids as $station_id){  
            $station = $this->station->find_sql($station_id);
            if ($station['setting_lock'] == ESC_STATION_SETTING_LOCK) {
                $commands[$station_id] = "";
                continue;
            }
            
            $command_id = $this->command->newStCommand($station_id,$_arg_str,$this->curr_user['id']);
            $commands[$station_id] = $command_id;
        }

        echo "<form id='subform' action='/backend/esgconf/batch_setting_report' method='post'>";
        echo "<input type='hidden' name='c' value='".json_encode($commands)."'>";
        echo "</form>";
        echo "<script>";
        echo "document.getElementById('subform').submit();";
        echo "</script>";


    }


    public function batch_setting_report(){
        $command_ids = json_decode($this->input->post("c"),true);
        $nums = array("unknow"=>0,"total"=>count($command_ids));
        foreach(h_command_status_array() as $status=>$name){
            $nums[$status] = 0;
        }
        $unfinish_stations = array();
        foreach($command_ids as $station_id=>$command_id){
            $command = $this->command->find($command_id);
            if($command){
                $nums[$command['status']] ++; 
                //命令未完成的基站需要显示出来
                if($command['status'] != ESC_COMMAND_STATUS__CLOSED){
                    $station = $this->station->find($station_id);
                    $station['project_name_chn'] = $this->project->getProjectNameChn($station['project_id']);
                    $station['city_name_chn'] = $this->area->getCityNameChn($station['city_id']);
                    $unfinish_stations[$command['status']][$station['id']] = $station;
                }
            }else{
                $nums['unknow'] ++;
                $station = $this->station->find($station_id);
                $station['project_name_chn'] = $this->project->getProjectNameChn($station['project_id']);
                $station['city_name_chn'] = $this->area->getCityNameChn($station['city_id']);
                $unfinish_stations["unknow"][$station['id']] = $station;
            }
        }
        $this->dt['nums'] = $nums;
        $this->dt['unfinish_stations'] = $unfinish_stations;
        $this->dt['command_json'] = $this->input->post("c");



        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/esgconf/batch_setting_report');
        $this->load->view('templates/backend_footer');        
    }


}












