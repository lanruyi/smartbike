<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Station_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('batch','mid/mid_station','esg','station','command','rom','area','restart','user','warning','station_log'));
    }

    function index()
    {
        redirect('/newback/station/slist', 'location');
    }

    function blank()
    {
        $this->load->view('newback/station/empty',$this->dt);
    }


    private function station_filter($filters)
    {
        $stations_equal_array = array( "colds_num", "project_id", "total_load", "building", 
            "station_type", "city_id", "district_id", "force_on", "alive", "creator_id", 
            "rom_id", "batch_id", "frontend_visible", "have_box", "status" );
        $esgconfs_equal_array = array("sys_mode","simple_control" );
        foreach($stations_equal_array as $equal_item){
            if($value = h_array_safe($filters,"stations#".$equal_item)){
                $this->station->where(array("stations.".$equal_item => $value));
            }
        }
        foreach($esgconfs_equal_array as $equal_item){
            if($value = h_array_safe($filters,"esgconfs#".$equal_item)){
                $this->station->where(array("esgconfs.".$equal_item => $value));
            }
        }
        if($_start_t = h_array_safe($filters,"create_start_time")){
            $this->station->where("(stations.create_time > ".h_dt_format($_start_t).")");
        }
        if($_stop_t = h_array_safe($filters,"create_stop_time")){
            $this->station->where("(stations.create_time < ".h_dt_format($_stop_t).")");
        }
        if(h_array_safe($filters,"station_ids")){
            $this->station->where("(stations.id in (".h_array_safe($filters,"station_ids")."))");
        }
        if(h_array_safe($filters,"new_rom_id")==ESC_BEING){
            $this->station->where(" stations.new_rom_id > 1 "); 
        }
        if(h_array_safe($filters,"new_rom_id")==ESC_BEINGLESS){
            $this->station->where(" stations.new_rom_id is null"); 
        }
        if(h_array_safe($filters,"search")){
            $this->station->where("stations.name_chn like '%".trim(h_array_safe($filters,"search"))."%'"); 
        }
        if(h_array_safe($filters,"no_batch")){
            $this->station->where("(stations.batch_id is null or stations.batch_id = 0)"); 
        }
        if(h_array_safe($filters,"has_batch")){
            $this->station->where("(stations.batch_id > 0)"); 
        }
    }

    public function slist($cur_page = 1)
    {
        $this->dt['title']      = "基站列表";
        $this->dt['creators']   = $this->user->findBy(array('department_id'=>4));
        $this->dt['cities']     = $this->area->findBy(array('type'=>ESC_AREA_TYPE_CITY));
        $this->dt['districts']  = $this->input->get('city_id')?$this->area->findDistricts($this->input->get('city_id')):$this->area->findDistricts();
        $this->dt['projects']   = $this->project->findBy(array());
        $this->dt['roms']       = $this->rom->findBy(array("station_num > "=>0),array("id desc"));
        $this->dt['batches']    = $this->batch->findBy(array(),array("city_id asc"));

        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):12;	

        $this->station->start_cache();
        $this->station->join('esgconfs','stations.id = esgconfs.station_id','left');
        $this->station->join('roms','stations.rom_id = roms.id','left');
        $this->station->where(array("stations.recycle" => ESC_NORMAL));
        $this->station_filter($this->input->get());
        $this->station->order_by("stations.id desc");
        $this->station->select("stations.*");
        $paginator =  $this->station->pagination_stop_cache($per_page,$cur_page);
        $config['base_url'] = '/newback/station/slist/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page'] = $per_page; 

        //$config['full_tag_open']	= '<div class="dataTables_paginate paging_bootstrap"><ul class="pagination">';
        //$config['full_tag_close']	= '</ul></div>';
        //$config['cur_tag_open']		= '<li class="active disable"><a>';
        //$config['cur_tag_close']	= '</a></li>';
        //$config['next_link']		= '<i class="icon-angle-right"></i>';
        //$config['prev_link']		= '<i class="icon-angle-left"></i>';
        //$config['prev_tag_open']	= '<li class="prev">';
        //$config['prev_tag_close']	= '</li>';
        $config['full_tag_open']	= '';
        $config['full_tag_close']	= '';
        $config['first_tag_open']		= '';
        $config['first_tag_close']	= '';
        $config['last_tag_open']		= '';
        $config['last_tag_close']	= '';
        $config['next_tag_open']		= '';
        $config['next_tag_close']	= '';
        $config['prev_tag_open']		= '';
        $config['prev_tag_close']	= '';
        $config['cur_tag_open']		= ' ';
        $config['cur_tag_close']	= ' ';
        $config['num_tag_open']		= '';
        $config['num_tag_close']	= '';
        $config['full_tag_open']	= '<span class="pagination2">';
        $config['full_tag_close']	= '</span>';

        $config['next_link']		= '下一页&gt;';
        $config['prev_link']		= '&lt;上一页';
        $config['first_link']		= '首页';
        $config['last_link']		= '尾页';
        $config['has_tail']	= FALSE;

        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();
        $this->dt['stations'] = $this->mid_station->getStationsDetail($paginator['res']);
        $this->dt['num_str'] = h_filter_num_str($config['total_rows'],$cur_page,$per_page);

        $this->load->view('newback/station/slist',$this->dt);
    }


    public function single($station_id){
        $station = $this->mid_station->onestation_detail($station_id);
        $this->dt['title']     = $station['name_chn'];
        $this->dt['station']   = $station;
        $this->dt['creators']  = $this->user->findBy(array('department_id'=>4));
        $this->dt['cities']    = $this->area->findBy(array('type'=>ESC_AREA_TYPE_CITY));
        $this->dt['districts'] = $this->input->get('city_id')?$this->area->findDistricts($this->input->get('city_id')):$this->area->findDistricts();
        $this->dt['projects']  = $this->project->findBy(array());
        $this->dt['roms']      = $this->rom->findBy(array("station_num > "=>0),array("id desc"));
        $this->dt['batches']   = $this->batch->findBy(array(),array("city_id asc"));
        $this->load->view('newback/station/single',$this->dt);
    }

    public function save_csv($arg=""){
        $this->station->join('esgconfs','stations.id = esgconfs.station_id','left');
        $this->station->join('roms','stations.rom_id = roms.id','left');
        $this->station->where(array("stations.recycle" => ESC_NORMAL));
        $this->station_filter($this->input->get());
        $this->station->order_by("stations.id desc,stations.project_id asc,stations.city_id asc,stations.total_load asc,stations.building asc");
        $this->station->select("stations.*");
        $stations = $this->station->findBy();
        if($arg=="bug"){
            if(count($stations) > 500){
                echo "每次导出故障的站点数量请不要超过500，此次您要导出".count($stations)." 请过滤后导出";
                return; 
            }
        }

        foreach($stations as $key => $station){
            $stations[$key]['city_name_chn'] = $this->area->getCityNameChn($station['city_id']);
            $stations[$key]['district_name_chn'] = $this->area->getCityNameChn($station['district_id']);
            $stations[$key]['project_name_chn'] = $this->project->getProjectNameChn($station['project_id']);
            $stations[$key]['esg_id'] = $this->esg->getEsgId($station['id']);
            $stations[$key]['rom_version'] = $this->rom->getRomVersion($station['rom_id']);
        }
        header( "Cache-Control: public" );
        header( "Pragma: public" );
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=stations.csv");
        header('Content-Type:APPLICATION/OCTET-STREAM');
        $fp = fopen('php://output', 'a');
        $titles=array("基站名","基站Id","状态","分期","rom版本","项目","城市","区县","负载档位","负载","建筑","基站类型","在线","空调数量",
            "新风类型","风机风量","恒温柜类型","室外传感","创建时间","ESG","SIM","电费单价","经度","纬度","地址","故障");
        foreach ($titles as $i => $v) {
            $titles[$i] = iconv('utf-8', 'gbk', $v);
        }
        fputcsv($fp, $titles);
        foreach($stations as $station){
            $bug_str = "";
            if($arg=="bug"){
                $bugs = $this->bug->findStationOpenBugs($station['id']);
                foreach($bugs as $bug){
                    $bug_str .= h_bug_type_name_chn($bug['type'])." ";
                }
            }
            $batch = $this->batch->find($station['batch_id']);
            $items = array("基站名"=>$station['name_chn'],
                "基站Id"=>$station['id'],
                "状态"=>h_station_status_name_chn($station['status']),
                "分期"=>$batch?$batch['name_chn']:"",
                "rom版本"=>$station['rom_version'],
                "项目"=>$station['project_id'],
                "城市"=>$station['city_name_chn'],
                "区县"=>$station['district_name_chn'],
                "负载档位"=>h_station_total_load_name_chn($station['total_load']),
                "负载"=>$station['load_num'],
                "建筑"=>h_station_building_name_chn($station['building']),
                "基站类型"=>h_station_station_type_name_chn($station['station_type']),
                "在线"=>h_alive_name_chn($station['alive']),
                "空调数量"=>$station['colds_num'],
                "新风类型"=>h_station_fan_type_name_chn($station['fan_type']),
                "风机风量"=>h_station_air_volume_name_chn($station['air_volume']),
                "恒温柜类型"=>h_station_box_type_name_chn($station['box_type']),
                "室外传感"=>$station['equip_with_outdoor_sensor']==ESC_BEING?"有":"无",
                "创建时间"=>$station['create_time'],
                "ESG"=>$station['esg_id'],
                "SIM"=>$station['sim_num'],
                "电费单价"=>$station['price'],
                "经度"=>$station['lng'],
                "纬度"=>$station['lat'],
                "地址"=>$station['address_chn'],
                "故障"=>$bug_str);
            foreach ($items as $i => $v) {
                $items[$i] = iconv('utf-8', 'gbk', $v);
            }
            fputcsv($fp, $items);
        }
    }


    public function mod_station(){
        $this->dt['title'] = "修改基站";
        $station_id = $this->uri->segment(4);
        $station = $this->mid_station->onestation_detail($station_id);

        $std_stations = $this->station->find_standard_stations($station_id);

        $this->dt['std_stations'] = $std_stations;
        $this->dt['station'] = $station;
        $this->dt['esg'] = $this->esg->findOneBy(array("station_id"=>$station_id));
        $this->dt['cities'] = $this->area->findProjectCities($station['project_id']);
        $this->dt['districts'] = $station['city_id']?$this->area->findDistricts($station['city_id']):$this->area->getDistricts_sql();
        $this->dt['projects'] = $this->project->getAllProjects();
        $this->dt['batches'] = $this->batch->findBatches($station['project_id'],$station['city_id']);

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/station/mod_station');
        $this->load->view('templates/backend_footer');
    }


    public function update_post(){
        $_params = $this->input->post();
        $_params['ns_start'] = date('Y-m-d 00:00:00',strtotime($_params['ns_start']));
        $esg_id = $_params['esg_id'];
        unset($_params['esg_id']);
        $_params['total_load'] = h_get_total_load_by_load_num($_params['load_num']);
        $_params['colds_num'] = $_params['colds_1_func']==ESC_STATION_COLDS_FUNC_NONE?1:2;;
        $_params['colds_1_type'] = $_params['colds_num']==2?$_params['colds_1_type']:0;
        $_params['have_box'] = $_params['box_type']==ESC_STATION_BOX_TYPE_NONE?ESC_HAVE_BOX_NONE:ESC_HAVE_BOX;
        //此处不能修改esg_id
        $this->station->update($_params['id'],$_params);

        //这里是基站修改日志
        $station = $this->station->find($_params['id']);
        $original_station = $station;
        $original_station['esg_id'] = $esg_id;
        $station_log = array();
        $station_log['original_content'] = json_encode($original_station);
        $station_log['create_time'] = h_dt_now();
        $station_log['station_id'] = $_params['id'];
        $station_log['creator_id'] = $this->session->userdata('user_id');
        $station_log['change_content'] = json_encode(h_station_differ_array($_params,$station));
        $this->station_log->insert($station_log);

        redirect(urldecode($this->input->get('backurl')), 'location');
    }


    public function del_station($station_id){
        $esg = $this->esg->findOneBy_sql(array("station_id" => $station_id));
        $this->station->update_sql($station_id,array("recycle"=>ESC_DEL));
        $this->esg->update_sql($esg['id'],array("station_id"=>null));
        $this->session->set_flashdata('flash_succ', '基站 <b></b> 已经删除!');
        redirect(urldecode($this->input->get('backurl')), 'location');
    }

    public function remote_on(){
        $station_id = $this->uri->segment(4); 
        $station = $this->station->find_sql($station_id);
        $this->command->newOnCommand($station_id,$this->curr_user['id']);
        $this->session->set_flashdata('flash_succ', '远程重启'.$station['name_chn'].'成功!');
        redirect(urldecode($this->input->get('backurl')), 'location');
    }

    public function force_reboot(){
        $station_id = $this->uri->segment(4); 
        $station = $this->station->find($station_id);
        $this->command->newREBCommand($station_id,$this->curr_user['id']);
        $this->session->set_flashdata('flash_succ', '强制重启'.$station['name_chn'].'成功!');
        redirect(urldecode($this->input->get('backurl')), 'location');
    }

    public function recycle_station_list($cur_page=1){
        $data['title'] = "基站列表";
        $data['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);
        $data['creators'] = $this->user->findBy_sql(array('department_id'=>4));
        $data['cities'] =  $this->area->findBy_sql(array('type'=>ESC_AREA_TYPE_CITY));

        $data['projects'] = $this->project->findBy_sql(array());
        $data['roms'] = $this->rom->findBy_sql(array());

        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;	

        $conditions = array();
        $conditions['recycle ='] = ESC_DEL;
        $conditions['project_id ='] = $this->input->get('project_id');
        $conditions['total_load ='] = $this->input->get('total_load');
        $conditions['building ='] = $this->input->get('building');
        $conditions['station_type ='] = $this->input->get('station_type');
        $conditions['city_id ='] = $this->input->get('city_id');
        $conditions['alive ='] = $this->input->get('alive');
        $conditions['creator_id ='] = $this->input->get('creator_id');
        $conditions['create_time >'] = $this->input->get('create_start_time');
        $conditions['create_time <'] = $this->input->get('create_stop_time');
        $conditions['have_box =']=$this->input->get('have_box');
        if($this->input->get('search')){
            $conditions['name_chn like'] = '\'%'.trim($this->input->get('search')).'%\'';
        }
        $orders = array("id"=>"desc");
        $paginator =  $this->station->pagination_sql($conditions,$orders,$per_page,$cur_page);
        $config['base_url'] = '/backend/station/recycle_station_list/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page'] = $per_page; 
        $this->pagination->initialize($config); 
        $data['pagination'] = $this->pagination->create_links();
        $data['stations'] = $this->mid_station->getStationsDetail($paginator['res']);
        $data['filter_num_str'] = h_filter_num_str($config['total_rows'],$cur_page,$per_page);


        $this->load->view('templates/backend_header', $data);
        $this->load->view('backend/menu');
        $this->load->view('backend/station/recycle_station_list');
        $this->load->view('templates/backend_footer');		
    }

    public function clearStationStatus(){
        $this->station->where("batch_id > 0");
        $this->station->where("status != ".ESC_STATION_STATUS_NORMAL);
        $this->station->whereAllStations();
        $this->station->updateBy(array("status"=>ESC_STATION_STATUS_NORMAL));
        $nums = $this->db->affected_rows();
        $this->station->where("( batch_id is null or batch_id = 0 )");
        $this->station->where("status != ".ESC_STATION_STATUS_CREATE);
        $this->station->whereAllStations();
        $this->station->updateBy(array("status"=>ESC_STATION_STATUS_CREATE));
        $nums += $this->db->affected_rows();
        $this->session->set_flashdata('flash_succ', "共修复".$nums."个站点");
        redirect('/backend/station/slist', 'location');
    }

    public function display_abnormal_station(){

        $stations = $this->station->findBy_sql(array('recycle'=> ESC_NORMAL));
        $abnormal_stations_str = "";
        foreach($stations as $station)
        {
            $string = "";
            if(!$station['station_type']){
                $string .= "no StationType ";
            }
            if(!$station['total_load']){
                $string .= "no TotalLoad ";
            }
            if(!$station['building']){
                $string .= "no Building ";
            }
            if(!$station['city_id']){
                $string .= "no CityId ";
            }
            if($string != NULL)
            {
                $abnormal_stations_str.= $station['name_chn']." is ".$string."<br />";
            }
        }

        $this->session->set_flashdata('flash_succ', $abnormal_stations_str);
        redirect('/backend/station/slist', 'location');
    }

    public function station_log($cur_page=1){
        $station_id = $this->input->get('station_id');
        if(!$station_id || !$this->station->find_sql($station_id)){
            show_error('no station_id,error!');
        }
        $per_page = $this->input->get('per_page')?$this->input->get('per_page'):3;
        $this->dt['title'] = '基站历史修改记录';
        $this->dt['station'] =  $this->mid_station->onestation_detail($station_id);

        $conditions = array();
        $conditions['station_id ='] = $station_id;
        $orders = array("create_time"=>"desc");
        $paginator =  $this->station_log->pagination_sql($conditions,$orders,$per_page,$cur_page);
        $config['base_url'] = '/backend/station/station_log/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'].'?station_id='.$station_id;
        $config['total_rows'] = $paginator['num'];
        $config['per_page'] = $per_page; 
        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();

        $station_logs = $paginator['res'];        
        $this->dt['station_logs'] = array();
        foreach($station_logs as $station_log){
            $station_log['original_content'] = get_object_vars(json_decode($station_log['original_content']));
            $station_log['change_content'] = json_decode($station_log['change_content'])?get_object_vars(json_decode($station_log['change_content'])):array();
            $station_log['creator_name_chn'] = $this->user->getUserNameChn($station_log['creator_id']);
            $this->dt['station_logs'][] = $station_log;
        }

        $station_logs = $this->station_log->findBy_sql(array('station_id'=>$station_id));
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/station/station_log');
        $this->load->view('templates/backend_footer');
    }
}
