<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('role'));
        $this->load->helper(array('role'));
    }

    public function index($cur_page = 1){
        $this->dt['title'] = "角色设置";
        $this->dt['roles'] = $this->role->findBy_sql(array());
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/role/index');
        $this->load->view('templates/backend_footer');
    }

    public function mod_role(){
        $this->dt['title'] = "修改角色";
        $this->dt['mod'] = true;
        $this->dt['role'] = $this->role->find_sql($this->uri->segment(4));
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/role/add_role');
        $this->load->view('templates/backend_footer');
    }


    public function update_role(){
        $role = $this->role->find_sql($this->input->post('id'));
        if($role){
            $auth = h_auth_all_zero();
            foreach($this->input->post("authorities") as $single){
                $auth = h_auth_set_1($auth,$single);
            }
            $this->role->update_sql($role['id'],
                array("name_chn"=>$this->input->post('name_chn'),"authorities"=>$auth));
        }
        redirect('/backend/role', 'location');
    }

}



