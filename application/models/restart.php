<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Restart extends ES_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table_name = "restarts";
    }

    //记录开发板重启一次
    public function recordRestart($esg_id) {
        if(!$esg_id) return;
        $esg = $this->esg->find_sql($esg_id);
        if ($esg) {
            $this->new_sql(array("restart_time"=> h_dt_now(),"esg_id"=>$esg['id'],"station_id"=>$esg['station_id']));
        }
    }


}
