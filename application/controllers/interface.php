<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Interface_controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('mid/mid_data','bug','station', 'project', 'command', 'area','user','rom','batch','appin'));
    }

    public function index(){
    }

    //以下接口都是传递给工单的数据
    public function getAliveBugs(){
        $bugs = $this->bug->findBy(array('status'=>ESC_BUG_STATUS__OPEN));
        $_datas = array();
        foreach($bugs as $k => $bug){
            $_datas[$k]['id'] = $bug['id'];
            $_datas[$k]['station_id'] = $bug['station_id'];
            $_datas[$k]['type'] = $bug['type'];
            $_datas[$k]['start_time'] = $bug['start_time'];
            $_datas[$k]['stop_time']  = $bug['stop_time'];
            $_datas[$k]['arg'] = $bug['arg'];
        }
        echo json_encode($_datas);
    }

    public function getAliveProjects(){
        $projects = $this->project->findBy(array('is_product'=>ESC_NORMAL));
        $_datas = array();
        foreach ($projects as $k => $project) {
            $_datas[$k]['id'] = $project['id'];
            $_datas[$k]['name_chn'] = $project['name_chn'];
            $_datas[$k]['city_list'] = $project['city_list'];
            $_datas[$k]['type'] = $project['type'];
        }
        echo json_encode($_datas);
    }

    public function getAliveRoms(){
        $roms = $this->rom->findBy();
        $_datas = array();
        foreach ($roms as $k => $rom) {
            $_datas[$k]['id'] = $rom['id'];
            $_datas[$k]['version'] = $rom['version'];
        }
        echo json_encode($_datas);
    }

    public function getAliveAreas(){
        $areas = $this->area->findBy_sql(array());
        $_datas = array();
        foreach ($areas as $k => $area) {
            $_datas[$k]['id'] = $area['id'];
            $_datas[$k]['name_chn'] = $area['name_chn'];
            $_datas[$k]['lng'] = $area['lng'];
            $_datas[$k]['lat'] = $area['lat'];
            $_datas[$k]['type'] = $area['type'];
            $_datas[$k]['father_id'] = $area['father_id'];
        }
        echo json_encode($_datas);
    }


    public function getBatches(){
        $batches = $this->batch->findBy();
        $_datas = array();
        foreach($batches as $k => $batch){
            $_datas[$k]['id'] = $batch['id'];
            $_datas[$k]['contract_id'] = $batch['contract_id'];
            $_datas[$k]['city_id'] = $batch['city_id'];
            $_datas[$k]['create_time'] = $batch['create_time'];
            $_datas[$k]['start_time'] = $batch['start_time'];
            $_datas[$k]['total_month'] = $batch['total_month'];
            $_datas[$k]['current_time'] = $batch['current_time'];
            $_datas[$k]['recycle'] = $batch['recycle'];
            $_datas[$k]['name_chn'] = $batch['name_chn'];
            $_datas[$k]['batch_num'] = $batch['batch_num'];
        }
        echo json_encode($_datas);
    }

    public function getAliveStations(){
        $stations = $this->station->findNormalStations();
        $_datas = array();
        foreach($stations as $k => $station){
            $_datas[$k]['id'] = $station['id'];
            $_datas[$k]['name_chn'] = $station['name_chn'];
            $_datas[$k]['city_id'] = $station['city_id'];
            $_datas[$k]['project_id'] = $station['project_id'];
            $_datas[$k]['station_type'] = $station['station_type'];
            $_datas[$k]['lng'] = $station['lng'];
            $_datas[$k]['lat'] = $station['lat'];
            $_datas[$k]['address_chn'] = $station['address_chn'];
            $_datas[$k]['colds_num'] = $station['colds_num'];
            $_datas[$k]['sim_num'] = $station['sim_num'];
            $_datas[$k]['load_num'] = $station['load_num'];
            $_datas[$k]['rom_id'] = $station['rom_id'];
            $_datas[$k]['ns_start'] = $station['ns_start'];
            $_datas[$k]['ns'] = $station['ns'];
            $_datas[$k]['district_id'] = $station['district_id'];
            $_datas[$k]['create_time'] = $station['create_time'];
            $_datas[$k]['status'] = $station['status'];
            $_datas[$k]['batch_id'] = $station['batch_id'];
        }
        echo json_encode($_datas);
    }

    //该接口只用一次
    public function getAliveUsers(){
        $users = $this->user->findBy_sql(array('recycle'=>ESC_NORMAL));
        $_datas = array();
        foreach($users as $k => $user){
            $_datas[$k]['id'] = $user['id'];
            $_datas[$k]['username'] = $user['username'];
            $_datas[$k]['password'] = $user['password'];
            $_datas[$k]['email'] = $user['email'];
            $_datas[$k]['telephone'] = $user['telephone'];
            $_datas[$k]['last_ip'] = $user['last_ip'];
            $_datas[$k]['created'] = $user['created'];
            $_datas[$k]['last_login'] = $user['last_login'];
            $_datas[$k]['modified'] = $user['modified'];
            $_datas[$k]['name_chn'] = $user['name_chn'];
        }
        echo json_encode($_datas);
    }


    //public function getStationInfoByName($city_name_chn,$station_name_chn){
    public function getStationInfoByName(){
        $station_name_chn = trim($this->input->post('station_name_chn'));
        if(!$station_name_chn){
            return;
        }
        $query = $this->db->query("select * from stations 
                where recycle=1 and name_chn like '%".($station_name_chn)."%' order by create_time DESC");
        $stations = $query->result_array();
        $result_array = array();
        if($stations){
            foreach($stations as $k => $station){
                $result_array[] = array("id"=>$station['id'],
                    "project_id"=>$station['project_id'],
                    "city_id"=>$station['city_id'],
                    "district_id"=>$station['district_id'],
                    "name_chn"=>$station['name_chn'],
                    "load_num"=>$station['load_num'],
                    "address"=>$station['address_chn'],
                    "district_name_chn"=>$this->area->getCityNameChn($station['district_id']),
                    "city_name_chn"=>$this->area->getCityNameChn($station['city_id']),
                    "project_name_chn"=>$this->project->getProjectNameChn($station['project_id']));
            }
        }
        echo json_encode($result_array);
        //$this->output->enable_profiler();
    }

    public function getStationInfoById($id){
        echo json_encode($this->station->find($id));
    }


    public function show60Datas($station_id,$datetime="now"){
        echo $this->mid_data->find60Datas($station_id,$datetime);
    }

    //工程semos_station表中所有数据同步此接口
    public function getAllStations(){
        //将semos中station表中所有数据传过来
        $stations = $this->station->findAll_sql();
        echo json_encode($stations);
    }
    
    //获取appins表所有数据
    public function getJsonAppins(){
        $app_datas = $this->appin->findAll_sql();
        echo json_encode($app_datas);
    }
    
    //获取某时刻之前某基站打开的bugs
    public function getCurrentOpenBugsByID($station_id, $datatime) {
        if ($station_id > 0 && $datatime) {
            $bugs = $this->bug->findBugByStationUntilTime($station_id, $datatime);
            echo json_encode($bugs?$bugs:'暂无');
            return;
        }
        
        echo '';
    }
    
 // 根据ID获取用户中文名
    public function getUserNameChn($user_id){
        if($user_id){
            $name_chn = $this->user->getUserNameChn($user_id);
            echo json_encode($name_chn);
            return;
        }
        
         echo '';
    }


}


