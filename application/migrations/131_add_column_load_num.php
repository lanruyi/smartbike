<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_column_load_num extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table daydatas add column load_num decimal(5,2) default null comment '当日负载'");
        $this->db->query("update `daydatas` left join stations on daydatas.station_id = stations.id  set daydatas.load_num = stations.load_num");
    }
    
    public function down()
    {
    	$this->db->query("alter table daydatas drop column load_num");
    }


}

