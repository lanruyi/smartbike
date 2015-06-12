<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Esgfix extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "esgfixs";
        $this->load->helper('common');
    }


    public function paramFormat($_params) {
        $_params['datetime']    = isset($_params['datetime'])  ? $_params['datetime']   : h_dt_now();
        return $_params;
    }


    public function addEsgChange($station_id,$esg_id,$new_esg_id,$user_id){
        $params = array("station_id"=>$station_id,"esg_id"=>$esg_id,"new_esg_id"=>$new_esg_id,"user_id"=>$user_id);
        $this->esgfix->insert($params);
    }

}


