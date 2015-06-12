<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_project extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "user_projects";
    }


    public function findUserHash($project_id){
        $user_hash = array();
        $user_projects = $this->findBy_sql(array("project_id"=>$project_id));
        foreach($user_projects as $user_project){
            $user_hash[$user_project['user_id']] = true;
        }
        return $user_hash;
    }

    public function get_user_projects($user_id){
        $query = $this->db->query("select * from ".$this->table_name." where user_id=?",array($user_id));
        $result = $query->result_array();
        return $result;
    }


}
