<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_monthdatas extends CI_Migration {

    public function up()
    {
        $this->db->query("
            CREATE TABLE `monthdatas` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `station_id` int(11) NOT NULL,
              `datetime` datetime NOT NULL,
              `main_energy` decimal(7,2) DEFAULT NULL,
              `dc_energy` decimal(7,2) DEFAULT NULL,
              `ac_energy` decimal(5,2) DEFAULT NULL,
              `calc_type` tinyint(4) NOT NULL DEFAULT '1',
              PRIMARY KEY (`id`),
              UNIQUE KEY `station_id` (`station_id`,`datetime`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
        ");
    }

    public function down()
    {
        $this->dbforge->drop_table('monthdatas');
    }

}
