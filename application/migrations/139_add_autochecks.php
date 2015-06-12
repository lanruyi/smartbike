<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_autochecks extends CI_Migration {

    public function up(){
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `autochecks` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `station_id` int(11) NOT NULL,
              `datetime` datetime NOT NULL,
              `check_time` tinyint(4) NOT NULL,
              `status` tinyint(4) NOT NULL,
              `report` varchar(210) NOT NULL,
              PRIMARY KEY (`id`)
            ) 
        ");
    }


    public function down()
    {
        $this->dbforge->drop_table('autochecks');
    }

}
