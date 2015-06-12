<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_table_t_fandaydatas extends CI_Migration {

    public function up()
    {
        $this->db->query("
            CREATE TABLE `t_fandaydatas` (
                `id` int(10) NOT NULL AUTO_INCREMENT,
                `station_id` int(10) DEFAULT NULL COMMENT '基站id',
                `fan_total` int(10) DEFAULT NULL COMMENT '新风开启的条数',
                `data_total` int(10) DEFAULT NULL COMMENT 'datas的条数',
                `record_time` datetime DEFAULT NULL COMMENT '哪一天的',
                PRIMARY KEY (`id`)
            ) COMMENT='每日新风节能的条数' ;
        ");
    }

    public function down()
    {
        $this->db->query("drop table `t_fandaydatas`");
    }

}
