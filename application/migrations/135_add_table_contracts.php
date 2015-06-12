<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_table_contracts extends CI_Migration {

    public function up()
    {
        $this->db->query("
            CREATE TABLE `contracts` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name_chn` varchar(255) NOT NULL  COMMENT '合同号',
            `project_id` int(9) DEFAULT NULL COMMENT '项目id',
            `create_time` datetime DEFAULT NULL COMMENT '创建时间',
            `recycle` tinyint(3) NOT NULL DEFAULT 1 COMMENT '合同状态：1、活着的 2、已删除',
            `image` varchar(255) NOT NULL COMMENT '图片',
            `content` text NOT NULL COMMENT '描述',
            PRIMARY KEY (`id`)
            ) COMMENT='合同表';
        ");

        $this->db->query("
            CREATE TABLE `batches` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `contract_id` int(9) DEFAULT NULL COMMENT '合同id',
            `city_id` int(9) DEFAULT NULL  COMMENT '城市id',
            `stage` tinyint(3) NOT NULL DEFAULT 1  COMMENT '第几期',
            `create_time` datetime DEFAULT NULL COMMENT '创建时间',
            `start_time` datetime DEFAULT NULL COMMENT '开始时间',
            `total_month` smallint(6) DEFAULT NULL COMMENT '总收款时间，单位：月',
            `current_time` datetime DEFAULT NULL COMMENT '上一次收款时间',
            `recycle` tinyint(3) NOT NULL DEFAULT 1 COMMENT '合同状态：1、活着的 2、已删除',
            PRIMARY KEY (`id`)
            ) COMMENT='批次表';
        ");

        $this->db->query("alter table `stations` add column `old_station_id` int(9) DEFAULT NULL comment '专门用来记录搬迁的老基站'");
        $this->db->query("alter table `stations` add column `status` tinyint(2) NOT NULL DEFAULT 4 comment '基站的状态 ：1、工程安装，建站 2、工程验收 3、内部验收 4、正常运营 ..'");
        $this->db->query("alter table `stations` add column `batch_id` int(9) DEFAULT NULL comment '批次id'");

    }
    
    public function down()
    {

        $this->db->query("drop table `contracts`");
        $this->db->query("drop table `batches`");
        $this->db->query("alter table `stations` drop column `old_station_id`");
        $this->db->query("alter table `stations` drop column `status`");
        $this->db->query("alter table `stations` drop column `batch_id`");

    }

}








