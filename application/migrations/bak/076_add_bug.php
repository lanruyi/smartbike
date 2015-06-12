<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_bug extends CI_Migration {


    public function up()
    {
        $this->db->query("
            CREATE TABLE `bugs` (
             `id` int(11) NOT NULL AUTO_INCREMENT,
             `station_id` int(11) NOT NULL,
             `type` tinyint(3) unsigned NOT NULL,
             `status` tinyint(1) NOT NULL DEFAULT '1',
             `start_time` datetime NOT NULL,
             `update_time` datetime DEFAULT NULL,
             `stop_time` datetime DEFAULT NULL,
             `project_id` int(11) DEFAULT NULL,
             `city_id` int(11) DEFAULT NULL,
             `user_id` int(11) DEFAULT NULL,
             PRIMARY KEY (`id`)
            )DEFAULT CHARSET=utf8
            ");

        $this->db->query("
            ALTER TABLE  `stations` ADD  `bug_point` TINYINT( 3 ) NOT NULL DEFAULT  '100' AFTER  `name_py`
            ");
    }


    public function down()
    {

    }

}












