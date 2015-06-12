<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Sysconfig extends ES_Model {

	public function __construct()
	{
        parent::__construct();
        $this->load->database();
		$this->table_name = "sysconfig";
	}

	public function getByName($name){
		$result = $this->findOneBy(array("config_name"=>$name));
		return h_array_safe($result,"config_str");
	}

	public function setByName($name,$str){
		$result = $this->findBy(array("config_name"=>$name));
        if(!$result){
            $this->sysconfig->insert(array("config_name"=>$name));
        }
        $this->sysconfig->updateBy(array("config_str"=>$str),array("config_name"=>$name));
	}



}

