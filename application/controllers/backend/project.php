<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('project','user_project','department','user','station','area'));
        $this->load->helper(array('project'));
    }

    public function index($cur_page = 1){
        $data['title'] = "项目设置";
        $data['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);

        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;	
        $conditions = array();
        $orders = array("id"=>"desc");

        $paginator =  $this->project->pagination_sql($conditions,$orders,$per_page,$cur_page);
        //config pagination
        $config['base_url'] = '/backend/project/index/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page'] = $per_page; 

        $this->pagination->initialize($config); 
        $data['pagination'] = $this->pagination->create_links();
        $data['projects'] = $paginator['res'];

        $this->load->view('templates/backend_header', $data);
        $this->load->view('backend/menu');
        $this->load->view('backend/project/index');
        $this->load->view('templates/backend_footer');
    }


    public function mod_project(){
        $data['title'] = "修改项目";
        $project_id = $this->uri->segment(4);
        $data['project'] = $this->project->find_sql($project_id);
        $data['areas'] =  $this->area->findBy_sql(array('type'=>ESC_AREA_TYPE_CITY));
        $data['departments'] = $this->department->findBy_sql(array());
        $data['users'] = $this->user->findBy_sql(array('recycle'=>ESC_NORMAL));
        $data['user_projects'] = $this->user_project->findUserHash($project_id);

        $this->load->view('templates/backend_header', $data);
        $this->load->view('backend/menu');
        $this->load->view('backend/project/mod_project');
        $this->load->view('templates/backend_footer');
    }


    public function update_project(){
        $project_id = $this->input->post('id');
        $project = $this->project->find_sql($project_id);

        $param['name_chn']=$this->input->post('name_chn');
        $param['is_hide_front']=$this->input->post('is_hide_front');
        $param['type']=$this->input->post('type');
        $param['ope_type'] = $this->input->post('ope_type');
        $param['city_list']=implode(",",$this->input->post('areas'));
        $this->project->update_sql($project_id,$param);


        $this->db->delete('user_projects',array('project_id'=>$project_id));

        foreach($this->input->post("users") as $user_id){
            $this->db->set(array('user_id'=>$user_id,'project_id'=>$project_id));
            $this->db->insert('user_projects');
        }

        $this->session->set_flashdata('flash_succ', $project['name_chn'].'修改成功');
        redirect('/backend/project', 'location');
    }

    public function del_project(){
        //$this->project->del_by_id($this->uri->segment(4));
        redirect('/backend/project', 'location');
    }

    public function ajax_get_cities(){
        if(!$this->input->get("project_id")){
            $result = $this->area->findAllCities();
            array_unshift($result,array("id"=>0,"name_chn"=>"全部"));
        }else{
            $result = $this->area->findProjectCities($this->input->get("project_id"));
            array_unshift($result,array("id"=>0,"name_chn"=>"全部"));
        }    
        echo json_encode($result);
    }
}



