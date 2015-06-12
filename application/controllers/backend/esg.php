<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Esg_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('esg','data','station','agingdata','restart'));
    }

    public function index($cur_page = 1){
        $this->dt['title'] = "ESG管理";
		$per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;	
		$conditions = array();
        $conditions['aging_status ='] = $this->input->get('aging_status');
		$conditions['alive ='] = $this->input->get('alive');      
        $conditions['create_time >'] = h_dt_format($this->input->get('create_start_time'));
        $conditions['create_time <'] = h_dt_format($this->input->get('create_stop_time'));
        if($this->input->get('search')){
            $conditions['id like'] = '\'%'.$this->input->get('search').'%\'';
        }
		$orders = array("id"=>"desc");
        $paginator =  $this->esg->pagination_sql($conditions,$orders,$per_page,$cur_page);
        $config['base_url'] = '/backend/esg/index/';
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

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/esg/index');
        $this->load->view('templates/backend_footer');
    }


    public function mod_esg($esg_id){
        $this->dt['title'] = "修改ESG控制板";
        $esg = $this->esg->find_sql($esg_id);
		$station = $this->station->find_sql($esg['station_id']);
        $this->dt['esg'] = $esg;
        $this->dt['station'] = $station;
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/esg/mod_esg');
        $this->load->view('templates/backend_footer');
    }

    public function update_esg(){   	
        $esg = $this->esg->find_sql($this->input->post('id'));
        $station_id = $this->input->post('station_id');
        $this->esg->update_sql($esg['id'],array(
            "string" => $this->input->post('string'),
            "esg_key" => $this->input->post('esg_key')));

        if($esg['station_id'] != $station_id){
            $station = $this->station->find_sql($station_id);
            if($station){
                $esg_set = $this->esg->findBy_sql(array("station_id"=>$station_id));
                if($esg_set){
                    $this->session->set_flashdata('flash_err', 
                        "这个基站 ".$station['name_chn']."已经安装了ESG");
                }else{
                    $this->esg->update_sql($esg['id'],array(
                        "station_id" => $station_id));
                }
            }else{
                $this->session->set_flashdata('flash_err',"没有这个基站");
            }
        }

        redirect(urldecode($this->input->get('backurl')), 'location');
    }

    public function del_esg($esg_id){
        $this->esg->del_by_id($esg_id);
        redirect('/backend/esg', 'location');
    }
	
	public function verify_agingstatus(){
        $esgs = $this->esg->findBy_sql(array());
        $str = " 结果如下: <br>";
        foreach($esgs as $esg){
        	if($esg['station_id']){
        		if($esg['aging_status'] == ESC_ESG_AGING_ING){
                    $this->esg->update_sql($esg['id'],array("aging_status" => ESC_ESG_AGING_FINISH));
        			$str .= $esg['id']." 更改为 '老化完成' [station:".$esg['station_id']."] <br>";
        		}
        	}            
        }
        $this->session->set_flashdata('flash_succ', $str);
        redirect('/backend/esg', 'location');		
	}
	
}




