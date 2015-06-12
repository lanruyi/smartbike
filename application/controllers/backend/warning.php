<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Warning_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('mid/mid_station','warning','station','esg','user','area'));
        $this->load->helper(array('warning'));
        $this->load->library('pagination');
    }


    public function index($cur_page = 1){
        $data['title'] = "报警列表";
        $data['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);

        if($this->input->get('station_id')){
            $data['station'] = $this->mid_station->onestation_detail($this->input->get('station_id'));
        }else{
            $data['station'] = null; 
        }
            
        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;	
        $conditions = array();
        $conditions['station_id = '] = $data['station']['id'];
        $conditions['type ='] = $this->input->get('type');
        $conditions['status ='] = $this->input->get('status');
        $conditions['create_time >'] = $this->input->get('create_start_time');
        $conditions['create_time <'] = $this->input->get('create_stop_time');
        
	$orders = array("id"=>"desc");
        $paginator =  $this->warning->pagination_sql($conditions,$orders,$per_page,$cur_page);		
        //config pagination
        $config['base_url'] = '/backend/warning/index/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $paginator['num'];
	$config['per_page'] = $per_page; 
		
        $this->pagination->initialize($config); 
        $data['pagination'] = $this->pagination->create_links();
        $data['warnings'] = $paginator['res'];
        foreach($data['warnings'] as &$warning){
            $station = $this->station->find_sql($warning['station_id']);
            $warning['station_name_chn'] = $station?$station['name_chn']:null; 
        }
				
        $this->load->view('templates/backend_header', $data);
        $this->load->view('backend/menu');
        $this->load->view('backend/warning/index');
        $this->load->view('templates/backend_footer');
    }


    public function del_warning($warning_id,$station_id = null){
        $this->warning->del_by_id($warning_id);
        redirect(!$station_id ? '/backend/warning':'/backend/warning?station_id='.$station_id,'location');
    }
}

