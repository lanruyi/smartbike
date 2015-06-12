<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_controller extends ES_Controller {

    function __construct(){
        parent::__construct();
		$this->load->helper('url');
    }

	public function index()
	{
        $this->dt['title'] = "系统选择"; 
        //是否为普通用户
        $is_admin = ($this->user_role['id'] != 1) && ($this->user_role['id'] != 6);

        if(!$is_admin)
        {
            redirect('/frontend','local');
        }
        
        $this->dt['frontend_right']  = true;
        $this->dt['aging_right']     = $is_admin;
        $this->dt['setup_right']     = $is_admin;
        $this->dt['stainfo_right']   = false;
        $this->dt['maintain_right']  = $is_admin;
        $this->dt['analysis_right']  = $is_admin;
        $this->dt['backend_right']   = $is_admin;
        $this->dt['reporting_system']  = $is_admin;

        $this->load->view('templates/header',$this->dt);
        $this->load->view('main/index');
	}

	public function uc()
	{
        echo "建设中！<a href='/main'>返回系统选择</a>";
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
