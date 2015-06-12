<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog extends ES_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table_name = "blogs";
    }


    public function paramFormat($_params) {
        $_params['station_id']  = isset($_params['station_id'])  ? $_params['station_id']   : 0;
        $_params['author_id']   = isset($_params['author_id'])   ? $_params['author_id']    : null;
        $_params['content']     = isset($_params['content'])     ? $_params['content']      : "";
        $_params['blog_type']   = isset($_params['blog_type'])   ? $_params['blog_type']    : null;
        $_params['create_time'] = isset($_params['create_time']) ? $_params['create_time']  : h_dt_now();
        return $_params;
    }


    public function findUserStationNearestBlog($user_id, $station_id) {
        if(!$user_id || !$station_id) 
            return null;
        $blog = $this->blog->findOneBy_sql(array(
            "author_id"=>$user_id,
            "station_id"=>$station_id),array("id desc"));
        return $blog;
    }
    
   
    public function find_authors(){
        //$query=$this->db->query("select name_chn from users");
        //return $query;
        $this->db->select('name_chn');
        $query=$this->db->get('users');
        return $query;
    }
    
    /*
     *统计日志的用户数量，从高到地，返回用户id以及日志的总数 
     */
    public function count_authors(){
        $query = $this->db->query("SELECT author_id,count(id) sum FROM ".$this->table_name." group by author_id order by sum desc");
        return $query->result_array();
    }
}
