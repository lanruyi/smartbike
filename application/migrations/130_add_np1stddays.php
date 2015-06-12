<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_np1stddays extends CI_Migration {

    public function up()
    {
        $this->db->query("
            CREATE TABLE `np1stddays` (
                `id` int(10) NOT NULL AUTO_INCREMENT,
                `station_id` int(10) DEFAULT NULL COMMENT '基站id',
                `datetime` datetime DEFAULT NULL COMMENT '哪一天是节能日',
                PRIMARY KEY (`id`)
            ) COMMENT='n+1基站的节能日' ;
        ");

        $this->db->query("insert into np1stddays (station_id,datetime) select station_id,day as datetime from daydatas where day_type = 2");
        $this->db->query("ALTER TABLE `daydatas` DROP `day_type`");
    }

    public function down()
    {
        $this->db->query("drop table `np1stddays`");
    }

}
