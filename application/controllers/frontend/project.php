<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project_controller extends Frontend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('main'));
        $this->load->model(array('project','station','user'));
    }

    public function projects(){
        $this->dt['title'] = "切换项目";
        $this->load->view('templates/header', $this->dt);
        $this->load->view('simple/projects');
    }

    public function change_project($project_id){
        $project = $this->project->find_sql($project_id);
        if(!$project){show_error("no such project!");}  
        $this->user->update_sql($this->curr_user['id'],array("current_project_id"=>$project_id));
        $this->current_project = $project;
        delete_cookie("current_station_id");
        delete_cookie("current_city_id");
        
        $this->redirectToCorrectPage($this->current_project['type']);
    }
    
    private function redirectToCorrectPage($project_type){
        if ($project_type == ESC_PROJECT_TYPE_STANDARD_SAVING_COMMON) {
            redirect('frontend/stations/newlist');
        } else if ($project_type == ESC_PROJECT_TYPE_STANDARD_SAVING){
            redirect('frontend/stations/stdlist');
        } else if ($project_type == ESC_PROJECT_TYPE_STANDARD_SAVING_SH){
            redirect('frontend/stations/stdlist_sh');   
        } else {    // n+1
            redirect('frontend/stations/slist');
        }
    }

}

