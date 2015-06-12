<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class T_fandaydata_controller extends ES_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('bug','date','project','datetime'));
        $this->load->model(array('station','data','project','area','t_fandaydata'));
    }
    
    public function index($cur_page = 1){
        $this->dt['title'] = '新风开启时间';
        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;

        $this->dt['projects'] = $this->project->findBy(array(),array('ope_type'));
        $this->dt['cities'] = ($this->input->get('project_id'))?$this->area->findProjectCities($this->input->get('project_id')):$this->area->findBy_sql(array('type'=>ESC_AREA_TYPE_CITY));	

        $conditions = array();

        $conditions['project_id ='] = $this->input->get('project_id');//xxx,待解决 t_fandaydata无该字段 
        $conditions['city_id ='] = $this->input->get('city_id');
        $conditions['station_type ='] = $this->input->get('station_type');

        $conditions['record_time >='] = $this->input->get('start_time')?"'".$this->input->get('start_time')."'":'';
        $conditions['record_time <='] = $this->input->get('end_time')?"'".$this->input->get('end_time')."'":'';    

        $orders = array("record_time"=>" desc");
        $paginator = $this->t_fandaydata->pagination_sql($conditions,$orders,$per_page,$cur_page);

        //config pagination
        $config['base_url'] = '/backend/t_fandaydata/index/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] =$paginator['num'];
        $config['per_page'] = $per_page; 

        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();
        $fandaydatas = $paginator['res'];

        $this->dt['fandaydatas'] = array();
        foreach($fandaydatas as $k=>$fandaydata){
            $station = $this->station->find_sql($fandaydata['station_id']);
            $fandaydata['station_name_chn'] = $station['name_chn'];
            $fandaydata['station_type'] = $station['station_type'];
            $fandaydata['project_name_chn'] = $this->project->getProjectNameChn($station['project_id']);
            $fandaydata['city_name_chn'] = $this->area->getCityNameChn($station['city_id']);
            $this->dt['fandaydatas'][$k] = $fandaydata;
        }

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/t_fandaydata/index.php');
        $this->load->view('templates/backend_footer');
    }
    
    public function ajax_get_areas(){
        if(!$this->input->get("project_id")){
            $result = $this->area->findBy_sql(array('type'=>ESC_AREA_TYPE_CITY));
            array_unshift($result,array("id"=>0,"name_chn"=>"全部"));
        }else{
            $project = $this->project->find_sql($this->input->get("project_id"));
            $query = $this->db->query("select * from areas where id in(".$project['city_list'].")");
            $result = $query->result_array();
        }    
        echo json_encode($result);
    }
    
    function __destruct() {

    }

}



