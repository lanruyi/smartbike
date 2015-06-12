<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Update_log_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
    }

    public function index($cur_page = 1) {
        $data['title'] = "服务器更新日志";
        $data['backurlstr'] = urlencode($_SERVER["REQUEST_URI"]);

        $this->load->view('templates/backend_header', $data);
        $this->load->view('backend/menu', $data);
        $this->load->view('backend/update_log', $data);
        $this->load->view('templates/backend_footer', $data);
    }	
}




