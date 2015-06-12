<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_stdstations extends CI_Migration {

    public function up(){
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `sav_stds` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `datetime` datetime NOT NULL,
              `project_id` int(11) NOT NULL,
              `city_id` int(11) NOT NULL,
              `building_type` tinyint(1) NOT NULL,
              `total_load` tinyint(1) NOT NULL,
              `std_station_id` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM
        ");
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `sav_std_averages` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `datetime` datetime NOT NULL,
              `project_id` int(11) NOT NULL,
              `city_id` int(11) NOT NULL,
              `building_type` tinyint(1) NOT NULL,
              `total_load` tinyint(1) NOT NULL,
              `average_main_energy` decimal(11,6) default NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM
        ");
        $this->db->query(" ALTER TABLE  `commands` ADD INDEX (`station_id`)");
    }


    public function down()
    {
        $this->dbforge->drop_table('sav_stds');
        $this->dbforge->drop_table('sav_std_averages');
        $this->db->query(" ALTER TABLE `commands` DROP INDEX `station_id` ");
    }

}
