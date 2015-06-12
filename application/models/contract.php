<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contract extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "contracts";
        $this->load->model('station');
        $this->load->helper('common');
    }

    public function findAliveContracts(){
        return $this->findBy_sql(array('recycle'=>ESC_NORMAL));
    }

    public function getContractNameChn($contract_id){
        if(!$contract_id){
            return "";
        }
        $contract = $this->find_sql($contract_id);
        return $contract?$contract['name_chn']:'';
    }

    public function generate_phase_num(){
        $query = $this->db->query("select * from contracts order by project_id desc,create_time asc");
        $phase_num = 0;
        $project_id = 0;
        foreach($query->result_array() as $contract){
            if($project_id == $contract['project_id']){
                $phase_num ++;
            }else{
                $project_id = $contract['project_id'];
                $phase_num = 1;
            }
            $this->db->query("update contracts set phase_num=? where id=?",array($phase_num,$contract['id']));
        }
    }
}
