<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('ESC_ESG_AGING_NONE',1);
define('ESC_ESG_AGING_ING',2);
define('ESC_ESG_AGING_FINISH',3);

define('ESC_ESG_NOT_FIXED',1);
define('ESC_ESG_FIXED',2);

class Esg extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "esgs";
        $this->load->helper('esg');
    }


    public function make_all_esg_fixed(){
        $this->esg->updateBy(array("fixed"=>ESC_ESG_FIXED));
    }

    public function getEsg($station_id){
        if(!$station_id) return null;
        return $this->findOneBy(array('station_id'=>$station_id));
    }

    public function getEsgId($station_id){
        if(!$station_id) return null;
        $esg = $this->findOneBy(array('station_id'=>$station_id));
        if($esg){
            return $esg['id'];
        }else{
            return null;
        }
    }


    public function putEsgOffline(){
        $this->db->where("last_update_time < date_sub(now(),interval 11 minute)");
        $this->esg->updateBy(array("alive"=>ESC_OFFLINE));
    }


    public function check_and_refresh_esg($esg_id){
        if(!$esg_id) return false;
        $this->db->select('id,station_id,alive,host');
        $esg = $this->find($esg_id);
        if($esg){
            if($esg['alive'] != ESC_ONLINE or $esg['host'] != $_SERVER['HTTP_HOST']){
                $this->update($esg_id,array("alive"=>ESC_ONLINE,"host"=>$_SERVER['HTTP_HOST']));
                $esg['alive'] = ESC_ONLINE;
                $esg['host'] = $_SERVER['HTTP_HOST'];
            }

            $this->update($esg_id,array("last_update_time"=>  h_dt_now()));
            return $esg;
        }else{
            return false;
        }
    }

    //有测试
    public function get_esg_by_esg_key($name,$key){
        $this->esg->where(array("fixed" => ESC_ESG_NOT_FIXED));
        $esg = $this->esg->findOneBy(array("esg_key"=>$key));
        if(!$esg){
            $esg = $this->esg->insert(array("esg_key"=>$key,"string"=>$name));
            $esg_id = $this->db->insert_id();
        }else{
            $esg_id = $esg['id'];
            $this->update($esg_id,array("string"=>$name));
        }
        return $esg_id;
    }

    public function paramFormat($_params) {
        $_params['alive']            = isset($_params['alive'])            ? $_params['alive']            : ESC_OFFLINE;
        $_params['count']            = isset($_params['count'])            ? $_params['count']            : 0;
        $_params['status']           = isset($_params['status'])           ? $_params['status']           : 0;
        $_params['create_time']      = isset($_params['create_time'])      ? $_params['create_time']      : h_dt_now();
        $_params['last_update_time'] = isset($_params['last_update_time']) ? $_params['last_update_time'] : h_dt_now();
        $_params['aging_status']     = isset($_params['aging_status'])     ? $_params['aging_status']     : ESC_ESG_AGING_NONE;
        $_params['aging_start_time'] = isset($_params['aging_start_time']) ? $_params['aging_start_time'] : null;
        $_params['aging_stop_time']  = isset($_params['aging_stop_time'])  ? $_params['aging_stop_time']  : null;
        $_params['aging_report']     = isset($_params['aging_report'])     ? $_params['aging_report']     : null;
        $_params['fixed']            = isset($_params['fixed'])            ? $_params['fixed']            : ESC_ESG_NOT_FIXED;
        return $_params;
    }



}


