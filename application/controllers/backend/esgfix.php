<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Esgfix_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('mid/mid_station','esg','esgfix','user'));
    }


    public function add_esgfix($station_id){
        $param['station_id'] = $station_id;
        $esg = $this->esg->findOneBy(array("station_id"=>$station_id));
        if($esg){
            $param['esg_id'] = $esg['id'];
            $param['new_esg_id'] = 0;
            $param['esg_ver'] = $this->input->post("esg_ver");
            $param['new_esg_ver'] = $this->input->post("new_esg_ver");
            $param['reason'] = $this->input->post("reason");
            $param['other_reason'] = $this->input->post("other_reason");
            $param['user_id'] = $this->curr_user['id'];
            $this->esgfix->insert($param);
        }

        redirect("/backend/esgfix/index?station_id=".$station_id,"local");
    }

    public function index($cur_page = 1){
        if($this->input->get('station_id')){
            $this->dt['station'] = $this->mid_station->onestation_detail($this->input->get('station_id'));
            $this->dt['title'] = $this->dt['station']['name_chn']." 维修列表 ";
        }else{
            $this->dt['station'] = null; 
        }

        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;     
        $conditions = array();

        $conditions['station_id = '] = $this->input->get('station_id');
        $orders = array("id"=>"desc");
        $paginator =  $this->esgfix->pagination_sql($conditions,$orders,$per_page,$cur_page);	 

        //config pagination
        $config['base_url'] = '/backend/esgfix/index/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page'] = $per_page; 

        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();
        $this->dt['esgfixs'] = $paginator['res'];

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/esgfix/index');
        $this->load->view('templates/backend_footer');
    }


}

