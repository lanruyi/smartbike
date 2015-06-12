<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_daydata extends CI_Migration {


    public function up()
    {
        $this->db->query("
CREATE TABLE `daydatas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `station_id` int(11) NOT NULL,
  `day` date NOT NULL,
  `main_energy` decimal(5,2) DEFAULT NULL,
  `dc_energy` decimal(5,2) DEFAULT NULL,
  `ac_energy` decimal(5,2) DEFAULT NULL,
  `packets` smallint(5) DEFAULT NULL,
  `calc_type` tinyint(4) NOT NULL DEFAULT '1',
  `day_type` tinyint(1) NOT NULL DEFAULT '1',
  `is_first_day` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `station_id` (`station_id`,`day`)
)DEFAULT CHARSET=utf8;
            ");

    }


    public function down()
    {

    }

}












