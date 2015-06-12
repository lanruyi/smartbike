<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('user','role','project','department','area','user_project'));
        $this->load->library(array('curl'));
    }

    public function index($cur_page = 1){
        $this->dt['title'] = "用户管理";
        $this->dt['users'] = $this->user->findBy(array());
        $this->dt['departments'] = $this->department->findBy(array());
        $this->dt['roles'] = $this->role->findBy(array());
        $this->dt['projects'] = $this->project->findBy(array());
        $this->dt['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);

        $per_page = $this->input->get('per_page')? $this->input->get('per_page'):20;
        //已删除用户不显示
        $conditions['recycle = '] = ESC_NORMAL; 
        $conditions['department_id = '] = $this->input->get('department_id');
        $conditions['role_id = '] = $this->input->get('role_id');
        $conditions['current_project_id = '] = $this->input->get('current_project_id');
        if($this->input->get('search')){
            $conditions['name_chn like'] = '\'%'.$this->input->get('search').'%\'';
        }

        $orders = array("id"=>"desc");
        $paginator =  $this->user->pagination_sql($conditions,$orders,$per_page,$cur_page);
        $config['base_url'] = '/backend/user/index/';
        $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['total_rows'] = $paginator['num'];
        $config['per_page'] = $per_page; 
        $this->pagination->initialize($config); 
        $this->dt['pagination'] = $this->pagination->create_links();
        $arrs = $paginator['res'];
        $this->dt['users'] = array();
        foreach($arrs as $arr){
            $arr['role'] = $this->role->getRoleNameChn($arr['role_id']);
            $arr['department'] = $this->department->getDepartmentNameChn($arr['department_id']);
            $arr['current_project'] = $this->project->getProjectNameChn($arr['current_project_id']);
            $arr['default_city'] = $this->area->getCityNameChn($arr['default_city_id']);
            $arr['projects_count'] = count($this->user_project->get_user_projects($arr['id']));
            $this->dt['users'][] = $arr;
        }

        $this->load->view('templates/backend_header',$this->dt);
        $this->load->view('backend/menu');
        $this->load->view('backend/user/index');
        $this->load->view('templates/backend_footer');
    }

    public function add_user(){
        $data['title'] = "添加用户";
        $data['mod'] = false;
        $data['roles'] = $this->role->findAll_sql();
        $data['departments'] = $this->department->findAll_sql();
        $data['projects'] = $this->project->findAll_sql();
        $data['cities'] = $this->area->findBy_sql(array('type'=>ESC_AREA_TYPE_CITY));
        $this->load->view('templates/backend_header', $data);
        $this->load->view('backend/menu');
        $this->load->view('backend/user/add_user');
        $this->load->view('templates/backend_footer');
    }

    public function mod_user(){
        $data['title'] = "修改用户";
        $data['mod'] = true;
        $data['user'] = $this->user->find_sql($this->uri->segment(4));
        $data['roles'] = $this->role->findAll_sql();
        $data['departments'] = $this->department->findAll_sql();
        $data['projects'] = $this->project->findAll_sql();
        $data['userProjects'] = $this->user_project->get_user_projects($this->uri->segment(4));
        $data['cities'] = $this->area->findBy_sql(array('type'=>ESC_AREA_TYPE_CITY));
        $this->load->view('templates/backend_header', $data);
        $this->load->view('backend/menu');
        $this->load->view('backend/user/add_user');
        $this->load->view('templates/backend_footer');
    }

    public function insert_user(){
        //插入数据rewrite
        $data = array(
            'username' => trim($this->input->post('username')),
            'password' => md5(trim($this->input->post('password'))),
            'name_chn' => trim($this->input->post('name_chn')),
            'email' => trim($this->input->post('email')),
            'telephone' => trim($this->input->post('telephone')),
            'remark' => trim($this->input->post('remark')),
            'last_ip' => '0.0.0.0',
            'created' => h_dt_date_str(''),
            'last_login' => h_dt_date_str(''),
            'role_id' => trim($this->input->post('role_id')),
            'department_id' => trim($this->input->post('department_id')),
            'current_project_id' => trim($this->input->post('current_project_id')),
            'default_city_id' => trim($this->input->post('default_city_id'))
        );
        $this->db->insert('users',$data);
        $id = $this->db->insert_id();
        if($this->input->post('project_ids')){
            foreach($this->input->post('project_ids') as $project_id){
                $this->db->set(array('user_id'=>$id,'project_id'=>$project_id));
                $this->db->insert('user_projects');
            }
        }
        $this->session->set_flashdata('flash_succ', "创建用户".trim($this->input->post('name_chn'))."成功！");
        redirect(urldecode($this->input->get('backurl')), 'location');
    }

    public function update_user(){
        //更新数据rewrite
        $id = $this->input->post('id');
        $data = array(
            'username' => trim($this->input->post('username')),
            'name_chn' => trim($this->input->post('name_chn')),
            'email' => trim($this->input->post('email')),
            'telephone' => trim($this->input->post('telephone')),
            'remark' => trim($this->input->post('remark')),
            'role_id' => trim($this->input->post('role_id')),
            'department_id' => trim($this->input->post('department_id')),
            'modified' => h_dt_date_str(''),
            'current_project_id' => trim($this->input->post('current_project_id')),
            'default_city_id' => trim($this->input->post('default_city_id'))
        );
        if($this->input->post('password')){
            $data['password'] = md5(trim($this->input->post('password')));
        }
        $this->db->where('id',$id);
        $this->db->update('users',$data);
        //下面的更新user_projects
        //先删除所有跟该用户id相关的数据，，然后再插入
        $this->db->delete('user_projects',array('user_id'=>$id));
        if($this->input->post('project_ids')){
            foreach($this->input->post('project_ids') as $project_id){
                $this->db->set(array('user_id'=>$id,'project_id'=>$project_id));
                $this->db->insert('user_projects');
            }
        }
        redirect(urldecode($this->input->get('backurl')), 'location');
    }

    public function del_user($user_id=0){
        $this->user->del_user($user_id);
        redirect(urldecode($this->input->get('backurl')), 'location');
    }

    public function verify_projects(){
        $users = $this->user->findAll_sql();
        $str = " 结果如下: <br>";
        foreach($users as $user){
            $data = array();
            $user_projects = $this->user_project->get_user_projects($user['id']);
            if(count($user_projects)){
                if((!$user['current_project_id']) or (!h_in_arrays($user['current_project_id'],$user_projects,'project_id'))){
                    $data['current_project_id'] = $user_projects[0]['project_id'];
                    $project_name_chn = $this->project->getProjectNameChn($user_projects[0]['project_id']);
                    $str .= $user['name_chn']."更改当前项目为 ".$project_name_chn." <br>";                    
                }
                if(count($user_projects)){
                    //返回某个项目组下的所有城市
                    $cities = $this->area->findProjectCities($user['current_project_id']);
                    if(!$user['default_city_id'] or (!h_in_arrays($user['default_city_id'],$cities,'id'))){
                        $data['default_city_id'] = $cities[0]['id'];
                        $str .= $user['name_chn']."更改默认城市为 ".$cities[0]['name_chn']." <br>";
                    }
                } else {
                    if($user['default_city_id']){
                        $data['default_city_id'] = null;
                        $this->db->update('users',$data,array('id' => $user['id']));
                        $str .= $user['name_chn']."更改默认城市为 NULL <br>";                       
                    }
                }    
            }else{
                if($user['current_project_id']){
                    $data['current_project_id'] = null;
                    $data['default_city_id'] = null;
                    $str .= $user['name_chn']."更改当前项目为 NULL  并清空默认城市<br>";
                }
            }
            if($data){
                $this->db->where('id',$user['id']);
                $this->db->update('users',$data); 
            }
        }
        $this->session->set_flashdata('flash_succ', $str);
        redirect(urldecode($this->input->get('backurl')), 'location');
    }


}







