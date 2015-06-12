<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prjconfig_controller extends Backend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('project'));
        $this->load->helper(array('project'));
    }

    public function index() {
        $this->dt['title'] = "项目设置";
        $projects = $this->project->findBy_sql(array());
        $this->dt['projects'] = $projects;
        $configs = array();
        foreach($projects as $project){
            $configs[$project['id']] = $this->project->getAndInitConfigs($project['id']);
        }
        $this->dt['configs'] = $configs;

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/prjconfig/index');
        $this->load->view('templates/backend_footer');
    }

    public function update_cfg() {
        $projects = $this->project->findBy_sql(array());
        foreach ($projects as $project) {
            $highest_indoor_tmp = $this->input->post('highest_indoor_tmp_'.$project['id']);
            $no_box_highest_indoor_tmp = $this->input->post('no_box_highest_indoor_tmp_'.$project['id']);
            $highest_box_tmp = $this->input->post('highest_box_tmp_'.$project['id']);
            $this->project->setTmp($project['id'],$highest_indoor_tmp,$no_box_highest_indoor_tmp,$highest_box_tmp);
        }
        $this->session->set_flashdata('flash_update', '保存成功！');
        redirect('/backend/prjconfig', 'location');
    }

    public function reset_cfg() {
        $this->session->set_flashdata('flash_reset', '重置完毕！');
        redirect('/backend/prjconfig', 'location');
    }
}
