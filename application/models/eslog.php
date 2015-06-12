<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/********************************
Fast JJump 
********************************/


define('ESC_ESLOG__GPRSTEST',1);
define('ESC_ESLOG__SOMETEST',10);

class Eslog extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name="eslogs";
    }

    public function addtestgprs($str){
        $this->new_sql(array("create_time"=>h_dt_now(),"log"=>$str,"long_log"=>"","type"=>ESC_ESLOG__GPRSTEST));
    } 
}

