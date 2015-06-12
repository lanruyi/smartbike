<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_hourdata extends CI_Migration {


    public function up()
    {
        $this->db->query("
 CREATE TABLE `hourdatas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `station_id` int(11) NOT NULL,
  `energy_main` decimal(5,2) DEFAULT NULL,
  `energy_dc` decimal(5,2) DEFAULT NULL,
  `energy_ac` decimal(5,2) DEFAULT NULL,	
  `time` datetime default NULL,	
    PRIMARY KEY (`id`)
  )DEFAULT CHARSET=utf8;
            ");

    }


    public function down()
    {
       $this->db->query("drop table hourdatas");
    }

}

