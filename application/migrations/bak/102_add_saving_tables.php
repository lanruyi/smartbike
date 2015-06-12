<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_saving_tables extends CI_Migration {

    public function up(){
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `savpairs` (
              `id` int(11) NOT NULL AUTO_INCREMENT,

              `datetime` datetime NOT NULL,
              `project_id` int(11) NOT NULL,
              `city_id` int(11) NOT NULL,
              `building_type` tinyint(1) NOT NULL,

              `total_load` tinyint(1) NOT NULL,

              `sav_station_id` int(11) NOT NULL,
              `std_station_id` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM;
        ");
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `savpairdatas` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `savpair_id` int(11) NOT NULL,

              `datetime` datetime NOT NULL,
              `time_type` tinyint(1) NOT NULL,

              `sav_station_cspt` decimal(6,2) default NULL,
              `std_station_cspt` decimal(6,2) default NULL,

              `rate` decimal(6,4) default NULL,
              `saving_func` tinyint(2) default NULL,
              `error` tinyint(2) default NULL,
              `warning` tinyint(2) default NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM;
        ");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS `loadleveldatas` (
              `id` int(11) NOT NULL AUTO_INCREMENT,

              `datetime` datetime NOT NULL,
              `project_id` int(11) NOT NULL,
              `city_id` int(11) NOT NULL,
              `building_type` tinyint(1) NOT NULL,
              `total_load` tinyint(1) NOT NULL,

              `time_type` tinyint(1) NOT NULL,

              `saving_rate` decimal(6,4) default NULL,
              `saving_func` int(11) default NULL,
              `error` tinyint(2) default NULL,
              `warning` tinyint(2) default NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM;
        ");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS `savings` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `station_id` int(11) NOT NULL,

              `datetime` datetime NOT NULL,
              `project_id` int(11) NOT NULL,
              `city_id` int(11) NOT NULL,
              `building_type` tinyint(1) NOT NULL,
              `total_load` tinyint(1) NOT NULL,

              `station_type` int(11) NOT NULL,

              `time_type` tinyint(1) NOT NULL,

              `rate` decimal(6,4) default NULL,
              `energy_save` decimal(10,2) default NULL,
              `saving_func` int(11) not NULL,
              `error` tinyint(2) default NULL,
              `warning` tinyint(2) default NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM;
        ");

    }


    public function down()
    {
        $this->dbforge->drop_table('savpairs');
        $this->dbforge->drop_table('savpairdatas');
        $this->dbforge->drop_table('loadleveldatas');
        $this->dbforge->drop_table('savings');

    }

}
