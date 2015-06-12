<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autocheck_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('mid/mid_station','mid/mid_data','autocheck','station'));
    }

    public function re_check(){
        $auto_check_id = $this->input->get("auto_check_id");
        $this->mid_data->reCheck($auto_check_id);
        $this->session->set_flashdata('flash_succ', '已重算');
        redirect(urldecode($this->input->get('backurl')), 'location');
    }

    public function index($cur_page = 1){
        $this->dt['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);

        if($this->input->get('station_id')){
            $this->dt['station'] = $this->mid_station->onestation_detail($this->input->get('station_id'));
             $this->dt['title'] = $this->dt['station']['name_chn']." 自检列表 ";
        }else{
            $this->dt['station'] = null; 
        }

        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;     
        $conditions = array();

        $conditions['station_id = '] = $this->input->get('station_id');
        $orders = array("id"=>"desc");
        $paginator =  $this->autocheck->pagination_sql($conditions,$orders,$per_page,$cur_page);	 

        //config pagination
        $config['base_url'] = '/backend/autocheck/index/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page'] = $per_page; 

        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();
        $this->dt['autochecks'] = $paginator['res'];

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/autocheck/index');
        $this->load->view('templates/backend_footer');
    }


}

