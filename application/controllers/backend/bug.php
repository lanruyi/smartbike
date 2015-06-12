<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bug_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('mid/mid_data','mid/mid_station','mid/mid_energy','bug','station','project','sysconfig'));
        $this->load->helper(array('bug'));
        $this->load->library('pagination');
    }


    public function config(){
        $this->project->where("id in (4,104,105,110)");
        $this->dt['projects'] = $this->project->findBy();         
        $b42_config = json_decode($this->sysconfig->getByName("b42_config"),true);
        $this->dt['b42_config'] = $b42_config;         
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/bug/bug_config');
        $this->load->view('templates/backend_footer');
    }
    public function update_bug_configs(){
        $b42_config = $this->input->post("b42_config");
        $this->sysconfig->setByName("b42_config",json_encode($b42_config));         
        $this->session->set_flashdata('flash_succ', '设置已保存!');
        redirect("/backend/bug/config","local");
    }
    public function doAnalysisMainEnergy(){
        $this->mid_energy->analysisMainEnergy();
        $this->session->set_flashdata('flash_succ', '能耗较大检测已完成!');
        redirect("/backend/bug/config","local");
    }


    public function index($cur_page = 1){
        if($this->input->get('station_id')){
            $station = $this->mid_station->onestation_detail($this->input->get('station_id')); 
            $this->dt['title'] = $station['name_chn']." 故障列表 ";
        }else{
            $station = null; 
        }
        $this->dt['station'] = $station; 
            
        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;
        $conditions = array();
        $conditions['station_id = '] = $this->input->get('station_id');
        $conditions['type ='] = $this->input->get('type');
        $conditions['status ='] = $this->input->get('status');
        $conditions['start_time >'] = $this->input->get('create_start_time');
        $conditions['start_time <'] = $this->input->get('create_stop_time');
        $orders = array("id"=>"desc");
        $paginator =  $this->bug->pagination_sql($conditions,$orders,$per_page,$cur_page);	
        //config pagination
        $config['base_url'] = '/backend/bug/index/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] =$paginator['num'];
        $config['per_page'] = $per_page; 

        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();
        $bugs = $paginator['res'];
        foreach($bugs as $key => $bug){
            $bugs[$key]['station'] = $this->station->find($bug['station_id']);
        }
        $this->dt['bugs'] = $bugs;
        if($station && $station['alive'] == ESC_OFFLINE){
            $this->dt['dis_bugs'] = $this->bug->findBugsBeforeOffline($station['id']);
        }

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/bug/index');
        $this->load->view('templates/backend_footer');
    }




    public function del_bug($bug_id,$station_id){
        $this->bug->del_by_id($bug_id);
        redirect(!$station_id ? '/backend/bug':'/backend/bug?station_id='.$station_id, 'location');        
    }


    public function colds_out_ctrl(){
        $this->dt['title'] = "空调不受控故障";
        $projects = $this->project->findProductProjects();
        $station_groups = array();
        $station_nums = 0;
        foreach($projects as $project){
            $this->db->select("id");
            $stations = $this->station->findAllStations($project['id']);
            $station_ids = h_array_to_id_array($stations);
            $num = count($stations);
            if($num){
                $station_nums += $num;
                for($i = 0 ;$i<ceil($num/20);$i++){
                    $station_groups[] = array_slice($station_ids,$i*20,20);
                }
            }
        }
        $this->dt['station_groups'] = $station_groups;
        $this->dt['station_nums'] = $station_nums;

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/bug/colds_out_ctrl');
        $this->load->view('templates/backend_footer');
    }

    public function go_colds_out_ctrl(){
        //usleep(100000);//休息100毫秒
        $station_ids = $this->input->get("station_ids_str");
        $day = h_dt_start_time_of_day($this->input->get("datetime")?$this->input->get("datetime"):"-1 day");
        $bugs =array();
        if($station_ids){
            $station = $this->station->find($station_ids[0]);
            if($this->mid_data->changeTable($station['id'],$day)){
                $this->data->where("station_id in (".implode(",",$station_ids).") ");
                $this->data->where("create_time > ".h_dt_format($day,"Ymd040000")." and create_time < ".h_dt_format($day,"Ymd160000"));
                $datas = $this->data->findBy();
                $bugs = $this->mid_data->errorColdsOutCtrl($station_ids,$datas);
            }
        }
        foreach($bugs as $type => $station_bugs){            
            //只开不关(啥时关 待定)
            $this->bug->openBugs($station_bugs,$type);
        }
        echo json_encode($bugs);
    }

    public function go_close_over_time_bugs(){
        $this->db->query("update bugs set stop_time=NOW(),status=? where status=? and type in (".
            implode(',',array(ESC_BUG__COLDS_OUT_CTRL,ESC_BUG__HAS_OTHER_EQP)).
            ") and update_time < date_sub(now(),interval 30 minute) ",
            array(ESC_BUG_STATUS__CLOSED,ESC_BUG_STATUS__OPEN));
        echo $this->db->affected_rows();
    }

}





