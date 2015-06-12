<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/********************************
[Controller Search]

********************************/

class Search_controller extends Frontend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('project','data','station','warning','area'));
    }

    function index(){
        $this->dt['title']="搜索结果";
        $project_id=$this->current_project['id'];
        $city_id=$this->current_city['id'];
        $search = $this->input->get('search');
        $cities = $this->area->findProjectCities($project_id);
        $this->dt['cities'] = h_array_to_id_hash($cities);
        $this->dt['search'] = $search;

        $stations = $this->station->searchFromProjectByName($search,$project_id,$city_id);
        $this->dt['stations'] = $stations;

        $this->load->view('templates/frontend_header', $this->dt);
		$this->load->view('frontend/search/index');
        $this->load->view('templates/frontend_footer');
    }

}
