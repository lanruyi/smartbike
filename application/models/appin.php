<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appin extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "appins";
    }


    public function newAppin($type,$content,$user_id=null){
        if(!$type){
            return '{"type":"'.$type.'","status":"no_type"}';
        }
        if(!$content){
            return '{"type":"'.$type.'","status":"no_content"}';
        }
        $this->appin->insert(array("content"=>$content,"type"=>$type,"user_id"=>$user_id));
        return '{"type":"'.$type.'","status":"success"}';
    }

    public function insertExploration($content,$user_id=0){
    }

    public function paramFormat($_params) {
        $_params['datetime'] = isset($_params['datetime'])? $_params['datetime'] : h_dt_now();
        return $_params;
    }

}
