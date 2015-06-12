<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_ext extends ES_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "data_exts";
    }

    public function getDataHash($data_ids){
        $hash = array();
        if($data_ids){
            $query = $this->db->query("select * from data_exts where data_id in (".implode(",",$data_ids).")");
            $result = $query->result_array();
            foreach($result as $de){
                $hash[$de['data_id']] = $de;
            }
        }
        return $hash;
    }



}
