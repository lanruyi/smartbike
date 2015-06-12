<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_t_fan_time_index extends CI_Migration {

    public function up()
    {
        $this->db->query("ALTER TABLE  `t_fandaydatas` ADD INDEX (  `record_time` ) ");
        $this->db->query("ALTER TABLE commands ADD INDEX (  `station_id` ,  `status` )");
        $this->db->query("ALTER TABLE commands DROP INDEX station_id");
    }
    
    public function down()
    {
    }

}








