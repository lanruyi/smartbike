<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_t_optional_pairs extends CI_Migration {

    public function up(){
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `t_optional_pairs` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `project_id` int(11) NOT NULL,
              `city_id` int(11) NOT NULL,
              `building_type` tinyint(1) NOT NULL,
              `total_load` tinyint(1) NOT NULL,
              `sav_station_id` int(11) NOT NULL,
              `std_station_id` int(11) NOT NULL,
              `user_id` int(11) default NULL,
              PRIMARY KEY (`id`)
            ) 
        ");
    }

    public function down()
    {
        $this->dbforge->drop_table('t_optional_pairs');
    }

}
