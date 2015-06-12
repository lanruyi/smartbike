<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Basedata_controller extends Backend_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('appin'));
    }

    public function index(){
    }

    public function project_and_city(){
        $this->dt['title'] = "项目&城市";

        //vimjumper ../../views/newback/basedata/project_and_city.php
        $this->load->view('newback/basedata/project_and_city',$this->dt);
    }

    public function appdata(){
        $this->dt['title'] = "移动端数据";
        $this->dt['appins'] = $this->appin->findBy();

        //vimjumper ../../views/newback/basedata/appdata.php
        $this->load->view('newback/basedata/appdata',$this->dt);
    }
}

