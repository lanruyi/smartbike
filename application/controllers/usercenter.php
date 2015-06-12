<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usercenter_controller extends Frontend_Controller {
		
	function __construct(){
        parent::__construct();
        $this->load->model(array('project','area','warning'));
    }
	
	public function index(){
                $data['title'] = "用户中心";
		$data['user'] = $this->curr_user;
		$data['backurlstr'] = urlencode($_SERVER['REQUEST_URI']);
		
                $this->load->view('templates/frontend_header.php',$data);
		$this->load->view('frontend/usercenter.php');
		$this->load->view('templates/frontend_footer.php');
	}
	
	public function safe(){
		$user = $this->curr_user;
		$old_password = trim($this->input->post('old_password'));
		$new_password1 = trim($this->input->post('new_password1'));
		$new_password2 = trim($this->input->post('new_password2'));
		$email = $this->input->post('email');
                
		if(md5($old_password) != $user['password']){
			$this->session->set_flashdata('flash_err','原密码错误, 请重新输入！');
			redirect(urldecode($this->input->get('backurl')),'location');
		}
		if($new_password1 != $new_password2){
			$this->session->set_flashdata('flash_err','两次输入密码不一致, 请重新输入！');
			redirect(urldecode($this->input->get('backurl')),'location');
		}
		if($new_password1=="" && $new_password2==""){
			$this->session->set_flashdata('flash_err','输入密码为空, 请重新输入！');
			redirect(urldecode($this->input->get('backurl')),'location');
		}

		$this->user->update_sql($user['id'],array(
                    'password'=>md5($new_password1),
                    'email'=>$email ));
		$this->session->set_flashdata('flash_succ','密码更改成功！');
		redirect(urldecode($this->input->get('backurl')),'location');
	}
        

}
