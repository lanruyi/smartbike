<?php defined('BASEPATH') OR exit('No direct script access allowed'); 


class Migration_Add_work_order extends CI_Migration {

    public function up()
    {
        $this->db->query("
           CREATE TABLE `work_orders` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `station_id` int(11) NOT NULL,
            `creator_id` int(11)  NOT NULL,
            `dispatcher_id` int(11)  NOT NULL,
            `dispatcher_tel` int(11) NOT NULL,
            `bug_type_ids` varchar(255) NOT NULL,
            `content` text NOT NULL,
            `status` tinyint(3) NOT NULL DEFAULT 1,
            `create_time` datetime NOT NULL,  
            `confirm_time` datetime NOT NULL,
            `fix_time` datetime NOT NULL,
            `confirm_fix_time` datetime NOT NULL,
              PRIMARY KEY (`id`)
            )ENGINE=MyISAM,DEFAULT CHARSET=utf8;
        ");

    }


    public function down()
    {
      $this->db->query("drop table work_orders");
    }

}

