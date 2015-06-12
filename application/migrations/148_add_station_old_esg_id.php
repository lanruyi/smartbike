<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_station_old_esg_id extends CI_Migration {

    public function up()
    {
        $this->db->query("alter table stations add `old_esg_id` int(10) default null comment '曾经的esg_id'");
    }
    
    public function down()
    {
    	$this->db->query("alter table stations drop `old_esg_id`");
    }


}

