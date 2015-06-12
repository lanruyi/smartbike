<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userlog_controller extends Backend_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('userlog','user','project'));
        $this->load->helper(array('userlog'));
        $this->load->library('pagination');
    }

    public function index($cur_page = 1){
        $this->dt['title'] = "用户日志";

        $users = $this->user->findBy_sql(array());
        $this->dt['users'] = $users;
        $projects = $this->project->findBy_sql(array());
        $this->dt['projects'] = $projects; 

        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;

        $conditions['project_id ='] = $this->input->get('project_id');
        $conditions['user_id ='] = $this->input->get('user_id');
        $conditions['create_time >'] = $this->input->get('create_start_time');
        $conditions['create_time <'] = $this->input->get('create_stop_time');
        if($this->input->get('url')){
            $conditions['url like'] = '\'%'.$this->input->get('url').'%\'';
        }
        if($this->input->get('data')){
            $conditions['data like'] = '\'%'.$this->input->get('data').'%\'';
        }

        $orders = array("id"=>"desc");
        $paginator =  $this->userlog->pagination_sql($conditions,$orders,$per_page,$cur_page);	

        //config pagination
        $config['base_url'] ='/backend/userlog/index/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];

        $config['total_rows'] = $paginator['num'];
        $config['per_page'] = $per_page;

        $this->pagination->initialize($config);
        $this->dt['pagination'] = $this->pagination->create_links();
        $userlogs = $paginator['res'];
        $this->dt['userlogs'] = array();
        foreach($userlogs as $userlog){
            $userlog['user_name_chn'] = $this->user->getUserNameChn($userlog['user_id']);
            $userlog['project_name_chn'] = $this->project->getProjectNameChn($userlog['project_id']);
            $this->dt['userlogs'][] = $userlog;
        }
        $this->dt['filter_num_str'] = h_filter_num_str($config['total_rows'],$cur_page,$per_page);

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/userlog/index');
        $this->load->view('templates/backend_footer');
    }
}

