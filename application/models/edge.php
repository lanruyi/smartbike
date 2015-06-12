<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edge extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "edges";
    }

    //新建一个命令 赋予适当的初始值
    public function new_sql($_params){
        $_params['name_chn']        = isset($_params['name_chn'])  ? $_params['name_chn']   : "";
        $_params['edge_desc']       = isset($_params['edge_desc'])     ? $_params['edge_desc']      : "";
        $_params['query']           = isset($_params['query'])         ? $_params['query']          : "";
        $_params['time_slot']       = isset($_params['time_slot'])      ? $_params['time_slot']       : "";
        $_params['threshold']       = isset($_params['threshold'])    ? $_params['threshold']     : 0;
        $_params['last_query_time'] = isset($_params['last_query_time'])     ? $_params['last_query_time']      : null;
        $_params['station_nums']    = isset($_params['station_nums']) ? $_params['station_nums']  : 0;
        return parent::new_sql($_params);
    }

}






