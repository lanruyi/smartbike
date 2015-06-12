<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("archive/data");
        if($this->input->get('debug')=='cx'){
            $this->output->enable_profiler(true);
        }
    }
    
    public function findLast2($table,$station_id){
        $this->data->changeTableName($table);
        $res = $this->data->findLast($station_id);
        echo json_encode($res);
    }

    //controller
    public function findLast($table,$station_id){
        $this->data->changeTableName($table);
        $res = $this->data->findLast($station_id);
        echo json_encode($res);
    }
    public function findLastN($table,$station_id,$n){
        $this->data->changeTableName($table);
        $res = $this->data->findLastN($station_id,$n);
        echo json_encode($res);
    }
    public function findPeriodDatas($table,$station_id,$start_time,$stop_time,$order){
        $this->data->changeTableName($table);
        $res = $this->data->findPeriodDatas($station_id,$start_time,$stop_time,$order);
        echo json_encode($res);
    }


    public function index(){
        $result = array();
        echo json_encode($result);
    }



}

