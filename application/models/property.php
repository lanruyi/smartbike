<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Property extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "properties";
        $this->load->helper(array('property'));
    }

    public function paramFormat($_params){
        $_params['esg_id']      = isset($_params['esg_id'])      ? $_params['esg_id']      : 0;
        foreach(h_property_array() as $pname){
            $_params[$pname]    = isset($_params[$pname])        ? $_params[$pname]        : null;
        }
        $_params['update_time'] = isset($_params['update_time']) ? $_params['update_time'] : h_dt_now();
        return $_params;
    }


    public function updatePropertyByJson($esg_id,$json_str){
        $_properties = json_decode($json_str);
        if (empty($_properties)) {
            log_message('error', 'json data error:' . $json_str);
            return false;
        } else {
            $sqldata = array();
            foreach ($_properties as $key => $value) {
                $sqldata[h_property_name_en($key)] = $value;
            }
        }
        //解析出问题的话打一下log
        if(!$sqldata){
            log_message('error', '[!]json debug error:' . $json_str);
        }
        $this->property->insertOrUpdate($esg_id,$sqldata);
        return $sqldata;
    }


    public function insertOrUpdate($esg_id,$params){
        $query = $this->db->query("select id from properties where esg_id=?",array($esg_id));
        $res = $query->row_array();
        if($res){
            $params['update_time'] = h_dt_now();
            $this->update_sql($res['id'],$params);
        }else{
            $params['esg_id'] = $esg_id;
            $this->insert($params);
        }
    }

}

