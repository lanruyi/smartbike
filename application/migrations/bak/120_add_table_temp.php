<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_table_temp extends CI_Migration {

    public function up()
    {
        $this->db->query("
            CREATE TABLE `temps` (
                `id` int(11) NOT NULL AUTO_INCREMENT ,
                `key` varchar(50) DEFAULT NULL ,
                `value` text DEFAULT NULL COMMENT '基站id的字符串',
				PRIMARY KEY (`id`)
            ) COMMENT='临时表' ;
        ");
    }

    public function down()
    {
        $this->db->query("drop table `temps`");
    }

}
