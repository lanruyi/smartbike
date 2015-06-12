<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('ESC_DEPARTMENT_STATION_SURPERVISE',4);
define('ESC_DEPARTMENT_OPERATION_MONITOR',8);
define('ESC_DEPARTMENT_OPERATION_SERVICE',9);

class Department extends ES_Model {

	public function __construct()
	{
        parent::__construct();
        $this->load->database();
		$this->table_name = "departments";
	}

	public function getDepartmentNameChn($id=0){
		$result = $this->find_sql($id);
		return $result?$result['name_chn']:"无";
	
    }

    public function res_array($id){
        $sql= "select * from ".$this->table_name." where id =".$id."";
        $res = $this->db->query($sql);
        $result = $res ->result_array();
        return $result[0];
    }
}
