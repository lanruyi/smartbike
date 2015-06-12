<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Temp extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "temps";
        $this->load->helper(array());
    }

    public function getDownloadSize(){
        $download_size = $this->temp->findOneBy(array("key"=>"download_size"));
        $res = $download_size?$download_size['value']:$this->config->item('rom_part_size');
        return $res;
    }

}













