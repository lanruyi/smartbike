<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('esg','data','station','agingdata','restart','esg_command'));
    }

    public function index($cur_page = 1){
    	$this->dt['title'] = "老化系统";
        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;	

        $conditions = array();  
        $conditions['station_id is '] = 'null';
        $conditions['aging_status ='] = $this->input->get('aging_status');
        $conditions['alive ='] = $this->input->get('alive');      
        $conditions['aging_start_time >='] = h_dt_format($this->input->get('create_start_begin_time'));  
        $conditions['aging_start_time <='] = h_dt_stop_time_of_day($this->input->get('create_start_end_time'));      
        $conditions['aging_stop_time >='] = h_dt_format($this->input->get('create_stop_begin_time'));      
        $conditions['aging_stop_time <='] = h_dt_stop_time_of_day($this->input->get('create_stop_end_time')); 
        
        if($this->input->get('search')){
            $conditions['id like'] = '\'%'.$this->input->get('search').'%\'';
        }
		
	$orders = array("id"=>"desc");
        $paginator =  $this->esg->pagination_sql($conditions,$orders,$per_page,$cur_page);
        $config['base_url'] = '/aging/home/index/';
		$config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
	    $config['total_rows'] = $paginator['num'];
	    $config['per_page'] = $per_page; 
	    $this->pagination->initialize($config); 
		$this->dt['pagination'] = $this->pagination->create_links();

        $esgs = $paginator['res'];
        foreach($esgs as $key => $esg){
            $esgs[$key]['station'] = 
                $esg['station_id']?$this->station->find_sql($esg['station_id']):null;
        }
        $this->dt['esgs'] = $esgs;

        $this->load->view('templates/aging_header', $this->dt);
        $this->load->view('aging/menu');
        $this->load->view('aging/home/index');
        $this->load->view('templates/footer');
    }

    //按开始老化按钮执行
    public function start_aging($esg_id = 0){
        $esg = $this->esg->find_sql($esg_id);
        if(!$esg){show_error('no that esg!');}
        if(ESC_ESG_AGING_NONE != $esg['aging_status']){
            $this->session->set_flashdata('flash_err', '不是未老化的ESG，操作有误!');
        }else{
            $this->esg->update_sql($esg_id,array(
                "aging_start_time"=>h_dt_now(),
                "aging_status"=>ESC_ESG_AGING_ING));
            $this->session->set_flashdata('flash_succ', '开始老化ESG'.$esg_id.'成功!');
        }
        redirect(urldecode($this->input->get('backurl')), 'location');
    }


    //按重置老化按钮执行
    public function reset_aging($esg_id){
        $esg = $this->esg->find_sql($esg_id);
        if(!$esg){show_error('no that esg!');}
        if(ESC_ESG_AGING_FINISH != $esg['aging_status']){
            $this->session->set_flashdata('flash_err', '不是已老化的ESG，操作有误!');
        }else{
            $this->esg->update_sql($esg_id,array(
                "aging_start_time"=>null,
                "aging_stop_time"=>null,
                "aging_report"=>null,
                "count"=>0,
                "aging_status"=>ESC_ESG_AGING_NONE));
            $this->db->query("delete from agingdatas where esg_id=".$esg_id);
            $this->session->set_flashdata('flash_succ', '重置老化ESG'.$esg_id.'成功!');
        }
        redirect(urldecode($this->input->get('backurl')), 'location');
    }

    //按结束老化按钮执行
    public function stop_aging($esg_id){
        $esg = $this->esg->find_sql($esg_id);
        if(!$esg){show_error('no that esg!');}
        if(ESC_ESG_AGING_ING != $esg['aging_status']){
            $this->session->set_flashdata('flash_err', '不是正在老化的ESG，操作有误!');
        }else{
            $this->esg->update_sql($esg_id,array(
                "aging_stop_time"=>h_dt_now(),
                "aging_status"=>ESC_ESG_AGING_FINISH));
            $this->session->set_flashdata('flash_succ', '结束老化ESG'.$esg_id.'成功!');
        }
        redirect(urldecode($this->input->get('backurl')), 'location');
    }


    public function agingdata(){
        $this->dt['title'] = "老化数据";
        $datetime = $this->input->get("time")?$this->input->get("time"):'now';
        $type     = $this->input->get('type')?$this->input->get('type'):"recent";
        $esg_id   = $this->input->get('esg_id')?$this->input->get('esg_id'):"";
        
        $esg = $this->esg->find_sql($esg_id);
        if(!$esg){show_error('no that esg!');}
        
         //最近的数据
        if( $type == "recent"){
            $this->dt['datas'] = $this->agingdata->findBy_sql(
                    array('esg_id'=>$esg_id),array("create_time desc"),60,0);	
        } else if( $type == "day"){
            $this->dt['datas'] = $this->agingdata->findDayDatas($esg_id,$datetime);
            krsort($this->dt['datas']);
        }

        $this->dt['esg'] = $esg;
        $this->dt['type']       = $type;
        $this->dt['datetime']   = $datetime;
        $this->load->view('templates/aging_header', $this->dt);
        $this->load->view('aging/menu');
        $this->load->view('aging/home/agingdata');
        $this->load->view('templates/footer');
    }

	////aging////////////////////////////////////////////////////////////////////
	
	public function report_aging($esg_id){
            $this->dt['title'] = "老化报告";
            $esg = $this->esg->find_sql($esg_id);	
                    if(!$esg){ show_error("no that esg!"); }
                    $this->dt['esg'] = $esg;
            $start_time = $esg['aging_start_time'];
            if(!$start_time){show_error("no start time!");}
                    $stop_time = $esg['aging_stop_time']?$esg['aging_stop_time']:h_dt_now();

                    $datas = $this->agingdata->findList($esg_id,$start_time,$stop_time);

            $params = array('indoor_tmp','outdoor_tmp','indoor_hum',
                            'outdoor_hum','colds_0_tmp','colds_1_tmp');

                    foreach ($params as $key => $param) {
                            $this->dt[$param] = $this->agingdata->findList_hc($datas,$param);
                    }

            $this->load->view('templates/aging_header', $this->dt);
            $this->load->view('aging/menu');
            $this->load->view('aging/home/report_aging');
            $this->load->view('templates/footer');				
	}
}


