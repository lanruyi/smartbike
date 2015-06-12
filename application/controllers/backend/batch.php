<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Batch_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('area','contract','batch','project'));
    }

    public function index($cur_page = 1){
        $this->dt['title'] = "批次管理";
        $this->dt['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);

        $batches = $this->batch->findBy_sql(array('recycle'=>ESC_NORMAL),array("contract_id asc","city_id asc","batch_num asc"));
        $this->dt['batches'] = array();
        foreach($batches as $batch){
            $batch['city_name_chn'] = $this->area->getCityNameChn($batch['city_id']);
            $batch['contract_name_chn'] = $this->contract->getContractNameChn($batch['contract_id']);
            $this->dt['batches'][] = $batch;
        }

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/batch/index');
        $this->load->view('templates/backend_footer');
    }


    public function generate_batch_num(){
        $this->batch->generate_batch_num();
        $this->session->set_flashdata('flash_succ', "成功！");
        redirect('/backend/batch', 'location');
    }

    public function generate_batch_name_chn(){
        $batches = $this->batch->findBy(array());
        foreach($batches as $batch){
            $contract = $this->contract->find($batch['contract_id']);
            $project  = $this->project->find($contract['project_id']);
            $city     = $this->area->find($batch['city_id']);
            $phase_name = $contract['alias']?
                $contract['alias']:h_contract_phase_name_chn($contract['phase_num']);
            $name = $project['name_chn']."_".$city['name_chn']."_"
                .$phase_name.h_batch_batch_name_chn($batch['batch_num']);
            $this->batch->update($batch['id'],array("name_chn"=>$name));
        }
        $this->session->set_flashdata('flash_succ', "成功！");
        redirect('/backend/batch', 'location');
    }


    public function add_batch(){
        $this->dt['title'] = "添加批次";
        $this->dt['mod'] = false;
        $this->dt['contracts'] = $this->contract->findAliveContracts();
        $this->dt['cities'] = $this->area->findAllCities();
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/batch/add_batch');
        $this->load->view('templates/backend_footer');
    }

    public function mod_batch($batch_id){
        $this->dt['title'] = "修改批次";
        $this->dt['mod'] = true;
        $this->dt['batch'] = $this->batch->find_sql($batch_id);
        $contract = $this->contract->find_sql($this->dt['batch']['contract_id']);
        $this->dt['project_name_chn'] = $this->project->getProjectNameChn($contract['project_id']);
        $this->dt['contracts'] = $this->contract->findAliveContracts();
        $this->dt['cities'] = $this->area->findAllCities();
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/batch/add_batch');
        $this->load->view('templates/backend_footer');
    }

    public function insert_batch(){
        $_params = $this->input->post();
        $_params['create_time'] = h_dt_date_str('');
        $this->batch->insert($_params);
        $title = $this->contract->getContractNameChn($_params['contract_id']).$this->area->getCityNameChn($_params['city_id']);
        $this->session->set_flashdata('flash_succ', "添加批次".$title."成功！");
        redirect('/backend/batch', 'location');
    }

    public function update_batch(){
        $_params = $this->input->post();
        $this->batch->update_sql($_params['id'], $_params);
        $title = $this->contract->getContractNameChn($_params['contract_id']).$this->area->getCityNameChn($_params['city_id']);
        $this->session->set_flashdata('flash_succ', "更新批次".$title."成功！");
        redirect('/backend/batch', 'location');
    }

    public function del_batch($batch_id){
        $this->batch->update_sql($batch_id,array("recycle"=>ESC_DEL));
        $this->session->set_flashdata('flash_succ', "删除成功！");
        redirect(urldecode($this->input->get('backurl')), 'location');
    }

}







