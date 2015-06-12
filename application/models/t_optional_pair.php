<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class T_optional_pair extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "t_optional_pairs";
        $this->load->helper(array());
    }

    public function paramFormat($_params) {
        //`project_id` int(11) NOT NULL,
        //`city_id` int(11) NOT NULL,
        //`building_type` tinyint(1) NOT NULL,
        //`total_load` tinyint(1) NOT NULL,
        //`sav_station_id` int(11) NOT NULL,
        //`std_station_id` int(11) NOT NULL,
        //`user_id` int(11) NOT NULL,
        $_params['user_id']      = isset($_params['user_id'])      ? $_params['user_id'] : null;
        return $_params;
    }


}













