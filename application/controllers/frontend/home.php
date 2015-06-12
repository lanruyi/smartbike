<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/********************************
[Controller Analysis]
./../models/Entities/Station.php 
./../models/station.php
./../../tests/controllers/StationControllerTest.php

********************************/

class Home_controller extends Frontend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('station'));
        $this->load->model(array('data','station','warning','area'));
    }

    public function index(){

        $this->load->view('templates/frontend_header', $this->dt);
		$this->load->view('frontend/home/index');
        $this->load->view('templates/frontend_footer');
    }

}
