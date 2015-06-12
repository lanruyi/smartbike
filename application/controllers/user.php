<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_controller extends CI_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('mid/user_sess','user','project'));
        $this->load->library('session');
    }

    public function index(){}

    public function login(){

        if($this->input->get("debug") == "cx"){
            echo "Session_id:".$this->session->userdata('session_id')."<br>";
            hp($_SESSION);
        }

        if ($this->user_sess->is_logged_in()) {
            redirect($this->session->userdata('his_url'));
        } else {
            $data['errors'] = "";
            $data['login'] = "";
            if($this->input->post("login")){
                $res = $this->user_sess->login($this->input->post('login'),$this->input->post('password'));
                if(!$res){
                    //delete_cookie("current_station_id");
                    //delete_cookie("current_city_id");                   
                    if($this->input->get("debug") == "cx"){
                        echo "Session_id:".$this->session->userdata('session_id')."<br>";
                        hp($_SESSION);
                    }
                    $this->load->view('login_succ', $data);
                    return;
                    //redirect($this->session->userdata('his_url'));
                }else{
                    if($res == 1){
                        $data['errors'] = "密码错误";
                        $data['login'] = $this->input->post('login');
                    }elseif($res == 2){
                        $data['errors'] = "没有这个用户";
                    }
                }
            }
            $this->load->view('frontend/login_form', $data);
        }
    }

      public function jump_login(){
        if ($this->user_sess->is_logged_in()) {
            redirect($this->session->userdata('his_url'));
        } else {
            $data['errors'] = "";
            $data['login'] = "";
            if($this->input->post("login")){
                $res = $this->user_sess->jump_login($this->input->post('login'),$this->input->post('password'));
                if(!$res){
                    delete_cookie("current_station_id");
                    delete_cookie("current_city_id");                   
                    redirect($this->session->userdata('his_url'));
                }else{
                    if($res == 1){
                        $data['errors'] = "密码错误";
                        $data['login'] = $this->input->post('login');
                    }elseif($res == 2){
                        $data['errors'] = "没有这个用户";
                    }
                }
            }
            $this->load->view('frontend/jump_form', $data);
        }
    }
    
    
    
    
    public function logout(){
        // See http://codeigniter.com/forums/viewreply/662369/ as the reason for the next line
        $this->session->set_userdata(array('user_id' => '', 'username' => '', 'status' => ''));
        $this->session->destroy();
        redirect('');
    }

}
