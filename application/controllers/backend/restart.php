<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Restart_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('mid/mid_station','restart','station'));
        $this->load->helper(array('station'));
    }

    public function index($cur_page = 1){
        $this->dt['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);

        if($this->input->get('station_id')){
            $this->dt['station'] = $this->mid_station->onestation_detail($this->input->get('station_id'));
            $this->dt['title'] = $this->dt['station']['name_chn']." 重启列表 ";
        }else{
            $this->dt['station'] = null; 
        }

        $conditions['station_id ='] = $this->input->get('station_id');
        $conditions['restart_time >'] = $this->input->get('restart_start_time');
        $conditions['restart_time <'] = $this->input->get('restart_stop_time');
        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;	

        $orders = array("restart_time"=>"desc");
        $paginator =  $this->restart->pagination_sql($conditions,$orders,$per_page,$cur_page);
        $config['base_url'] = '/backend/restart/index/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = count($paginator);
        $config['per_page'] = $paginator['num'];
        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();
        $this->dt['restarts'] = $paginator['res'];  
        foreach($this->dt['restarts'] as &$restart){
            $station = $this->station->find_sql($restart['station_id']);
            $restart['station_name_chn'] = $station?$station['name_chn']:null; 
        }

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/restart/index');
        $this->load->view('templates/backend_footer');

    }


    public function station_list($cur_page = 1){

        $data['title'] = "重启列表";
        $data['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);


        $type = $this->input->get("type")?$this->input->get("type"):"day";
        $time_str = $this->input->get("time")?$this->input->get("time"):"";
        $start_time = h_dt_date_str_db(h_dt_start_time_of_day($time_str));
        $stop_time  = h_dt_date_str_db(h_dt_stop_time_of_day($time_str));
        $data['start_time'] = $start_time;
        $data['stop_time'] = $stop_time;

        $config['base_url'] = '/backend/restart/station_list/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = 50;
        $config['per_page'] = 10; 
        $this->pagination->initialize($config); 
        $data['pagination'] = $this->pagination->create_links();

        $sql = "select station_id,count(*) a from restarts where station_id is not null and restart_time>".
            $start_time." and restart_time<".$stop_time." group by station_id order by a desc limit ".(($cur_page-1)*10).",10;";
        $query = $this->db->query($sql);
        $station_array = array();
        $stations = array();
        foreach($query->result_array() as $res){
            $station_array[$res['station_id']] = $res['a']; 
            array_push($stations,$this->station->find_sql($res['station_id']));
        }
        $data['stations'] = $stations;
        $data['station_array'] = $station_array;  	       

        $this->load->view('templates/backend_header', $data);
        $this->load->view('backend/menu');
        $this->load->view('backend/restart/station_list');
        $this->load->view('templates/backend_footer');

    }



}





