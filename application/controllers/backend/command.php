<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Command_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('mid/mid_station','command','station','user'));
        $this->load->helper(array('command'));
        $this->load->library('pagination');
    }

    public function index($cur_page = 1){
        $this->dt['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);
        $this->dt['users'] = $this->user->findBy_sql(array());

        if($this->input->get('station_id')){
            $this->dt['station'] = $this->mid_station->onestation_detail($this->input->get('station_id'));
            $this->dt['title'] = $this->dt['station']['name_chn']." 命令列表 ";
        }else{
            $this->dt['station'] = null; 
        }

        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;     
        $conditions = array();
        $conditions['status ='] = $this->input->get('status');
        if($command = $this->input->get('command')){
            $conditions['command ='] = "'".$command."'";
        }
        $conditions['station_id = '] = $this->input->get('station_id');
        $user_name_chn = $this->input->get('user_name_chn');
        $user = $user_name_chn?$this->user->findOneBy_sql(array("name_chn" => $user_name_chn)):array();
        $conditions['user_id = '] = $user?$user['id']:"";
        $conditions['create_time >'] = h_dt_format($this->input->get('create_start_time'));
        $conditions['create_time <'] = h_dt_stop_time_of_day($this->input->get('create_stop_time'));
        $orders = array("id"=>"desc");
        $paginator =  $this->command->pagination_sql($conditions,$orders,$per_page,$cur_page);	 

        //config pagination
        $config['base_url'] = '/backend/command/index/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page'] = $per_page; 

        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();
        $this->dt['commands'] = $paginator['res'];
        foreach($this->dt['commands'] as &$command){
            $station = $this->station->find_sql($command['station_id']);
            $user = $this->user->find_sql($command['user_id']);
            $command['station_name_chn'] = $station?$station['name_chn']:""; 
            $command['user_name_chn'] = $user?$user['name_chn']:"";
        }

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/command/index');
        $this->load->view('templates/backend_footer');
    }


    public function del_command($command_id=0){
        $this->command->del_by_id($command_id);
        redirect(urldecode($this->input->get('backurl')), 'location');
    }

    public function add_command(){
        $this->dt['title'] = "新增命令";
        $this->dt['mod'] = false;
        $this->dt['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/command/add_command');
        $this->load->view('templates/backend_footer');
    }

    public function insert_command(){
        $this->command->new_sql(array('station_id'=>$this->input->get('station_id'),'command'=>$this->input->get('command'),'user_id'=>$this->curr_user['id']));
        redirect(urldecode($this->input->get('backurl')),'location');
    }
}

