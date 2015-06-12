<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Station_log extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "station_logs";
    }

}
