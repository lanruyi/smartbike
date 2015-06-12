<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_fixbugs extends CI_Migration {


    public function up()
    {
        $this->db->query("
        CREATE TABLE `fixbugs` (
         `id` int(11) NOT NULL AUTO_INCREMENT,
         `station_id` int(11) NOT NULL,
         `bug_type` tinyint(2) NOT NULL,
         `time` datetime NOT NULL,
         `user_id` int(11) NOT NULL,
         PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8
            ");
    }


    public function down()
    {
    }

}











