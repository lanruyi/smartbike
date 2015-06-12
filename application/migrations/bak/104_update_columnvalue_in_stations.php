<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update_columnvalue_in_stations extends CI_Migration {

    public function up()
    {
        $query = $this->db->query("select id,load_num from stations");
        $stations = $query->result_array();
        foreach ($stations as $station){
            $load_num = intval($station['load_num']);
            //未知负载数不调它的档位
            if(0 == $load_num){
                continue;
            }
            $total_load = floor($load_num/10);          
            if($total_load < 1){ $total_load = 1; }
            if($total_load > 7){ $total_load = 7; }
            $this->db->query('update stations set total_load= ? where id=? ',array($total_load,$station['id']));
        }      
    }

    public function down()
    {
    }
}
