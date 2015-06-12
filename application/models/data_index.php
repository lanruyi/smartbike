<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_index extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "data_indexs";
    }


    public function findStationIndex($station_id,$day){
        $cache_key = "esproject_".$station_id."_".$day;
        //可以改很长
        $cache_time = 3600;
        $data_index_str = $this->cache->get($cache_key);
        if(!$data_index_str){
            $station = $this->station->find($station_id);
            $data_index = $this->data_index->findProjectIndex($station['project_id'],$day);
            $data_index_str = json_encode($data_index);
            $this->cache->save($cache_key,$data_index_str,$cache_time);
        }
        //echo $data_index_str."<br>";
        return json_decode($data_index_str,true);
    }


    public function findProjectIndex($project_id,$day){
        $this->db->where(array("project_id"=>$project_id,
            "from <= "=>$day,
            "to >= "=>$day));
        $data_index = $this->data_index->findOneBy();
        if($data_index){
            return $data_index;
        }else{
            $this->db->where(array("project_id"=>0,
                "from <= "=>$day,
                "to >= "=>$day));
            $data_index = $this->data_index->findOneBy();
            if($data_index){
                return $data_index;
            }else{
                return array("table"=>"datas","archive"=>1);
            }
        }
    }



    public function getActiveTableNames(){
        $day = h_dt_start_time_of_day('now');
        $this->db->where(array("from <= "=>$day,"to >= "=>$day));
        $data_indexs = $this->data_index->findBy();
        $tables = array();
        if($data_indexs){
            foreach($data_indexs as $data_index){
                $tables[] = $data_index["table"];
            }
        }else{
            $tables = array("datas");
        }
        return $tables;
    }


}
