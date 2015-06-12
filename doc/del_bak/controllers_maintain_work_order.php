<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Work_order_controller extends Backend_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library(array());
        $this->load->model(array('area','correct','bug','station','data','project','user','department'));
        $this->load->helper(array('date','project','bug','map','chart','station'));
    }


    public function prepare_orders($cur_page = 1){
        $this->dt['title'] = '生成工单';
        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;
        //下拉菜单的数据
        $this->dt['projects'] = $this->project->getMaintainProjects();
        $this->dt['station_creators'] = $this->user->findDepartment(ESC_DEPARTMENT_STATION_SURPERVISE);
        $this->dt['cities'] = ($this->input->get('project_id')>0)?$this->area->findProjectCities_sql($this->input->get('project_id')):$this->area->findAll_sql();

        //过滤器
        $conditions = array();
                      
        $conditions['project_id ='] = $this->input->get('project_id');
        $conditions['station_type ='] = $this->input->get('station_type');
        $conditions['city_id ='] = $this->input->get('city_id');
        $conditions['creator_id ='] = $this->input->get('station_creator_id');
        if($this->input->get('search')){
            $conditions['name_chn like'] = '\'%'.trim($this->input->get('search')).'%\'';
        }
        $orders = array("bug_point"=>" desc");


        $result = $this->station->prepare_station_orders($conditions,$orders,$cur_page,$per_page);
        $stations = $result['res'];
        $has_bug_stations = array();
        foreach($stations as $station){
             $bugs = $this->bug->find_stationid_sql($station['id']);    
             $station['bug_name_chn'] = h_bug_return_bugs_msg($bugs);
             //城市名
             $station['city_name_chn'] = $this->area->getCityNameChn($station['city_id']);
             //督导（建站者）
             $station['creator_name'] = empty($station['creator_id'])?"暂无":$this->user->getUserNameChn($station['creator_id']);   
             $has_bug_stations[]=$station;   
        }
        //todo 改一下名字
        $this->dt['datas'] = $has_bug_stations;
        //分页
        $config['base_url'] = '/maintain/work_order/prepare_orders';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $result['num'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();
        $this->dt['filter_num_str'] = h_filter_num_str($config['total_rows'],$cur_page,$per_page);
        $this->dt['currentTime'] = time();

        $this->load->view('templates/maintain_header',$this->dt);
        $this->load->view('maintain/home/menu');         
        $this->load->view('maintain/work_order/menu');         
        $this->load->view('maintain/work_order/prepare_orders');         
        $this->load->view('templates/maintain_footer');   
    }

    //第三方工单
    public function insert_third_party(){
        $gd=array(
            'station_id'=>$this->input->post('station_id'),
            'creator_id'=>$this->session->userdata('user_id'),
            'creator_remark'=>$this->input->post('creator_remark'),
            'create_time'=>mdate("%Y-%m-%d %H:%i:%s",time()),
            'status'=>ESC_WORK_ORDER__CREATE,
            'third_party'=>ESC_WORK_ORDER_THIRD_PARTY
        );
        
        $this->db->insert('work_orders',$gd);
        //获取新插入数据库的id值
        $work_order_id = mysql_insert_id();
        redirect('maintain/work_order/third_party_status/'.$work_order_id,'location'); 
    }
    
    public function third_party_status($work_order_id){
        $result = $this->work_order->find_sql($work_order_id);
        $result['title'] = "第三方工单";
        $result['bug_types'] = $this->bug->findBugByStationUntilTime($result['station_id'],time());
        $result['station_name_chn'] = $this->station->getStationNameChn($result['station_id']);
        $result['create_name_chn'] = $this->user->getUserNameChn($result['creator_id']);
        $result['address_name_chn'] = $this->station->getStationAddressNameChn($result['station_id']);
        $this->load->view('templates/backend_header',$result);
        $this->load->view('maintain/home/menu');
        $this->load->view('maintain/work_order/third_party_status');
        $this->load->view('templates/backend_footer');

    }

    public function modify_third_party($work_order_id){
        $data = $this->work_order->find_sql($work_order_id);
        $data['title']="修改第三方工单";
        $data['station_name_chn'] = $this->station->getStationNameChn($data['station_id']);
        $data['creator_name_chn'] = $this->user->getUserNameChn($data['creator_id']);
        $data['bug_types'] = $this->bug->findBugByStationUntilTime($data['station_id'],time());
        $this->load->view('templates/backend_header',$data);
        $this->load->view('maintain/home/menu');
        $this->load->view('maintain/work_order/modify_third_party');
        $this->load->view('templates/backend_footer');
    }

    public function update_third_party(){
        $data=array(
            'creator_remark'=>$this->input->post('creator_remark'),
        );
                 
        $this->db->where('id',$this->input->post('id'));
        $this->db->update('work_orders',$data);
        redirect('maintain/work_order/third_party_status/'.$this->input->post('id'),'location');
    }

    //我方工单
     public function insert_work_order(){
        $gd=array(
            'station_id'=>$this->input->post('station_id'),
            'creator_id'=>$this->session->userdata('user_id'),
            'dispatcher_id'=>$this->input->post('dispatcher_id'),
            'creator_remark'=>$this->input->post('creator_remark'),
            'create_time'=>mdate("%Y-%m-%d %H:%i:%s",time()),
            'status'=>ESC_WORK_ORDER__CREATE,
            'third_party'=>ESC_WORK_ORDER_WE
        );
        
        $this->db->insert('work_orders',$gd);
        //获取新插入数据库的id值
        $work_order_id = mysql_insert_id();        
            
        redirect('maintain/work_order/work_order_status/'.$work_order_id,'location');
    }

    //我方工单页
    public function work_order_status($work_order_id){        
        $result = $this->work_order->find_sql($work_order_id);
        $result['title'] = "我方工单";
        $result['bug_types'] = $this->bug->findBugByStationUntilTime($result['station_id'],time());
        $result['station_name_chn'] = $this->station->getStationNameChn($result['station_id']);
        $result['create_name_chn'] = $this->user->getUserNameChn($result['creator_id']);
        $result['address_name_chn'] = $this->station->getStationAddressNameChn($result['station_id']);
        $result['dispatcher_name_chn'] = $this->user->getUserNameChn($result['dispatcher_id']);
        $result['dispatcher_tel'] = $this->user->findUsertel_sql($result['dispatcher_id']);
        $this->load->view('templates/backend_header',$result);
        $this->load->view('maintain/home/menu');
        $this->load->view('maintain/work_order/work_order_status');
        $this->load->view('templates/backend_footer');

    }

     public function modify_work_order($work_order_id){
        $data = $this->work_order->find_sql($work_order_id);
        $data['title']="修改我方工单";
        $data['station_name_chn'] = $this->station->getStationNameChn($data['station_id']);
        $data['creator_name_chn'] = $this->user->getUserNameChn($data['creator_id']);
        $data['bug_types'] = $this->bug->findBugByStationUntilTime($data['station_id'],time());
        $data['dispatcher_tel'] = $this->user->findUsertel_sql($data['dispatcher_id']);
        //所有维修人
        $data['dispatchers'] = $this->user->findDepartment(ESC_DEPARTMENT_OPERATION_SERVICE);
        $this->load->view('templates/backend_header',$data);
        $this->load->view('maintain/home/menu');
        $this->load->view('maintain/work_order/modify_work_order');
        $this->load->view('templates/backend_footer');
    }

    public function update_work_order(){       
        $data=array(
            'dispatcher_id'=>$this->input->post('dispatcher_id'),
            'creator_remark'=>$this->input->post('creator_remark')
        );
                 
        $this->db->where('id',$this->input->post('id'));
        $this->db->update('work_orders',$data);
        redirect('maintain/work_order/work_order_status/'.$this->input->post('id'),'location');   

    }

    //生成工单
    public function new_orders($cur_page = 1){
        $this->dt['title'] = '生成工单未确定';
        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20; 

        //下拉菜单的数据
        $this->dt['projects'] = $this->project->getMaintainProjects();
        $this->dt['station_creators'] = $this->user->findDepartment(ESC_DEPARTMENT_STATION_SURPERVISE);
        $this->dt['cities'] = ($this->input->get('project_id')>0)?$this->area->findProjectCities_sql($this->input->get('project_id')):$this->area->findAll_sql();
        $this->dt['work_order_creators'] = $this->user->findDepartment(ESC_DEPARTMENT_OPERATION_MONITOR);
        $this->dt['work_order_dispatchers'] = $this->user->findDepartment(ESC_DEPARTMENT_OPERATION_SERVICE);


        //过滤条件
        $conditions = array();
        //固定过滤条件 未被删除的基站 
        $conditions['s.recycle ='] = ESC_NORMAL;
        //固定过滤条件 当前工单状态
        $conditions['t.status ='] = ESC_WORK_ORDER__CREATE;
        $conditions['t.third_party ='] = ESC_WORK_ORDER_WE;    

        $conditions['s.project_id ='] = $this->input->get('project_id');
        $conditions['s.station_type ='] = $this->input->get('station_type');
        $conditions['s.city_id ='] = $this->input->get('city_id');
        $conditions['s.creator_id ='] = $this->input->get('station_creator_id');
        $conditions['t.creator_id ='] = $this->input->get('creator_id');
        $conditions['t.dispatcher_id ='] = $this->input->get('dispatcher_id');
        $conditions['s.id ='] = $this->input->get('station_ids');
        if($this->input->get('search')){
            $conditions['s.name_chn like'] = '\'%'.trim($this->input->get('search')).'%\'';
        }
        
        $orders = array("s.bug_point"=>" desc");
        $station_params = array("s.name_chn"=>"s_name_chn","station_type"=>"station_type","city_id"=>"city_id","s.creator_id"=>"s_creator_id");
        $res = $this->work_order->pagination_sql_stations($conditions,$orders,$cur_page,$per_page,$station_params );
        $stations = $res['res'];

        $has_bug_stations = array();

        foreach($stations as $station){
             $station['city_name_chn'] = $this->area->getCityNameChn($station['city_id']);
             $bugs = $this->bug->find_stationid_sql($station['station_id']);    
             $station['bug_name_chn'] = h_bug_return_bugs_msg($bugs); 

             //城市名
             $station['city_name_chn'] = $this->area->getCityNameChn($station['city_id']);
             //督导（建站者）
             $station['station_creator_name_chn'] = $this->user->getUserNameChn($station['s_creator_id']);   
             //监控
             $station['work_order_creator_name_chn'] = $this->user->getUserNameChn($station['creator_id']);
             //维修
             $station['dispatcher_name_chn'] = $this->user->getUserNameChn($station['dispatcher_id']);
             $has_bug_stations[]=$station;   
        }
        $this->dt['datas'] = $has_bug_stations;
        //分页
        $config['base_url'] = '/maintain/work_order/new_orders';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $res['num'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();
        $this->dt['filter_num_str'] = h_filter_num_str($config['total_rows'],$cur_page,$per_page);

        $this->load->view('templates/maintain_header',$this->dt);
        $this->load->view('maintain/home/menu');         
        $this->load->view('maintain/work_order/menu');         
        $this->load->view('maintain/work_order/new_orders');         
        $this->load->view('templates/maintain_footer');   

    }


    //确认工单
    public function confirme_orders($cur_page = 1){
        $this->dt['title'] = '已确认工单';
        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20; 

        //下拉菜单的数据
        $this->dt['projects'] = $this->project->getMaintainProjects();
        $this->dt['station_creators'] = $this->user->findDepartment(ESC_DEPARTMENT_STATION_SURPERVISE);
        $this->dt['cities'] = ($this->input->get('project_id')>0)?$this->area->findProjectCities_sql($this->input->get('project_id')):$this->area->findAll_sql();
        $this->dt['work_order_creators'] = $this->user->findDepartment(ESC_DEPARTMENT_OPERATION_MONITOR);
        $this->dt['work_order_dispatchers'] = $this->user->findDepartment(ESC_DEPARTMENT_OPERATION_SERVICE);


        //过滤条件
        $conditions = array();
        //固定过滤条件 未被删除的基站 
        $conditions['s.recycle ='] = ESC_NORMAL;
        //固定过滤条件 当前工单状态
        $conditions['t.status ='] = ESC_WORK_ORDER__CONFIRM;    
        $conditions['t.third_party ='] = ESC_WORK_ORDER_WE;

        $conditions['s.project_id ='] = $this->input->get('project_id');
        $conditions['s.station_type ='] = $this->input->get('station_type');
        $conditions['s.city_id ='] = $this->input->get('city_id');
        $conditions['s.creator_id ='] = $this->input->get('station_creator_id');
        $conditions['t.creator_id ='] = $this->input->get('creator_id');
        $conditions['t.dispatcher_id ='] = $this->input->get('dispatcher_id');
        $conditions['s.id ='] = $this->input->get('station_ids');
        if($this->input->get('search')){
            $conditions['s.name_chn like'] = '\'%'.trim($this->input->get('search')).'%\'';
        }
        
        $orders = array("s.bug_point"=>" desc");
        $station_params = array("s.name_chn"=>"s_name_chn","station_type"=>"station_type","city_id"=>"city_id","s.creator_id"=>"s_creator_id");
        $res = $this->work_order->pagination_sql_stations($conditions,$orders,$cur_page,$per_page,$station_params );
        $stations = $res['res'];

        $has_bug_stations = array();
        foreach($stations as $station){
             $station['city_name_chn'] = $this->area->getCityNameChn($station['city_id']);
             $bugs = $this->bug->find_stationid_sql($station['station_id']);    
             $station['bug_name_chn'] = h_bug_return_bugs_msg($bugs); 
             //城市名
             $station['city_name_chn'] = $this->area->getCityNameChn($station['city_id']);
             //督导（建站者）
             $station['station_creator_name_chn'] = $this->user->getUserNameChn($station['s_creator_id']);   
             //监控
             $station['work_order_creator_name_chn'] = $this->user->getUserNameChn($station['creator_id']);
             //维修
             $station['dispatcher_name_chn'] = $this->user->getUserNameChn($station['dispatcher_id']);
             $has_bug_stations[]=$station;   
        }
        $this->dt['datas'] = $has_bug_stations;
        //分页
        $config['base_url'] = '/maintain/work_order/confirme_orders';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $res['num'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();
        $this->dt['filter_num_str'] = h_filter_num_str($config['total_rows'],$cur_page,$per_page);

        $this->load->view('templates/maintain_header',$this->dt);
        $this->load->view('maintain/home/menu');         
        $this->load->view('maintain/work_order/menu');         
        $this->load->view('maintain/work_order/confirme_orders');         
        $this->load->view('templates/maintain_footer');   

    }

    //已修复工单
    public function fixed_orders($cur_page = 1){
        $this->dt['title'] = '已修复工单';
        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20; 

        //下拉菜单的数据
        $this->dt['projects'] = $this->project->getMaintainProjects();
        $this->dt['station_creators'] = $this->user->findDepartment(ESC_DEPARTMENT_STATION_SURPERVISE);
        $this->dt['cities'] = ($this->input->get('project_id')>0)?$this->area->findProjectCities_sql($this->input->get('project_id')):$this->area->findAll_sql();
        $this->dt['work_order_creators'] = $this->user->findDepartment(ESC_DEPARTMENT_OPERATION_MONITOR);
        $this->dt['work_order_dispatchers'] = $this->user->findDepartment(ESC_DEPARTMENT_OPERATION_SERVICE);


        //过滤条件
        $conditions = array();
        //固定过滤条件 未被删除的基站 
        $conditions['s.recycle ='] = ESC_NORMAL;
        //固定过滤条件 当前工单状态
        $conditions['t.status ='] = ESC_WORK_ORDER__FIX;    
        $conditions['t.third_party ='] = ESC_WORK_ORDER_WE;
        
        $conditions['s.project_id ='] = $this->input->get('project_id');
        $conditions['s.station_type ='] = $this->input->get('station_type');
        $conditions['s.city_id ='] = $this->input->get('city_id');
        $conditions['s.creator_id ='] = $this->input->get('station_creator_id');
        $conditions['t.creator_id ='] = $this->input->get('creator_id');
        $conditions['t.dispatcher_id ='] = $this->input->get('dispatcher_id');
        $conditions['s.id ='] = $this->input->get('station_ids');
        if($this->input->get('search')){
            $conditions['s.name_chn like'] = '\'%'.trim($this->input->get('search')).'%\'';
        }
        
        $orders = array("s.bug_point"=>" desc");
        $station_params = array("s.name_chn"=>"s_name_chn","station_type"=>"station_type","city_id"=>"city_id","s.creator_id"=>"s_creator_id");
        $res = $this->work_order->pagination_sql_stations($conditions,$orders,$cur_page,$per_page,$station_params );
        $stations = $res['res'];

        $has_bug_stations = array();
        foreach($stations as $station){
             $station['city_name_chn'] = $this->area->getCityNameChn($station['city_id']);
             $bugs = $this->bug->find_stationid_sql($station['station_id']);    
             $station['bug_name_chn'] = h_bug_return_bugs_msg($bugs); 
             //城市名
             $station['city_name_chn'] = $this->area->getCityNameChn($station['city_id']);
             //督导（建站者）
             $station['station_creator_name_chn'] = $this->user->getUserNameChn($station['s_creator_id']);   
             //监控
             $station['work_order_creator_name_chn'] = $this->user->getUserNameChn($station['creator_id']);
             //维修
             $station['dispatcher_name_chn'] = $this->user->getUserNameChn($station['dispatcher_id']);
             $has_bug_stations[]=$station;   
        }
        $this->dt['datas'] = $has_bug_stations;
        //分页
        $config['base_url'] = '/maintain/work_order/fixed_orders';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $res['num'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();
        $this->dt['filter_num_str'] = h_filter_num_str($config['total_rows'],$cur_page,$per_page);

        $this->load->view('templates/maintain_header',$this->dt);
        $this->load->view('maintain/home/menu');         
        $this->load->view('maintain/work_order/menu');         
        $this->load->view('maintain/work_order/fixed_orders');         
        $this->load->view('templates/maintain_footer');   

    }


    public function third_party($cur_page=1){
        $this->dt['title'] = '第三方工单';
        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20; 

        //下拉菜单的数据
        $this->dt['projects'] = $this->project->getMaintainProjects();
        $this->dt['station_creators'] = $this->user->findDepartment(ESC_DEPARTMENT_STATION_SURPERVISE);
        $this->dt['cities'] = ($this->input->get('project_id')>0)?$this->area->findProjectCities_sql($this->input->get('project_id')):$this->area->findAll_sql();
        $this->dt['work_order_creators'] = $this->user->findDepartment(ESC_DEPARTMENT_OPERATION_MONITOR);

        //过滤条件
        $conditions = array();
        //固定过滤条件 未被删除的基站 
        $conditions['s.recycle ='] = ESC_NORMAL;
        //固定过滤条件 当前工单状态
        $conditions['t.status ='] = ESC_WORK_ORDER__CREATE; 
        $conditions['t.third_party ='] = ESC_WORK_ORDER_THIRD_PARTY;   

        $conditions['s.project_id ='] = $this->input->get('project_id');
        $conditions['s.station_type ='] = $this->input->get('station_type');
        $conditions['s.city_id ='] = $this->input->get('city_id');
        $conditions['s.creator_id ='] = $this->input->get('station_creator_id');
        $conditions['t.creator_id ='] = $this->input->get('creator_id');
        $conditions['s.id ='] = $this->input->get('station_ids');
        if($this->input->get('search')){
            $conditions['s.name_chn like'] = '\'%'.trim($this->input->get('search')).'%\'';
        }
        $orders = array();
        $station_params = array("s.name_chn"=>"s_name_chn","station_type"=>"station_type","city_id"=>"city_id","s.creator_id"=>"s_creator_id");
        $res = $this->work_order->pagination_sql_stations($conditions,$orders,$cur_page,$per_page,$station_params );
        $stations = $res['res'];
        $has_bug_stations = array();
        foreach($stations as $station){
             $station['city_name_chn'] = $this->area->getCityNameChn($station['city_id']);
             $bugs = $this->bug->find_stationid_sql($station['station_id']);    
             $station['bug_name_chn'] = h_bug_return_bugs_msg($bugs); 
             //城市名
             $station['city_name_chn'] = $this->area->getCityNameChn($station['city_id']);
             //督导（建站者）
             $station['station_creator_name_chn'] = $this->user->getUserNameChn($station['s_creator_id']);   
             //监控
             $station['work_order_creator_name_chn'] = $this->user->getUserNameChn($station['creator_id']);
             //维修
             $station['dispatcher_name_chn'] = $this->user->getUserNameChn($station['dispatcher_id']);
             $has_bug_stations[]=$station;   
        }
        $this->dt['datas'] = $has_bug_stations;
        //分页
        $config['base_url'] = '/maintain/work_order/third_party';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $res['num'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();
        $this->dt['filter_num_str'] = h_filter_num_str($config['total_rows'],$cur_page,$per_page);

        //分页
        $config['base_url'] = '/maintain/work_order/new_orders';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $res['num'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();
        $this->dt['filter_num_str'] = h_filter_num_str($config['total_rows'],$cur_page,$per_page);

        $this->load->view('templates/maintain_header',$this->dt);
        $this->load->view('maintain/home/menu');         
        $this->load->view('maintain/work_order/menu');         
        $this->load->view('maintain/work_order/third_party');         
        $this->load->view('templates/maintain_footer');   

    }

    public function ajax_get_areas(){
        if(!$this->input->get("project_id")){
            $query = $this->db->query("select id,name_chn from areas");
            $result = $query->result_array();
            array_unshift($result,array("id"=>0,"name_chn"=>"全部"));
        }else{
            $query = $this->db->query("select city_list from projects where id =?",array($this->input->get("project_id")));       
            $result = $query->row_array();
            $query = $this->db->query("select * from areas where id in (".$result['city_list'].")");
            $result = $query->result_array();
        }    
        echo json_encode($result);
    }


    //工单系统
    public function add_work_order($station_id){
        $data['title'] = "分发工单";
        //得到基站的名字
        $data['name_chn'] = $this->station->getStationNameChn($station_id);
        $data['station_id'] = $station_id;
        //获取监控人姓名
        $data['creator_name_chn'] = $this->curr_user['name_chn'];
        //获取故障类型
        //附加一条维护部的成员
        $data['dispatchers'] = $this->user->findDepartment(ESC_DEPARTMENT_OPERATION_SERVICE);
        $data['bug_types'] = $this->bug->findBugByStationUntilTime($station_id,time());
        $this->load->view('templates/backend_header',$data);
        $this->load->view('maintain/home/menu');
        $this->load->view('maintain/work_order/add_work_order');
        $this->load->view('templates/backend_footer');
    }
    
   
     
   

    
    



    //工单详情
    public function work_order_detail($work_order_id){
        $result = $this->work_order->find_sql($work_order_id);
        $result['title'] = "我方工单";
        $result['bug_types'] = $this->bug->findBugByStationUntilTime($result['station_id'],time());
        $result['station_name_chn'] = $this->station->getStationNameChn($result['station_id']);
        $station = $this->station->find_sql($result['station_id']);
        $result['create_name_chn'] = $this->user->getUserNameChn($result['creator_id']);
        $result['address_name_chn'] = $station['address_chn'];
        $result['dispatcher_name_chn'] = $this->user->getUserNameChn($result['dispatcher_id']);
        $result['dispatcher_tel'] = $this->user->findUsertel_sql($result['dispatcher_id']);
        $this->load->view('templates/backend_header',$result);
        $this->load->view('maintain/home/menu');
        $this->load->view('maintain/work_order/work_order_detail');
        $this->load->view('templates/backend_footer');

    }
    
    //查找维修人员
    public function find_user_id(){
        $data = $this->user->find_sql($this->input->get('dispatcher_id'));
        echo json_encode($data);
    }
	
	
    //work_order_list
    public function work_order_list($cur_page=1){
        $data['title'] = "工单列表";
        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):10;	
        $conditions = array();
        //$conditions['type ='] = $this->input->get('type');
        $conditions['create_time >'] = $this->input->get('create_start_time');
        $conditions['create_time <'] = $this->input->get('create_stop_time');
		//$condtitions['dispatcher_id']= 73;
		
        $orders = array("id"=>"desc");
		//pagination_sql是分页函数
        $paginator =  $this->work_order->pagination_sql($conditions,$orders,$per_page,$cur_page);
        //分页
        $config['base_url'] = '/maintain/work_order/work_order_list';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config); 
        $data['pagination'] = $this->pagination->create_links();
        $data['work_orders']=$paginator['res'];
        foreach($data['work_orders'] as &$work_order){
            $work_order['station_name_chn'] = $this->station->getStationNameChn($work_order['station_id']);
	        $station = $this->station->find_sql($work_order['station_id']);
            $work_order['station_type'] = $station['station_type'];
		}
		
        $this->load->view('templates/maintain_header',$data);
        $this->load->view('maintain/home/menu');
        $this->load->view('maintain/work_order/work_order_list');
        $this->load->view('templates/maintain_footer');  
    }

	
	

    //工单的提示信息ajax联动
    public function ajax_work_list(){
        $result = $this->work_order->findOneDispatcherWorkOrder_sql($this->session->userdata('user_id'));
        echo json_encode($result);
    }

    //刷新故障
    public function ajax_get_new_bugs(){
        $query = $this->db->query("select * from bugs where status=? and start_time>?",array(ESC_BUG_STATUS__OPEN,date("Y-m-d H:i:s",$this->input->get("currentTime"))));
        echo json_encode($query->result_array());
    }

    //关闭我方工单
    public function before_close_work_order($work_order_id){
        if(!$work_order_id){    
        }else{
            $data = $this->work_order->find_sql($work_order_id);
            if($this->session->userdata('user_id')!=$data['creator_id']){
                echo "<script>您没有该操作权限</script>";
                redirect('maintain/work_order/fixed_orders','location');
            }
            $data['station_name_chn'] = $this->station->getStationNameChn($data['station_id']);
            $data['creator_name_chn'] = $this->user->getUserNameChn($data['creator_id']);
            $data['dispatcher_name_chn'] = $this->user->getUserNameChn($data['dispatcher_id']);
            $this->load->view('templates/maintain_header',$data);
            $this->load->view('maintain/home/menu');
            $this->load->view('maintain/work_order/before_close_work_order');
            $this->load->view('templates/maintain_footer');
        }
    }

    public function close_work_order(){
        //根据基站id查看故障是否消失，若消失，则说明修复完毕
        $bugs = $this->bug->findBugByStationUntilTime($this->input->post('station_id'),time());
        $is_repaired = ESC_WORK_ORDER_REPAIRED;
        if(count($bugs)){
            $is_repaired = ESC_WORK_ORDER_NO_REPAIRED;
        }
        $gd=array(
            'creator_repair_remark'=>$this->input->post('creator_repair_remark'),
            'confirm_fix_time'=>mdate("%Y-%m-%d %H:%i:%s",time()),
            'status'=>ESC_WORK_ORDER__CLOSE,
            'is_history'=>ESC_WORK_ORDER_HISTORY,
            'is_repaired'=>$is_repaired
        );
        $this->db->where('id',$this->input->post('work_order_id'));
        $this->db->update('work_orders',$gd);

        redirect('maintain/work_order/fixed_orders','location');
    }

    //关闭第三方工单、
    public function close_third_party($work_order_id){
        //根据基站id查看故障是否消失，若消失，则说明修复完毕
        $work_order = $this->work_order->find_sql($work_order_id);
        if($this->session->userdata('user_id')!=$work_order['creator_id']){
                redirect('maintain/work_order/third_party','location');
            }
        $gd=array(
            'confirm_fix_time'=>mdate("%Y-%m-%d %H:%i:%s",time()),
            'status'=>ESC_WORK_ORDER__CLOSE,
            'is_history'=>ESC_WORK_ORDER_HISTORY
        );
        $this->db->where('id',$work_order_id);
        $this->db->update('work_orders',$gd);

        redirect('maintain/work_order/third_party','location');
    }
}
