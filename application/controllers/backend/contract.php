<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contract_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('area','contract','project','batch'));
        $this->load->helper(array());
        $this->load->library(array('curl','pagination'));
    }

    public function index($cur_page = 1){
        $this->dt['title'] = "合同管理";
        $this->dt['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);
        $contracts = $this->contract->findBy(array('recycle'=>ESC_NORMAL),array("project_id desc,create_time asc"));
        $this->dt['contracts'] = array();
        foreach($contracts as $contract){
            $contract['project_name_chn'] = $this->project->getProjectNameChn($contract['project_id']);
            $this->dt['contracts'][] = $contract;
        }

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/contract/index');
        $this->load->view('templates/backend_footer');
    }

    public function add_contract(){
        $this->dt['title'] = "添加合同";
        $this->dt['mod'] = false;
        $this->dt['projects'] = $this->project->findAliveProjects();
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/contract/add_contract');
        $this->load->view('templates/backend_footer');
    }

    public function generate_phase_num(){
        $this->contract->generate_phase_num();
        $this->session->set_flashdata('flash_succ', "成功！");
        redirect('/backend/contract', 'location');
    }


    public function mod_contract($contract_id){
        $this->dt['title'] = "修改合同";
        $this->dt['mod'] = true;
        $this->dt['contract'] = $this->contract->find_sql($contract_id);
        $this->dt['projects'] = $this->project->findAliveProjects();
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/contract/add_contract');
        $this->load->view('templates/backend_footer');
    }

    public function insert_contract(){
        $_params = $this->input->post();
        $_params['create_time'] = h_dt_date_str('');
        $this->contract->insert($_params);
        if(mysql_insert_id()){
            $this->session->set_flashdata('flash_succ', "添加合同".$_param['name_chn']."成功！");
        }else{
            $this->session->set_flashdata('flash_err', "添加合同".$_param['name_chn']."失败！");
        }
        redirect('/backend/contract', 'location');
    }

    public function update_contract(){
        $_params = $this->input->post();
        $this->contract->update_sql($_params['id'], $_params);
        $this->session->set_flashdata('flash_succ', "更新合同".$_params['name_chn']."成功！");
        redirect('/backend/contract', 'location');
    }

    public function del_contract($contract_id){
        $this->contract->update_sql($contract_id,array("recycle"=>ESC_DEL));
        $this->session->set_flashdata('flash_succ', "删除合同成功！");
        redirect(urldecode($this->input->get('backurl')), 'location');
    }

    public function ajax_get_cities(){
        if(!$this->input->get("contract_id")){
            $result = $this->area->findAllCities();
            array_unshift($result,array("id"=>0,"name_chn"=>"全部"));
            array_unshift($result,array("name_chn"=>""));
        }else{
            $contract = $this->contract->find_sql($this->input->get('contract_id'));
            $project_id = $contract['project_id'];
            $result = $this->area->findProjectCities($project_id);
            array_unshift($result,array("name_chn"=>$this->project->getProjectNameChn($contract['project_id'])));
        }    
        echo json_encode($result);
    }

}







