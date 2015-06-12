<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Batch extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "batches";
        $this->load->helper('common');
    }

    public function findAliveBatches(){
        return $this->findBy_sql(array('recycle'=>ESC_NORMAL));
    }

    public function generate_batch_num(){
        $query = $this->db->query("select * from batches order by contract_id,city_id,start_time");
        $batch_num = 0;
        $contract_id = 0;
        $city_id     = 0;
        foreach($query->result_array() as $batch){
            if($contract_id == $batch['contract_id'] && $city_id == $batch['city_id']){
                $batch_num ++;
            }else{
                $contract_id = $batch['contract_id'];
                $city_id     = $batch['city_id'];
                $batch_num = 1;
            }
            $this->db->query("update batches set batch_num=? where id=?",array($batch_num,$batch['id']));
        }
    }

    public function findBatches($project_id,$city_id){
        $query = $this->db->query("select batches.* 
            from batches left join contracts on batches.contract_id = contracts.id
            where contracts.project_id=? and batches.city_id=?",
            array($project_id,$city_id));
        return $query->result_array();
    }

}
