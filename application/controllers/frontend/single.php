<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/********************************
  [Controller Station]
  ./../../models/Entities/Station.php
  ./../../models/station.php
  ./../../../tests/controllers/StationControllerTest.php
 ********************************/

class Single_controller extends Frontend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('fake','chart','text', 'single', 'station',));
        $this->load->model(array('daydata','monthdata', 'data', 'station','fixdata',
            'correct','weather','area','mid/mid_energy','mid/mid_data','mid/mid_station','station_log'));
        $this->load->library('pagination');
    }

    

    public function day($station_id) {
        $station = $this->station->getAndCheckStation($station_id);
        $this->input->set_cookie('current_city_id', $station['city_id'], 86000);
        $this->input->set_cookie('current_station_id', $station_id, 86000);
        
        // 此处需要统一或者提供界面按项目进行设置
        if ($this->current_project['id'] == 112 ) { 
            $time_str = $this->input->get("time") ? 
                $this->input->get("time") : h_dt_date_str_db("now");    // time 为空时，上海项目要求设置为今日
        } else {
            $time_str = $this->input->get("time") ? 
                $this->input->get("time") : h_dt_date_str_db("-1 day"); // time 为空时，显示昨天数据
        }
        
        if (h_dt_is_future($time_str)) {
            $time_str = h_dt_date_str_db("now");
        }

        $this->dt['title'] = $station['name_chn']." 日图表";
        $this->dt['levels'] = $this->input->get('levels')?$this->input->get('levels'):'3-1-1-1-0-1'; //功率图应该显示详细信息，否则误差大
        $this->dt['level'] = explode('-',$this->dt['levels']);
        $this->dt['time_disp'] = h_dt_date_str_no_time("");
        $this->dt['station_info'] = $this->get_station_info($station_id);
        $this->dt['station'] = $this->mid_station->onestation_detail_customed($station_id);
        $this->dt['city'] = $this->area->find_sql($station['city_id']);
        $this->dt['time_disp'] = h_dt_format($time_str,"Y-m-d");

        //获取所有数据
        $this->dt += $this->mid_data->generateDayDataList($station_id,$time_str, $this->dt['levels']);

        $this->load->view('templates/frontend_header', $this->dt);
        if ($this->current_project['type'] == ESC_PROJECT_TYPE_STANDARD_SAVING_SH) {
            $this->load->view('frontend/single/detail_menu');
        } else {
            $this->load->view('frontend/single/menu');
        }
        $this->load->view('frontend/single/day');
        $this->load->view('templates/frontend_footer');
    }
    
    public function data() {
        if ($this->input->get('station_id')) {
            $station_id = $this->input->get('station_id');
            $this->dt['station'] = $this->mid_station->onestation_detail_customed($station_id);
            $this->dt['title'] = $this->dt['station']['name_chn']." 原始数据 ";
        } else {
            show_error("请指定基站ID"); 
        }
        $datetime = $this->input->get("time")?$this->input->get("time"):'now';
        $type     = $this->input->get('type')?$this->input->get('type'):"recent";
        $compress = $this->input->get('compress')?$this->input->get('compress'):"1";

        //最近的数据
        if( $type == "recent"){
            $datas = $this->mid_data->findRecentDatas($station_id);
        //某小时的数据
        }else if( $type == "hour"){
            $datas = $this->mid_data->findHourDatas($station_id,$datetime);
            krsort($datas);
        //某天的数据
        }else if( $type == "day"){
            $datas = $this->mid_data->findDayDatas($station_id,$datetime);
            krsort($datas);
        }
        
        $data_x_time = $this->mid_data->dataXtimeHash($datas,6);
        $this->dt['data_x_time'] = $data_x_time;
        
        if($compress > 1){
            $compressed = array();
            foreach($datas as $key=>$data){
                if($key % $compress == 0){
                    $compressed[] = $data;
                }
            }
            $datas = $compressed;
        }

        $this->dt['type']       = $type;
        $this->dt['datas']      = $datas;
        $this->dt['datetime']   = $datetime;
        
        
        $this->load->view('templates/frontend_header', $this->dt);
        $this->load->view('frontend/single/detail_menu');
        $this->load->view('frontend/single/data');
        $this->load->view('templates/frontend_footer');
    }

    public function month($station_id = 16) {
        $station = $this->station->getAndCheckStation($station_id);

        $tmp_err = "";
        $city = $this->area->find_sql($station['city_id']);
        $_time_str = $this->input->get("time") ? $this->input->get("time") : h_dt_now();
        $month = h_dt_start_time_of_month($_time_str);
        $fixdatas = $this->fixdata->findFixDatasHash(
                $station_id,$month,h_dt_stop_time_of_month($month));

        if (ESC_STATION_TYPE_NPLUSONE == $station['station_type']) {

            $day_datas = $this->mid_data->findNp1StationDaydatas($station['id'],
                $month,h_dt_stop_time_of_month($month));
            $this->dt['day_datas'] = $day_datas;
        
        }else{
            $daydatas = $this->daydata->findDayDatasHash(
                        $station_id,$month,h_dt_stop_time_of_month($month));
            $monthdata = $this->monthdata->findOneBy_sql(
                array("station_id"=>$station_id,"datetime"=>$month));
            foreach ($daydatas as $time => $daydata){
                $daydatas[$time]['fixdata'] = isset($fixdatas[$time])?
                    $fixdatas[$time]:null;
            }

            $month_saving_rate = $this->savpair->getOneAverageSavingRate(
                $station['project_id'],
                $station['city_id'],
                $station['building'],
                $month,
                $station['total_load']);
            $this->dt['month_saving_rate'] = $month_saving_rate ;

            foreach ($daydatas as $time => $daydata){
                if(ESC_STATION_TYPE_STANDARD == $station['station_type']){
                    $daydatas[$time]['rate'] = null;
                }else if(h_dt_is_time_this_month($month)){
                    $daydatas[$time]['rate'] = null;
                }else{
                    $daydatas[$time]['rate'] = $month_saving_rate;
                }
            }
            $this->dt['monthdata'] = $monthdata;
            $this->dt['daydatas'] = $daydatas;
        }

        $this->dt['title'] = $station['name_chn']." 月节能 ";
        $this->dt['station'] = $station;
        $this->dt['city'] = $city;
        $this->dt['current_month'] = h_dt_format($month);
        $this->dt['time_disp'] = h_dt_format($month,'Y年m月');;
        $this->dt['tmp_err'] = $tmp_err;

        $this->load->view('templates/frontend_header', $this->dt);
        $this->load->view('frontend/single/menu');
        $this->load->view('frontend/single/month');
        $this->load->view('templates/frontend_footer');
    }
    
    public function energy() {
        if ($this->input->get('station_id')) {
            $station = $this->mid_station->onestation_detail_customed($this->input->get('station_id'));
            $this->dt['station'] = $station;
            $station_id = $this->input->get('station_id');
            $this->dt['title'] =  $this->dt['station']['name_chn']." 能耗列表 ";
        } else {
            show_error("请指定基站ID"); 
        }

        $tmp_err = "";
        $city = $this->area->find_sql($station['city_id']);
        $_time_str = $this->input->get("time") ? $this->input->get("time") : h_dt_now();
        $month = h_dt_start_time_of_month($_time_str);
        $fixdatas = $this->fixdata->findFixDatasHash(
                $station_id,$month,h_dt_stop_time_of_month($month));

        if (ESC_STATION_TYPE_NPLUSONE == $station['station_type']) {

            $day_datas = $this->mid_data->findNp1StationDaydatas($station['id'],
                $month,h_dt_stop_time_of_month($month));
            $this->dt['day_datas'] = $day_datas;
        
        }else{
            $daydatas = $this->daydata->findDayDatasHash(
                        $station_id,$month,h_dt_stop_time_of_month($month));
            $monthdata = $this->monthdata->findOneBy_sql(
                array("station_id"=>$station_id,"datetime"=>$month));

            foreach ($daydatas as $time => $daydata){
                $daydatas[$time]['fixdata'] = isset($fixdatas[$time])?
                    $fixdatas[$time]:null;
            }

            $month_saving_rate = $this->savpair->getOneAverageSavingRate(
                $station['project_id'],
                $station['city_id'],
                $station['building'],
                $month,
                $station['total_load']);
            $this->dt['month_saving_rate'] = $month_saving_rate ;

            foreach ($daydatas as $time => $daydata){
                if(ESC_STATION_TYPE_STANDARD == $station['station_type']){
                    $daydatas[$time]['rate'] = null;
                }else if(h_dt_is_time_this_month($month)){
                    $daydatas[$time]['rate'] = null;
                }else{
                    $daydatas[$time]['rate'] = $month_saving_rate;
                }
            }
            $this->dt['monthdata'] = $monthdata;
            $this->dt['daydatas'] = $daydatas;
        }

        $this->dt['city'] = $city;
        $this->dt['current_month'] = h_dt_format($month);
        $this->dt['time_disp'] = h_dt_format($month,'Y年m月');;
        $this->dt['tmp_err'] = $tmp_err;
        
        $this->load->view('templates/frontend_header', $this->dt);
        $this->load->view('frontend/single/detail_menu');
        $this->load->view('frontend/single/energy');
        $this->load->view('templates/frontend_footer');
    }
    public function sync_meter() {
        $station_id = $this->input->get('station_id');
        $station = $this->station->find_sql($station_id);
        $this->dt['title'] = $station["name_chn"]." 电表同步 ";
        
        $this->dt['time_disp'] = $this->input->get("time") ? 
            $this->input->get("time") :  h_dt_format(h_dt_now(),"Y-m-d H:i"); // time 为空时，显示昨天数据
        $this->dt['station'] = $this->mid_station->onestation_detail_customed($station_id);
        $this->dt['corrects'] = $this->correct->findBy_sql(
            array("station_id"=>$station['id']),array("time desc"));
        //hp($this->dt['corrects']);
        
        $this->load->view('templates/frontend_header', $this->dt);
        $this->load->view('frontend/single/detail_menu');
        $this->load->view('frontend/single/sync_meter');
        $this->load->view('templates/frontend_footer');
    }
    
    // 尝试增加一条基站电表记录, 10分钟以内最早的一个
    // xx 针对上海项目，需要同时记录上一次采集的数据
    public function add_meter_record() {
        $station_id = $this->input->get('station_id');
        $time = $this->input->get('time');
        $_data = $this->mid_data->findSometimeData($station_id,$time,10);
        if($_data){
            $correct_num = $this->input->get('meter_sample');
            $org_num = $_data['energy_main'];
            $time = h_dt_format($this->input->get('time'));
            $this->correct->insert_new_record($station_id,$correct_num,$org_num,$time);

           //计算这次同步电表后的同步参数, xxx 此处需要重新处理
           $this->correct->calc_last_correct($station_id);
           redirect(urldecode("/frontend/single/sync_meter?station_id=".$station_id), 'location');
        }else{
            h_message_goto("查询[".$this->input->get('time')."]无智能电表数据,请确认抄表日期和时间！");
        }
    }
    

    public function blog($cur_page = 1) {
        $this->dt['users'] = $this->user->findBy_sql(array());

        if ($this->input->get('station_id')) {
            $this->dt['station'] = $this->mid_station->onestation_detail_customed($this->input->get('station_id'));
            $this->dt['title'] = $this->dt['station']['name_chn']." 维护日志 ";
        } else {
            $this->dt['station'] = null;
        }

        $conditions['station_id = '] = $this->input->get('station_id');
        $conditions['author_id = '] = $this->input->get('author_id');
        if ($this->input->get('start_time')) {
            $conditions['create_time >'] = h_dt_format($this->input->get('start_time'));
        }
        
        if($this->input->get('stop_time')) { 
            $conditions['create_time <='] = h_dt_stop_time_of_day($this->input->get('stop_time'));
        }
        $per_page = $this->input->get('per_page') ? $this->input->get('per_page') : 30;
        $orders = array("create_time" => "desc");
        $paginator = $this->blog->pagination_sql($conditions, $orders, $per_page, $cur_page);

        $config['base_url'] = '/frontend/single/blog';
        $config['suffix'] = "?" . $_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'] . $config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $this->dt['pagination'] = $this->pagination->create_links();
        $this->dt['blogs'] = $paginator['res'];

        foreach ($this->dt['blogs'] as &$blog) {
            $station = $this->station->find_sql($blog['station_id']);
            $user = $this->user->find_sql($blog['author_id']);
            $blog['station_name_chn'] = $station ? $station['name_chn'] : "";
            $blog['author_name_chn'] = $user ? $user['name_chn'] : "";
        }

        $this->load->view('templates/frontend_header', $this->dt);
        $this->load->view('frontend/single/detail_menu');
        $this->load->view('frontend/single/blog');
        $this->load->view('templates/frontend_footer');
    }
    
    public function station_blog_add($station_id) {
        $this->blog->insert(array(
            'author_id' => $this->curr_user['id'],
            'station_id'=> $station_id,
            'content'   => $this->input->post('content'),
            'blog_type' => $this->input->post('type')));
        $this->session->set_flashdata('flash_succ', '添加成功!');
        redirect('/frontend/single/blog?station_id=' . $station_id, 'location');
     
    }
    
    public function del_blog() {
        $this->blog->del_sql($this->uri->segment(4));
        $this->session->set_flashdata('flash_succ', '删除成功!');
        redirect(urldecode($this->input->get('baseurl')), 'location');
    }
    
    public function mod_blog() {   
        $this->dt['mod'] = true;
        $blog = $this->blog->find_sql($this->uri->segment(4));
        $this->dt['blog'] = $blog;
        $this->dt['content'] = $blog['content'];
        $this->dt['station'] = $this->station->find_sql($blog['station_id']);
        $this->dt['user'] = $this->curr_user;
        
        if ($blog['station_id'] > 0) {
            $this->dt['title'] = $this->dt['station']['name_chn']." 更新日志 ";
        } 
        
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/blog/mod_blog');
        $this->load->view('templates/backend_footer');
    }

    public function update_blog() {
        $this->blog->update_sql($this->input->post('id'),array(
            'content'   => $this->input->post('content'),
            'blog_type' => $this->input->post('type')));
        $this->session->set_flashdata('flash_succ', '修改很成功!');
        redirect(urldecode($this->input->get('backurl')), 'location');
    }
    
    public function bug($cur_page = 1){
        $station_id = $this->input->get('station_id');
        if($station_id){
            $station = $this->mid_station->onestation_detail_customed($station_id); 
            $this->dt['title'] = $station['name_chn']." 故障列表 ";
        }else{
            echo "Wrong URLs, no station_id";
            return;
        }

        $this->dt['station'] = $station;            
        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;
        $conditions = array();
        $conditions['station_id = '] = $station_id;
        $conditions['type ='] = $this->input->get('type');
        $conditions['status ='] = $this->input->get('status');
        if ($this->input->get('create_start_time')) {
            $conditions['start_time >'] = h_dt_format($this->input->get('create_start_time'));
        }
        
        if($this->input->get('create_stop_time')) { 
            $conditions['start_time <='] = h_dt_stop_time_of_day($this->input->get('create_stop_time'));
        }
        $orders = array("id"=>"desc");
        $paginator =  $this->bug->pagination_sql($conditions,$orders,$per_page,$cur_page);
        // check and modify front bugs   
        if($paginator['res']) {
            $bugs = h_get_front_display_bugs($paginator['res']);
            $paginator['res'] = $bugs;
            $paginator['num'] = count($bugs);
        }     
        
        //config pagination
        $config['base_url'] = '/frontend/single/bug';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] =$paginator['num'];
        $config['per_page'] = $per_page; 

        $this->pagination->initialize($config);   
        $this->dt['pagination'] = $this->pagination->create_links();    
        $this->dt['bugs'] = $paginator['res'];
        if($station && $station['alive'] == ESC_OFFLINE){
            $this->dt['dis_bugs'] = $this->bug->findBugsBeforeOffline($station['id']);
        }

        $this->load->view('templates/frontend_header', $this->dt);
        $this->load->view('frontend/single/detail_menu');
        $this->load->view('frontend/single/bug');
        $this->load->view('templates/frontend_footer');
    }
    
    public function station_log($cur_page=1){
        $station_id = $this->input->get('station_id');
        if(!$station_id || !$this->station->find_sql($station_id)){
            show_error('no station_id,error!');
        }
        $per_page = $this->input->get('per_page')?$this->input->get('per_page'):3;
        
        $this->dt['station'] =  $this->mid_station->onestation_detail_customed($station_id);
        $this->dt['title'] = $this->dt['station']['name_chn']." 历史修改记录 ";

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
        $this->load->view('templates/frontend_header', $this->dt);
        $this->load->view('frontend/single/detail_menu');
        $this->load->view('frontend/single/station_log');
        $this->load->view('templates/frontend_footer');
    }
    
    public function command($cur_page = 1) {
        $this->dt['users'] = $this->user->findBy_sql(array());

        if($this->input->get('station_id')){
            $this->dt['station'] = $this->mid_station->onestation_detail_customed($this->input->get('station_id'));
            $this->dt['title'] = $this->dt['station']['name_chn']." 命令列表 ";
        }else{
            $this->dt['station'] = null; 
        }

        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;     
        $conditions = array();
        $conditions['status ='] = $this->input->get('status');
        if($command = $this->input->get('command')){
            $conditions['command ='] = "'".$command."'";
        }
        $conditions['station_id = '] = $this->input->get('station_id');
        $user_name_chn = $this->input->get('user_name_chn');
        $user = $user_name_chn?$this->user->findOneBy_sql(array("name_chn" => $user_name_chn)):array();
        $conditions['user_id = '] = $user?$user['id']:"";
        $conditions['create_time >'] = h_dt_format($this->input->get('create_start_time'));
        $conditions['create_time <'] = h_dt_stop_time_of_day($this->input->get('create_stop_time'));
        $orders = array("id"=>"desc");
        $paginator =  $this->command->pagination_sql($conditions,$orders,$per_page,$cur_page);	 

        //config pagination
        $config['base_url'] = '/backend/command/index/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page'] = $per_page; 

        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();
        $this->dt['commands'] = $paginator['res'];
        foreach($this->dt['commands'] as &$command){
            $station = $this->station->find_sql($command['station_id']);
            $user = $this->user->find_sql($command['user_id']);
            $command['station_name_chn'] = $station?$station['name_chn']:""; 
            $command['user_name_chn'] = $user?$user['name_chn']:"";
        }
        
        $this->load->view('templates/frontend_header', $this->dt);
        $this->load->view('frontend/single/detail_menu');
        $this->load->view('frontend/single/command');
        $this->load->view('templates/frontend_footer');
    }

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // private functions
    //////////////////////////////////////////////////////////////////////////////////////////////////////////

    private function get_station_info($station_id) {
        $_gap_mins =  60;
        $_data = $this->mid_data->findRecentLast($station_id, $_gap_mins);
        $station_info = array(
            'last_indoor_tmp'=>'',
            'last_outdoor_tmp'=>'',
            'last_indoor_hum'=>'',
            'last_box_tmp'=>'',
            'last_fan_0_on'=>'',
            'last_colds_0_on'=>'',
            'last_colds_1_on'=>'',
            'last_energy_main'=>'',
            'last_energy_main_correct'=>'',
            'last_create_time'=>''
        );
        if($_data){
            $station_info['last_indoor_tmp'] =  $_data['indoor_tmp'];
            $station_info['last_outdoor_tmp'] =  $_data['outdoor_tmp'];
            $station_info['last_indoor_hum'] =  $_data['indoor_hum'];
            $station_info['last_box_tmp'] =  $_data['box_tmp'];
            $station_info['last_fan_0_on'] =  $_data['fan_0_on'];
            $station_info['last_colds_0_on'] =  $_data['colds_0_on'];
            $station_info['last_colds_1_on'] =  $_data['colds_1_on'];
            $station_info['last_energy_main'] =  $_data['energy_main'];
            $station_info['last_create_time'] =  $_data['create_time'];
            $correct = $this->correct->findLastCorrect($station_id);
            if($correct && h_available_slope($correct['slope'])){
                $station_info['last_energy_main_correct'] = round(
                        ($station_info['last_energy_main'] - $correct['base'])
                        * $correct['slope']
                        + $correct['correct_base']
                        , 2);
            }
        }
        return $station_info;
    }

}

