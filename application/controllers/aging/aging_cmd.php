<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aging_cmd_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('esg','data','station','agingdata','restart','command','esg_command'));
        $this->load->helper(array('command'));
        $this->load->library('pagination');
    }

    public function index($cur_page = 1){
    	$this->dt['title'] = "老化远程命令测试";
        $this->dt['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);
        
        $esg_id = $this->input->get('esg_id');
        $esg = $this->esg->find_sql($esg_id);
        if(!$esg){show_error('no that esg!');}
        $this->dt['esg'] = $esg;
        
         $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;     
        $conditions = array();
        $conditions['status ='] = $this->input->get('status');
        if($command = $this->input->get('command')){
            $conditions['command ='] = "'".$command."'";
        }
        $conditions['esg_id = '] = $this->input->get('esg_id');
        $conditions['user_id = '] = "";
        $conditions['create_time >='] = h_dt_format($this->input->get('create_start_time'));
        $conditions['create_time <='] = h_dt_stop_time_of_day($this->input->get('create_stop_time'));
        $orders = array("id"=>"desc");
        $paginator =  $this->esg_command->pagination_sql($conditions,$orders,$per_page,$cur_page);	 

        //config pagination
        $config['base_url'] = '/aging/aging_cmd/index/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page'] = $per_page; 

        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();
        $this->dt['commands'] = $paginator['res'];

        $this->load->view('templates/aging_header', $this->dt);
        $this->load->view('aging/menu');
        $this->load->view('aging/home/aging_cmd');
        $this->load->view('templates/footer');
    }
    
    public function del_command($command_id=0){
        $this->esg_command->del_by_id($command_id);
        redirect(urldecode($this->input->get('backurl')), 'location');
    }

   
	
}


