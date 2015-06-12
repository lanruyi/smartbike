<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Debug_controller extends CI_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('command','station','warning','cmail'));
        $this->load->helper(array());
        $this->load->library(array('curl'));
    }

    public function index(){
        $c_id = $this->command->new_sql(array(),1);
        $this->command->update_sql($c_id,array("station_id"=>16),1);
        //$this->command->del_sql(20890);
        //$cmd = $this->command->find_sql(20889);
        //h_p($cmd);
        $cmds = $this->command->findby_sql(array("station_id"=>16,"command"=>"'reb'"),array(),1);
        h_p($cmds);
    }


}
