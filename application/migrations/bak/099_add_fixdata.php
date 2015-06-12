<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_fixdata extends CI_Migration {

    public function up()
    {
        $this->db->query(" CREATE TABLE `fixdatas` (
                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                  `station_id` int(10) unsigned NOT NULL DEFAULT '0',
                  `energy_main` decimal(10,2) DEFAULT NULL,
                  `energy_dc` decimal(10,2) DEFAULT NULL,
                  `energy_main_flag` tinyint(4) NOT NULL DEFAULT '0',
                  `energy_dc_flag` tinyint(4) NOT NULL DEFAULT '0',
                  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                  PRIMARY KEY (`id`),
                  KEY `station_time` (`station_id`,`time`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
    }

    public function down()
    {
        $this->dbforge->drop_table('fixdatas');
    }

}
