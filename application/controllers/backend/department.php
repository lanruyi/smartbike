<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Department_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('department','user','role'));
    }

    //主页面
    public function index(){
        $this->dt['title'] = "部门设置";
        $this->dt['departments'] = $this->department->findBy_sql(array());
        $this->dt['users'] = $this->user->findBy_sql(array('recycle'=>ESC_NORMAL));

        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/department/index');
        $this->load->view('templates/backend_footer');
    }

    //添加页面
    public function add_department(){
        $this->dt['title'] = "添加部门";
        $this->dt['mod'] = false;
        $this->dt['users'] = $this->user->findBy_sql(array('recycle'=>ESC_NORMAL));
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/department/add_department');
        $this->load->view('templates/backend_footer');
    }

    //修改页面
    public function mod_department(){
        $this->dt['title'] = "修改部门";
        $this->dt['mod'] = true;
        $this->dt['department'] = $this->department->find_sql($this->uri->segment(4));
        $this->dt['users'] = $this->user->findBy_sql(array('recycle'=>ESC_NORMAL));
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/department/add_department');
        $this->load->view('templates/backend_footer');
    }
    
    //添加
    public function insert_department(){
        $this->department->new_sql(array("name_chn"=>$this->input->post('name_chn')));         
        $department_id = $this->db->insert_id();
        foreach($this->input->post("user_ids") as $user_id){
            $this->user->update_sql($user_id,array("department_id"=>$department_id));
        }
        redirect('/backend/department', 'location');
    }

    //修改
    public function update_department(){
        $user_group_id = $this->input->post('id');
        $this->department->update_sql($user_group_id,array("name_chn"=>$this->input->post('name_chn')));
        $this->db->query("update users set department_id=NULL 
            where department_id=".$user_group_id);  
        foreach($this->input->post("user_ids") as $user_id){  
            $this->user->update_sql($user_id,array("department_id"=>$this->input->post('id')));
        }		
        redirect('/backend/department', 'location');
    }

    //删除
    public function del_department(){
        $department = $this->department->find_sql($this->uri->segment(4));
        if($department){
            $query = $this->db->query("update users set department_id=NULL where department_id=".$department['id']);
            $this->department->del_sql($department['id']);
        }
        redirect('/backend/department', 'location');
    }

    //授权
    public function authorize_department(){
        $this->dt['roles'] = $this->role->getAllRoles();          
        $this->dt['get']= $this->input->get();
        $this->dt['department_msg'] =$this->department->res_array($this->dt['get']['id']);
        $this->load->view('templates/backend_header', $this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/department/authorize');   
        $this->load->view('templates/backend_footer');
    }

    //授权处理
    public function department_role(){
        if($this->input->post()){
        $sql = "UPDATE `departments` SET `role_id`= ".$this->input->post('role_id')." WHERE id = ".$this->input->post('did')." ";
        $query =$this->db->query($sql);
        }
       redirect('/backend/department', 'location');
    }


}





