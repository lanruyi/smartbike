<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_controller extends Statistic_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('area','station','project'));
    }


    public function index(){
        $this->dt['title'] = '';

        $this->load->view('templates/statistic_header',$this->dt);
        $this->load->view('statistic/menu');
        $this->load->view('templates/statistic_footer'); 
    }

} 
