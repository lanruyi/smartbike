<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appuser extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "appusers";
    }


    public function paramFormat($_params) {
        $_params['createtime'] = isset($_params['createtime'])? $_params['createtime'] : h_dt_now();
        return $_params;
    }

}
