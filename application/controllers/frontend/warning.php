<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/********************************
[Controller Warning]
./../../models/warning.php
******************************* */

class Warning_controller extends Frontend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array());
        $this->load->model(array('warning','project','area', 'station'));
    }


    public function index($cur_page=1){
        $this->dt['title'] = "告警中心";

        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;	
        $conditions = array();
        $conditions['type ='] = $this->input->get('type');
        $conditions['status ='] = ESC_WARNING_STATUS__OPEN;
        $conditions['create_time >'] = $this->input->get('create_start_time');
        $conditions['create_time <'] = $this->input->get('create_stop_time');
        
		$orders = array("id"=>"desc","create_time"=>"desc");
        $paginator =  $this->warning->pagination_sql($conditions,$orders,$per_page,$cur_page);		
        //config pagination
        $config['base_url'] = '/frontend/warning/index/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
	    $config['total_rows'] = $paginator['num'];
	    $config['per_page'] = $per_page; 
		
        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();
        $this->dt['warnings'] = $paginator['res'];
        $this->dt['warning_nums_of_city'] = 
            array("p"=>array(ESC_WARNING_PRIORITY__HIGH=>0,
                            ESC_WARNING_PRIORITY__MIDDLE=>0,
                            ESC_WARNING_PRIORITY__LOW=>0),
                  "w"=>array());
        $this->load->view('templates/frontend_header', $this->dt);
        $this->load->view('frontend/warning/city');
        $this->load->view('templates/frontend_footer');          
    }
    
   
    private function priority_count($warnings){
        $counts = array('high'=>0,'middle'=>0,'low'=>0,'total'=>count($warnings));
        foreach ($warnings as $key => $warning) {
            if($warning->getPriority() == ESC_WARNING_PRIORITY__HIGH){ $counts['high']++; }
            if($warning->getPriority() == ESC_WARNING_PRIORITY__MIDDLE){ $counts['middle']++; }
            if($warning->getPriority() == ESC_WARNING_PRIORITY__LOW){ $counts['low']++; }
        }
        return $counts;
    }
    
    private function type_count($warnings){
        $types = array();
        foreach ($warnings as $key => $warning) {
            array_push($types,$warning->getType());
        }
        return array_count_values($types);
    }
    
    private function getOrderArray($sort_str){
        $orders = array();
        $strs = explode('--', $sort_str);
        foreach ($strs as $key => $str) {
            $array = explode('-', $str);
            $orders[$array[0]] = $array[1];
        }
        return $orders;
    }
}
