<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('ESC_AUTOCHECK_STATUS_ING',1);
define('ESC_AUTOCHECK_STATUS_PASS',2);
define('ESC_AUTOCHECK_STATUS_FAIL',3);

class Autocheck extends ES_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->table_name = "autochecks";
    }

    public function paramFormat($_params) {
        $_params['id']         = isset($_params['id'])         ? $_params['id']         : 0;
        $_params['station_id'] = isset($_params['station_id']) ? $_params['station_id'] : 0;
        $_params['datetime']   = isset($_params['datetime'])   ? $_params['datetime']   : h_dt_now();
        $_params['status']     = isset($_params['status'])     ? $_params['status']     : ESC_AUTOCHECK_STATUS_ING;
        $_params['report']     = isset($_params['report'])     ? $_params['report']   : 0;
        return $_params;
    }


    public function add($station_id,$report) {
        $this->autocheck->insert(array(
            "station_id"=>$station_id,
            "report"=>$report));
    }

    public function getReport($station_id){
        $this->db->limit(1);
        $autochecks = $this->autocheck->findBy(array("station_id"=>$station_id),
            array("datetime desc"));
        if($autochecks){
            return $autochecks[0]['report'];
        }else{
            return '["no_check"]';
        }
    }


    //public function check($station_id,$warnings_json){
        //$_data = json_decode($json);
        //if (!empty($_data)) {
            //foreach ($_data as $_time => $_dataitem) {
                //foreach ($_dataitem as $_bug_type){
                    //if (20 == $_bug_type) {
                        
                    //}
                //}
            //}
        //}
    //}

    //public function makeExpire(){
        //$query = $this->db->query("select station_id,count(*) num from autochecks where status=? 
            //group by station_id",array(ESC_AUTOCHECK_STATUS_ING));
        //foreach($query->result_array() as $autocheck){
            //$num = $autocheck['num'];
            //$station_id = $autocheck['station_id'];
            //if($num > 1){
                //$stations = $this->autocheck->findBy(
                    //array("station_id"=>$station_id),
                    //array("datetime asc"));
                //for($i = 0; $i < $num - 1; $i ++){
                    //$this->autocheck->update($stations[$i]['id'],
                        //array("status"=>ESC_AUTOCHECK_STATUS_EXPIRE));
                //}
            //}
        //}
    //}


}
