<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userlog extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "userlogs";
    }


    public function paramFormat($_params) {
        $_params['user_id']    = isset($_params['user_id'])    ? $_params['user_id']    : null;
        $_params['project_id'] = isset($_params['project_id']) ? $_params['project_id'] : null;
        $_params['url']        = isset($_params['url'])        ? $_params['url']        : "";
        $_params['data']       = isset($_params['data'])       ? $_params['data']       : "";
        $_params['method']     = isset($_params['method'])     ? $_params['method']     : "";
        $_params['create_time'] = isset($_params['create_time']) ? $_params['create_time']  : h_dt_now();
        return $_params;
    }

    public function addUserLogNew($user_id,$project_id){
        $param = array(
            'user_id' => $user_id,
            'project_id' => $project_id,
            'method' => $_SERVER['REQUEST_METHOD'],
            'url' => current_url(),
            'create_time' => h_dt_date_str('')
        );
        $arrs = array();
        if($this->input->get()){
            $arrs += $this->input->get();
        }
        if($this->input->post()){
            $arrs += $this->input->post();
        }
        $data_str = "";
        if($arrs){
            foreach($arrs as $key => $value){
                $data_str.=$key."=".$value." ";
            }
        }
        $param['data'] = $data_str;
        $this->insert($param);
    }

}
