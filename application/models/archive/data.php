<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data extends ES_Model {

    public function __construct() {
        parent::__construct("archive");
        $this->load->database("archive");
        $this->table_name = "test_datas";
        $this->load->helper('main');
    }

    public function changeTableName($table){
        $this->table_name = $table;
    }
    public function findLast($station_id){
        return $this->data->findOneBy(
                array("station_id"=>$station_id),
                array("create_time desc"));
    }
    public function findLastN($station_id,$n){
        return $this->data->findBy(array("station_id"=>$station_id),array("create_time desc"),$n);
    }
    public function findPeriodDatas($station_id,$start_time,$stop_time,$order){
        $this->data->where("create_time >= ".$start_time." and create_time<=".$stop_time);
        return $this->data->findBy(array("station_id"=>$station_id),array("create_time ".$order));
    }



}














