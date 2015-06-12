<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_index extends CI_Migration {


    public function up()
    {
        $this->db->query("ALTER TABLE  `energies` ADD INDEX station_time_type (  `station_id` ,  `create_time` ,  `type` ) ;");
        $this->db->query("ALTER TABLE  `humidities` ADD INDEX station_time_type (  `station_id` ,  `create_time` ,  `type` ) ;");
        $this->db->query("ALTER TABLE  `temperatures` ADD INDEX station_time_type (  `station_id` ,  `create_time` ,  `type` ) ;");
        $this->db->query("ALTER TABLE  `switchons` ADD INDEX station_time_type (  `station_id` ,  `create_time` ,  `type` ) ;");
        $this->db->query("ALTER TABLE  `powers` ADD INDEX station_time_type (  `station_id` ,  `create_time` ,  `type` ) ;");
    }

    public function down()
    {
        
    }

}





