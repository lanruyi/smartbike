<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Area_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('area'));
        $this->load->helper(array());
        $this->load->library(array('curl','pagination'));
    }

    public function index($cur_page = 1){
        $this->dt['title'] = "城市管理";
        $this->dt['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);

        $areas = $this->area->findBy_sql(array('type'=>ESC_AREA_TYPE_CITY));
        $this->dt['areas'] = array();
        foreach($areas as $area){
            $area['sum'] = count($this->area->findDistricts($area['id']));
            $this->dt['areas'][] = $area;
        }
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/area/index');
        $this->load->view('templates/backend_footer');
    }

    public function add_city(){
        $this->dt['title'] = "添加城市";
        $this->dt['mod'] = false;
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/area/add_city');
        $this->load->view('templates/backend_footer');
    }

    public function mod_city($area_id){
        $this->dt['title'] = "修改城市";
        $this->dt['mod'] = true;
        $this->dt['area'] = $this->area->find_sql($area_id);
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/area/add_city');
        $this->load->view('templates/backend_footer');
    }

    public function insert_city(){
        $_params = $this->input->post();
        $_params['type'] = ESC_AREA_TYPE_CITY;
        $this->area->insert($_params);
        $this->session->set_flashdata('flash_succ', "添加城市".trim($this->input->post('name_chn'))."成功！");
        redirect('/backend/area', 'location');
    }

    public function update_city(){
        $_params = $this->input->post();
        $this->area->update_sql($_params['id'], $_params);
        $this->session->set_flashdata('flash_succ', "更新城市".trim($this->input->post('name_chn'))."成功！");
        redirect('/backend/area', 'location');
    }

    public function one_city($city_id){
        $this->dt['title'] = '区县列表';
        $this->dt['cities'] = $this->area->findBy_sql(array('type'=>ESC_AREA_TYPE_CITY));
        $this->dt['father_id'] = $city_id;       
        $this->dt['districts'] = $this->area->findDistricts($city_id);
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/area/one_city');
        $this->load->view('templates/backend_footer');
    }

    public function add_district(){
        $this->dt['title'] = '添加区县';
        $this->dt['mod'] = false;
        $this->dt['father_id'] = $this->uri->segment(4);
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/area/add_district');
        $this->load->view('templates/backend_footer');
    }

    public function insert_district(){
        $_params = $this->input->post();
        $_params['type'] = ESC_AREA_TYPE_DISTRICT;
        $this->area->insert($_params); 
        redirect('/backend/area', 'location');
    }

    public function mod_district($district_id){
        $this->dt['title'] = "修改区县";
        $this->dt['mod'] = true;
        $this->dt['area'] = $this->area->find_sql($district_id);
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/area/add_district');
        $this->load->view('templates/backend_footer');
    }

    public function update_district(){
        $_params = $this->input->post();
        $this->area->update_sql($_params['id'],$_params);
        $this->session->set_flashdata('flash_succ', "更新区县".trim($this->input->post('name_chn'))."成功！");
        redirect(urldecode($this->input->get('backurl')),'location');
    }

    public function ajax_get_districts(){
        if(!$this->input->get("city_id")){
            $result = $this->area->findDistricts();
            array_unshift($result,array("id"=>0,"name_chn"=>"全部"));
        }else{
            $result = $this->area->findDistricts($this->input->get('city_id'));
            array_unshift($result,array("id"=>0,"name_chn"=>"全部"));
        }    
        echo json_encode($result);
    }
}







