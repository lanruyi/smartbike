<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_table_station_logs extends CI_Migration {

    public function up()
    {
        $this->db->query("
            CREATE TABLE `station_logs` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `station_id` int(11) DEFAULT NULL comment '基站id', 
            `creator_id` int(11) DEFAULT NULL comment '修改基站信息的用户id', 
            `original_content` text NOT NULL DEFAULT '' COMMENT '基站更新前的数据，以json的形式存入数据库',
            `change_content` text NOT NULL DEFAULT '' COMMENT '基站变化内容，以json的形式存入数据库',
            `create_time` datetime DEFAULT NULL COMMENT '创建时间',
            PRIMARY KEY (`id`)
            ) COMMENT='基站修改日志表';
        ");

        $this->db->query("alter table `batches` drop column stage ");
    }
    
    public function down()
    {

        $this->db->query("drop table `station_logs`");
        $this->db->query("alter table `batches` add column `stage` tinyint(2) DEFAULT NULL comment '第几期'");
    }

}








