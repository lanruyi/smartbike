<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_For_station_batch extends CI_Migration {

    public function up(){
        $this->db->query("ALTER TABLE `stations` CHANGE `batch_id` `batch_id` SMALLINT(2) NULL DEFAULT NULL 
            COMMENT  '批次id'");
        $this->db->query("alter table batches add column name_chn varchar(200) not null default '' 
            comment '全名'");
        $this->db->query("alter table contracts add column phase_num tinyint(2) not null default 0 
            comment '第几期'");
        $this->db->query("alter table batches add column batch_num tinyint(2) not null default 0 
            comment '第几批'");

    }

    public function down()
    {
        $this->db->query("alter table batches drop column name_chn"); 
        $this->db->query("alter table contracts drop column phase_num"); 
        $this->db->query("alter table batches drop column batch_num"); 
    }

}
