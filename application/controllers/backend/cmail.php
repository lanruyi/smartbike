<?php
class Cmail_controller extends Backend_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('cmail');
        $this->load->helper('cmail');
    }

    public function index($cur_page = 1){
        $data['title'] = "邮件记录";

        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;	
        $conditions = array();
        if($this->input->get('subject')){
            $conditions['subject like'] = '\'%'.$this->input->get('subject').'%\'';
        } 
        if($this->input->get('content')){
            $conditions['content like'] = '\'%'.$this->input->get('content').'%\'';
        }
        $conditions['status ='] = $this->input->get('status');
        $conditions['create_time >'] = $this->input->get('create_start_time');
        $conditions['create_time <'] = $this->input->get('create_stop_time');

        //config pagination
        $orders = array("id"=>"desc");
        $paginator =  $this->cmail->pagination_sql($conditions,$orders,$per_page,$cur_page);
        $config['base_url'] = '/backend/cmail/index/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page'] = $per_page; 
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['cmails'] = $paginator['res'];
        $data['filter_num_str'] = h_filter_num_str($config['total_rows'],$cur_page,$per_page);


        $this->load->view('templates/backend_header', $data);
        $this->load->view('backend/menu');
        $this->load->view('backend/cmail/index');
        $this->load->view('templates/backend_footer');
    }


    public function verify_cmailstatus(){
        $str = "邮件状态修改成功";    
        mysql_query("update `cmails` set `status`=2 where `status`=1");
        $this->session->set_flashdata('flash_succ', $str);
        redirect('/backend/cmail', 'location');	
    }

}
