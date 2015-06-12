<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project_controller extends Newfront_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('main'));
        $this->load->model(array('project','station','user'));
    }

    //所有项目
    public function switching(){
        $this->session->
        $projects = $this->project->findProductProjects();
        foreach($projects as $project){
            echo '<a href="/newfront/project/index/'.$project['id'].'">'.$project['name_chn'].'</a><br />';
        }
    }

    //单个项目
    public function index($project_id){
        $project_id = $project_id ? $project_id : "4";
        $func_name = $this->project->getNewfrontProjectFuncName($project_id);
        redirect("/newfront/project/".$func_name."/".$project_id,"location");
    }

    //江苏联通一样的结算方式
    public function js($project_id){
        $this->load->view('templates/newfront_header', $this->dt);
        $this->load->view('newfront/project/js');
        $this->load->view('templates/footer');
    }

    //广西联通一样的结算方式
    public function gx($project_id){
        $this->load->view('templates/newfront_header', $this->dt);
        $this->load->view('newfront/project/gx');
        $this->load->view('templates/footer');
    }

    //n+1结算方式
    public function np1($project_id){
        $this->load->view('templates/newfront_header', $this->dt);
        $this->load->view('newfront/project/np1');
        $this->load->view('templates/footer');
    }

}

